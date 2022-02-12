<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SiteSetting extends Model
{
    use HasFactory;

    protected $table='site_settings';
 
    protected $fillable = [
        'logo',
        'favicon',
        'disqus_plugin',
        'facebook_link',
        'twitter_link',
        'instagram_link',
        'youtube_link',
        'about',
 
    ];
}
