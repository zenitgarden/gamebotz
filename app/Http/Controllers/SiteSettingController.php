<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use App\Models\Post;
use App\Models\Category;
use App\Models\SiteSetting;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Validator;

class SiteSettingController extends Controller
{

    public function __construct()
    {
        $this->middleware('permission:site_settings_show',['only'=>'index']);
        $this->middleware('permission:site_settings_update',['only'=>['saveGeneral','saveSocial','saveAbout']]);
    }

    public function index(SiteSetting $siteSetting)
    {
        $postCount = Post::all()->count();
        $categCount = Category::all()->count();
        $tagCount = Tag::all()->count();
        
        $postCountUser  = Post::where('user_id', auth()->user()->id)->count();
        $trashCountUser = Post::where('user_id', auth()->user()->id)->onlyTrashed()->count();
       
        return view('site_setting.index',[
            'siteSetting'=> $siteSetting->first(),
            'postCount' => $postCount,
            'categCount' => $categCount,
            'tagCount' => $tagCount,
            'postCountUser' => $postCountUser,
            'trashCountUser' => $trashCountUser,
        ]);


    }

    public function saveGeneral(Request $request, SiteSetting $siteSetting)
    {
    
        $validator = Validator::make($request->all(),
        [
            'site_logo'=>'image|max:1000',
            'site_favicon'=>'max:1000|mimes:jpeg,jpg,png,ico,jfif',
            'disqus_plugin'=>'required'
        ],
        [
            'site_logo.required'=>'The logo image should be exist',
            'site_favicon.required'=>'The favicon image should be exist',
            'disqus_plugin.required'=>'The disqus cannot be empty',
            'site_logo.max'=>'The logo must not be greater than 1000 mb/megabyte.',
            'site_favicon.max'=>'TThe favicon must not be greater than 1000 mb/megabyte.',

        ]);

        if($validator->fails())
        {
            return redirect()->to('/dashboard/settings#general4')->withInput($request->all())->withErrors($validator);
        }

        $data = [
            'disqus_plugin'=> $request->disqus_plugin,
        ];

         // logo
         
        if ($request->hasFile('site_logo')) {
            $image = $request->file('site_logo');
            // Rename image
            $getname = $request->file('site_logo')->getClientOriginalName();
            $file_name = pathinfo($getname, PATHINFO_FILENAME);
            $destinationPath = public_path('/assets/img/'.$siteSetting->first()->logo);
            $filenameLogo = Str::slug($file_name).'.'.Str::lower($image->getClientOriginalExtension());

            if(file_exists( $destinationPath) ){
                File::delete($destinationPath);
            }
            $request->file('site_logo')->move(public_path('/assets/img/'), $filenameLogo);
            $data['logo'] = $filenameLogo;
        }
        // favicon
        
        if ($request->hasFile('site_favicon')) {
            $image = $request->file('site_favicon');
            // Rename image
            $getname = $request->file('site_favicon')->getClientOriginalName();
            $file_name = pathinfo($getname, PATHINFO_FILENAME);
            $destinationPath = public_path('/assets/img/'.$siteSetting->first()->favicon);
            $filenameIcon = Str::slug($file_name).'.'.Str::lower($image->getClientOriginalExtension());

            if(file_exists( $destinationPath) ){
                File::delete($destinationPath);
            }
            $request->file('site_favicon')->move(public_path('/assets/img/'), $filenameIcon);
            $data['favicon'] = $filenameIcon;
        }

        try {
            $siteSetting->first()->update($data);
            Alert::success(
                'Edit Setting',
                'Succesfull editing the general setting',
            );

            return redirect()->to('/dashboard/settings#general4');

        } catch (\Throwable $th) {
            //throw $th;
            Alert::error( 
                "ERROR", 
                'Failed when editing the general setting. ERROR: '. $th->getMessage(),
             );

            return redirect()->back()->withInput($request->all());
        }
    }

    public function saveSocial(Request $request, SiteSetting $siteSetting)
    {
        

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
        Alert::warning(
            "Validation error",
            'Failed editing social media ,re-check again',
        );
        return redirect()->back()->withInput($request->all())->withErrors($validator);   
    }
      
        try {
           $siteSetting->first()->update([
            'facebook_link' => $request->facebook,
            'twitter_link' => $request->twitter,
            'instagram_link' => $request->instagram,
            'youtube_link' => $request->youtube,
           ]);

            Alert::success(
                "Edit social media",
                "Successful editing social media"
            );
            return back();
        } catch (\Throwable $th) {
            //throw $th;

            Alert::error(
                "ERROR",
                'Failed when editing social media ERROR: '.$th->getMessage(),
            );
            return back();
        }
    
    }

    public function saveAbout(Request $request, SiteSetting $siteSetting)
    {
        $validator = Validator::make($request->all(),
        [
            'about' => 'required',
        ],
        [
            'about.required'=>'About us cannot be empty',
        ]);

        if($validator->fails())
        {
            return back()->withInput($request->all())->withErrors($validator);
        }

        try {
            $siteSetting->first()->update(
                [
                    'about' => $request->about,
                ]);
                Alert::success(
                "Edit about us",
                "Successful editing about us"
                );
                return back();
        } catch (\Throwable $th) {
            //throw $th;
            Alert::error(
                "ERROR",
                'Failed when editing about us ERROR: '.$th->getMessage(),
            );
            return back();
        }
    }
}
