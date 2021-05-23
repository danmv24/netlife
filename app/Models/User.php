<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'email',
        'username',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getUsername()
    {
        return $this->username;
    }

    public function getAvatar()
    {
        return "https://www.gravatar.com/avatar/{{ md5($this->email)?d=mp&s=40 }}";
    }

    public function myFriends()
    {
        return $this->belongsToMany('App\Models\User', 'friends',
            'user_id', 'friend_id');
    }

    public function friend()
    {
        return $this->belongsToMany('App\Models\User', 'friends',
            'friend_id', 'user_id');
    }

    public function friends()
    {
        return $this->myFriends()->wherePivot('accepted', true)->get()
            ->merge($this->friend()->wherePivot('accepted', true)->get());
    }

    public function friendRequests()
    {
        return $this->myFriends()->wherePivot('accepted', false)->get();
    }
}
