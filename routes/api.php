<?php

use Illuminate\Http\Request;

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

##### RESET PASWORD ########################
	Route::group([    
    'namespace' => 'Auth',    
    'middleware' => 'api',    
    'prefix' => 'password'
	], function () {    
    Route::post('create', 'PasswordResetController@create');
    Route::get('find/{token}', 'PasswordResetController@find');
    Route::post('reset', 'PasswordResetController@reset');    
});

Route::group([    
    'namespace' => 'Auth',    
    'middleware' => 'api',        
	], function () {    
    Route::post('social-register', 'RegisterController@socialRegister');
});
	
Route::group(['middleware' => 'auth:api'], function(){

	Route::group(['namespace' => 'Employee', 'prefix' => 'employee', 'middleware' => 'is-employee'], function(){
		###### PROFILE #########################
		Route::get('profiles/my-profile', 'EmployeeProfileController@myProfile');
		Route::get('profiles/user-data', 'EmployeeProfileController@userData');
		Route::post('profiles', 'EmployeeProfileController@store');	

		###### EXPERIENCE ######################
		Route::post('experience', 'EmployeeExperienceController@store');
		Route::get('experience', 'EmployeeExperienceController@experienceList');
		Route::get('experience/options', 'EmployeeExperienceController@experienceOptions');
		Route::delete('experience/{item_id}', 'EmployeeExperienceController@delete');

		##### STUDIES ##########################
		Route::post('studies', 'EmployeeStudyController@store');
		Route::get('studies', 'EmployeeStudyController@list');
		Route::delete('studies/{item_id}', 'EmployeeStudyController@delete');

		#### CATEGORIES ########################
		Route::get('categories', 'EmployeeCategoryController@list');
		Route::get('categories/my-categories', 'EmployeeCategoryController@myCategories');
		Route::post('categories/attach', 'EmployeeCategoryController@attach');

	});


	###### EMPLOYER #########################
	Route::group(['namespace' => 'Employer', 'prefix' => 'employer', 'middleware' => 'is-employer'], function(){
		####PROFILE ###########################
		Route::get('profiles', 'EmployerProfileController@getProfile');
		Route::post('profiles', 'EmployerProfileController@store');
		#####OFFERS ############################
		Route::get('offers', 'EmployerOfferController@index');
		Route::delete('offers/{offer_id}', 'EmployerOfferController@destroy');
		Route::get('offers/show/{offer_id}', 'EmployerOfferController@show');
		Route::get('offers/{offer_id}/edit', 'EmployerOfferController@edit');
		Route::post('offers', 'EmployerOfferController@store');
		Route::post('offers/attach-cities-and-deps', 'EmployerOfferController@attachCitiesAndDeps');	
		Route::post('offers/attach-category', 'EmployerOfferController@attachCategory');
	});

	#### AUTH ###############################
	Route::post('user/current-user', 'AppController@authUser');
	Route::post('user/update-profile-type-field', 'AppController@setProfileTypeField');
});

##### SETTINGS ##########################
Route::get('settings/doc-types', 'SettingController@getDocTypes');
Route::get('settings/get-cites-with-deps', 'SettingController@getCitiesWithDeps');
Route::get('settings/get-sectors', 'SettingController@getSectors');
Route::get('settings/get-cities-and-deps', 'SettingController@getCitiesAndDeps');