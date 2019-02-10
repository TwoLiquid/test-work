<?php

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

Route::group(['prefix' => 'api/v1', 'namespace' => 'Api\V1'], function() {
    Route::get('users','UserController@users')->name('api.v1.users');
});
