<?php

namespace App\Http\Controllers;

use App\Like;
use App\User;
use App\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
     * @return Like|\Illuminate\Support\MessageBag
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(int $id)
    {
        return Like::find($id);
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
     *  @OA\Delete(
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
     *       @OA\Response(response=400, description="Bad request"),
     * )
     * Remove like
     *
     * @param int $id
     * @return int
     */
    public function destroy(int $id)
    {
        return Like::destroy($id);
    }
}
