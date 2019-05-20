<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Comment;
use App\User;
use App\Article;


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
     * @OA\Get(
     *      path="/comments",
     *      operationId="getComments",
     *      tags={"comment"},
     *      summary="Get list of all comments",
     *      @OA\Response(
     *          response=200,
     *          description="successful operation",
     *          @OA\Schema(
     *              type="array",
     *              items={@OA\Schema(ref="#/components/schemas/Comment")}
     *          )
     *       ),
     *       @OA\Response(response=400, description="Bad request"),
     * )
     * Retrieve all comments
     *
     * @return Comment[]|\Illuminate\Database\Eloquent\Collection
     */
    public function index()
    {
        return Comment::all();
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
     * @return Comment|\Illuminate\Support\MessageBag
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
     * @OA\Get(
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(int $id)
    {
        return Comment::find($id);
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
     *  @OA\Delete(
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
     * @param int $id
     * @return int
     */
    public function destroy(int $id)
    {
        return Comment::destroy($id);
    }
}
