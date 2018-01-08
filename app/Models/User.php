<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    protected $table = 'users';
    const IS_ADMIN = 'PHP';

     /**
      * Value of role
      *
      * @var array
      */
    public static $role = [
       'admin' => 1,
       'user' => 0,
    ];
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
        return ($team == self::IS_ADMIN);
    }
}
