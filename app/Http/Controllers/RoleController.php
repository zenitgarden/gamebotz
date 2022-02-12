<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use App\Models\Post;
use App\Models\Category;
use App\Models\SiteSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Validator;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->middleware('permission:role_show',['only'=>'index']);
        $this->middleware('permission:role_create',['only'=>['create','store']]);
        $this->middleware('permission:role_update',['only'=>['edit','update']]);
        $this->middleware('permission:role_detail',['only'=>'show']);
        $this->middleware('permission:role_delete',['only'=>'destroy']);
    }

    public function index(Request $request)
    {
        $roles = [];
        if($request->has('keyword')){
            $roles = Role::where('name','LIKE',"%{$request->keyword}%")->paginate(10);
        }else{
            $roles = Role::paginate(10);
        }
        $siteSetting = SiteSetting::first();
        $postCount = Post::all()->count();
        $categCount = Category::all()->count();
        $tagCount = Tag::all()->count();

        $postCountUser  = Post::where('user_id', auth()->user()->id)->count();
        $trashCountUser = Post::where('user_id', auth()->user()->id)->onlyTrashed()->count();


        return view('role.index',[
            'roles' => $roles->appends(['keyword'=>$request->keyowrd]), 
            'postCount' => $postCount,
            'categCount' => $categCount,
            'tagCount' => $tagCount,
            'siteSetting' => $siteSetting,
            
            'postCountUser' => $postCountUser,
            'trashCountUser' => $trashCountUser,
        ]);
    }

    public function select(Request $request)
    {
        $roles = Role::select('id','name')->limit(7);
       if($request->has('q')){
           $roles->where('name','LIKE',"%{$request->q}%");
       }
        return response()->json( $roles->get());
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

        return view('role.create',[
            'authorities' => config('permission.authorities'),
            'postCount' => $postCount,
            'categCount' => $categCount,
            'tagCount' => $tagCount,
            'siteSetting' => $siteSetting,

            'postCountUser' => $postCountUser,
            'trashCountUser' => $trashCountUser,

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
        $validator = Validator::make(
            $request->all(),
            [
                'name'=> "required|string|unique:roles,name",
                'permissions'=> "required",
            ],
            [
                'name.required'=> "Role name cannot be empty",
                'name.unique'=> "Role name has been taken",
                'permissions.required'=> "Please choose permission !",
            ],
           
        );

        if($validator->fails()){
            return redirect()->back()->withInput($request->all())->withErrors($validator);
        }
        DB::beginTransaction();
        try {
           $role = Role::create(['name' => $request->name]);
           $role->givePermissionTo($request->permissions);

           Alert::success(
               "Add Role",
               "Succesful creating new role",
           );
           return redirect()->route('roles.index');
        } catch (\Throwable $th) {
            Alert::error(
               "ERROR",
               'Failed when creating a new role ERROR: '.$th->getMessage(),
            );
            return redirect()->back()->withInput($request->all());
        }finally{
            DB::commit();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Role $role)
    {
        $siteSetting = SiteSetting::first();
        $postCount = Post::all()->count();
        $categCount = Category::all()->count();
        $tagCount = Tag::all()->count();

        $postCountUser  = Post::where('user_id', auth()->user()->id)->count();
        $trashCountUser = Post::where('user_id', auth()->user()->id)->onlyTrashed()->count();

        return view('role.detail',[
            'role' => $role,
            'postCount' => $postCount,
            'categCount' => $categCount,
            'tagCount' => $tagCount,
            'authorities' => config('permission.authorities'),
            'rolePermission' =>$role->permissions->pluck('name')->toArray(),
            'siteSetting' => $siteSetting,

            'postCountUser' => $postCountUser,
            'trashCountUser' => $trashCountUser,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Role $role)
    {
        $siteSetting = SiteSetting::first();
        $postCount = Post::all()->count();
        $categCount = Category::all()->count();
        $tagCount = Tag::all()->count();
        
        $postCountUser  = Post::where('user_id', auth()->user()->id)->count();
        $trashCountUser = Post::where('user_id', auth()->user()->id)->onlyTrashed()->count();

        
        return view('role.edit',[
            'role' => $role,
            'postCount' => $postCount,
            'categCount' => $categCount,
            'tagCount' => $tagCount,
            'authorities' => config('permission.authorities'),
            'rolePermission' =>$role->permissions->pluck('name')->toArray(),
            'permissionChecked' => $role->permissions->pluck('name')->toArray(),
            'siteSetting' => $siteSetting,

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
    public function update(Request $request, Role $role)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'name'=> "required|string|unique:roles,name," . $role->id,
                'permissions'=> "required",
            ],
            [
                'name.required'=> "Role name cannot be empty",
                'name.unique'=> "Role name has been taken",
                'permissions.required'=> "Please choose permission !",
            ],
          
        );

        if($validator->fails()){
            return redirect()->back()->withInput($request->all())->withErrors($validator);
        }

        DB::beginTransaction();
        try {
           $role->name =  $request->name;
           $role->syncPermissions($request->permissions);
           $role->save();

            Alert::success(
                "Update Role",
                "Succesful updating role",
            );
           return redirect()->route('roles.index');
        } catch (\Throwable $th) {
            Alert::error(
                "ERROR",
                'Failed when updating role ERROR: '.$th->getMessage(),
             );
            return redirect()->back()->withInput($request->all());
        }finally{
            DB::commit();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Role $role)
    {
        DB::beginTransaction();
        try {
            $role->revokePermissionTo($role->permissions->pluck('name')->toArray());
            $role->delete();

            Alert::success(
                "Delete Role",
                "Succesful deleting role",
            );
        } catch (\Throwable $th) {
            DB::rollBack();
            Alert::error(
                "ERROR",
                'Failed when deleting role ERROR: '.$th->getMessage(),
            );
            
        }finally{
            DB::commit();
        }
        return redirect()->route('roles.index');
    }
}
