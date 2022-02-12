<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use App\Models\Post;
use App\Models\User;
use App\Models\Category;
use App\Models\SiteSetting;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Validator;
use Cviebrock\EloquentSluggable\Services\SlugService;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    

    public function __construct()
    {
        $this->middleware('permission:post_show',['only'=>['index','showTrash']]);
        $this->middleware('permission:post_create',['only'=>['create','store']]);
        $this->middleware('permission:post_update',['only'=>['edit','update']]);
        $this->middleware('permission:post_detail',['only'=>'show']);
        $this->middleware('permission:post_delete',['only'=>['destroy','restoreTrash','deleteAll','kill']]);
    }

    public function index(Request $request)
    {
        /** @var \App\Models\User */
        $user= Auth::user();
       
        $status = [
            'draft',
            'publish',
        ];
     
        if($user->hasRole('Admin'))
        {
            switch ($request->get('f')) {
                case "$status[1]":
                    $posts = Post::with(['categories','authors'])->publish()->latest();
                  break;
                case "$status[0]":
                    $posts = Post::with(['categories','authors'])->draft()->latest();
                  break;
                case "myp":
                    $posts = Post::with(['categories','authors'])->where('user_id', auth()->user()->id)->latest();
                  break;
                default:
                    $posts = Post::with(['categories','authors'])->latest();
              }
            $posts->when(request('category'), function ($query) {
                $query->whereHas('categories', function ($query) {
                    $query->where('title', request('category'));
                });
            });
            $posts->when(request('author'), function ($query) {
                $query->whereHas('authors', function ($query) {
                    $query->where('name', request('author'));
                });
            });
        }else{
        switch ($request->get('f')) {
            case "$status[1]":
                $posts = Post::with(['categories','authors'])->where('user_id', auth()->user()->id)->publish()->latest();
              break;
            case "$status[0]":
                $posts = Post::with(['categories','authors'])->where('user_id', auth()->user()->id)->draft()->latest();
              break;
            default:
                $posts = Post::with(['categories','authors'])->where('user_id', auth()->user()->id)->latest();
          }
          $posts->when(request('category'), function ($query) {
            $query->whereHas('categories', function ($query) {
                $query->where('title', request('category'));
            });
        });
        }
        
        $siteSetting = SiteSetting::first();
        $publishCount = Post::publish()->count();
        $draftCount = Post::draft()->count();
        $postCount = Post::all()->count();

        $publishCountUser = Post::where('user_id', auth()->user()->id)->publish()->count();
        $draftCountUser  = Post::where('user_id', auth()->user()->id)->draft()->count();
        $postCountUser  = Post::where('user_id', auth()->user()->id)->count();
        $trashCountUser = Post::where('user_id', auth()->user()->id)->onlyTrashed()->count();

        $categCount = Category::all()->count();
        $tagCount = Tag::all()->count();


        return view('posts.index',[
            'status'=> $status,
            'posts' => $posts->whereHas('categories', function ($q){
                return $q->where('slug','!=','recommendation-game');
            })->get(),
            'postCount' => $postCount,
            'categCount' => $categCount,
            'tagCount' => $tagCount,
            'publishCount' => $publishCount,
            'draftCount' => $draftCount,
            'siteSetting' => $siteSetting,  

            'publishCountUser' => $publishCountUser,
            'draftCountUser' => $draftCountUser,
            'postCountUser' => $postCountUser,
            'trashCountUser' => $trashCountUser,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user= Auth::user();
        if($user->username == null){
            Alert::html('Setup Account', '<p>You need to complete the information about your account, so you can create post.<p> <a href="dashboard/profile">Go to profile</a> ', 'warning');
            return redirect()->route('dashboard.index');
          }
        $siteSetting = SiteSetting::first();
        $postCount = Post::all()->count();
        $categCount = Category::all()->count();
        $tagCount = Tag::all()->count();
        $trashCountUser = Post::where('user_id', auth()->user()->id)->onlyTrashed()->count();
        $postCountUser  = Post::where('user_id', auth()->user()->id)->count();

        return view('posts.create',[
            'postCount'=> $postCount,
            'categCount' => $categCount,
            'tagCount' => $tagCount,
            'status'=> ['draft','publish'],
            'categories' => Category::with('descendants')->onlyParent()->where('slug','!=','recommendation-game')->get(),
            'siteSetting' => $siteSetting,  

            'trashCountUser' => $trashCountUser,
            'postCountUser' => $postCountUser,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
            $validator = Validator::make($request->all(),
            [
                'title'=> 'required|string|max:250',
                'slug'=> 'required|string|max:250|unique:posts,slug',
                'thumbnail'=> 'required|image|mimes:jpg,jpeg,png',
                'content'=> 'required',
                'category'=> 'required',
                'tag'=> 'required',
                'status'=> 'required',
            ],
            [
                'title.required' => 'Title cannot be empty',
                'slug.required' => 'Slug cannot be empty',
                'slug.unique' => 'Slug has been taken',
                'thumbnail.required' => 'Please Choose image ',
                'thumbnail.image' => 'The type file should be an image',
                'content.required' => 'Content cannot be empty',
                'category.required'=> 'Please Choose category !',
                'tag.required'=> 'Please Choose tag !',
                'status.required'=> 'Choose status !',
            ],
           
        );

        if($validator->fails()){
            if($request['tag']){
                $request['tag'] = Tag::select('id','title')->whereIn('id',$request->tag)->get();
            }
            return redirect()->back()->withInput($request->all())->withErrors($validator);
        }


        DB::beginTransaction();
        try {

            $fileName = null;
            if (request()->hasFile('thumbnail')) {
                $file = request()->file('thumbnail');
                $fileName = $file->storeAs('/thumbnail', $request->slug . "-" . time() . "." . $file->getClientOriginalExtension(), 'public');
    
                //  md5 file name 
                // $fileName = md5($file->getClientOriginalName(). "-". time()) . "." . $file->getClientOriginalExtension();
                // $file->move('./uploads/photos/shares/', $fileName);    
            }
            
            $post = Post::create([
                'title'=> $request->title,
                'slug'=> $request->slug,
                'thumbnail'=> '/uploads/'. $fileName,
                'content'=> $request->content,
                'excerpt' => Str::limit(strip_tags($request->content),120),
                'status'=> $request->status,
                'user_id'=> Auth::user()->id,
            ]);
            $post->tags()->attach($request->tag);
            $post->categories()->attach($request->category);

            Alert::success(
                'Add Post',
                'Succesful creating a new post',
            );

            return redirect()->route('posts.index');
        } catch (\Throwable $th) {
            DB::rollBack();
            Alert::error(
                'ERROR',
                'Failed when creating a new post ERROR: '.$th->getMessage(),
            );
            if($validator->fails()){
                if($request['tag']){
                    $request['tag'] = Tag::select('id','title')->whereIn('id',$request->tag)->get();
                }
                return redirect()->back()->withInput($request->all())->withErrors($validator);
            }
            return redirect()->back()->withInput($request->all());
        }finally{
            DB::commit();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
    //     /** @var \App\Models\User */
    //     $user= Auth::user();
    //     if($post->authors->id !== $user->id && !$user->hasRole('Admin')) {
    //         abort(403);
    //    }
        $siteSetting = SiteSetting::first();
        $postCount = Post::all()->count();
        $categCount = Category::all()->count();
        $tagCount = Tag::all()->count();
        $categories = $post->categories;
        $tags = $post->tags;
        $trashCountUser = Post::where('user_id', auth()->user()->id)->onlyTrashed()->count();
        $postCountUser  = Post::where('user_id', auth()->user()->id)->count();

        return view('posts.detail',[
            'post'=> $post,
            'postCount' =>  $postCount,
            'categCount' =>  $categCount,
            'tagCount' =>  $tagCount,
            'categories' => $categories,
            'tags' => $tags,
            'siteSetting' => $siteSetting,  

            'trashCountUser' => $trashCountUser,
            'postCountUser' => $postCountUser,
    
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        /** @var \App\Models\User */
        $user= Auth::user();
        if($post->authors->id !== $user->id && !$user->hasRole('Admin')) {
            abort(403);
       }
       $siteSetting = SiteSetting::first();
        $postCount = Post::all()->count();
        $categCount = Category::all()->count();
        $tagCount = Tag::all()->count();
        $trashCountUser = Post::where('user_id', auth()->user()->id)->onlyTrashed()->count();
        $postCountUser  = Post::where('user_id', auth()->user()->id)->count();

        return view('posts.edit',[
            'post'=> $post,
            'postCount' =>  $postCount,
            'categCount' =>  $categCount,
            'tagCount' =>  $tagCount,
            'status'=> ['draft','publish'],
            'categories' => Category::with('descendants')->onlyParent()->where('slug','!=','recommendation-game')->get(),
            'siteSetting' => $siteSetting,  

            'trashCountUser' => $trashCountUser,
            'postCountUser' => $postCountUser,
    
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        /** @var \App\Models\User */
        $user= Auth::user();
        if($post->authors->id !== $user->id && !$user->hasRole('Admin')) {
            abort(403);
       }
        $validator = Validator::make($request->all(),
            [
                'title'=> 'required|string|max:250',
                'slug'=> 'required|string|max:250|unique:posts,slug,' .$post->id,
                'thumbnail'=> 'image||mimes:jpg,jpeg,png',
                'content'=> 'required',
                'category'=> 'required',
                'tag'=> 'required',
                'status'=> 'required',
            ],
            [
                'title.required' => 'Title cannot be empty',
                'slug.required' => 'Slug cannot be empty',
                'slug.unique' => 'Slug has been taken',
                'thumbnail.required' => 'Please Choose image ',
                'thumbnail.image' => 'The type file should be an image',
                'content.required' => 'Content cannot be empty',
                'category.required'=> 'Please Choose category !',
                'tag.required'=> 'Please Choose tag !',
                'status.required'=> 'Choose status !',
            ],
        );
        if($validator->fails()){
            if($request['tag']){
                $request['tag'] = Tag::select('id','title')->whereIn('id',$request->tag)->get();
            }
            return redirect()->back()->withInput($request->all())->withErrors($validator);
        }

        
        
        DB::beginTransaction();
        try {

            $data = [
                'title'=> $request->title,
                'slug'=> $request->slug,
                'excerpt' => Str::limit(strip_tags($request->content),120),
                'content'=> $request->content,
                'status'=> $request->status,
                
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
            $post->update($data);
            $post->tags()->sync($request->tag);
            $post->categories()->sync($request->category);

            Alert::success(
                'Edit Post',
                'Succesful editing post',
            );

            return redirect()->route('posts.index');
        } catch (\Throwable $th) {
            DB::rollBack();
            Alert::error(
                'ERROR',
                'Failed when editing post ERROR: '.$th->getMessage(),
            );
            if($validator->fails()){
                if($request['tag']){
                    $request['tag'] = Tag::select('id','title')->whereIn('id',$request->tag)->get();
                }
                return redirect()->back()->withInput($request->all())->withErrors($validator);
            }
            return redirect()->route('posts.index');
        }finally{
            DB::commit();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        /** @var \App\Models\User */
        $user= Auth::user();
        if($post->authors->id !== $user->id && !$user->hasRole('Admin')) {
            abort(403);
       }

        DB::beginTransaction();
        try {
        
            $post->delete();
            
            Alert::success(
                'Delete Post',
                'Succesfull deleting post, moved it to trash',
            );

            return redirect()->route('posts.index');
        } catch (\Throwable $th) {
            DB::rollBack();
            Alert::error(
                'ERROR',
                'Failed when deleting post ERROR: '.$th->getMessage(),
            );
            
        }finally{
            DB::commit();

            return redirect()->back();
        }
    }

    public function showTrash()
    {
        $siteSetting = SiteSetting::first();
        $postCount = Post::all()->count();
        $categCount = Category::all()->count();
        $tagCount = Tag::all()->count();
        $publishCount = Post::publish()->count();
        $draftCount = Post::draft()->count();


        $publishCountUser = Post::where('user_id', auth()->user()->id)->publish()->count();
        $draftCountUser  = Post::where('user_id', auth()->user()->id)->draft()->count();
        $postCountUser  = Post::where('user_id', auth()->user()->id)->count();
        $trashCountUser = Post::where('user_id', auth()->user()->id)->onlyTrashed()->count();

       
    
        $posts = Post::with('categories')->where('user_id', auth()->user()->id)->onlyTrashed()->get();
        return view('posts.trash',[
            'postCount' =>  $postCount,
            'categCount' =>  $categCount,
            'tagCount' =>  $tagCount,
            'posts' => $posts,
            'publishCount' => $publishCount,
            'draftCount' => $draftCount,
            'siteSetting' => $siteSetting,  

            'publishCountUser' => $publishCountUser,
            'draftCountUser' => $draftCountUser,
            'postCountUser' => $postCountUser,
            'trashCountUser' => $trashCountUser,

        ]);
    }

    public function restoreTrash($slug)
    {
     
        $post = Post::withTrashed()->where('user_id', Auth::user()->id)->where('slug', $slug)->first();
   
        if($post == null){
            abort(403);
        }
        if($post->slug != $slug){
            abort(403);
        }
        DB::beginTransaction();
        try {
            $post = Post::withTrashed()->where('slug', $slug)->first();
            $post->restore();
            
            Alert::success(
                'Restore Post',
                'Succesful Restoring post',
            );

            return back();
        } catch (\Throwable $th) {
            DB::rollBack();
            Alert::error(
                'ERROR',
                'Failed when deleting post ERROR: '.$th->getMessage(),
            );
            
        }finally{
            DB::commit();

            return redirect()->back();
        }
    }

    public function kill($slug)
    {
        $post = Post::withTrashed()->where('user_id', Auth::user()->id)->where('slug', $slug)->first();
   
        if($post == null){
            abort(403);
        }
        if($post->slug != $slug){
            abort(403);
        }

        //Delete file 
        $imagePath = DB::table('posts')->select('thumbnail')->where('slug', $slug)->first();
        if($imagePath->thumbnail){
        File::delete(public_path($imagePath->thumbnail));
        }

        DB::beginTransaction();
        try {
            $post = Post::withTrashed()->where('slug', $slug)->first();
            $post->tags()->detach();
            $post->categories()->detach();
            $post->forceDelete();
            
            Alert::success(
                'Delete Post',
                'Succesful deleting post permanently ',
            );

            return back();
        } catch (\Throwable $th) {
            DB::rollBack();
            Alert::error(
                'ERROR',
                'Failed when deleting post ERROR: '.$th->getMessage(),
            );
            
        }finally{
            DB::commit();

            return redirect()->back();
        }
    }

    public function deleteAll()
    {
       
        $posts = Post::where('user_id', Auth::user()->id)->onlyTrashed()->get();
        if($posts){
            foreach($posts as $post){
                File::delete(public_path($post->thumbnail));
                $post->forceDelete();
                $post->tags()->detach();
                $post->categories()->detach();
            }

                Alert::success(
                    'Delete All ',
                    'Succesful deleting all trashs',
                );
                return back();
        }else{
            Alert::error(
                'Delete All ',
                'No post',
            );
            return redirect()->back();
        }
      
    }

    public function checkSlug(Request $request)
    {
        $slug =  SlugService::createSlug(Post::class, 'slug', $request->title);
        return response()->json(['slug'=> $slug]);
    }
}
