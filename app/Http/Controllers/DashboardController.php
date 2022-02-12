<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use App\Models\Post;
use App\Models\User;
use App\Models\Category;
use App\Models\SiteSetting;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Validator;

class DashboardController extends Controller
{

    public function __construct()
    {
        $this->middleware('permission:recommendation_game_show',['only'=>'recommendationGame']);
        $this->middleware('permission:recommendation_game_edit',['only'=>['edit','update']]);
    }

    public function index()
    {
        $siteSetting = SiteSetting::first();
        $categCount = Category::all()->count();
        $tagCount = Tag::all()->count();
        $postCount = Post::all()->count();
        $users = User::all();
        $authorCount = User::role('Author')->get()->count();
        
        $postCountUser  = Post::where('user_id', auth()->user()->id)->count();
        $trashCountUser = Post::where('user_id', auth()->user()->id)->onlyTrashed()->count();

         /** @var \App\Models\User */
         $user = Auth::user();
        if($user->hasRole('Admin') == true){
            $latestPost = Post::with('authors')->publish()->latest()->whereHas('categories', function ($q){
                return $q->where('slug','!=','recommendation-game');
            })->take(6)->get();
        }else{
            $latestPost = Post::with('authors')->publish()->latest()->whereHas('categories', function ($q){
                return $q->where('slug','!=','recommendation-game');
            })->where('user_id', auth()->user()->id)->take(6)->get();
        }
       
        $date = Carbon::today()->subDays(7);
        $popularPost = Post::with('authors')->publish()->orderBy('views', 'DESC')->where('created_at', '>=',$date)->whereHas('categories', function ($q){
            return $q->where('slug','!=','recommendation-game');
        })->take(6)->get();

        return view('dashboard.index',[
            'postCount'=>$postCount,
            'categCount' => $categCount,
            'tagCount' => $tagCount,
            'siteSetting' =>  $siteSetting,
            'users' => $users,
            'authorCount' => $authorCount,

            'postCountUser' => $postCountUser,
            'trashCountUser' => $trashCountUser,

            'latestPost'=> $latestPost,
            'popularPost'=> $popularPost,

        ]);
    }

    public function recommendationGame()
    {
        $post = Post::with(['categories','tags'])->whereHas('categories', function ($q) {
            return $q->where('slug','recommendation-game'); 
        })->first();
        $categories = $post->categories;

        $siteSetting = SiteSetting::first();
        $postCount = Post::all()->count();
        $categCount = Category::all()->count();
        $tagCount = Tag::all()->count();
        
        $postCountUser  = Post::where('user_id', auth()->user()->id)->count();
        $trashCountUser = Post::where('user_id', auth()->user()->id)->onlyTrashed()->count();

        return view('dashboard.recom',[
            'post'=>$post,
            'categories'=>$categories,
            'postCount'=>$postCount,
            'categCount' => $categCount,
            'tagCount' => $tagCount,
            'siteSetting' =>  $siteSetting,
            'postCountUser' => $postCountUser,
            'trashCountUser' => $trashCountUser,
        ]);
    }

    public function edit()
    {
    
        $post = Post::with(['categories','tags'])->whereHas('categories', function ($q) {
            return $q->where('slug','recommendation-game'); 
        })->first();
        $siteSetting = SiteSetting::first();
        $postCount = Post::all()->count();
        $categCount = Category::all()->count();
        $tagCount = Tag::all()->count();
        $trashCountUser = Post::where('user_id', auth()->user()->id)->onlyTrashed()->count();
        $postCountUser  = Post::where('user_id', auth()->user()->id)->count();

        return view('dashboard.edit-recom',[
            'post'=> $post,
            'postCount' =>  $postCount,
            'categCount' =>  $categCount,
            'tagCount' =>  $tagCount,
            'siteSetting' => $siteSetting,  

            'trashCountUser' => $trashCountUser,
            'postCountUser' => $postCountUser,
    
        ]);
    }

    public function update(Request $request)
    {
       
        $validator = Validator::make($request->all(),
            [
                'title'=> 'required|string|max:250',
                'thumbnail'=> 'image||mimes:jpg,jpeg,png',
                'content'=> 'required',
            ],
            [
                'title.required' => 'Title cannot be empty',
                'thumbnail.required' => 'Please Choose image ',
                'thumbnail.image' => 'The type file should be an image',
                'content.required' => 'Content cannot be empty',
            ],
        );
        if($validator->fails()){
            return redirect()->back()->withInput($request->all())->withErrors($validator);
        }

        
        DB::beginTransaction();
        try {

            $data = [
                'title'=> $request->title,
                'excerpt' => Str::limit(strip_tags($request->content),120),
                'content'=> $request->content,
                'user_id'=> Auth::user()->id,
                    
            ];
            // if change thumbnail file ? run the code below : just update $data above
            $fileName = null;
            if($request->file('thumbnail')){
                if($request->oldImage){
                    File::delete(public_path($request->oldImage));
                }
                $file = $request->file('thumbnail');
                $fileName = $file->storeAs('/thumbnail', $request->slug . "-2" . time() . "." . $file->getClientOriginalExtension(), 'public');
                $data['thumbnail'] = '/uploads/'. $fileName;
            }
            // Updating
            $post = Post::with(['categories','tags'])->whereHas('categories', function ($q) {
                return $q->where('slug','recommendation-game'); 
            })->first();

            $post->update($data);

            Alert::success(
                'Edit Post',
                'Succesful editing post',
            );

            return redirect()->route('dashboard.recom');
        } catch (\Throwable $th) {
            DB::rollBack();
            Alert::error(
                'ERROR',
                'Failed when editing post ERROR: '.$th->getMessage(),
            );
            if($validator->fails()){
                return redirect()->back()->withInput($request->all())->withErrors($validator);
            }
            return redirect()->route('dashboard.recom');
        }finally{
            DB::commit();
        }
    }
}
