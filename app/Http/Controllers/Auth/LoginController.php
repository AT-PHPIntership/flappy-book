<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use App\Model\User;
use App\Http\Requests\LoginFormValidation;
use Illuminate\Support\Facades\Auth;
use App\Libraries\Portal;

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
        $this->middleware('guest')->except('logout');
    }


    /**
     * Show the application's login form.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('auth.login');
    }
    
    /**
     * Handle a login request to the application.
     *
     * @param \Illuminate\Http\Request $request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     */
    public function login(LoginFormValidation $request)
    {
        $data = $request->except('_token');
        try {
            $accessToken = Portal::login($data);
            if ($accessToken) {
                $portalUserResponse = Portal::userProfile($accessToken);
                $user = $this->saveUser($portalUserResponse, $accessToken, $request);
                Auth::login($user, $request->filled('remember'));
                if ($user->is_admin == true) {
                    return redirect("/admin");
                } else {
                    return redirect("/");
                }
            } else {
                redirect('/login')
                ->withErrors(['error' => trans('portal.messages.server_error')]);
            }
        } catch (ClientException $e) {
            $portalResponse = json_decode($e->getResponse()->getBody()->getContents());
            return redirect()
                ->back()
                ->withInput()
                ->withErrors(['error' => trans('portal.messages.' . $portalResponse->errors->email_password)]);
        }
    }
    /**
     * Save data users
     *
     * @param App\Http\Controllers\Auth $portalUserResponse $portalUserResponse
     * @param App\Http\Controllers\Auth $accessToken        $accessToken
     * @param \Illuminate\Http\Request  $request            $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     */
    public function saveUser($portalUserResponse, $accessToken, $request)
    {
        # Collect user data from response
        $userCondition = [
            'employ_code' => $portalUserResponse->employee_code,
            'email' => $request->email,
        ];
        $user = [
            'name' => $portalUserResponse->name,
            'team' => $portalUserResponse->teams[0]->name,
            'avatar_url' => $portalUserResponse->avatar->file,
            'access_token' => $accessToken,
        ];
        if ($portalUserResponse->teams[0]->name == User::TEAM_SA) {
            $user['is_admin'] = User::ROLE_ADMIN;
        }
        # Get user from database OR create User
        return User::updateOrCreate($userCondition, $user);
    }
    
    /**
     * Log the user out of the application.
     *
     * @param \Illuminate\Http\Request $request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        return redirect('/');
    }
}
