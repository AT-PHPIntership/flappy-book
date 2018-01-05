<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    protected $table = 'users';

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
}
