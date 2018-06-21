<?php

namespace ProdeIAW\Services;
use ProdeIAW\SocialTwitterAccount;
use ProdeIAW\User;
use Laravel\Socialite\Contracts\User as ProviderUser;

class SocialTwitterAccountService
{
    public function createOrGetUser(ProviderUser $providerUser)
    {
        $account = SocialTwitterAccount::whereProvider('twitter')
            ->whereProviderUserId($providerUser->getId())
            ->first();
        if ($account) {
            return $account->user;
        } else {
            $users = sizeOf(User::all());
            $isAdmin = 1;
            if($users > 0){
                $isAdmin = 0;
            }
            $account = new SocialTwitterAccount([
                'provider_user_id' => $providerUser->getId(),
                'provider' => 'twitter'
            ]);

            $user = User::whereName($providerUser->getName())->first();

            if (!$user) {

                $user = User::create([
                    'name' => $providerUser->getName(),
                    'password' => md5(rand(1,10000)),
                    'admin' => $isAdmin,
                    'avatar' => $providerUser->getAvatar(),
                ]);
            }
            $account->user()->associate($user);
            $account->save();

            return $user;
        }
    }
}