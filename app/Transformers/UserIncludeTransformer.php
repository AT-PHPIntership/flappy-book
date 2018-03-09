<?php

namespace App\Transformers;

use App\Model\User;
use League\Fractal\TransformerAbstract;

class UserIncludeTransformer extends TransformerAbstract
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
            'team' => (string) $user->team,
            'avatar_url' => (string) $user->avatar_url,
            'is_admin' => (int) $user->is_admin,
        ];
    }
}
