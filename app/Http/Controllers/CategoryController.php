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
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function index()
    {
        return DB::table('categories')->paginate(10);
    }

    /**
     *  @OA\Get(
     *      path="/categories/{id}/articles",
     *      operationId="getArticlesBycategory",
     *      tags={"category"},
     *      summary="Get articles by category",
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
     *       )
     * )
     *
     * Get articles by category
     *
     * @param int $id
     * @return \Illuminate\Support\Collection
     */
    public function getArticlesByCategory(int $id)
    {
        return DB::table('articles')->where('category_id', $id)->get();
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
        $category = Category::create($request->only(['name']));

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
     *      @OA\Response(response=404, description="Resource not found")
     * )
     * Get category by id
     *
     * @param Category $category
     * @return Category
     */
    public function show(Category $category)
    {
        return $category;
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
     *     @OA\Response(response=404, description="Resource not found"),
     * )
     * Update category
     *
     * @param Request $request
     * @param Category $category
     * @return Category|\Illuminate\Support\MessageBag
     */
    public function update(Request $request, Category $category)
    {
        $validation = Validator::make($request->all(), [
            'name' => 'required|string|min:2|max:255',
        ]);

        if ($validation->fails())
            return $validation->errors();

        $category->update($request->only(['name']));

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
     *       @OA\Response(response=404, description="Resource not found"),
     * )
     * Remove category
     *
     * @param Category $category
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy(Category $category)
    {
        $category->delete();

        return Response::json([],204);
    }
}
