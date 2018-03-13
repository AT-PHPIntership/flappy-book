<?php

namespace App\Libraries;

use GuzzleHttp\Client;
use App\Model\User;
use App\Model\Book;
use Exception;
use DB;

class Portal
{
    /**
     * Update images of Book.
     *
     * @param array $data data
     *
     * @return string
     */
    public static function login($data)
    {
        $client = new Client();
        $portal = $client->post(config('portal.base_url_api') . config('portal.end_point.login'), ['form_params' => $data]);
        $portalResponse = json_decode($portal->getBody()->getContents());
        return $portalResponse->access_token;
    }
    /**
     * Get user profiles
     *
     * @param string $accessToken accessToken
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     */
    public static function userProfile($accessToken)
    {
        $client = new Client();
        $portalUserProfiles = $client->request('GET', config('portal.base_url_api') . config('portal.end_point.user_profiles'), [
            'headers' => [
                'authorization' => $accessToken,
            ]
        ]);
        $portalUserResponse = json_decode($portalUserProfiles->getBody()->getContents());
        return $portalUserResponse;
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
    public static function saveUser($portalUserResponse, $accessToken, $request)
    {
        /**
         * Update employ code
         *
         * @param string $employCode $employCode
         * @param string $email      $email
         *
         * @return employcode
         */
        function updateEmployCode($employCode, $email)
        {
            $user = User::select(['id', 'employ_code'])->where('email', $email)->first();
            if ($user) {
                if ($user->employ_code !== $employCode) {
                    DB::beginTransaction();
                    try {
                        DB::statement('SET FOREIGN_KEY_CHECKS = 0;');
                        Book::where('from_person', $user->employ_code)
                            ->update(['from_person' => $employCode]);
                        $user->employ_code = $employCode;
                        $user->save();
                        DB::statement('SET FOREIGN_KEY_CHECKS = 1;');
                        DB::commit();
                    } catch (Exception $e) {
                        DB::rollBack();
                    }
                }
            }
            return $employCode;
        }
        # Collect user data from response
        $userCondition = [
            'employ_code' => updateEmployCode($portalUserResponse->employee_code, $request->email),
        ];
        $user = [
            'email' => $request->email,
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
}
