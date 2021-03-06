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

    /**
     * Получить имя пользователя
     */
    public function getUsername()
    {
        return $this->username;
    }

    public function getId()
    {
        return $this->id;
    }

    /**
     * Получить аватар пользователя
     */
    public function getAvatar()
    {
        return "https://www.gravatar.com/avatar/{{ md5($this->email)?d=mp&s=40 }}";
    }

    /**
     * Пользователю принадлежит публикация
     */
    public function statuses()
    {
        return $this->hasMany('App\Models\Status', 'user_id');
    }

    /**
     * Пользователю принадлежит сообщение
     */
    public function messages()
    {
        return $this->hasMany('App\Models\Message', 'auth_id');
    }


    /**
     * Отношения многие ко многим(мои друзья)
     */
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
     * Удалить из друзей
     */
    public function deleteFriend(User $user)
    {
        $this->friend()->detach($user->id);
        $this->myFriends()->detach($user->id);
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

    public function avatarsPath($user_id)
    {
        $path = "uploads/avatars/id{$user_id}";

        if (!file_exists("$path")) {
            mkdir($path, 0755, true);
        }

        return "/$path/";
    }

    public function clearAvatars($user_id)
    {
        $path = "uploads/avatars/id{$user_id}";

        if (file_exists(public_path("/$path"))) {
            foreach (glob(public_path("/$path/*")) as $avatar) {
                unlink($avatar);
            }
        }
    }
}
