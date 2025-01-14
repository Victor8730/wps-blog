<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;


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

Route::group(['prefix' => LaravelLocalization::setLocale()], function()
{
    /** ADD ALL LOCALIZED ROUTES INSIDE THIS GROUP **/
    Route::get('test',function(){
        return View::make('test');
    });
});

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth:sanctum', 'verified'])->get('/adm-panel', function () {
    return view('dashboard');
})->name('adm');




#Route::get('/adm-panel/post/switch/{id}', 'App\Http\Controllers\PostController')->name('post.switch');
#Route::get('/adm-panel/post/switch/{id}', [PostController::class, 'switch']);
Route::get('/adm-panel/post/switch/{id}', 'App\Http\Controllers\PostController@switch')->middleware('auth');
Route::resource('/adm-panel/post', PostController::class)->middleware('auth');
Route::resource('/adm-panel/categories', CategoryController::class)->middleware('auth');
