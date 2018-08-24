<?php namespace App\Services;

use DateTime;

class PassportTokenizerService
{
    private $token = null;

    private $properties = array();

    public function with($token)
    {
        $this->properties = static::dirtyDecode($token);
        $this->token = $token;
    }

    public function getToken()
    {
        return $this->token;
    }

    public function getProperties()
    {
        return $this->properties;
    }

    public function __get($property)
    {
        if (array_key_exists($property, $this->properties)) {
            return $this->properties[$property];
        }
        return null;
    }

    /**
     * Check if token exists in DB (table 'oauth_access_tokens'), require \Illuminate\Support\Facades\DB class
     *
     * @return boolean
     */
    public function existsValid()
    {
        return static::existsValidToken($this->token_id, $this->user_id);
    }

    /**
     * Check if token exists in DB (table 'oauth_access_tokens'), require \Illuminate\Support\Facades\DB class
     *
     * @param string $token_id
     * @param string $user_id
     *
     * @return boolean
     */
    public static function existsValidToken($token_id, $user_id)
    {
        if (class_exists('\Illuminate\Support\Facades\DB')) {
            return (bool)\Illuminate\Support\Facades\DB::table('oauth_access_tokens')
                ->where('id', $token_id)
                ->where('user_id', $user_id)
                ->where('expires_at', '>=', date('Y-m-d H:i:s'))
                ->get();
        } else {
            return false;
        }
    }

    /**
     * Decode a Access Token
     *
     * @param string $access_token Access Token
     *
     * @return array
     */
    public static function dirtyDecode($access_token)
    {
        $now = time();
        $expecting = false;
        $incorrect = false;
        $expired = false;
        $error = false;
        $errors = array();
        $token_segments = explode('.', $access_token);
        $body = (isset($token_segments[1])) ? $token_segments[1] : null;
        if (count($token_segments) != 3) {
            $error = true;
            $errors[] = "Token has wrong number of segments";
        }
        if (null === $data = static::jsonDecode(static::urlDecode($body))) {
            $error = true;
            $errors[] = "Decoder has problem with Token encoding";
        }
        if (isset($data->nbf) && $data->nbf > $now) {
            $expecting = true;
        }
        if (isset($data->iat) && $data->iat > $now) {
            $incorrect = true;
        }
        if (isset($data->exp) && $now >= $data->exp) {
            $expired = true;
        }
        return array(
            'token_id' => (isset($data->jti)) ? $data->jti : null,
            'user_id' => (isset($data->sub)) ? $data->sub : null,
            'expecting' => $expecting,
            'start_at_unix' => (isset($data->nbf)) ? $data->nbf : null,
            'start_at' => (isset($data->nbf)) ? date(DateTime::ISO8601, $data->nbf) : null,
            'incorrect' => $incorrect,
            'created_at_unix' => (isset($data->iat)) ? $data->iat : null,
            'created_at' => (isset($data->iat)) ? date(DateTime::ISO8601, $data->iat) : null,
            'expired' => $expired,
            'expires_at_unix' => (isset($data->exp)) ? $data->exp : null,
            'expires_at' => (isset($data->exp)) ? date(DateTime::ISO8601, $data->exp) : null,
            'error' => $error,
            'errors' => $errors,
            'valid' => ($expecting || $incorrect || $expired || $error) ? false : true
        );
    }

    public static function urlDecode($input)
    {
        $remainder = strlen($input) % 4;
        if ($remainder) {
            $padlen = 4 - $remainder;
            $input .= str_repeat('=', $padlen);
        }
        return base64_decode(strtr($input, '-_', '+/'));
    }

    public static function jsonDecode($input)
    {
        if (version_compare(PHP_VERSION, '5.4.0', '>=') && !(defined('JSON_C_VERSION') && PHP_INT_SIZE > 4)) {
            $obj = json_decode($input, false, 512, JSON_BIGINT_AS_STRING);
        } else {
            $max_int_length = strlen((string)PHP_INT_MAX) - 1;
            $json_without_bigints = preg_replace('/:\s*(-?\d{' . $max_int_length . ',})/', ': "$1"', $input);
            $obj = json_decode($json_without_bigints);
        }
        if (function_exists('json_last_error') && $errno = json_last_error()) {
            return null;
        } elseif ($obj === null && $input !== 'null') {
            return null;
        }
        return $obj;
    }
}