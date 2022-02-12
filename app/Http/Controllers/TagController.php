<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use App\Models\Post;
use App\Models\Category;
use App\Models\SiteSetting;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Validator;

class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->middleware('permission:tag_show',['only'=>'index']);
        $this->middleware('permission:tag_create',['only'=>['create','store']]);
        $this->middleware('permission:tag_update',['only'=>['edit','update']]);
        $this->middleware('permission:tag_delete',['only'=>'destroy']);
    }

    public function index(Request $request)
    {
        $siteSetting = SiteSetting::first();
        $postCount = Post::all()->count();
        $categCount = Category::all()->count();
        $tagCount = Tag::all()->count();

        $postCountUser  = Post::where('user_id', auth()->user()->id)->count();
        $trashCountUser = Post::where('user_id', auth()->user()->id)->onlyTrashed()->count();

        $tags = $request->get('keyword') 
        ? Tag::search($request->keyword)->paginate(10) 
        : Tag::paginate(10);
        return view('tags.index' ,[
            'tags'=> $tags->appends(['keyword'=>$request->keyword]),
            'postCount'=> $postCount,
            'categCount'=> $categCount,
            'tagCount'=> $tagCount,
            'siteSetting' => $siteSetting, 

            'postCountUser' => $postCountUser,
            'trashCountUser' => $trashCountUser,
        ]);
    }

    public function select(Request $request)
    {
        $tags = [];
        if ($request->has('q')) {
            $tags = Tag::select('id','title')->search($request->q)->get();
        }else{
            $tags = Tag::select('id','title')->limit(5)->get();
        }
        return response()->json($tags);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $siteSetting = SiteSetting::first();
        $postCount = Post::all()->count();
        $categCount = Category::all()->count();
        $tagCount = Tag::all()->count();
        $postCountUser  = Post::where('user_id', auth()->user()->id)->count();
        $trashCountUser = Post::where('user_id', auth()->user()->id)->onlyTrashed()->count();

        return view('tags.create',compact('postCount','categCount','tagCount','trashCountUser','postCountUser','siteSetting'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
            // validasi data
            Validator::make($request->all(),[
                    
                'title' => 'required|string|max:60|unique:tags,title',
                'slug' => 'required|string|unique:tags,slug',
            ],
            [
                'title.required' => 'Tag cannot be empty',
                'slug.required' => 'Slug cannot be empty',
                'slug.unique' => 'Slug has been taken or tag already exists',
                'title.unique' => 'Tag already exists',
            ],
            )->validate();
            
            try {
                Tag::create([
                    'title' => $request->title,
                    'slug'=> $request->slug,
                ]);
                Alert::success(
                    'Add Tag',
                    'Succesfull creating new tag',
                );

                return redirect()->route('tags.index');

            } catch (\Throwable $th) {
                //throw $th;
                Alert::error( 
                    "ERROR", 
                    'Failed when creating tag. ERROR: '. $th->getMessage(),
                 );

                return redirect()->back()->withInput($request->all());
            }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function show(Tag $tag)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function edit(Tag $tag)
    {
        $siteSetting = SiteSetting::first();
        $postCount = Post::all()->count();
        $categCount = Category::all()->count();
        $tagCount = Tag::all()->count();
        
        $postCountUser  = Post::where('user_id', auth()->user()->id)->count();
        $trashCountUser = Post::where('user_id', auth()->user()->id)->onlyTrashed()->count();
        return view('tags.edit',[
            'tag'=> $tag,
            'postCount' =>  $postCount,
            'categCount' =>  $categCount,
            'tagCount' =>  $tagCount,
            'siteSetting' =>  $siteSetting,

            'postCountUser' =>  $postCountUser,
            'trashCountUser' =>  $trashCountUser,

    
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Tag $tag)
    {
                // validasi data
            Validator::make($request->all(),[
                    
                'title' => 'required|string|max:60|unique:tags,title,'.$tag->id,
                'slug' => 'required|string|unique:tags,slug,' .$tag->id
            ],
            [
                'title.required' => 'Tag cannot be empty',
                'slug.required' => 'Slug cannot be empty',
                'slug.unique' => 'Slug has been taken or tag already exists',
                'title.unique' => 'Tag already exists',
            ],
            )->validate();

            try {
                $tag->update([
                    'title' => $request->title,
                    'slug'=> $request->slug,
                ]);
                Alert::success(
                    'Edit Tag',
                    'Succesfull editing tag',
                );

                return redirect()->route('tags.index');

            } catch (\Throwable $th) {
                //throw $th;
                Alert::error(
                    'ERROR',
                    'Failed when updating tag. ERROR: '.$th->getMessage(),
                );

                return redirect()->back()->withInput($request->all());
            }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tag $tag)
    {
        try {
            $tag->delete();
            Alert::success(
                'Delete Tag',
                'Successfull deleting '.$tag->title,
            );

        } catch (\Throwable $th) {
            //throw $th;
            Alert::error(
                'ERROR',
                'Failed when deleting tag. ERROR: '.$th->getMessage(),
            );
        }
        return redirect()->back();
    }
}
