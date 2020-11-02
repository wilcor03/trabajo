<?php

##### ADMIN USER ####################
Route::prefix('/app/{any?}')->group(function(){
	Route::get('/', 'AppController@index')->where('any', '.*');
});
##### END ADMIN USER ################

#### PUBLIC ROUTES ###################
Route::get('/', 'HomeController@index')->name('home');
Route::get('publicar-ofertas-de-empleo', 'HomeController@wherePublicOffers');
#### END PUBLIC ROUTES ###################
Route::post('/register', 'Auth\RegisterController@register');

//Auth::routes();

//Route::get('/home', 'HomeController@index')->name('home');
Route::get('/send-email', 'SettingController@sendEmail');

/*Route::get('test', function(){	
	$user = App\User::find(1);
	return 
              new App\Notifications\PasswordResetRequest($user)
          ;
  //return (new App\Notifications\PasswordResetRequest(str_random(60)));
});*/