<?php

namespace App\Http\Controllers;

use App\Article;
use App\Http\Resources\Article as ArticleResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\Comment as CommentResource;


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
     * )
     * Retrieve all articles
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function index()
    {
        return ArticleResource::collection(DB::table('articles')->paginate(10));
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
            'author_id' => 'required|integer',
            'category_id' => 'required|integer'
        ]);

        if ($validation->fails())
            return $validation->errors();

        $article = Article::create($request->only(['title', 'content', 'author_id', 'category_id']));

        return Response::json($article,201);
    }

    /**
     *  @OA\Get(
     *      path="/arrticles/{id}/comments",
     *      operationId="getCommentsByArticle",
     *      tags={"commentsArticle"},
     *      summary="Get comments by article",
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
     *          @OA\JsonContent(ref="#/components/schemas/Comment"),
     *       )
     * )
     *
     * Get comments by article
     *
     * @param int $id
     * @return \Illuminate\Support\Collection
     */
    public function getCommentsByArticle(int $id)
    {
        return CommentResource::collection(DB::table('comments')->where('article_id', $id)->get());
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
     *       @OA\Response(response=404, description="Resource not found"),
     * )
     * Get article by id
     *
     * @param Article $article
     * @return Article
     */
    public function show(Article $article)
    {
        return new ArticleResource($article);
    }

    /**
     *  @OA\Put(
     *     path="/articles/{id}",
     *     tags={"article"},
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
     *          @OA\JsonContent(ref="#/components/schemas/Article"),
     *     ),
     *     @OA\RequestBody(
     *          @OA\JsonContent(ref="#/components/schemas/Article")
     *     ),
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource not found")
     * )
     *
     * Update article
     *
     * @param Request $request
     * @param Article $article
     * @return Article|\Illuminate\Support\MessageBag
     */
    public function update(Request $request, Article $article)
    {
        $validation = Validator::make($request->all(), [
            'title' => 'required|string|min:2|max:255',
            'content' => 'required|string|min:2',
            'author_id' => 'required|integer',
            'category_id' => 'required|integer'
        ]);

        if ($validation->fails())
            return $validation->errors();

        $article->update($request->only(['title', 'content', 'author_id', 'category_id']));

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
     *       @OA\Response(response=404, description="Resource not found"),
     * )
     * Remove article
     *
     * @param Article $article
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy(Article $article)
    {
        $article->delete();

        return Response::json([],204);
    }
}
