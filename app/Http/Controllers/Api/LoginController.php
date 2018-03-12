<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Validation\ValidationException;
use GuzzleHttp\Exception\ClientException;
use App\Http\Requests\LoginFormValidation;
use Illuminate\Support\Facades\Auth;
use App\Libraries\Portal;
use GuzzleHttp\Client;

class LoginController extends ApiController
{
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
                $user = Portal::saveUser($portalUserResponse, $accessToken, $request);
                Auth::login($user, $request->filled('remember'));
                return $this->responseSuccess($user);
            } else {
                throw new TokenMismatchException(__('api.error.unauthorized'), Response::HTTP_UNAUTHORIZED);
            }
        } catch (ClientException $e) {
            $portalResponse = json_decode($e->getResponse()->getBody()->getContents());
            return response()->json(['error' => trans('portal.messages.' . $portalResponse->errors->email_password)]);
        }
    }
}
