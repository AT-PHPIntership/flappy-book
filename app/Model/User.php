<?php

namespace App\Model;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    protected $table = 'users';

    /**
      * Constant admin team
      * Set role admin 1
      * Set role user 0
      *
      * @var constants
      */
    const ADMIN_TEAM_NAME = 'PHP';
    const ROLE_ADMIN = 1;
    const ROLE_USER = 0;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
     'employ_code',
     'name',
     'email',
     'team',
     'avatar_url',
     'is_admin',
     'access_token',
     'expires_at',
    ];

     /**
      * Check admin
      *
      * @param App\Model\User $team return team
      *
      * @return string
     */
    public static function getRoleByTeam($team)
    {
        return $team == self::ADMIN_TEAM_NAME ? self::ROLE_ADMIN : self::ROLE_USER;
    }
}
