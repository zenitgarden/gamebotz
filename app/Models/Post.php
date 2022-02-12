<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Post extends Model
{
    use HasFactory, SoftDeletes, Sluggable;

    
    protected $fillable = [
        'title',
        'slug',
        'thumbnail',
        'excerpt',
        'content',
        'status',
        'user_id',
    ];

    public function tags()
    {
        return $this->belongsToMany(Tag::class,'tag_post')->withTimestamps();
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class,'category_post')->withTimestamps();
    }

    public function scopePublish($query)
    {
        return $query->where('status',"publish");
    }

    public function scopeDraft($query)
    {
        return $query->where('status',"draft");
    }

    public function scopeSearch($query,$title)
    {
        return $query->where('title','LIKE',"%{$title}%");
    }

    public function authors()
    {
        return $this->belongsTo(User::class,'user_id');
    }

    

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }
}
