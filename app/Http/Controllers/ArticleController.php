<?php

namespace App\Http\Controllers;

use App\User;
use App\Article;
use App\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;

/**
 * @OA\Tag(
 *     name="article",
 *     description="Operations about article",
 *     @OA\ExternalDocumentation(
 *         description="Find out more about",
 *         url="http://swagger.io"
 *     )
 * )
 */
class ArticleController extends Controller
{

    /**
     * @OA\Get(
     *      path="/articles",
     *      operationId="getArticles",
     *      tags={"article"},
     *      summary="Get list of all articles",
     *     @OA\Parameter(
     *          in="query",
     *          name="page",
     *          required=false,
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="successful operation",
     *          @OA\Schema(
     *              type="array",
     *              items={@OA\Schema(ref="#/components/schemas/Article")}
     *          )
     *       ),
     *       @OA\Response(response=400, description="Bad request"),
     * )
     * Retrieve all articles
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function index()
    {
        return DB::table('articles')->paginate(15);;
    }

    /**
     * @OA\Post(
     *     path="/articles",
     *     tags={"article"},
     *     description="Create an article",
     *     operationId="createArticle",
     *     @OA\Response(
     *         response=201,
     *         description="successful operation"
     *     ),
     *     @OA\RequestBody(
     *          @OA\JsonContent(ref="#/components/schemas/Article")
     *     ),
     *     @OA\Response(response=400, description="Bad request")
     * )
     *
     * Create article
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Support\MessageBag
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

        return Response::json($article,201);
    }

    /**
     * @OA\Get(
     *      path="/articles/{id}",
     *      operationId="getArticle",
     *      tags={"article"},
     *      summary="Get article by id",
     *      @OA\Parameter(
     *          in="path",
     *          name="id",
     *          required=true,
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/Article"),
     *       ),
     *       @OA\Response(response=400, description="Bad request"),
     * )
     * Get article by id
     *
     * @param int $id
     * @return mixed
     */
    public function show(Article $article)
    {
        return $article;
    }

    /**
     * @OA\Put(
     *     path="/articles/{id}",
     *     tags={"article"},
     *     summary="Update article",
     *     operationId="updateArticle",
     *     @OA\Parameter(
     *          in="path",
     *          name="id",
     *          required=true,
     *          @OA\Schema(
     *              type="integer"
     *          )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/Article"),Update
     *     ),
     *     @OA\RequestBody(
     *          @OA\JsonContent(ref="#/components/schemas/Article")
     *     ),
     *     @OA\Response(response=400, description="Bad request"),
     * )
     *
     * Update article
     *
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Support\MessageBag
     */
    public function update(Request $request, Article $article)
    {
        $validation = Validator::make($request->all(), [
            'title' => 'required|string|min:2|max:255',
            'content' => 'required|string|min:2',
            'author' => 'required|integer',
            'category' => 'required|integer'
        ]);

        if ($validation->fails())
            return $validation->errors();

        $article->update($request->only(['title', 'content', 'author', 'category']));

        return $article;
    }

    /**
     * @OA\Delete(
     *      path="/articles/{id}",
     *      operationId="deleteArticle",
     *      tags={"article"},
     *      summary="Delete article",
     *      @OA\Parameter(
     *          in="path",
     *          name="id",
     *          required=true,
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=204,
     *          description="successful operation"
     *       ),
     *       @OA\Response(response=400, description="Bad request"),
     * )
     * Remove article
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Article $article)
    {
        $article->delete();

        return Response::json([],204);
    }
}
