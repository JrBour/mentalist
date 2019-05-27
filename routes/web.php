<?php

Route::get('/{any}', function() {
  return view('spa');
})->where('any', '.*');
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
