<?php

namespace App\Libraries;

use GuzzleHttp\Client;

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
}
