<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\Comment as CommentResource;
use App\Comment;


/**
 * @OA\Tag(
 *     name="comment",
 *     description="Operations about comment",
 *     @OA\ExternalDocumentation(
 *         description="Find out more about",
 *         url="http://swagger.io"
 *     )
 * )
 */
class CommentController extends Controller
{
    /**
     *  @OA\Get(
     *      path="/comments",
     *      operationId="getComments",
     *      tags={"comment"},
     *      summary="Get list of all comments",
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
     *              items={@OA\Schema(ref="#/components/schemas/Comment")}
     *          )
     *       ),
     * )
     * Retrieve all comments
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        return CommentResource::collection(DB::table('comments')->paginate(10));
    }


    /**
     * @OA\Post(
     *     path="/comments",
     *     tags={"comment"},
     *     description="Create a comment",
     *     operationId="createComment",
     *     @OA\Response(
     *         response=201,
     *         description="successful operation"
     *     ),
     *     @OA\RequestBody(
     *          @OA\JsonContent(ref="#/components/schemas/Comment")
     *     ),
     *     @OA\Response(response=400, description="Bad request")
     * )
     * Create comment
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Support\MessageBag
     */
    public function store(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'content' => 'required|string|min:2',
            'author_id' => 'required|integer',
            'article_id' => 'required|integer'
        ]);

        if ($validation->fails())
            return $validation->errors();
        $comment  = Comment::create($request->only(['content', 'author_id', 'article_id']));

        return Response::json($comment, 201);

    }

    /**
     *  @OA\Get(
     *      path="/comments/{id}",
     *      operationId="getComment",
     *      tags={"comment"},
     *      summary="Get comment by id",
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
     *       ),
     *       @OA\Response(response=400, description="Bad request"),
     * )
     * Get comment by id
     *
     * @param int $id
     * @return CommentResource
     */
    public function show(int $id)
    {
        return new CommentResource(Comment::find($id));
    }


    /**
     * @OA\Put(
     *     path="/comments/{id}",
     *     tags={"comment"},
     *     summary="Update comment",
     *     operationId="updateComments",
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
     *          @OA\JsonContent(ref="#/components/schemas/Comment"),
     *     ),
     *     @OA\RequestBody(
     *          @OA\JsonContent(ref="#/components/schemas/Comment")
     *     ),
     *     @OA\Response(response=400, description="Bad request"),
     * )
     * Update comment.
     *
     * @param Request $request
     * @param Comment $comment
     * @return Comment|\Illuminate\Support\MessageBag
     */
    public function update(Request $request, Comment $comment)
    {
        $validation = Validator::make($request->all(), [
            'content' => 'required|string|min:2',
            'author_id' => 'required|integer',
            'article_id' => 'required|integer'
        ]);

        if ($validation->fails())
            return $validation->errors();
        $comment->update($request->only(['content', 'author_id', 'article_id']));

        return $comment;
    }

    /**
     * @OA\Delete(
     *      path="/comments/{id}",
     *      operationId="deleteComment",
     *      tags={"comment"},
     *      summary="Delete comment",
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
     * Remove comment
     *
     * @param Comment $comment
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy(Comment $comment)
    {
        $comment->delete();

        return Response::json([],204);
    }
}
