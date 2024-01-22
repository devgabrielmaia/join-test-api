<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Support\Facades\Cache;
use OpenApi\Annotations as OA;

/**
 * @OA\Info(
 *     title="API Case Técnico Join",
 *     version="1.0",
 *     description="API Case Técnico Join",
 *     @OA\Contact(
 *         email="gabrielmaia.web@gmail.com",
 *         name="Gabriel Maia"
 *     ),
 *     @OA\License(
 *         name="Apache 2.0",
 *         url="http://www.apache.org/licenses/LICENSE-2.0.html"
 *     )
 * )
 */
class CategoryController extends Controller
{
    /**
     * @OA\SecurityScheme(
     *     type="http",
     *     scheme="bearer",
     *     securityScheme="bearerAuth",
     * )
     */

    /**
     * @OA\Get(
     *     path="/api/category",
     *     summary="Get all categories",
     *     tags={"Category"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(response="200", description="List of categories"),
     * )
     */
    public function index(): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        $categories = Cache::remember('categories', 60 * 60, fn() => Category::all());
        return CategoryResource::collection($categories);
    }

    /**
     * @OA\Get(
     *     path="/api/category/{id}",
     *     summary="Get a category by ID",
     *     tags={"Category"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\Response(response="200", description="Category details"),
     *     @OA\Response(response="404", description="Category not found"),
     * )
     */
    public function show($id): CategoryResource
    {
        $categories = Cache::remember(
            "category-{$id}",
            60 * 60,
            fn() => Category::findOrFail($id)
        );
        return new CategoryResource($categories);
    }

    /**
     * @OA\Post(
     *     path="/api/category",
     *     summary="Create a new category",
     *     tags={"Category"},
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 required={"categoryName"},
     *                 @OA\Property(property="categoryName", type="string", example="New Category")
     *             )
     *         )
     *     ),
     *     @OA\Response(response="201", description="Category created"),
     *     @OA\Response(response="422", description="Validation error"),
     * )
     */
    public function store(CategoryRequest $request): CategoryResource
    {
        $category = new Category();
        $category->fill([
            'nome_categoria' => $request->input('categoryName')
        ]);
        $category->save();
        return new CategoryResource($category);
    }

    /**
     * @OA\Put(
     *     path="/api/category/{id}",
     *     summary="Update a category by ID",
     *     tags={"Category"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 required={"categoryName"},
     *                 @OA\Property(property="categoryName", type="string", example="Updated Category")
     *             )
     *         )
     *     ),
     *     @OA\Response(response="200", description="Category updated"),
     *     @OA\Response(response="404", description="Category not found"),
     *     @OA\Response(response="422", description="Validation error"),
     * )
     */
    public function update(CategoryRequest $request, $id): CategoryResource
    {
        $category = Category::findOrFail($id);
        $category->fill([
            'nome_categoria' => $request->input('categoryName')
        ]);
        $category->update();
        return new CategoryResource($category);
    }

    /**
     * @OA\Delete(
     *     path="/api/category/{id}",
     *     summary="Delete a category by ID",
     *     tags={"Category"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\Response(response="204", description="Category deleted"),
     *     @OA\Response(response="404", description="Category not found"),
     * )
     */
    public function destroy($id): \Illuminate\Http\JsonResponse
    {
        $category = Category::findOrFail($id);
        $category->delete();
        return response()->json(null, 204);
    }
}
