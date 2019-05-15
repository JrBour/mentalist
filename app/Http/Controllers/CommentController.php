<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Comment;
use App\User;
use App\Article;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Comment::all();
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
            'content' => 'required|string|min:2',
            'author' => 'required|integer',
            'article' => 'required|integer'
        ]);

        if ($validation->fails())
            return $validation->errors();

        $comment = new Comment();
        $comment->content = $request->content;
        $comment->author()->associate(User::find($request->author));
        $comment->article()->associate(Article::find($request->article));

        $comment->save();

        return $comment;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(int $id)
    {
        return Comment::find($id);
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
            'content' => 'required|string|min:2',
            'author' => 'required|integer',
            'article' => 'required|integer'
        ]);

        if ($validation->fails())
            return $validation->errors();

        $comment = Comment::find($id);
        $comment->content = $request->content;
        $comment->author()->associate(User::find($request->author));
        $comment->article()->associate(Article::find($request->article));

        $comment->save();

        return $comment;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        return Comment::destroy($id);
    }
}
