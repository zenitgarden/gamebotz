<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use App\Models\Post;
use App\Models\User;
use App\Models\Category;
use App\Models\SiteSetting;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Rules\MatchOldPassword;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->middleware('permission:user_show',['only'=>'index']);
        $this->middleware('permission:user_create',['only'=>['create','store']]);
        $this->middleware('permission:user_update',['only'=>['edit','update']]);
        $this->middleware('permission:user_detail',['only'=>'show']);
        $this->middleware('permission:user_delete',['only'=>'destroy']);
    }

    public function select(Request $request)
    {
        $users = [];
        if($request->has('q')){
            $search = $request->q;
            $users = User::select('slug','name')->where('name','LIKE',"%$search%")->limit(6)->get();
        } else {
            $users = User::select('slug','name')->limit(6)->get();
        }

        return response()->json($users);
    } 

    public function index(Request $request)
    {
        $siteSetting = SiteSetting::first();
        $postCount = Post::all()->count();
        $categCount = Category::all()->count();
        $tagCount = Tag::all()->count();
        
        $postCountUser  = Post::where('user_id', auth()->user()->id)->count();
        $trashCountUser = Post::where('user_id', auth()->user()->id)->onlyTrashed()->count();


        $users = [];
        if($request->get('keyword')){
            $users = User::with(['roles','posts'])->search($request->keyword)->get();
        }else{
            $users = User::with(['roles','posts'])->get()->sortBy(function ($user, $key) {
                return $user->roles->pluck('name');
            });
            // where('id', '!=', Auth::id()) //same like -> except(Auth::id());
        }
        $roles = Role::all();
        return view('users.index',[
            'users'=>$users,
            'postCount' => $postCount,
            'categCount' => $categCount,
            'tagCount' => $tagCount,
            'siteSetting' => $siteSetting, 
            'roles' => $roles,

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


        return view('users.create',[
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

        $validator = Validator::make($request->all(),[
            "name" => "required|string",
            "role" => "required",
            "email" => "required|email|unique:users,email",
            "password" => "required|min:8|confirmed",
        ],
        [
            'name.required'=> "Name cannot be empty",
            'role.required'=> "Please choose role",
            'email.required'=> "Email cannot be empty",
            'email.unique'=> "This email already have an account",
            "password.required" => "Password cannot be empty",
        ],
    );

    if($validator->fails()){
        $request['role'] = Role::select('id','name')->find($request->role);
        return redirect()->back()->withInput($request->all())->withErrors($validator);
    }

    DB::beginTransaction();
    try {
        $user = User::create([
            'name' => $request->name,
            'slug' => md5($request->name),
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        $user->assignRole($request->role);

        Alert::success(
            "Add User",
            "Successful creating a new user"
        );
        return redirect()->route('users.index');
    } catch (\Throwable $th) {
        //throw $th;
        DB::rollBack();
        Alert::error(
           "ERROR",
           'Failed when creating user ERROR: '.$th->getMessage(),
        );
            $request['role'] = Role::select('id','name')->find($request->role);
            return redirect()->back()->withInput($request->all())->withErrors($validator);

    }finally{
        DB::commit();
    }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        $siteSetting = SiteSetting::first();
        $postCount = Post::all()->count();
        $categCount = Category::all()->count();
        $tagCount = Tag::all()->count();

        $postCountUser  = Post::where('user_id', auth()->user()->id)->count();
        $trashCountUser = Post::where('user_id', auth()->user()->id)->onlyTrashed()->count();
        $roles = Role::all();
        $userPost = $user->postlatest->take(5);
        return view('users.detail',[
            'user' =>$user,
            'userPost' =>$userPost,
            'postCount'=> $postCount,
            'categCount'=> $categCount,
            'tagCount'=> $tagCount,
            'siteSetting' => $siteSetting, 
            'roles'=> $roles,
    
            'postCountUser' => $postCountUser,
            'trashCountUser' => $trashCountUser,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $siteSetting = SiteSetting::first();
        $postCount = Post::all()->count();
        $categCount = Category::all()->count();
        $tagCount = Tag::all()->count();

        $postCountUser  = Post::where('user_id', auth()->user()->id)->count();
        $trashCountUser = Post::where('user_id', auth()->user()->id)->onlyTrashed()->count();

        return view('users.edit',[
            'user'=> $user,
            'roleSelected' =>$user->roles->first(),
            'postCount' => $postCount,
            'categCount' => $categCount,
            'tagCount' => $tagCount,
            'siteSetting' => $siteSetting, 
            

            'postCountUser' => $postCountUser,
            'trashCountUser' => $trashCountUser,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
            $validator = Validator::make($request->all(),[
                "role" => "required",
                "name" => "required|string",
            ],
            [
                'role.required'=> "Please choose role",
                'name.required'=> "Name cannot be empty",
            ],
        
        );

        if($validator->fails()){
            $request['role'] = Role::select('id','name')->find($request->role);
            return redirect()->back()->withInput($request->all())->withErrors($validator);
        }

        DB::beginTransaction();
        try {
            $user->update([
                'name'=>$request->name
            ]);
            $user->syncRoles($request->role);
            Alert::success(
                "Edit User",
                "Successful editing user"
            );
            return redirect()->route('users.index');
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            Alert::error(
                "ERROR",
                'Failed when editing user ERROR: '.$th->getMessage(),
            );
                $request['role'] = Role::select('id','name')->find($request->role);
                return redirect()->back()->withInput($request->all())->withErrors($validator);

        }finally{
            DB::commit();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        DB::beginTransaction();
        try {
            
            $user->removeRole($user->roles->first());
            $user->delete();
            // $user_id = $user->id;
            // File::deleteDirectory(public_path('uploads/photos/' . $user_id));
            // File::deleteDirectory(public_path('uploads/files/' . $user_id));
            Alert::success(
                "Delete User",
                "Successful deleting user"
            );
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            Alert::error(
                "ERROR",
                'Failed when deleting user ERROR: '.$th->getMessage(),
            );

        }finally{
            DB::commit();
        }
        return redirect()->back();
    }

    public function profile()
    {   
        if(Auth::check() != true)
        {
            abort(404);
        }
        $siteSetting = SiteSetting::first();
        $postCount = Post::all()->count();
        $categCount = Category::all()->count();
        $tagCount = Tag::all()->count();
        $user = Auth::user();

        $postCountUser  = Post::where('user_id', auth()->user()->id)->count();
        $trashCountUser = Post::where('user_id', auth()->user()->id)->onlyTrashed()->count();
 
        return view('users.profile',[
            'user' =>$user,
            'postCount'=> $postCount,
            'categCount'=> $categCount,
            'tagCount'=> $tagCount,
            'siteSetting' => $siteSetting, 
    
            'postCountUser' => $postCountUser,
            'trashCountUser' => $trashCountUser,
        ]);
    }

    public function updateProfile(Request $request)
    {   
        if(Auth::check() != true)
        {
            abort(404);
        }
        $user = User::where('id', Auth::user()->id);
        
            $validator = Validator::make($request->all(),[
                "name" => "required|string",
                "username" => "required|unique:users,username,". Auth::user()->id,
                "email" => "required|email|unique:users,email,". Auth::user()->id,
            ],
            [
                'name.required'=> "Name cannot be empty",
                'username.required'=> "Username cannot be empty",
                'username.unique'=> "The Username has already been taken",
                'email.unique'=> "This email already have an account",
                'email.required' => "Email cannot be empty",
            ],
        
        );

        if($validator->fails()){
            return redirect()->back()->withInput($request->all())->withErrors($validator);
        }

        DB::beginTransaction();
        try {
            $user->update([
                'name'=>$request->name,
                'username'=>$request->username,
                'slug'=>$request->slug,
                'description'=>$request->description,
                'email'=>$request->email,
            ]);

            Alert::success(
                "Edit Profile",
                "Successful editing profile"
            );
            return redirect()->route('users.profile');
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            Alert::error(
                "ERROR",
                'Failed when editing profile ERROR: '.$th->getMessage(),
            );
                return redirect()->back()->withInput($request->all())->withErrors($validator);

        }finally{
            DB::commit();
        }
    
    }


    public function updateSocialMedia(Request $request)
    {   

        if(Auth::check() != true)
        {
            abort(404);
        } 
        $user = User::where('id', Auth::user()->id);

        $validator = Validator::make($request->all(),[

            'instagram' => 'nullable|starts_with:https://www.instagram.com',
            'twitter' => 'nullable|starts_with:https://www.twitter.com',
            'facebook' => 'nullable|starts_with:https://www.facebook.com',
            'youtube' => 'nullable|starts_with:https://www.youtube.com',
        ],
        [
            'instagram.starts_with'=>'Should include : https://www.instagram.com',
            'twitter.starts_with'=>'Should include : https://www.twitter.com',
            'facebook.starts_with'=>'Should include : https://www.facebook.com',
            'youtube.starts_with'=>'Should include : https://www.youtube.com',
        ],
        
    
    );
    if($validator->fails()){
        return redirect()->back()->withInput($request->all())->withErrors($validator);
    }

        DB::beginTransaction();
        try {
           $user->update([
            'facebook_link' => $request->facebook,
            'twitter_link' => $request->twitter,
            'instagram_link' => $request->instagram,
            'youtube_link' => $request->youtube,
           ]);

            Alert::success(
                "Edit social media",
                "Successful editing your social media"
            );
            return redirect()->route('users.profile');
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            Alert::error(
                "ERROR",
                'Failed when editing your social media ERROR: '.$th->getMessage(),
            );
            
        }finally{
            DB::commit();
        }
    
    }

    public function avatar(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'profile_picture' => 'required|image|max:2000,'.Auth::user()->id,
        ]);

        if ($validator->fails()) {
            
            return back()->withInput($request->all())->withErrors($validator);           
        }

        $status = "";

        if ($request->hasFile('profile_picture')) {
            $image = $request->file('profile_picture');
            // Rename image
            $destinationPath = public_path('uploads/avatar/'.Auth::user()->avatar);
            $filename = md5(Auth::user()->name ."-". time()).'.'.$image->guessExtension();

            if(file_exists( $destinationPath) ){
                File::delete($destinationPath);
            }
            $request->file('profile_picture')->storeAs('avatar', $filename,'public');
            $user = User::where('id', Auth::user()->id);

            $user->update([
                'avatar'=> $filename,
            ]);

            $status = "uploaded";
        
        }else{
            Alert::error(
                "ERROR",
                'Failed when changing avatar',
            );
            return redirect()->route('users.profile');

        }
        
        return response($status,200);
    }

    public function passwordPage()
    {
        $site = SiteSetting::first();
        return view('users.edit-password',compact('site'));
    } 

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required', new MatchOldPassword],
            'password' => 'required|min:8|confirmed',
        ],
        [
            "current_password.required" => "Current password cannot be empty",
            "password.required" => "New password cannot be empty",
        ]);
   
      
        try {
            User::find(auth()->user()->id)->update(['password'=> Hash::make($request->password)]);

            Alert::success(
                "Change password",
                "Successful changing password"
            );
            return redirect()->route('users.profile');

        } catch (\Throwable $th) {
            //throw $th;
            Alert::error(
                "ERROR",
                'Failed when changing password'.$th->getMessage(),
            );
            return back();

        }

    }
}
