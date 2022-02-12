<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use App\Models\Post;
use App\Models\User;
use App\Models\Category;
use App\Models\SiteSetting;
use Illuminate\Http\Request;


class NewsController extends Controller
{

    public function index()
    {
        $posts = Post::with('authors')->publish()->latest()->whereHas('categories', function ($q) {
            return $q->where('slug','!=','recommendation-game'); 
        })->get();

        $posts1 = Post::with('authors')->publish()->latest()->whereHas('categories', function ($q) {
            return $q->where('slug','!=','recommendation-game'); 
        })->take(3)->get();

        $posts2 = Post::with('authors')->publish()->latest()->whereHas('categories', function ($q) {
            return $q->where('slug','!=','recommendation-game'); 
        })->skip(3)->take(3)->get();

        // note :post pc & console
        $postsCaroP = Post::publish()->latest()->whereHas('categories', function($q) {
            $q->where('title','=', 'PC')->orWhere('title','=','Console');
        })->take(5)->get();
        // note :post mobile
        $postsMb = Post::publish()->latest()->whereHas('categories', function($q) {
            $q->where('title','=', 'Mobile');
        })->take(5)->get();

        $flashPost = Post::publish()->inRandomOrder()->latest()->whereHas('categories', function ($q) {
            return $q->where('slug','!=','recommendation-game'); 
        })->take(3)->get();

        $postCarousel = Post::with('authors')->publish()->latest()->whereHas('categories', function ($q) {
            return $q->where('slug','!=','recommendation-game'); 
        })->take(4)->get();

        $trending = Post::with('authors')->publish()->orderBy('views','desc')->latest()->whereHas('categories', function ($q) {
            return $q->where('slug','!=','recommendation-game'); 
        })->take(3)->get();
        
        $recom = Post::with('authors')->publish()->with(['categories','tags'])->whereHas('categories', function ($q) {
            return $q->where('slug','recommendation-game'); 
        })->first();

        $site = SiteSetting::first();

        return view('news.index',[
            'posts'=> $posts,
            'recom'=> $recom,
            'posts1'=> $posts1,
            'posts2'=> $posts2,
            'postsCaroP'=> $postsCaroP,
            'postsMb'=> $postsMb,
            'flashPost'=> $flashPost,
            'postCarousel'=> $postCarousel,
            'trending'=> $trending,
            'site'=> $site,
        ]);
    }

    public function news()
    {

        $posts = Post::with('authors')->publish()->latest()->whereHas('categories', function($q) {
          $q->where('title','=', 'News');
        })->paginate(8);

        $flashPost = Post::publish()->inRandomOrder()->latest()->whereHas('categories', function ($q) {
            return $q->where('slug','!=','recommendation-game'); 
        })->take(3)->get();

        $latestPost = Post::with('authors')->publish()->latest()->whereHas('categories', function ($q) {
            return $q->where('slug','!=','recommendation-game'); 
        })->take(3)->get();

        $category = Category::where('title', 'News')->first();

        $trending = Post::with('authors')->publish()->orderBy('views','desc')->latest()->whereHas('categories', function ($q) {
            return $q->where('slug','!=','recommendation-game'); 
        })->take(3)->get();
        $site = SiteSetting::first();
        return view('news.category',[
            'posts'=> $posts,
            'category'=> $category,
            'flashPost'=> $flashPost,
            'latestPost'=> $latestPost,
            'trending'=> $trending,
            'site'=> $site,
        ]);
    }

    public function esport()
    {

        $posts = Post::with('authors')->publish()->latest()->whereHas('categories', function($q) {
          $q->where('title','=', 'Esports');
        })->paginate(8);

        $flashPost = Post::publish()->inRandomOrder()->latest()->whereHas('categories', function ($q) {
            return $q->where('slug','!=','recommendation-game'); 
        })->take(3)->get();

        $latestPost = Post::with('authors')->publish()->latest()->whereHas('categories', function ($q) {
            return $q->where('slug','!=','recommendation-game'); 
        })->take(3)->get();

        $category = Category::where('title', 'Esports')->first();

        $trending = Post::with('authors')->publish()->orderBy('views','desc')->latest()->whereHas('categories', function ($q) {
            return $q->where('slug','!=','recommendation-game'); 
        })->take(3)->get();
        $site = SiteSetting::first();
        return view('news.category',[
            'posts'=> $posts,
            'category'=> $category,
            'flashPost'=> $flashPost,
            'latestPost'=> $latestPost,
            'trending'=> $trending,
            'site'=> $site,
        ]);
    }

    public function tipsNtrick()
    {

        $posts = Post::with('authors')->publish()->latest()->whereHas('categories', function($q) {
          $q->where('title','=', 'Tips & Tricks');
        })->paginate(8);
        $flashPost = Post::publish()->inRandomOrder()->latest()->whereHas('categories', function ($q) {
            return $q->where('slug','!=','recommendation-game'); 
        })->take(3)->get();

        $latestPost = Post::with('authors')->publish()->latest()->whereHas('categories', function ($q) {
            return $q->where('slug','!=','recommendation-game'); 
        })->take(3)->get();

        $category = Category::where('title', 'Tips & Tricks')->first();

        $trending = Post::with('authors')->publish()->orderBy('views','desc')->latest()->whereHas('categories', function ($q) {
            return $q->where('slug','!=','recommendation-game'); 
        })->take(3)->get();
        
        $site = SiteSetting::first();
        return view('news.category',[
            'posts'=> $posts,
            'category'=> $category,
            'flashPost'=> $flashPost,
            'latestPost'=> $latestPost,
            'trending'=> $trending,
            'site'=> $site,
        ]);
    }

    public function detail($slug)
    {
        $post = Post::with('authors')->publish()->latest()->with(['categories','tags'])->where('slug',$slug)->first();

        $flashPost = Post::publish()->inRandomOrder()->latest()->whereHas('categories', function ($q) {
            return $q->where('slug','!=','recommendation-game'); 
        })->take(3)->get();

        $latestPost = Post::with('authors')->publish()->latest()->whereHas('categories', function ($q) {
            return $q->where('slug','!=','recommendation-game'); 
        })->take(3)->get();

        $post->increment('views');

        $trending = Post::with('authors')->publish()->orderBy('views','desc')->latest()->whereHas('categories', function ($q) {
            return $q->where('slug','!=','recommendation-game'); 
        })->take(3)->get();

        $related = Post::with('authors')->publish()->whereHas('tags', function ($q) use ($post) {
            return $q->whereIn('title', $post->tags->pluck('title')); 
        })->where('id', '!=', $post->id)->take(2)->get();

        if($related->count() != 2 || $related->count() < 2){
            $related = Post::with('authors')->publish()->whereHas('categories', function ($q) use ($post) {
                return $q->whereIn('title', $post->categories->where('title','!=','Recommendation Game')->pluck('title')); 
            })->where('id', '!=', $post->id)->take(2)->get();
        }

        $site = SiteSetting::first();
        return view('news.detail',[
            'post'=> $post,
            'flashPost'=> $flashPost,
            'latestPost'=> $latestPost,
            'trending'=> $trending,
            'related'=> $related,
            'site'=> $site,
        ]);
    }

    public function author($slug)
    {
        
        $posts = Post::with('authors')->publish()->latest()->whereHas('authors', function($query) use($slug){
            return $query->where('slug',$slug);
        })->whereHas('categories', function ($q) {
            return $q->where('slug','!=','recommendation-game'); 
        })->paginate(8);
        $author = User::where('slug', $slug)->first();

        $flashPost = Post::publish()->inRandomOrder()->latest()->whereHas('categories', function ($q) {
            return $q->where('slug','!=','recommendation-game'); 
        })->take(3)->get();

        $latestPost = Post::with('authors')->publish()->latest()->whereHas('categories', function ($q) {
            return $q->where('slug','!=','recommendation-game'); 
        })->take(3)->get();

        $trending = Post::with('authors')->publish()->orderBy('views','desc')->latest()->whereHas('categories', function ($q) {
            return $q->where('slug','!=','recommendation-game'); 
        })->take(3)->get();

        $site = SiteSetting::first();
        return view('news.author',[
            'posts'=> $posts,
            'author'=> $author,
            'flashPost'=> $flashPost,
            'latestPost'=> $latestPost,
            'trending'=> $trending,
            'site'=> $site,
        ]);
    }

    public function category($slug)
    {
        
        $posts = Post::with('authors')->publish()->latest()->whereHas('categories', function($query) use($slug){
            return $query->where('slug',$slug);
        })->paginate(8);
        $category = Category::where('slug', $slug)->first();

        $flashPost = Post::publish()->inRandomOrder()->latest()->whereHas('categories', function ($q) {
            return $q->where('slug','!=','recommendation-game'); 
        })->take(3)->get();

        $latestPost = Post::with('authors')->publish()->latest()->whereHas('categories', function ($q) {
            return $q->where('slug','!=','recommendation-game'); 
        })->take(3)->get();

        $trending = Post::with('authors')->publish()->orderBy('views','desc')->latest()->whereHas('categories', function ($q) {
            return $q->where('slug','!=','recommendation-game'); 
        })->take(3)->get();
        $site = SiteSetting::first();

        return view('news.category',[
            'posts'=> $posts,
            'category'=> $category,
            'flashPost'=> $flashPost,
            'latestPost'=> $latestPost,
            'trending'=> $trending,
            'site'=> $site,
        ]);
    }

    public function tag($slug)
    {
        
        $posts = Post::with('authors')->publish()->latest()->whereHas('tags', function($query) use($slug){
            return $query->where('slug',$slug);
        })->whereHas('categories', function ($q) {
            return $q->where('slug','!=','recommendation-game'); 
        })->paginate(8);
        $tag = Tag::where('slug', $slug)->first();

        $flashPost = Post::publish()->inRandomOrder()->latest()->whereHas('categories', function ($q) {
            return $q->where('slug','!=','recommendation-game'); 
        })->take(3)->get();

        $latestPost = Post::with('authors')->publish()->latest()->whereHas('categories', function ($q) {
            return $q->where('slug','!=','recommendation-game'); 
        })->take(3)->get();
        
        $trending = Post::with('authors')->publish()->orderBy('views','desc')->latest()->whereHas('categories', function ($q) {
            return $q->where('slug','!=','recommendation-game'); 
        })->take(3)->get();

        $site = SiteSetting::first();
        return view('news.tag',[
            'posts'=> $posts,
            'tag'=> $tag,
            'flashPost'=> $flashPost,
            'latestPost'=> $latestPost,
            'trending'=> $trending,
            'site'=> $site,
        ]);
    }

    public function searchPost(Request $request)
    {
        $flashPost = Post::publish()->inRandomOrder()->latest()->whereHas('categories', function ($q) {
            return $q->where('slug','!=','recommendation-game'); 
        })->take(3)->get();

        $latestPost = Post::with('authors')->publish()->latest()->whereHas('categories', function ($q) {
            return $q->where('slug','!=','recommendation-game'); 
        })->take(3)->get();

        $trending = Post::with('authors')->publish()->orderBy('views','desc')->latest()->whereHas('categories', function ($q) {
            return $q->where('slug','!=','recommendation-game'); 
        })->take(3)->get();

        $searched = Post::with('authors')->publish()->search($request->s)->whereHas('categories', function ($q) {
            return $q->where('slug','!=','recommendation-game'); 
        })->paginate(8)->withQueryString();

        $site = SiteSetting::first();
        if(!$request->get('s')){
            return redirect()->route('news.index');
        }else{
            return view('news.search',[
                'posts' => $searched,
                'flashPost'=> $flashPost,
                'latestPost'=> $latestPost,
                'trending'=> $trending,
                'site'=> $site,
            ]);
        }
        
    }

    public function recommendationGame()
    {
     
        $post = Post::with('categories')->whereHas('categories', function ($q) {
            return $q->where('slug','recommendation-game'); 
        })->first();
        

        $flashPost = Post::publish()->inRandomOrder()->latest()->whereHas('categories', function ($q) {
            return $q->where('slug','!=','recommendation-game'); 
        })->take(3)->get();
        $latestPost = Post::with('authors')->publish()->latest()->take(3)->whereHas('categories', function ($q) {
            return $q->where('slug','!=','recommendation-game'); 
        })->get();
        
        $trending = Post::with('authors')->publish()->orderBy('views','desc')->latest()->whereHas('categories', function ($q) {
            return $q->where('slug','!=','recommendation-game'); 
        })->take(3)->get();

        $site = SiteSetting::first();
        return view('news.recom',[
            'post'=> $post,
            'flashPost'=> $flashPost,
            'latestPost'=> $latestPost,
            'trending'=> $trending,
            'site'=> $site,
        ]);
    }

    public function about()
    {
        $about = SiteSetting::first();
        $flashPost = Post::publish()->inRandomOrder()->latest()->whereHas('categories', function ($q) {
            return $q->where('slug','!=','recommendation-game'); 
        })->take(3)->get();

        $latestPost = Post::with('authors')->publish()->latest()->take(3)->whereHas('categories', function ($q) {
            return $q->where('slug','!=','recommendation-game'); 
        })->get();
        

        $trending = Post::with('authors')->publish()->orderBy('views','desc')->latest()->whereHas('categories', function ($q) {
            return $q->where('slug','!=','recommendation-game'); 
        })->take(3)->get();


        $site = SiteSetting::first();
        return view('news.about',compact('about','flashPost','trending','latestPost','site'));
    }


}
