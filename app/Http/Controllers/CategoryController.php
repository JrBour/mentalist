<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

/**
 * @OA\Tag(
 *     name="category",
 *     description="Operations about category",
 *     @OA\ExternalDocumentation(
 *         description="Find out more about",
 *         url="http://swagger.io"
 *     )
 * )
 */
class CategoryController extends Controller
{
    /**
     * @OA\Get(
     *      path="/categories",
     *      operationId="getCategories",
     *      tags={"category"},
     *      summary="Get list of all categories",
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
     *              items={@OA\Schema(ref="#/components/schemas/Category")}
     *          )
     *       )
     * )
     * Retrieve all categories
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function index()
    {
        return DB::table('categories')->paginate(15);
    }

    /**
     * @OA\Post(
     *     path="/categories",
     *     tags={"category"},
     *     description="Create a category",
     *     operationId="createCategory",
     *     @OA\Response(
     *         response=201,
     *         description="successful operation"
     *     ),
     *     @OA\RequestBody(
     *          @OA\JsonContent(ref="#/components/schemas/Category")
     *     ),
     *     @OA\Response(response=400, description="Bad request")
     * )
     * Create category
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Support\MessageBag
     */
    public function store(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'name' => 'required|string|min:2|max:255',
        ]);

        if ($validation->fails())
            return $validation->errors();

        $category = new Category();
        $category->name = $request->name;

        $category->save();

        return Response::json($category, 201);
    }

    /**
     * @OA\Get(
     *      path="/categories/{id}",
     *      operationId="getCategory",
     *      tags={"category"},
     *      summary="Get category by id",
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
     *          @OA\JsonContent(ref="#/components/schemas/Category"),
     *       ),
     *       @OA\Response(response=400, description="Bad request"),
     * )
     * Get category by id
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(int $id)
    {
        if (Category::find($id) !== null) {
            return Category::find($id);
        } else {
            return Response::json([], 404);
        }
    }

    /**
     * @OA\Put(
     *     path="/categories/{id}",
     *     tags={"category"},
     *     summary="Update category",
     *     operationId="UpdateCategory",
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
     *          @OA\JsonContent(ref="#/components/schemas/Category"),
     *     ),
     *     @OA\RequestBody(
     *          @OA\JsonContent(ref="#/components/schemas/Category")
     *     ),
     *     @OA\Response(response=400, description="Bad request"),
     * )
     * Update category.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, int $id)
    {
        $validation = Validator::make($request->all(), [
            'name' => 'required|string|min:2|max:255',
        ]);

        if ($validation->fails())
            return $validation->errors();

        $category = Category::find($id);
        if (Category::find($id) === null)
            return Response::json([], 404);
        $category->name = $request->name;

        $category->save();

        return $category;
    }

    /**
     *  @OA\Delete(
     *      path="/categories/{id}",
     *      operationId="deleteCategory",
     *      tags={"category"},
     *      summary="Delete category",
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
     * Remove category
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(int $id)
    {
        Category::destroy($id);

        return Response::json([],204);
    }
}
