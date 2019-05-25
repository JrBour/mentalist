<?php

namespace App\Http\Controllers;

use App\Like;
use App\User;
use App\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;

/**
 * @OA\Tag(
 *     name="like",
 *     description="Operations about like",
 *     @OA\ExternalDocumentation(
 *         description="Find out more about",
 *         url="http://swagger.io"
 *     )
 * )
 */
class LikeController extends Controller
{

    /**
     * * @OA\Get(
     *      path="/likes",
     *      operationId="getLikes",
     *      tags={"like"},
     *      summary="Get list of all likes",
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
     *              items={@OA\Schema(ref="#/components/schemas/Like")}
     *          )
     *       ),
     *       @OA\Response(response=400, description="Bad request"),
     * )
     * Retrieve all likes
     * @return mixed
     */
    public function index()
    {
        return DB::table('likes')->paginate(15);
    }

    /**
     * @OA\Post(
     *     path="/likes",
     *     tags={"like"},
     *     description="Create a like",
     *     operationId="createLike",
     *     @OA\Response(
     *         response=201,
     *         description="successful operation"
     *     ),
     *     @OA\RequestBody(
     *          @OA\JsonContent(ref="#/components/schemas/Like")
     *     ),
     *     @OA\Response(response=400, description="Bad request")
     * )
     * Create likes
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Support\MessageBag
     */
    public function store(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'user_id' => 'required|integer',
            'article_id' => 'required|integer'
        ]);

        if ($validation->fails())
            return $validation->errors();
        $like = Like::create($request->only(['user_id', 'article_id']));;

        return Response::json($like,201);
    }

    /**
     * @OA\Get(
     *      path="/likes/{id}",
     *      operationId="getLike",
     *      tags={"like"},
     *      summary="Get like by id",
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
     *          @OA\JsonContent(ref="#/components/schemas/Like"),
     *       ),
     *       @OA\Response(response=400, description="Bad request"),
     * )
     * Get like by id
     *
     * @param Like $like
     * @return Like
     */
    public function show(Like $like)
    {
        return $like;
    }

    /**
     * @OA\Put(
     *     path="/likes/{id}",
     *     tags={"like"},
     *     summary="Update like",
     *     operationId="updateLike",
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
     *          @OA\JsonContent(ref="#/components/schemas/Like"),
     *     ),
     *     @OA\RequestBody(
     *          @OA\JsonContent(ref="#/components/schemas/Like")
     *     ),
     *     @OA\Response(response=400, description="Bad request"),
     * )
     * Update like
     *
     * @param Request $request
     * @param Like $like
     * @return Like|\Illuminate\Support\MessageBag
     */
    public function update(Request $request, Like $like)
    {
        $validation = Validator::make($request->all(), [
            'user_id' => 'required|integer',
            'article_id' => 'required|integer'
        ]);

        if ($validation->fails())
            return $validation->errors();
        $like->update($request->only(['user_id', 'article_id']));

        return $like;
    }


    /**
     * @OA\Delete(
     *      path="/likes/{id}",
     *      operationId="deleteLike",
     *      tags={"like"},
     *      summary="Delete like",
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
     *       @OA\Response(response=404, description="Resource not found"),
     * )
     * Remove like
     *
     * @param Like $like
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy(Like $like)
    {
        $like->delete();

        return Response::json([],204);
    }
}
