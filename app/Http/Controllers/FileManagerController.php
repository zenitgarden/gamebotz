<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use App\Models\Post;
use App\Models\Category;
use App\Models\SiteSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FileManagerController extends Controller
{
    public function index()
    {   
        if(Auth::check() != true){abort(404);}
        
        $siteSetting = SiteSetting::first();
        $postCount = Post::all()->count();
        $categCount = Category::all()->count();
        $tagCount = Tag::all()->count();
        $postCountUser  = Post::where('user_id', auth()->user()->id)->count();
        $trashCountUser = Post::where('user_id', auth()->user()->id)->onlyTrashed()->count();
        return view('filemanager.index',[

            'postCount' => $postCount,
            'categCount' => $categCount,
            'tagCount' => $tagCount,
            'siteSetting' => $siteSetting,

            'postCountUser' => $postCountUser,
            'trashCountUser' => $trashCountUser,
        ]);
    }
}
