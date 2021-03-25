<?php

namespace App;


// use Illuminate\Database\Eloquent\Factory\HasFactory;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password'
    ];


    public function roles(){
        return $this->belongsToMany('App\role');
    }

    /**
     * check if theres a role and returns true if the given 
     * role exists in the role_users table
     */
    public function hasAnyRole(string $role){
        return null !== $this->roles()->where('name', $role)->first(); 
    }

    /** 
     * check if the user has any given role and returns true if 
     * the given role exists in the role_users table
     */
    public function hasAnyRoles(array $role){
        return null !== $this->roles()->whereIn('name', $role)->first(); 
    }
}
