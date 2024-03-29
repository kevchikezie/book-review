<?php

namespace App\Http\Controllers\Auth;

use Auth;
use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except(['logout', 'apiLogout', 'loggedInUser']);
    }

    /**
     * Login user through the API (Create access token)
     *
     * @param  \App\Http\Requests\LoginRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function apiLogin(LoginRequest $request)
    {
        abort_if(!Auth::attempt($request->toArray()), 401);

        $user = Auth::user();

        $token = $user->createToken("BookRating");

        $user['token'] = $token->accessToken;
        $user['expires_at'] = $token->token->expires_at;
        $user['token_type'] = 'Bearer';

        array_except($user, ['id']);

        return response()->json([
            'status' => 'success',
            'code' => 200,
            'title' => 'OK',
            'message' => 'Login was successful.',
            'data' => [$user]
        ]);
    }

    /**
     * Logout user through the API (Revoke the token)
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string
     */
    public function apiLogout(Request $request)
    {
        // Revoke authenticated user's token.
        $request->user()->token()->revoke();

        // Delete the token from the database after revoking.
        $request->user()->token()->delete();

        return response()->json([
            'status' => 'success',
            'code' => 200,
            'title' => 'OK',
            'message' => 'Successfully logged out.'
        ]);
    }

    /**
     * Get the authenticated User
     *
     * @return array
     */
    public function loggedInUser(Request $request)
    {
        return response()->json($request->user());
    }
}
