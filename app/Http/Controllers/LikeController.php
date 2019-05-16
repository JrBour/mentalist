<?php

namespace App\Http\Controllers;

use App\Like;
use App\User;
use App\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class LikeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Like::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'user' => 'required|integer',
            'article' => 'required|integer'
        ]);

        if ($validation->fails())
            return $validation->errors();

        $like = new Like();
        $like->user()->associate(User::find($request->user));
        $like->article()->associate(Article::find($request->article));

        $like->save();

        return $like;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(int $id)
    {
        return Like::find($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, int $id)
    {
        $validation = Validator::make($request->all(), [
            'user' => 'required|integer',
            'article' => 'required|integer'
        ]);

        if ($validation->fails())
            return $validation->errors();

        $like = Like::find($id);
        $like->user()->associate(User::find($request->user ));
        $like->article()->associate(Article::find($request->article));

        $like->save();

        return $like;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        return Like::destroy($id);
    }
}
