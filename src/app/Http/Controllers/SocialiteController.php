<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Socialite;
use App\User;
use App\UserSocialAccount as SocialAccount;
use Illuminate\Http\Request;

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
    public function handleTwitterCallback(Request $request): JsonResponse
    {
        $twitterUser = Socialite::with('twitter')->user();
        return response()->json([
            '$twitterUser' => $twitterUser,
        ]);

        $socialAccount = SocialAccount::firstOrNew([
            'provider' => 'twitter',
            'account_id' => $twitterUser->getId(),
        ]);

        if ($socialAccount->exists) {
            $user = User::find($socialAccount->getAttribute('user_id'));
        } else {
            $user = User::create([
                'name' => $twitterUser->getName(),
                'email' => $twitterUser->getEmail(),
                'password' => null,
                'twitter_id' => $twitterUser->getNickName(),
            ]);

            $socialAccount->setAttribute('user_id', $createdUser->id);
            $socialAccount->save();
        }

        return response()->json([
            'user' => $user,
            'access_token' => $user->createToken(null, ['*'])->accessToken,
        ]);;
    }

    public function redirectToGithub(): JsonResponse
    {
        $redirectResponse = Socialite::driver('github')->redirect();
        return response()->json([
            'redirect_url' => $redirectResponse->getTargetUrl()
        ]);
    }
}
