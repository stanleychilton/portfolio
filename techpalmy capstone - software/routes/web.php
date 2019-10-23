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

// Redirect url's that would cause problems, i.e. no company id.
Route::redirect('/companies/edit', '/');
Route::redirect('/companies/update', '/');
Route::get('/consultants/edit', 'ConsultantController@edit');
Route::redirect('/consultants/update', '/');

// Routing that handles all LISTING's creating, deleting, displaying etc...
//check that the user is verified

Route::resource('companies', 'CompanyController');
Route::resource('events', 'EventController');
Route::resource('techgroups', 'TechGroupController');
Route::resource('jobs', 'JobController');
Route::resource('consultants', 'ConsultantController');
Route::post('approve_flaglisting', [
    'uses' => 'SiteGovernance@flaglisting'
  ]);

// Authentication and Users
Auth::routes();
Route::get('/logout','Auth\LoginController@logout');
Route::get('/user', 'ProfileController@show');

// note: Middleware is executed in the middle of the request, either before the controller action, or after.

Route::get('/user/edit', 'ProfileController@edit');
Route::put('/user/update', 'ProfileController@update');


// Public Routes
Route::get('/students', 'CompanyController@studentcompanies');
Route::get('/', 'PageController@index');
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/search', 'SearchController@search')->name('search');
Route::get('/about_us', 'PageController@about_us');
Route::get('/contactus', 'PageController@contactus');
Route::get('/information_page', 'PageController@information_page');


// Route::get('/admin', 'AdminController@admin');
    
// Routes that only the ADMIN can access (and only admin can see).

Route::middleware(['abort_if_guest','is_admin'])->prefix('admin')->group(function(){
    Route::get('/','ProfileController@show');
    Route::get('email','AdminController@email');
    Route::post('notification','EmailController@sendNotification');
    Route::get('sitegovernance', 'SiteGovernance@info');
    Route::get('pendinglistings', 'SiteGovernance@showpendinglistings');
});

Route::post('addadmin', 'TechGroupController@addAdmin');

Route::get('/verifyemail/{token}', 'Auth\RegisterController@verify');

Route::get('/studentmi', 'PageController@moreinfo');
Route::get('/summeroftech', 'PageController@summeroftech');
Route::get('/home', 'HomeController@index')->name('home');
