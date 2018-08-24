<?php namespace App\Services;

use App\Models\SocialAccount;
use App\Models\User;

class SocialAccountService
{
    public function setOrGetUser($provider)
    {
        $providerUser = $provider->stateless()->user();
        $providerName = class_basename($provider);
        $providerId = $providerUser->getId();
        $providerEmail = $providerUser->getEmail();
        $providerAvatar = $providerUser->getAvatar();
        $providerUserName = $providerUser->getName();

        $account = SocialAccount::where([
            'provider' => $providerName,
            'provider_id' => $providerId,
        ])->first();

        if ($account) {
            return $account->user;
        } else {
            $account = new SocialAccount([
                'provider_id' => $providerId,
                'provider' => $providerName,
                'avatar' => $providerAvatar
            ]);

            $user = User::where(['email' => $providerEmail])->first();

            if (!$user) {
                $user = User::create([
                    'email' => $providerEmail,
                    'name' => $providerUserName,
                    'username' => strtolower(preg_replace('/\s+/', '_', $providerUserName) . mt_rand(10, 100))
                ]);
            }

            $account->user()->associate($user);
            $account->save();

            return $user;
        }
    }
}