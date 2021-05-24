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
        /**
         * Получить имя пользователя
         */
        return $this->username;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getAvatar()
        /**
         * Получить аватар пользователя
         */
    {
        return "https://www.gravatar.com/avatar/{{ md5($this->email)?d=mp&s=40 }}";
    }

    public function myFriends()
    {
        /**
         * Отношения многие ко многим(мои друзья)
         */
        return $this->belongsToMany('App\Models\User', 'friends',
            'user_id', 'friend_id');
    }

    public function friend()
    {
        return $this->belongsToMany('App\Models\User', 'friends',
            'friend_id', 'user_id');
    }

    /**
     * Друзья. У обоих пользователей должна быть подтверждена дружба(accepted должно равняться true)
     */
    public function friends()
    {
        return $this->myFriends()->wherePivot('accepted', true)->get()
            ->merge($this->friend()->wherePivot('accepted', true)->get());
    }

    /**
     * Запросы в друзья
     */
    public function friendRequests()
    {
        return $this->myFriends()->wherePivot('accepted', false)->get();
    }

    /**
     * Запрос на ожидание друга
     */
    public function friendRequestsPending()
    {
        return $this->friend()->wherePivot('accepted', false)->get();
    }

    /**
     * Есть запрос на добавление в друзья
     */
    public function hasFriendRequestsPending(User $user)
    {
        return (bool) $this->friendRequestsPending()->where('id', $user->id)->count();
    }

    /**
     * Получил запрос дружбы
     */
    public function hasFriendRequestReceived(User $user)
    {
        return (bool) $this->friendRequests()->where('id', $user->id)->count();
    }

    /**
     * Добавить в друзья
     */
    public function addFriend(User $user)
    {
        $this->friend()->attach($user->id);
    }

    /**
     * Принять запрос дружбы
     */
    public function acceptFriendRequest(User $user)
    {
        $this->friendRequests()->where('id', $user->id)->first()->pivot->update([
           'accepted' => true
        ]);
    }

    /**
     * Пользователь дружит с
     */
    public function isFriendWith(User $user)
    {
        return (bool) $this->friends()->where('id', $user->id)->count();
    }
}
