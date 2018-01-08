<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ServerException;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

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
    public function login(Request $request)
    {
        # Collect data form request
        $data = $request->except('_token');
        try {
            # Try to call API to Portal
            $client = new Client();
            $portal = $client->post(config('portal.base_url_api') . config('portal.end_point.login'), ['form_params' => $data]);
            $portalResponse = json_decode($portal->getBody()->getContents());

            if ($portalResponse->meta->status == config('define.login_msg_success')) {
                $user = $this->saveUser($portalResponse, $request);
                if ($user->is_admin == true) {
                    return redirect("/admin");
                } else {
                    return redirect("/");
                }
            } else {
            }
        } catch (ServerException $e) {
            # Catch errors from Portal
            $portalResponse = json_decode($e->getResponse()->getBody()->getContents());
            return redirect()
                ->back()
                ->withInput()
                ->withErrors(['email' => trans('portal.messages.' . $portalResponse->meta->messages)]);
        }
    }
    /**
     * Save data users
     *
     * @param App\Http\Controllers\Auth $portalResponse $portalResponse
     * @param \Illuminate\Http\Request  $request        $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     */
    public function saveUser($portalResponse, $request)
    {
        $userResponse = $portalResponse->data->user;
        # Collect user data from response
        $userCondition = [
            'employ_code' => $userResponse->employee_code,
            'email' => $request->email,
        ];
        $user = [
            'name' =>$userResponse->name,
            'team' =>$userResponse->teams[0]->name,
            'avatar_url' => $userResponse->avatar_url,
            'access_token' => $userResponse->access_token,
        ];
        $user['is_admin'] = User::getRoleByTeam($user['team']);
        # Get user from database OR create User
        $user = User::updateOrCreate($userCondition, $user);
        # Set login for user
        Auth::login($user, $request->filled('remember'));

        return $user;
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
