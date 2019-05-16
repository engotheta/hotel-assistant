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

//----------------------------------------------------------------------------------------------
//static pages
//----------------------------------------------------------------------------------------------

Auth::routes();

Route::get('/', function () { return view('welcome'); });
Route::get('/home', 'HomeController@index')->name('home')->middleware('auth');
Route::get('/logout', 'Auth\LoginController@logout')->name('logout');
Route::get('/welcome', function () { return view('welcome'); })->name('welcome');

Route::get('/drinks-variables/{branch}', 'DrinkController@showDrinkVariables');
Route::get('/drinks-variables/{branch}/{department}', 'DrinkController@showDrinkVariables');

Route::get('/rooms-variables','RoomController@showRoomVariables');
Route::get('/rooms-variables/{branch}', 'RoomController@showRoomVariables');
Route::get('/rooms-variables/{branch}/{department}','RoomController@showRoomVariables');

/////////////////////////////////////////////////////////////////////////////////////////////////


//----------------------------------------------------------------------------------------------
// settings
//----------------------------------------------------------------------------------------------
Route::post('/settings/save', 'SettingController@saveSettings')->name('settings.save');
/////////////////////////////////////////////////////////////////////////////////////////////////




//----------------------------------------------------------------------------------------------
// branch
//----------------------------------------------------------------------------------------------
Route::get('/{branch}/edit','BranchController@edit');

Route::get('/branches/{branch}/edit','BranchController@edit');
Route::get('/branches/{branch}/delete', ['uses' =>'BranchController@showToDelete']);

Route::get('/branches/add','BranchController@create');
Route::get('/branches/create','BranchController@create');

Route::post('/branches/{branch}','BranchController@update');

Route::post('/branches/','BranchController@store');
/////////////////////////////////////////////////////////////////////////////////////////////////





//----------------------------------------------------------------------------------------------
//department
//----------------------------------------------------------------------------------------------

// page: add
Route::get('/departments/{branch}/add','DepartmentController@create');
Route::get('/departments/{branch}/create','DepartmentController@create');
Route::get('/departments/{branch}/{department}/add','DepartmentController@create');
Route::get('/departments/{branch}/{department}/create','DepartmentController@create');

// page: show
Route::get('/departments/{department}/delete','DepartmentController@showToDelete');
Route::get('/departments/{department}/{branch}','DepartmentController@show');
Route::get('/departments/{department}/{branch}/delete','DepartmentController@showToDelete');

// form: edit
Route::get('/departments/{department}/{branch}/edit','DepartmentController@edit');

// page: index
Route::get('/departments/','DepartmentController@index');
Route::get('/departments/{branch}','DepartmentController@index');

// resource: store
Route::post('/departments/{branch}','DepartmentController@store');

// resource: update
Route::post('/departments/{department}/{branch}','DepartmentController@update');
Route::put('/departments/{department}/{branch}','DepartmentController@update');

// resource: delete
Route::post('/departments/{department}/{branch}/destroy','DepartmentController@destroy');
Route::delete('/departments/{department}/{branch}','DepartmentController@destroy');
/////////////////////////////////////////////////////////////////////////////////////////////////





//----------------------------------------------------------------------------------------------
//members ---- uses slug
//----------------------------------------------------------------------------------------------

// resource: update
Route::put('/members/{branch}/update-many','UserController@updateMany');
Route::put('/members/{member}/{branch}','UserController@update');
Route::put('/members/{branch}/{department}/update-many','UserController@updateMany');
Route::put('/members/{member}/{branch}/{department}','UserController@update');

Route::post('/members/{branch}/update-many','UserController@updateMany');
Route::post('/members/{member}/{branch}','UserController@update');
Route::post('/members/{branch}/{department}/update-many','UserController@updateMany');
Route::post('/members/{member}/{branch}/{department}','UserController@update');


// form: add
Route::get('/members/{branch}/add','UserController@create');
Route::get('/members/{branch}/create','UserController@create');
Route::get('/members/{branch}/add-many','UserController@createMany');
Route::get('/members/{branch}/create-many','UserController@createMany');
Route::get('/members/{branch}/{department}/add','UserController@create');
Route::get('/members/{branch}/{department}/create','UserController@create');
Route::get('/members/{branch}/{department}/add-many','UserController@createMany');
Route::get('/members/{branch}/{department}/create-many','UserController@createMany');

// form: edit
Route::get('/members/{member}/{branch}/edit','UserController@edit');
Route::get('/members/{member}/{branch}/{department}/edit','UserController@edit');
Route::get('/members/{branch}/edit-many','UserController@editMany');
Route::get('/members/{branch}/{department}/edit-many','UserController@editMany');

// page: show
Route::get('/members/{member}/show','UserController@show');
Route::get('/members/{member}/delete','UserController@showToDelete');
Route::get('/members/{member}/{branch}/show','UserController@show');
Route::get('/members/{member}/{branch}/delete','UserController@showToDelete');
Route::get('/members/{member}/{branch}/{department}','UserController@show');
Route::get('/members/{member}/{branch}/{department}/show','UserController@show');
Route::get('/members/{member}/{branch}/{department}/delete','UserController@showToDelete');

// page: index
Route::get('/members/{branch}','UserController@index');
Route::get('/members/{branch}/{department}','UserController@index');


// resource: store
Route::post('/members/{branch}','UserController@store');
Route::post('/members/{branch}/store-many','UserController@storeMany');
Route::post('/members/{branch}/{department}','UserController@store');
Route::post('/members/{branch}/{department}/store-many','UserController@storeMany');




// resource: delete
Route::get('/members/{member}/{branch}/destroy','UserController@destroy');
Route::get('/members/{member}/{branch}/{department}/destroy','UserController@destroy');
Route::post('/members/{member}/{branch}/destroy','UserController@destroy');
Route::post('/members/{member}/{branch}/{department}/destroy','UserController@destroy');
Route::delete('/members/{member}/{branch}','UserController@destroy');
Route::delete('/members/{member}/{branch}/{department}','UserController@destroy');

/////////////////////////////////////////////////////////////////////////////////////////////////




//----------------------------------------------------------------------------------------------
//titles  ---- uses id
//----------------------------------------------------------------------------------------------

// page : index
Route::get('/roles/{branch}', 'UserController@showMemberRoles');
Route::get('/titles/{branch}', 'UserController@showMemberTitles');

// resource : update
Route::post('/titles/update-many', 'TitleController@updateMany');
Route::post('/titles/{branch}/update-many', 'TitleController@updateMany');
Route::post('/titles/{branch}/{department}/update-many', 'TitleController@updateMany');

// resource : store
Route::post('/titles/{branch}', 'TitleController@store');
Route::post('/titles/{branch}/{department}', 'TitleController@store');

// resource : delete
Route::get('/titles/{title}/destroy', 'TitleController@destroy');
Route::get('/titles/{title}/{branch}/destroy', 'TitleController@destroy');
Route::get('/titles/{title}/{branch}/{department}/destroy', 'TitleController@destroy');

/////////////////////////////////////////////////////////////////////////////////////////////////




//----------------------------------------------------------------------------------------------
//activities
//----------------------------------------------------------------------------------------------

// form: add
Route::get('/activities/{branch}/add','ActivityController@create');
Route::get('/activities/{branch}/create','ActivityController@create');
Route::get('/activities/{branch}/add-many','ActivityController@createMany');
Route::get('/activities/{branch}/create-many','ActivityController@createMany');
Route::get('/activities/{branch}/{department}/add','ActivityController@create');
Route::get('/activities/{branch}/{department}/create','ActivityController@create');
Route::get('/activities/{branch}/{department}/add-many','ActivityController@createMany');
Route::get('/activities/{branch}/{department}/create-many','ActivityController@createMany');

// form: edit
Route::get('/activities/{activity}/{branch}/edit','ActivityController@edit');
Route::get('/activities/{activity}/{branch}/{department}/edit','ActivityController@edit');
Route::get('/activities/{branch}/edit-many','ActivityController@editMany');
Route::get('/activities/{branch}/{department}/edit-many','ActivityController@editMany');

// resource: show
Route::get('/activities/{activity}/show','ActivityController@show');
Route::get('/activities/{activity}/delete','ActivityController@showToDelete');
Route::get('/activities/{activity}/{branch}/show','ActivityController@show');
Route::get('/activities/{activity}/{branch}/start','ActivityController@showActivity');
Route::get('/activities/{activity}/{branch}/delete','ActivityController@showToDelete');
Route::get('/activities/{activity}/{branch}/{department}','ActivityController@show');
Route::get('/activities/{activity}/{branch}/{department}/show','ActivityController@show');
Route::get('/activities/{activity}/{branch}/{department}/delete','ActivityController@showToDelete');

// resource: index
Route::get('/activities/{branch}','ActivityController@index');
Route::get('/activities/{branch}/{department}','ActivityController@index');

// resource: store
Route::post('/activities/{branch}','ActivityController@store');
Route::post('/activities/{branch}/store-many','ActivityController@storeMany');
Route::post('/activities/{branch}/{department}','ActivityController@store');
Route::post('/activities/{branch}/{department}/store-many','ActivityController@storeMany');

// resource: update
Route::post('/activities/{activity}/{branch}','ActivityController@update');
Route::post('/activities/{activity}/{branch}/{department}','ActivityController@update');
Route::post('/activities/{branch}/update-many','ActivityController@updateMany');
Route::post('/activities/{branch}/{department}/update-many','ActivityController@updateMany');

Route::put('/activities/{activity}/{branch}','ActivityController@update');
Route::put('/activities/{activity}/{branch}/{department}','ActivityController@update');
Route::put('/activities/{branch}/update-many','ActivityController@updateMany');
Route::put('/activities/{branch}/{department}/update-many','ActivityController@updateMany');

// resource: delete
Route::get('/activities/{activity}/{branch}/destroy','ActivityController@destroy');
Route::get('/activities/{activity}/{branch}/{department}/destroy','ActivityController@destroy');
Route::post('/activities/{activity}/{branch}/destroy','ActivityController@destroy');
Route::post('/activities/{activity}/{branch}/{department}/destroy','ActivityController@destroy');
Route::delete('/activities/{activity}/{branch}','ActivityController@destroy');
Route::delete('/activities/{activity}/{branch}/{department}','ActivityController@destroy');

/////////////////////////////////////////////////////////////////////////////////////////////////




//----------------------------------------------------------------------------------------------
//room
//----------------------------------------------------------------------------------------------



// form: add
Route::get('/rooms/{branch}/add','RoomController@create');
Route::get('/rooms/{branch}/add-many','RoomController@createMany');
Route::get('/rooms/{branch}/create-many','RoomController@createMany');
Route::get('/rooms/{branch}/create','RoomController@create');
Route::get('/rooms/{branch}/{department}/create','RoomController@create');
Route::get('/rooms/{branch}/{department}/add','RoomController@create');
Route::get('/rooms/{branch}/{department}/add-many','RoomController@createMany');
Route::get('/rooms/{branch}/{department}/create-many','RoomController@createMany');

// resource: update
Route::post('/rooms/{branch}/update-many','RoomController@updateMany');
Route::post('/rooms/{room}/{branch}','RoomController@update');
Route::post('/rooms/{room}/{branch}/{department}','RoomController@update');
Route::post('/rooms/{branch}/{department}/update-many','RoomController@updateMany');

Route::put('/rooms/{branch}/update-many','RoomController@updateMany');
Route::put('/rooms/{room}/{branch}','RoomController@update');
Route::put('/rooms/{branch}/{department}/update-many','RoomController@updateMany');
Route::put('/rooms/{room}/{branch}/{department}','RoomController@update');


// form: edit
Route::get('/rooms/{branch}/edit-many','RoomController@editMany');
Route::get('/rooms/{room}/{branch}/edit','RoomController@edit');
Route::get('/rooms/{room}/{branch}/{department}/edit','RoomController@edit');
Route::get('/rooms/{branch}/{department}/edit-many','RoomController@editMany');

// page: show
Route::get('/rooms/{room}/show','RoomController@show');
Route::get('/rooms/{room}/delete','RoomController@showToDelete');
Route::get('/rooms/{room}/{branch}/show','RoomController@show');
Route::get('/rooms/{room}/{branch}/delete','RoomController@showToDelete');
Route::get('/rooms/{room}/{branch}/{department}','RoomController@show');
Route::get('/rooms/{room}/{branch}/{department}/show','RoomController@show');
Route::get('/rooms/{room}/{branch}/{department}/delete','RoomController@showToDelete');

// page: index
Route::get('/rooms/{branch}','RoomController@index');
Route::get('/rooms/{branch}/{department}','RoomController@index');

// resource: store
Route::post('/rooms/{branch}','RoomController@store');
Route::post('/rooms/{branch}/store-many','RoomController@storeMany');
Route::post('/rooms/{branch}/{department}','RoomController@store');
Route::post('/rooms/{branch}/{department}/store-many','RoomController@storeMany');


// resource: delete
Route::get('/rooms/{room}/{branch}/destroy','RoomController@destroy');
Route::get('/rooms/{room}/{branch}/{department}/destroy','RoomController@destroy');
Route::post('/rooms/{room}/{branch}/destroy','RoomController@destroy');
Route::post('/rooms/{room}/{branch}/{department}/destroy','RoomController@destroy');
Route::delete('/rooms/{room}/{branch}','RoomController@destroy');
Route::delete('/rooms/{room}/{branch}/{department}','RoomController@destroy');
////////////////////////////////////////////////////////////////////////////////////////////////




//----------------------------------------------------------------------------------------------
// room types --- uses - id
//----------------------------------------------------------------------------------------------

// resource: update
Route::post('/room-types/update-many', 'RoomTypeController@updateMany');
Route::post('/room-types/{branch}/update-many', 'RoomTypeController@updateMany');
Route::post('/room-types/{branch}/{department}/update-many', 'RoomTypeController@updateMany');

Route::post('/room-types/{room_type}/{branch}', 'RoomTypeController@udpate');
Route::post('/room-types/{room_type}/{branch}/{department}', 'RoomTypeController@update');

Route::put('/room-types/update-many', 'RoomTypeController@updateMany');
Route::put('/room-types/{branch}/update-many', 'RoomTypeController@updateMany');
Route::put('/room-types/{branch}/{department}/update-many', 'RoomTypeController@updateMany');

Route::put('/room-types/{room_type}/{branch}', 'RoomTypeController@udpate');
Route::put('/room-types/{room_type}/{branch}/{department}', 'RoomTypeController@update');

// resource: store
Route::post('/room-types/{branch}', 'RoomTypeController@store');
Route::post('/room-types/{branch}/store-many', 'RoomTypeController@storeMany');
Route::post('/room-types/{branch}/{department}','RoomTypeController@store');
Route::post('/room-types/{branch}/{department}/store-many','RoomTypeController@storeMany');

// resource: delete
Route::get('/room-types/{room_type}/{branch}/destroy', 'RoomTypeController@destroy');
Route::get('/room-types/{room_type}/{branch}/{department}/delete','RoomTypeController@destroy');
Route::post('/room-types/{room_type}/{branch}/destroy', 'RoomTypeController@destroy');
Route::post('/room-types/{room_type}/{branch}/{department}/destroy', 'RoomTypeController@destroy');
Route::delete('/room-types/{room_type}/{branch}', 'RoomTypeController@destroy');
Route::delete('/room-types/{room_type}/{branch}/{department}', 'RoomTypeController@destroy');

/////////////////////////////////////////////////////////////////////////////////////////////////



//----------------------------------------------------------------------------------------------
//venues
//----------------------------------------------------------------------------------------------

// form: add
Route::get('/venues/{branch}/add','VenueController@create');
Route::get('/venues/{branch}/create','VenueController@create');
Route::get('/venues/{branch}/add-many','VenueController@createMany');
Route::get('/venues/{branch}/create-many','VenueController@createMany');
Route::get('/venues/{branch}/{department}/add','VenueController@create');
Route::get('/venues/{branch}/{department}/create','VenueController@create');
Route::get('/venues/{branch}/{department}/add-many','VenueController@createMany');
Route::get('/venues/{branch}/{department}/create-many','VenueController@createMany');

// form: edit
Route::get('/venues/{venue}/{branch}/edit','VenueController@edit');
Route::get('/venues/{venue}/{branch}/{department}/edit','VenueController@edit');
Route::get('/venues/{branch}/edit-many','VenueController@editMany');
Route::get('/venues/{branch}/{department}/edit-many','VenueController@editMany');

// page: show
Route::get('/venues/{venue}/show','VenueController@show');
Route::get('/venues/{venue}/delete','VenueController@showToDelete');
Route::get('/venues/{venue}/{branch}/show','VenueController@show');
Route::get('/venues/{venue}/{branch}/delete','VenueController@showToDelete');
Route::get('/venues/{venue}/{branch}/{department}','VenueController@show');
Route::get('/venues/{venue}/{branch}/{department}/show','VenueController@show');
Route::get('/venues/{venue}/{branch}/{department}/delete','VenueController@showToDelete');

// page: index
Route::get('/venues/{branch}','VenueController@index');
Route::get('/venues/{branch}/{department}','VenueController@index');

// resource: store
Route::post('/venues/{branch}','VenueController@store');
Route::post('/venues/{branch}/store-many','VenueController@storeMany');
Route::post('/venues/{branch}/{department}','VenueController@store');
Route::post('/venues/{branch}/{department}/store-many','VenueController@storeMany');

// resource: update
Route::post('/venues/{branch}/update-many','VenueController@updateMany');
Route::post('/venues/{venue}/{branch}','VenueController@update');
Route::post('/venues/{venue}/{branch}/{department}','VenueController@update');
Route::post('/venues/{branch}/{department}/update-many','VenueController@updateMany');

Route::put('/venues/{branch}/update-many','VenueController@updateMany');
Route::put('/venues/{venue}/{branch}','VenueController@update');
Route::put('/venues/{venue}/{branch}/{department}','VenueController@update');
Route::put('/venues/{branch}/{department}/update-many','VenueController@updateMany');

// resource: delete
Route::get('/venues/{venue}/{branch}/destroy','VenueController@destroy');
Route::get('/venues/{venue}/{branch}/{department}/destroy','VenueController@destroy');
Route::post('/venues/{venue}/{branch}/destroy','VenueController@destroy');
Route::post('/venues/{venue}/{branch}/{department}/destroy','VenueController@destroy');
Route::delete('/venues/{venue}/{branch}','VenueController@destroy');
Route::delete('/venues/{venue}/{branch}/{department}','VenueController@destroy');
/////////////////////////////////////////////////////////////////////////////////////////////////







//----------------------------------------------------------------------------------------------
//foods ---- uses - slug
//----------------------------------------------------------------------------------------------

// resource: update
Route::post('/foods/{branch}/update-many','FoodController@updateMany');
Route::post('/foods/{food}/{branch}','FoodController@update');
Route::post('/foods/{branch}/{department}/update-many','FoodController@updateMany');
Route::post('/foods/{food}/{branch}/{department}','FoodController@update');

Route::put('/foods/{branch}/update-many','FoodController@updateMany');
Route::put('/foods/{food}/{branch}','FoodController@update');
Route::put('/foods/{branch}/{department}/update-many','FoodController@updateMany');
Route::put('/foods/{food}/{branch}/{department}','FoodController@update');

// form: add
Route::get('/foods/{branch}/add','FoodController@create');
Route::get('/foods/{branch}/create','FoodController@create');
Route::get('/foods/{branch}/add-many','FoodController@createMany');
Route::get('/foods/{branch}/create-many','FoodController@createMany');
Route::get('/foods/{branch}/{department}/add','FoodController@create');
Route::get('/foods/{branch}/{department}/create','FoodController@create');
Route::get('/foods/{branch}/{department}/add-many','FoodController@createMany');
Route::get('/foods/{branch}/{department}/create-many','FoodController@createMany');


// form: edit
Route::get('/foods/{branch}/edit-many','FoodController@editMany');
Route::get('/foods/{food}/{branch}/edit','FoodController@edit');
Route::get('/foods/{branch}/{department}/edit-many','FoodController@edit');
Route::get('/foods/{food}/{branch}/{department}/edit','FoodController@edit');

// page: show
Route::get('/foods/{food}/show','FoodController@show');
Route::get('/foods/{food}/delete','FoodController@showToDelete');
Route::get('/foods/{food}/{branch}/show','FoodController@show');
Route::get('/foods/{food}/{branch}/delete','FoodController@showToDelete');
Route::get('/foods/{food}/{branch}/{department}','FoodController@show');
Route::get('/foods/{food}/{branch}/{department}/show','FoodController@show');
Route::get('/foods/{food}/{branch}/{department}/delete','FoodController@showToDelete');

// page: index
Route::get('/foods/{branch}','FoodController@index');
Route::get('/foods/{branch}/{department}','FoodController@index');

// resource: store
Route::post('/foods/{branch}','FoodController@store');
Route::post('/foods/{branch}/store-many','FoodController@storeMany');
Route::post('/foods/{branch}/{department}','FoodController@store');
Route::post('/foods/{branch}/{department}/store-many','FoodController@storeMany');


// resource: delete
Route::get('/foods/{food}/{branch}/destroy','FoodController@destroy');
Route::get('/foods/{food}/{branch}/{department}/destroy','FoodController@destroy');

Route::post('/foods/{food}/{branch}/destroy','FoodController@destroy');
Route::post('/foods/{food}/{branch}/{department}/destroy','FoodController@destroy');

Route::delete('/foods/{food}/{branch}','FoodController@destroy');
Route::delete('/foods/{food}/{branch}/{department}','FoodController@destroy');
/////////////////////////////////////////////////////////////////////////////////////////////////





//----------------------------------------------------------------------------------------------
//drinks  ----- uses - slug
//----------------------------------------------------------------------------------------------

// form: add
Route::get('/drinks/{branch}/add','DrinkController@create');
Route::get('/drinks/{branch}/add-many','DrinkController@createMany');
Route::get('/drinks/{branch}/create','DrinkController@create');
Route::get('/drinks/{branch}/create-many','DrinkController@createMany');
Route::get('/drinks/{branch}/{department}/add','DrinkController@create');
Route::get('/drinks/{branch}/{department}/add-many','DrinkController@createMany');
Route::get('/drinks/{branch}/{department}/create','DrinkController@create');
Route::get('/drinks/{branch}/{department}/create-many','DrinkController@createMany');

// form: edit
Route::get('/drinks/{branch}/edit-many','DrinkController@editMany');
Route::get('/drinks/{drink}/{branch}/edit','DrinkController@edit');
Route::get('/drinks/{branch}/{department}/edit-many','DrinkController@editMany');
Route::get('/drinks/{drink}/{branch}/{department}/edit','DrinkController@edit');

// page: show
Route::get('/drinks/{drink}/show','DrinkController@show');
Route::get('/drinks/{drink}/delete','DrinkController@showToDelete');
Route::get('/drinks/{drink}/{branch}/show','DrinkController@show');
Route::get('/drinks/{drink}/{branch}/delete','DrinkController@showToDelete');
Route::get('/drinks/{drink}/{branch}/{department}','DrinkController@show');
Route::get('/drinks/{drink}/{branch}/{department}/show','DrinkController@show');
Route::get('/drinks/{drink}/{branch}/{department}/delete','DrinkController@showToDelete');

// page: index
Route::get('/drinks/{branch}','DrinkController@index');
Route::get('/drinks/{branch}/{department}','DrinkController@index');

// resource: store
Route::post('/drinks/{branch}','DrinkController@store');
Route::post('/drinks/{branch}/store-many','DrinkController@storeMany');
Route::post('/drinks/{branch}/{department}','DrinkController@store');
Route::post('/drinks/{branch}/{department}/store-many','DrinkController@storeMany');

// resource: update
Route::post('/drinks/{branch}/update-many','DrinkController@updateMany');
Route::post('/drinks/{drink}/{branch}','DrinkController@update');
Route::post('/drinks/{branch}/{department}/update-many','DrinkController@updateMany');
Route::post('/drinks/{drink}/{branch}/{department}','DrinkController@update');

Route::put('/drinks/{branch}/update-many','DrinkController@updateMany');
Route::put('/drinks/{drink}/{branch}','DrinkController@update');
Route::put('/drinks/{branch}/{department}/update-many','DrinkController@updateMany');
Route::put('/drinks/{drink}/{branch}/{department}','DrinkController@update');

// resource: delete
Route::get('/drinks/{drink}/{branch}/destroy','DrinkController@destroy');
Route::get('/drinks/{drink}/{branch}/{department}/destroy','DrinkController@destroy');

Route::post('/drinks/{drink}/{branch}/destroy','DrinkController@destroy');
Route::post('/drinks/{drink}/{branch}/{department}/destroy','DrinkController@destroy');

Route::delete('/drinks/{drink}/{branch}','DrinkController@destroy');
Route::delete('/drinks/{drink}/{branch}/{department}','DrinkController@destroy');

/////////////////////////////////////////////////////////////////////////////////////////////////





//----------------------------------------------------------------------------------------------
//drink type ------- uses - id
//----------------------------------------------------------------------------------------------

// resource: store
Route::post('/drink-types/{branch}', 'DrinkTypeController@store');
Route::post('/drink-types/{branch}/store-many', 'DrinkTypeController@storeMany');
Route::post('/drink-types/{branch}/{department}', 'DrinkTypeController@store');
Route::post('/drink-types/{branch}/{department}/store-many', 'DrinkTypeController@storeMany');

// resource: update
Route::post('/drink-types/update-many', 'DrinkTypeController@updateMany');
Route::post('/drink-types/{drink_type}', 'DrinkTypeController@update');
Route::post('/drink-types/{branch}/update-many', 'DrinkTypeController@updateMany');
Route::post('/drink-types/{drink_type}/{branch}', 'DrinkTypeController@update');
Route::post('/drink-types/{branch}/{department}/update-many', 'DrinkTypeController@updateMany');
Route::post('/drink-types/{drink_type}/{branch}/{department}', 'DrinkTypeController@update');

Route::put('/drink-types/update-many', 'DrinkTypeController@updateMany');
Route::put('/drink-types/{drink_type}', 'DrinkTypeController@update');
Route::put('/drink-types/{branch}/update-many', 'DrinkTypeController@updateMany');
Route::put('/drink-types/{drink_type}/{branch}', 'DrinkTypeController@update');
Route::put('/drink-types/{branch}/{department}/update-many', 'DrinkTypeController@updateMany');
Route::put('/drink-types/{drink_type}/{branch}/{department}', 'DrinkTypeController@update');

// resource: delete
Route::get('/drink-types/{drink_type}/{branch}/destroy',  'DrinkTypeController@destroy' );
Route::get('/drink-types/{drink_type}/{branch}/{department}/destroy',  'DrinkTypeController@destroy' );

Route::post('/drink-types/{drink_type}/{branch}/destroy',  'DrinkTypeController@destroy' );
Route::post('/drink-types/{drink_type}/{branch}/{department}/destroy',  'DrinkTypeController@destroy' );

Route::delete('/drink-types/{drink_type}/{branch}',  'DrinkTypeController@destroy' );
Route::delete('/drink-types/{drink_type}/{branch}/{department}',  'DrinkTypeController@destroy' );
/////////////////////////////////////////////////////////////////////////////////////////////////




//----------------------------------------------------------------------------------------------
//crate crate_sizes ------- uses - id
//----------------------------------------------------------------------------------------------

// store
Route::post('/crate-sizes/{branch}','CrateSizeController@store');
Route::post('/crate-sizes/{branch}/{department}','CrateSizeController@store');

// update
Route::post('/crate-sizes/save-many','CrateSizeController@saveMany');
Route::post('/crate-sizes/{crate_size}','CrateSizeController@update');
Route::post('/crate-sizes/{branch}/save-many','CrateSizeController@saveCrateSizes');
Route::post('/crate-sizes/{crate_size}/{branch}','CrateSizeController@update');
Route::post('/crate-sizes/{branch}/{department}/save-many','CrateSizeController@saveCrateSizes');
Route::post('/crate-sizes/{crate_size}/{branch}/{department}','CrateSizeController@update');

Route::put('/crate-sizes/save-many','CrateSizeController@saveMany');
Route::put('/crate-sizes/{crate_size}','CrateSizeController@update');
Route::put('/crate-sizes/{branch}/save-many','CrateSizeController@saveCrateSizes');
Route::put('/crate-sizes/{crate_size}/{branch}','CrateSizeController@update');
Route::put('/crate-sizes/{branch}/{department}/save-many','CrateSizeController@saveCrateSizes');
Route::put('/crate-sizes/{crate_size}/{branch}/{department}','CrateSizeController@update');

// delete
Route::get('/crate-sizes/{crate_size}/{branch}/destroy','CrateSizeController@destroy');
Route::get('/crate-sizes/{crate_size}/{branch}/{department}/destroy', 'CrateSizeController@destroy');

Route::post('/crate-sizes/{crate_size}/{branch}/destroy','CrateSizeController@destroy');
Route::post('/crate-sizes/{crate_size}/{branch}/{department}/destroy', 'CrateSizeController@destroy');

Route::delete('/crate-sizes/{crate_size}/{branch}','CrateSizeController@destroy');
Route::delete('/crate-sizes/{crate_size}/{branch}/{department}', 'CrateSizeController@destroy');
/////////////////////////////////////////////////////////////////////////////////////////////////


//----------------------------------------------------------------------------------------------
//businessdays ---- uses -> slug
//----------------------------------------------------------------------------------------------


// form: add
Route::get('/businessdays/{branch}/add','BusinessdayController@create');
Route::get('/businessdays/{branch}/create','BusinessdayController@create');;
Route::get('/businessdays/{branch}/{is_department}/add','BusinessdayController@create');
Route::get('/businessdays/{branch}/{is_department}/create','BusinessdayController@create');

// form: edit
Route::get('/businessdays/{drink}/edit','BusinessdayController@edit');
Route::get('/businessdays/{drink}/{branch}/edit','BusinessdayController@edit');
Route::get('/businessdays/{drink}/{branch}/{is_department}/edit','BusinessdayController@edit');

// page: show
Route::get('/businessdays/{drink}/show','BusinessdayController@show');
Route::get('/businessdays/{drink}/{branch}/show','BusinessdayController@show');
Route::get('/businessdays/{drink}/{branch}/{is_department}','BusinessdayController@show');
Route::get('/businessdays/{drink}/{branch}/{is_department}/show','BusinessdayController@show');

// page: index
Route::get('/businessdays/{branch}','BusinessdayController@index');
Route::get('/businessdays/{branch}/{is_department}','BusinessdayController@index');

// resource: store
Route::post('/businessdays/{branch}','BusinessdayController@store');
Route::post('/businessdays/{branch}/{is_department}','BusinessdayController@store');

// resource: update
Route::post('/businessdays/{drink}/{branch}','BusinessdayController@update');
Route::post('/businessdays/{drink}/{branch}/{is_department}','BusinessdayController@update');

Route::put('/businessdays/{drink}/{branch}','BusinessdayController@update');
Route::put('/businessdays/{drink}/{branch}/{is_department}','BusinessdayController@update');

// resource: delete
Route::get('/businessdays/{drink}/{branch}/destroy','BusinessdayController@destroy');
Route::get('/businessdays/{drink}/{branch}/{is_department}/destroy','BusinessdayController@destroy');

Route::post('/businessdays/{drink}/{branch}/destroy','BusinessdayController@destroy');
Route::post('/businessdays/{drink}/{branch}/{is_department}/destroy','BusinessdayController@destroy');

Route::delete('/businessdays/{drink}/{branch}','BusinessdayController@destroy');
Route::delete('/businessdays/{drink}/{branch}/{is_department}','BusinessdayController@destroy');


/////////////////////////////////////////////////////////////////////////////////////////////////



//----------------------------------------------------------------------------------------------
//resource routes
//----------------------------------------------------------------------------------------------
Route::resource('settings','SettingController');
Route::resource('branches','BranchController');
Route::resource('departments','DepartmentController');
Route::resource('users','UserController');
Route::resource('members','UserController');
Route::resource('venues','VenueController');
Route::resource('rooms','RoomController');
Route::resource('drinks','DrinkController');
Route::resource('foods','FoodController');
Route::resource('activities','ActivityController');

Route::resource('roles','RoleController');
Route::resource('titles','TitleController');

Route::resource('crate_sizes','CrateSizeController');
Route::resource('drink_types','DrinkTypeController');
Route::resource('room_types','RoomTypeController');

Route::resource('loans','LoanController');
Route::resource('businessdays','BusinessdayController');
Route::resource('transactions','TransactionController');
/////////////////////////////////////////////////////////////////////////////////////////////////


//----------------------------------------------------------------------------------------------
//users ---- uses slug     //replica of member
//----------------------------------------------------------------------------------------------
// page: add
Route::get('/users/{branch}/add','UserController@create');
Route::get('/users/{branch}/create','UserController@create');
Route::get('/users/{branch}/add-many','UserController@addMany');
Route::get('/users/{branch}/create-many','UserController@addMany');
Route::get('/users/{branch}/{department}/add','UserController@create');
Route::get('/users/{branch}/{department}/create','UserController@create');
Route::get('/users/{branch}/{department}/add-many','UserController@addMany');
Route::get('/users/{branch}/{department}/create-many','UserController@addMany');

// page: show
Route::get('/users/{member}/show','UserController@show');
Route::get('/users/{member}/delete','UserController@showToDelete');
Route::get('/users/{member}/{branch}/show','UserController@show');
Route::get('/users/{member}/{branch}/edit','UserController@edit');
Route::get('/users/{member}/{branch}/delete','UserController@showToDelete');
Route::get('/users/{member}/{branch}/{department}','UserController@show');
Route::get('/users/{member}/{branch}/{department}/show','UserController@show');
Route::get('/users/{member}/{branch}/{department}/edit','UserController@edit');
Route::get('/users/{member}/{branch}/{department}/delete','UserController@showToDelete');

// page: index
Route::get('/users/{branch}','UserController@index');
Route::get('/users/{branch}/{department}','UserController@index');

// resource: update
Route::put('/users/{member}/{branch}','UserController@update');
Route::put('/users/{member}/{branch}/{department}','UserController@update');
Route::put('/users/{branch}/update-many','UserController@updateMany');
Route::put('/users/{branch}/{department}/update-many','UserController@updateMany');

Route::post('/users/{member}/{branch}','UserController@update');
Route::post('/users/{member}/{branch}/{department}','UserController@update');
Route::post('/users/{branch}/update-many','UserController@updateMany');
Route::post('/users/{branch}/{department}/update-many','UserController@updateMany');

// resource: store
Route::post('/users/{branch}','UserController@store');
Route::post('/users/{branch}/store-many','UserController@storeMany');
Route::post('/users/{branch}/{department}','UserController@store');
Route::post('/users/{branch}/{department}/store-many','UserController@storeMany');

// resource: delete
Route::get('/users/{member}/{branch}/destroy','UserController@destroy');
Route::get('/users/{member}/{branch}/{department}/destroy','UserController@destroy');
Route::post('/users/{member}/{branch}/destroy','UserController@destroy');
Route::post('/users/{member}/{branch}/{department}/destroy','UserController@destroy');
Route::delete('/users/{member}/{branch}','UserController@destroy');
Route::delete('/users/{member}/{branch}/{department}','UserController@destroy');

/////////////////////////////////////////////////////////////////////////////////////////////////
