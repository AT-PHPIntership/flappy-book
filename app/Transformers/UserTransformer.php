<?php

namespace App\Transformers;

use App\Model\User;
use League\Fractal\TransformerAbstract;

class UserTransformer extends TransformerAbstract
{
    /**
     * Transform
     *
     * @param User $user user
     *
     * @return Array
     */
    public function transform(User $user)
    {
        return [
            'id' => (int) $user->id,
            'name' => (string) $user->name,
            'employ_code' => (string) $user->employ_code,
            'email' => (string) $user->email,
            'team' => (string) $user->team,
            'avatar_url' => (string) $user->avatar_url,
            'is_admin' => (int) $user->is_admin,
            'created_at' => (string) $user->created_at,
            'updated_at' => (string) $user->updated_at
        ];
    }
}
