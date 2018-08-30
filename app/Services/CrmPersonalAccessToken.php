<?php namespace App\Services;

use App\Models\User;
use Laravel\Passport\PersonalAccessTokenFactory;
use Laravel\Passport\PersonalAccessTokenResult;

class CrmPersonalAccessToken extends PersonalAccessTokenFactory
{
    public function make($userId, $name, array $scopes = [])
    {
        $response = $this->dispatchRequestToAuthorizationServer(
            $this->createRequest($this->clients->personalAccessClient(), $userId, $scopes)
        );

//        dd($response['access_token']);
//
//        $user = User::find($userId);
//
//        $token = $user->withValidToken();
//
//        if (!$token) {

        $token = tap($this->findAccessToken($response), function ($token) use ($userId, $name) {
            $this->tokens->save($token->forceFill([
                'user_id' => $userId,
                'name' => $name,
            ]));
        });
//        }

        dump($token->id);
        return new PersonalAccessTokenResult(
            $response['access_token'], $token
        );
    }
}