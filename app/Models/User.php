<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function chats()
    {
        return $this->belongsToMany(Chat::class);
    }

    public function chat(User $user)
    {
        return $this->chats()->attach($user);
    }

    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    public function friends()
    {
        return $this->belongsToMany(User::class, 'friends', 'user_id', 'friend_id');
    }

    public function follow(User $user)
    {
        if ($this->id !== $user->id) {
            return $this->friends()->attach($user->id);
        }
    }

    public function unfollow(User $user)
    {
        return $this->friends()->detach($user->id);
    }

    public function isFriends(User $user)
    {
        return $this->friends->contains($user->id);
    }

    public function friendss()
    {
        return $this->friends()->where('user_id', $this->id)->get();
    }
}

