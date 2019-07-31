<?php

##### ADMIN USER ####################
Route::prefix('/app/{any?}')->group(function(){
	Route::get('/', 'AppController@index')->where('any', '.*');
});
##### END ADMIN USER ################

#### PUBLIC ROUTES ###################
Route::get('/', 'HomeController@index')->name('home');
#### END PUBLIC ROUTES ###################
Route::post('/register', 'Auth\RegisterController@register');

//Auth::routes();

//Route::get('/home', 'HomeController@index')->name('home');
Route::get('/send-email', 'SettingController@sendEmail');
