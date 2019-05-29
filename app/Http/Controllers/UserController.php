<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;

/**
 * @OA\Tag(
 *     name="user",
 *     description="Operations about user",
 *     @OA\ExternalDocumentation(
 *         description="Find out more about",
 *         url="http://swagger.io"
 *     )
 * )
 */
class UserController extends Controller
{
    /**
     * * @OA\Get(
     *      path="/users",
     *      operationId="getUsersList",
     *      tags={"user"},
     *      summary="Get list of all users",
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
     *              items={@OA\Schema(ref="#/components/schemas/User")}
     *          )
     *       ),
     *       @OA\Response(response=400, description="Bad request"),
     * )
     * Retrieve all users
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function index()
    {
        return DB::table('users')->paginate(15);
    }

    /**
     * @OA\Post(
     *     path="/users",
     *     tags={"user"},
     *     summary="Create an user",
     *     operationId="createUser",
     *     @OA\Response(
     *         response=201,
     *         description="successful operation"
     *     ),
     *     @OA\RequestBody(
     *          @OA\JsonContent(ref="#/components/schemas/User")
     *     )
     * )
     *
     * Create User
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Support\MessageBag
     */
    public function store(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'firstname' => 'required|string|min:2|max:255',
            'name' => 'required|string|min:2|max:255',
            'email' => 'required|string|email|min:2|max:255',
            'username' => 'required|string|min:2|max:150',
            'password' => 'required|string|min:6|max:255'
        ]);

        if ($validation->fails())
            return $validation->errors();

        $user = new User();
        $user->firstname = $request->firstname;
        $user->username= $request->username;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->admin    = true;
        $user->password = Hash::make($request->password);
        $user->email_hashed = md5( strtolower( trim($request->email )));

        $user->save();

        return Response::json($user,201);
    }

    /**
     * @OA\Post(
     *     path="/login",
     *     tags={"login"},
     *     summary="Logged an user",
     *     operationId="loginUser",
     *     @OA\Response(
     *         response=200,
     *         description="successful operation"
     *     ),
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                  @OA\Property(property="email", type="string"),
     *                  @OA\Property(property="password", type="string"),
     *              )
     *          )
     *      )
     * )
     *
     * Sign in an user
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Auth\Authenticatable|\Illuminate\Http\JsonResponse|\Illuminate\Support\MessageBag|null
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function login(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'email' => 'required|string|email|min:2|max:255',
            'password' => 'required|string|min:6|max:255'
        ]);

        if ($validation->fails())
            return $validation->errors();

        if (auth()->attempt(['email' => $request->input('email'), 'password' => $request->input('password')])) {
            $user = auth()->user();
            $username = $user->email;
            $password = $request->input('password');
            $basicAuth = base64_encode("{$username}:{$password}");
            $client = new Client(['base_uri' => 'https://www.gravatar.com/avatar/']);
            $response = $client->request('GET', $user->email_hashed);
            $user->picture = explode('"', $response->getHeader('Content-Disposition')[0])[1];
            $user->token = $basicAuth;

            return $user;
        }
        return response()->json(['error' => 'Unauthenticated user'], 401);
    }

    /**
     * @OA\Get(
     *      path="/users/{id}",
     *      operationId="getUser",
     *      tags={"user"},
     *      summary="Get user by id",
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
     *          @OA\Schema(
     *              type="array",
     *              items={@OA\Schema(ref="#/components/schemas/Article")}
     *          )
     *       ),
     *       @OA\Response(response=400, description="Bad request"),
     * )
     *
     * Get user by id
     *
     * @param User $user
     * @return User
     */
    public function show(User $user)
    {
        return $user;
    }

    /**
     *  @OA\Get(
     *      path="/users/{id}/articles",
     *      operationId="getArticlesByUser",
     *      tags={"userArticles"},
     *      summary="Get articles by user",
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
     *          @OA\JsonContent(ref="#/components/schemas/User"),
     *       ),
     *       @OA\Response(response=400, description="Bad request"),
     * )
     *
     * Get articles by user
     *
     * @param int $id
     * @return \Illuminate\Support\Collection
     */
    public function getArticlesByUser(int $id)
    {
        return DB::table('articles')->where('author_id', $id)->get();

    }

    /**
     * @OA\Put(
     *     path="/users/{id}",
     *     tags={"user"},
     *     summary="Update an user",
     *     operationId="UpdateUser",
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
     *          @OA\JsonContent(ref="#/components/schemas/User"),
     *     ),
     *     @OA\RequestBody(
     *          @OA\JsonContent(ref="#/components/schemas/User")
     *     ),
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource not found"),
     * )
     * Update User
     *
     * @param Request $request
     * @param User $user
     * @return User|\Illuminate\Support\MessageBag
     */
    public function update(Request $request, User $user)
    {
        $validation = Validator::make($request->all(), [
            'firstname' => 'required|string|min:2|max:255',
            'name' => 'required|string|min:2|max:255',
            'email' => 'required|string|email|min:2|max:255',
            'username' => 'required|string|min:2|max:150',
            'password' => 'required|string|min:6|max:255'
        ]);

        if ($validation->fails())
            return $validation->errors();

        $user->firstname = $request->firstname;
        $user->username= $request->username;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->admin    = true;
        $user->password = Hash::make($request->password);
        $user->email_hashed = md5( strtolower( trim($request->email )));

        $user->save();

        return $user;
    }

    /**
     * @OA\Delete(
     *      path="/users/{id}",
     *      operationId="deleteUser",
     *      tags={"user"},
     *      summary="Delete an user",
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
     * Destroy User
     *
     * @param User $user
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy(User $user)
    {
        $user->delete();

        return Response::json([],204);
    }
}
