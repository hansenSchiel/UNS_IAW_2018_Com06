<?php
namespace ProdeIAW\Http\Controllers;

use Illuminate\Http\Request;
use ProdeIAW\Services\SocialTwitterAccountService;
use Socialite;

class SocialAuthTwitterController extends Controller
{
  /**
   * Create a redirect method to twitter api.
   *
   * @return void
   */
    public function redirect()
    {
        return Socialite::driver('twitter')->redirect();
    }

    /**
     * Return a callback method from twitter api.
     *
     * @return callback URL from twitter
     */
    public function callback(SocialTwitterAccountService $service)
    {
  		$user = $service->createOrGetUser(Socialite::driver('twitter')->user());
  		auth()->login($user);
  		return redirect()->to('/');
    }

    public function logout(){
        auth()->logout(); 
        return redirect()->to('/');
    }
}