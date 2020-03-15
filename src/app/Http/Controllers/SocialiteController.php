<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Socialite;

class SocialiteController extends Controller
{
    public function __construct()
    {
        $this->middleware('session');
    }

    /**
     * Redirect the user to the Twitter authentication page.
     *
     * @return JsonResponse
     */
    public function redirectToTwitter(): JsonResponse
    {
        return response()->json([
            'redirect_url' => Socialite::driver('twitter')->redirect()->getTargetUrl()
        ]);
    }

    /**
     * Obtain the user information from Twitter.
     *
     * @return JsonResponse
     */
    public function handleTwitterCallback(): JsonResponse
    {
        $user = Socialite::driver('twitter')->user();
        $user->getId();
        $user->getNickname();
        $user->getName();
        $user->getEmail();
        $user->getAvatar();
    }

    public function redirectToGithub(): JsonResponse
    {
        $redirectResponse = Socialite::driver('github')->redirect();
        return response()->json([
            'redirect_url' => $redirectResponse->getTargetUrl()
        ]);
    }
}
