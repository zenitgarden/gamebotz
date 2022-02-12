<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TagController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FileManagerController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\SiteSettingController;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/',[NewsController::class,'index'])->name('news.index');
Route::get('/news',[NewsController::class,'news'])->name('news.news');
Route::get('/esport',[NewsController::class,'esport'])->name('news.esport');
Route::get('/tips-&-tricks',[NewsController::class,'tipsNtrick'])->name('news.tipsNtrick');
Route::get('/recommendation-game',[NewsController::class,'recommendationGame'])->name('news.recom');
Route::get('/about-us',[NewsController::class,'about'])->name('news.about');

Route::get('/news/{slug}',[NewsController::class,'detail'])->name('news.detail');
Route::get('/author/{slug}',[NewsController::class,'author'])->name('news.author');
Route::get('/category/{slug}',[NewsController::class,'category'])->name('news.category');
Route::get('/tag/{slug}',[NewsController::class,'tag'])->name('news.tag');
Route::get('/search',[NewsController::class,'searchPost'])->name('news.search');

Auth::routes([
    'register' => false,
]);


Route::group(['prefix' =>'dashboard', 'middleware' =>['web','auth','preventBackHistory']], function(){

    // Dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard.index');
    Route::get('/recomendation-game', [DashboardController::class, 'recommendationGame'])->name('dashboard.recom');
    Route::get('/recomendation-game/edit', [DashboardController::class, 'edit'])->name('dashboard.recom.edit');
    Route::put('/recomendation-game/update',[DashboardController::class,'update'])->name('dashboard.recom.update');

    // Category
    Route::get('/categories/select',[CategoryController::class,'select'])->name('categories.select');
    Route::resource('/categories', CategoryController::class)->except('show');

    // Tag
    Route::get('/tags/select',[TagController::class,'select'])->name('tags.select');
    Route::resource('/tags', TagController::class)->except('show');

    // Post
    Route::get('/posts/checkSlug', [PostController::class,'checkSlug'])->name('posts.slug');
    Route::get('/posts/trash',[PostController::class,'showTrash'])->name('posts.trash');
    Route::get('/posts/restore/{slug}',[PostController::class,'restoreTrash'])->name('posts.restore');
    Route::delete('/posts/kill/{slug}',[PostController::class,'kill'])->name('posts.kill');
    Route::delete('/posts/delete-all',[PostController::class,'deleteAll'])->name('posts.deleteAll');
    Route::resource('/posts', PostController::class);

    // role
    Route::get('/roles/select',[RoleController::class,'select'])->name('roles.select');
    Route::resource('/roles', RoleController::class);

    // User
    Route::get('/users/select',[UserController::class,'select'])->name('users.select');
    Route::get('/profile/change-password',[UserController::class,'passwordPage'])->name('users.passwordPage');
    Route::post('/profile/change-password/update', [UserController::class,'updatePassword'])->name('users.updatePassword');
    Route::post('/profile/avatar',[UserController::class,'avatar'])->name('users.avatar');
    Route::get('/profile',[UserController::class,'profile'])->name('users.profile');
    Route::put('/profile/socialmedia',[UserController::class,'updateSocialMedia'])->name('users.update.sm');
    Route::put('/profile/update',[UserController::class,'updateProfile'])->name('users.update.profile');
    Route::resource('/users', UserController::class);

    // Site setting
    Route::get('/settings',[SiteSettingController::class,'index'])->name('settings.index');
    Route::put('/settings',[SiteSettingController::class,'saveGeneral'])->name('settings.general');
    Route::put('/settings/socialmedia',[SiteSettingController::class,'saveSocial'])->name('settings.sm');
    Route::put('/settings/about',[SiteSettingController::class,'saveAbout'])->name('settings.about');

    // filemanager
    Route::group(['prefix' =>'filemanager'], function(){
        \UniSharp\LaravelFilemanager\Lfm::routes();
        Route::get('/index',[FileManagerController::class,'index'])->name('filemanager.index');
    });
   

});



