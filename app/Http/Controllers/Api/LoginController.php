<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ServerException;
use App\Model\User;

class LoginController extends ApiController
{
    /**
     * Handle a login request to the application.
     *
     * @param \Illuminate\Http\Request $request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $data = $request->except('_token');
        try {
            $client = new Client();
            $portal = $client->post(config('portal.base_url_api') . config('portal.end_point.login'), ['form_params' => $data]);
            $portalResponse = json_decode($portal->getBody()->getContents());
            if ($portalResponse->meta->status == config('define.login.msg_success')) {
                $user = $this->saveUser($portalResponse->data->user, $request);
                return $this->showOne($user);
            }
            return response()->json(['message' => trans('portal.messages.server_error')], Response::HTTP_INTERNAL_SERVER_ERROR);
        } catch (ServerException $e) {
            $portalResponse = json_decode($e->getResponse()->getBody()->getContents());
            return response()->json($portalResponse, Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Save data users
     *
     * @param App\Http\Controllers\Auth $userResponse $userResponse
     * @param \Illuminate\Http\Request  $request      $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     */
    public function saveUser($userResponse, $request)
    {
        # Collect user data from response
        $userCondition = [
            'employ_code' => $userResponse->employee_code,
            'email' => $request->email,
        ];
        $user = [
            'name' => $userResponse->name,
            'team' => $userResponse->teams[0]->name,
            'expires_at' => date(config('define.login.datetime_format'), strtotime($userResponse->expires_at)),
            'avatar_url' => $userResponse->avatar_url,
            'access_token' => $userResponse->access_token,
        ];
        if ($userResponse->teams[0]->name == User::TEAM_SA) {
            $user['is_admin'] = User::ROLE_ADMIN;
        }
        # Get user from database OR create User
        return User::updateOrCreate($userCondition, $user);
    }
}
