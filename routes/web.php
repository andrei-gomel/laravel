<?php

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
    return view('welcome');
});

//Route::get('/go/{name}', 'TestController');

Route::get('/go/{name}', function ($name) {
    return '<H1>Привет, ' .$name.'!</H1>';
});

Route::group(['prefix' => 'digging_deeper'], function () {
	Route::get('collections', 'DiggingDeeperController@collections')
	->name('digging_deeper.collections');
});

/*Route::resource('/rest', 'RestTestController')->names('restTest');

Route::group(['namespace' => 'Blog', 'prefix' => 'blog'], function(){
	Route::resource('posts', 'PostController')->names('blog.posts');
});
*/
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

// Админка Блога
$groupData = [
	'namespace' => 'Blog\Admin',
	'prefix' => 'admin/blog',
];

Route::group($groupData, function(){
//BlogCategory
	$methods = ['index','edit','store','update','create',];
	Route::resource('categories','CategoryController')
	->only($methods)
	->names('blog.admin.categories');
  //BlogPost
  Route::resource('posts','PostController')
	->except('show')
	->names('blog.admin.posts');
});
