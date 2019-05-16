<?php

Route::get('/{any}', function() {
  return view('spa');
})->where('any', '.*');