<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Cache;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'slug',
        'description',
        'facebook_link',
        'twitter_link',
        'instagram_link',
        'youtube_link',
        'avatar',

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

    public function posts()
    {
        return $this->hasMany(Post::class);
    }
    
    public function scopeSearch($query, $name)
    {
        return $query->where('name','LIKE',"%{$name}%")->orWhere('username', 'like', '%' . $name . '%');;
    }
    
    public function postPub()
    {
        return $this->hasMany(Post::class)->where('status', '=', 'publish');
    }

    public function postlatest()
    {
        return $this->hasMany(Post::class)->where('status', '=', 'publish')->orderBy('created_at', 'desc')->whereHas('categories', function ($q) {
            return $q->where('slug','!=','recommendation-game'); 
        });
    }

    public function isOnline()
    {
        return Cache::has('is_online' . $this->id);
    }
    
    public function getRouteKeyName()
    {
        return 'slug';
    }


}
