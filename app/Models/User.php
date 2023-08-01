<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Illuminate\Translation\MessageSelector;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

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
        return $this->belongsToMany(Chat::class)->withPivot('user_id');
    }

    public function chat(User $user)
    {
        return $this->chats()->attach($user);
    }

    public function userExists(User $user)
    {
        return $this->where('id', $user->id)->exists();
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

    public function friendships()
    {
        return $this->friends()->where('user_id', $this->id)->get();
    }

    public function hasChatWith(User $user)
    {
        return  DB::table('chat_user')
            ->whereIn('chat_id', $this->chats->modelKeys())
            ->where('user_id', $user->id)
            ->count() > 0;
    }

    public function getMessages(Chat $chat)
    {
        return $this->messages()->where('chat_id', $chat->id);
    }

    public function setPasswordAttribute($value){
        $this->attributes['password'] = bcrypt($value);
    }
}
