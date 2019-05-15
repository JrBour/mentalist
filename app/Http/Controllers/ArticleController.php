<?php

namespace App\Http\Controllers;

use App\User;
use App\Article;
use App\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Article::all();
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
            'title' => 'required|string|min:2|max:255',
            'content' => 'required|string|min:2',
            'author' => 'required|integer',
            'category' => 'required|integer'
        ]);

        if ($validation->fails())
            return $validation->errors();

        $article = new Article();
        $article->title = $request->title;
        $article->content = $request->content;
        $article->author()->associate(User::find($request->author));
        $article->category()->associate(Category::find($request->category));

        $article->save();

        return $article;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(int $id)
    {
        return Article::find($id);
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
            'title' => 'required|string|min:2|max:255',
            'content' => 'required|string|min:2',
            'author' => 'required|integer',
            'category' => 'required|integer'
        ]);

        if ($validation->fails())
            return $validation->errors();

        $article = Article::find($id);
        $article->title = $request->title;
        $article->content = $request->content;
        $article->author()->associate(User::find($request->author));
        $article->category()->associate(Category::find($request->category));

        $article->save();

        return $article;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        return Article::destroy($id);
    }
}
