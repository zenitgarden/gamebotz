<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $fillable = ['title','slug','parent_id'];

    public function scopeOnlyParent($query)
    {
        return $query->whereNull('parent_id');
    }

    public function parent()
    {
        return $this->belongsTo(self::class);
    }

    public function children()
    {
        return $this->hasMany(self::class, 'parent_id');
    }

    public function descendants()
    {
        return $this->children()->with('descendants');
    }

    public function scopeSearch($query ,$title)
    {
        return $query->where('title','LIKE',"%{$title}%");
    }

    public function root()
    {
        return $this->parent ? $this->parent->root() : $this;
    }

    public function posts()
    {
        return $this->hasMany(Post::class, 'parent_id');
    }
    public function getRouteKeyName()
    {
        return 'slug';
    }
}
