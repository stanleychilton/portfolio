<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    const ADMIN = 'admin';
    const DEFAULT = 'default';
    const VERIFIED = 'verified';
    protected $primaryKey = "ID";
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    /**
     * The Tech Groups that belong to the user.
     */
    public function techgroups()
    {
        return $this->belongsToMany('App\Models\TechGroup', 'usertechgroups', 'User_id', 'Tech_id');
    }

    public function company()
    {
        return $this->hasOne('App\Models\Company', 'comp_id');
    }

    public function consultant()
    {
        return $this->hasOne('App\Models\Consultant', 'con_id');
    }

    public function events()
    {
        return $this->hasMany('App\Models\Event', 'users_id');
    }

//     @if ($product->supplier)
//     {{ $product->supplier->supplier_name }}
// @endif
    public function isAdmin()
    {
        return $this->type === self::ADMIN;
    }

    protected $fillable = [
        'name', 'email', 'password', 'email_token', 
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
}
