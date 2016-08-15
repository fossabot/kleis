<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    const USER_STATUS = [
        0 => [  'text' => 'inactif',
                'icon' => '',
                'unicon' => '' ],
        1 => [  'text' => 'actif',
                'icon' => 'fa-check',
                'unicon' => '&#xf00c;' ]
    ];

    const USER_LEVEL = [
        1 => [  'text' => 'gestionnaire',
                'icon' => 'fa-support',
                'unicon' => '&#xf1cd;' ],
        2 => [  'text' => 'administrateur',
                'icon' => 'fa-shield',
                'unicon' => '&#xf132;' ],
        9 => [  'text' => 'super administrateur',
                'icon' => 'fa-rocket',
                'unicon' => '&#xf135;' ],
    ];

    const SEARCH_CRITERIA = [
        'email' => ['email'],
        'fullname' => ['firstname', 'lastname'],
        'group' => [['group' => 'name']],
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'firstname', 'lastname', 'email', 'password', 'status',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function getStatus()
    {
        if (array_key_exists($this->status, self::USER_STATUS)) {
            return self::USER_STATUS[$this->status];
        } else {
            return null;
        }
    }

    public function getLevel()
    {
        if (array_key_exists($this->level, self::USER_LEVEL)) {
            return self::USER_LEVEL[$this->level];
        } else {
            return null;
        }
    }

    public function creator()
    {
        return $this->hasOne('App\User', 'id', 'created_by');
    }

    public function group()
    {
        return $this->hasOne('App\Group', 'id', 'group_id');
    }
}
