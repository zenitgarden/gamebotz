<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use App\Models\Post;
use App\Models\Category;
use App\Models\SiteSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->middleware('permission:category_show',['only'=>'index']);
        $this->middleware('permission:category_create',['only'=>['create','store']]);
        $this->middleware('permission:category_update',['only'=>['edit','update']]);
        $this->middleware('permission:category_delete',['only'=>'destroy']);
    }

    public function select(Request $request)
    {
        $categories = [];
        if($request->has('q')){
            $search = $request->q;
            $categories = Category::select('id','title')->where('title','LIKE',"%$search%")->limit(6)->get();
        } else {
            $categories = Category::select('id','title')->OnlyParent()->limit(6)->get();
        }

        return response()->json($categories);
    } 

    public function index(Request $request)
    {
        $categories = Category::with('descendants');
        if($request->has('keyword') && trim($request->keyword)){
            
            $categories->search($request->keyword);
        }else{
            $categories->OnlyParent();
        }
        $siteSetting = SiteSetting::first();
        $postCount = Post::all()->count();
        $categCount = Category::all()->count();
        $tagCount = Tag::all()->count();

        $postCountUser  = Post::where('user_id', auth()->user()->id)->count();
        $trashCountUser = Post::where('user_id', auth()->user()->id)->onlyTrashed()->count();

        return view('category.index', [
            'categories' => $categories->paginate(15)->appends(['keyword' => $request->get('keyword')]),
            'postCount'=> $postCount,
            'categCount'=> $categCount,
            'tagCount'=> $tagCount,
            'siteSetting' =>  $siteSetting,

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
        $siteSetting = SiteSetting::first();
        $postCount = Post::all()->count();
        $categCount = Category::all()->count();
        $tagCount = Tag::all()->count();

        $postCountUser  = Post::where('user_id', auth()->user()->id)->count();
        $trashCountUser = Post::where('user_id', auth()->user()->id)->onlyTrashed()->count();


        return view('category.create',compact('postCount','categCount','tagCount','trashCountUser','postCountUser','siteSetting'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
                $validator = Validator::make($request->all(),[
                        
                    'title' => 'required|string|max:60|unique:categories,title',
                    'slug' => 'required|string|unique:categories,slug',
                ],
                [
                    'title.required' => 'Category cannot be empty',
                    'slug.required' => 'Slug cannot be empty',
                    'slug.unique' => 'Slug has been taken or category already exists',
                    'title.unique' => 'Category already exists',
                ],
                
            );

            if($validator->fails()){
                if($request->has('parent_category')){
                    $request['parent_category'] = Category::select('id', 'title')->find($request->parent_category);
                }
                return redirect()->back()->withInput($request->all())->withErrors($validator);
            }

            try {
                Category::create([
                    'title'=> $request->title,
                    'slug'=> $request->slug,
                    'parent_id'=> $request->parent_category,
                ]);
                Alert::success(
                    "Add Category", 
                    "Successfull creating category",
                );
                return redirect()->route('categories.index');
                
            } catch (\Throwable $th) {
                if($request->has('parent_category')){
                    $request['parent_category'] = Category::select('id', 'title')->find($request->parent_category);
                }
                
                 Alert::error( 
                    "ERROR", 
                    'Failed when creating category. ERROR: '. $th->getMessage(),
                 );
                return redirect()->back()->withInput($request->all());
            }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        $siteSetting = SiteSetting::first();
        $postCount = Post::all()->count();
        $categCount = Category::all()->count();
        $tagCount = Tag::all()->count();

        $postCountUser  = Post::where('user_id', auth()->user()->id)->count();
        $trashCountUser = Post::where('user_id', auth()->user()->id)->onlyTrashed()->count();

        return view('category.edit',[
            'category' => $category,
            'postCount' => $postCount,
            'categCount' => $categCount,
            'tagCount' => $tagCount,
            'siteSetting' =>  $siteSetting,

            'postCountUser' => $postCountUser,
            'trashCountUser' => $trashCountUser,
            
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
            // validasi data
            $validator = Validator::make($request->all(),[
                    
                'title' => 'required|string|max:60|unique:categories,title,'.$category->id,
                'slug' => 'required|string|unique:categories,slug,'. $category->id,

            ],
            [
                'title.required' => 'Category cannot be empty',
                'slug.required' => 'Slug cannot be empty',
                'slug.unique' => 'Slug has been taken or category already exists',
                'title.unique' => 'Category already exists',
            ],
        );
    
        if($validator->fails()){
            if($request->has('parent_category')){
                $request['parent_category'] = Category::select('id', 'title')->find($request->parent_category);
            }
            return redirect()->back()->withInput($request->all())->withErrors($validator);
        }

        if($request->parent_category == $category->id ){
            Alert::error( 
                "ERROR", 
                "Cannot select a category with the same parent category"
            );
            return redirect()->back();
        }

            // update data
        try {
            $category->update([
                'title'=> $request->title,
                'slug'=> $request->slug,
                'parent_id'=> $request->parent_category,
            ]);
            Alert::success(
                'Edit Category', 
                'Successfull updating category',
            );
            return redirect()->route('categories.index');
            
        } catch (\Throwable $th) {
            if($request->has('parent_category')){
                $request['parent_category'] = Category::select('id', 'title')->find($request->parent_category);
            }

            Alert::error( 
                "ERROR", 
                'Failed when updating category. ERROR: '. $th->getMessage(),
             );
            return redirect()->back()->withInput($request->all());
        }
    }   

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        try {
            $category->delete();
            Alert::success(
                'Delete Category', 
                'Successfull deleting '.$category->title,
            );
        } catch (\Throwable $th) {
            Alert::error( 
                "ERROR", 
                'Failed when deleting category. ERROR: '. $th->getMessage(),
             );
        }
        return redirect()->back();
    }
}
