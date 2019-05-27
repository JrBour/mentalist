<?php

Route::apiResource('users', 'UserController');
Route::apiResource('categories', 'CategoryController');
Route::apiResource('articles', 'ArticleController');
Route::apiResource('comments', 'CommentController');
Route::apiResource('likes', 'LikeController');

Route::post('/login', 'UserController@login');

Route::middleware('auth.basic.once')->get('/fdp', 'UserController@test');
