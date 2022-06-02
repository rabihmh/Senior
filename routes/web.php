<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('auth.login');
});


Auth::routes();
Route::group(['prefix' => '', 'middleware' => ['auth']], function () {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::get('home/myServices', [App\Http\Controllers\ServicesController::class, 'myServices'])->name('services.my');
    Route::get('home/services/all', [App\Http\Controllers\ServicesController::class, 'getAll'])->name('services.all');
    Route::get('home/services/{id}', [App\Http\Controllers\ServicesController::class, 'getservice'])->name('services.get');
    Route::get('services/add', 'App\Http\Controllers\ServicesController@insert')->name('insertServices');
    Route::post('services/add', 'App\Http\Controllers\ServicesController@store')->name('storeServices');
    Route::get('services/delete/{id}', 'App\Http\Controllers\ServicesController@delete')->name('myservice.delete');

    Route::get('services/{cat_name}', 'App\Http\Controllers\CategoriesController@specificCat')->name('services');
    /*route of profile*/
    Route::get('user/{userName}', [App\Http\Controllers\UsersController::class, 'myProfile'])->name('myprofile');
    Route::get('profile/{ID}', [App\Http\Controllers\UsersController::class, 'myprofileID'])->name('myprofileID');
    Route::get('user/{userName}/edit', [App\Http\Controllers\UsersController::class, 'myProfileEdit'])->name('myprofileEdit');
    Route::post('profile/update', 'App\Http\Controllers\UsersController@storeProfile')->name('profilePersonal');
    Route::post('EditProfile/update', 'App\Http\Controllers\UsersController@EditProfile')->name('EditProfileStore');
    Route::get('home/freelancers', [App\Http\Controllers\FreelancerController::class, 'getFreelancers'])->name('freelancers');

    Route::get('cart', [CartController::class, 'cartList'])->name('cart.list');
    Route::post('cart', [CartController::class, 'addToCart'])->name('cart.store');
    Route::post('update-cart', [CartController::class, 'updateCart'])->name('cart.update');
    Route::post('remove', [CartController::class, 'removeCart'])->name('cart.remove');
    Route::post('clear', [CartController::class, 'clearAllCart'])->name('cart.clear');

});


Route::group(['middleware' => ['auth']], function () {
    Route::get('/logout', 'App\Http\Controllers\LogoutController@perform')->name('logout.perform');

});
Route::get('/getSub/{id}', [App\Http\Controllers\CategoriesController::class, 'getSubCategories'])->name('category.getSub');
//Route::get('services/get_more_projects/{id}', [App\Http\Controllers\ServicesController::class, 'getMoreProjects'])->name('get_more_projects');

