<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Models\Product;
use App\Http\Resources\ProductResource;

class ProductController extends Controller
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
     *     path="/api/product",
     *     summary="Get all products",
     *     tags={"Product"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(response="200", description="List of products"),
     * )
     */

    public function index(): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        return ProductResource::collection(
            Product::with('category')->get()
        );
    }

    /**
     * @OA\Get(
     *     path="/api/product/{id}",
     *     summary="Get a product by ID",
     *     tags={"Product"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\Response(response="200", description="Product details"),
     *     @OA\Response(response="404", description="Product not found"),
     * )
     */
    public function show($id): ProductResource
    {
        return new ProductResource(
            Product::with('category')->findOrFail($id)
        );
    }

    /**
     * @OA\Post(
     *     path="/api/product",
     *     summary="Create a new product",
     *     tags={"Product"},
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 required={"categoryId", "productName", "price"},
     *                 @OA\Property(property="categoryId", type="integer", example="1"),
     *                 @OA\Property(property="productName", type="string", example="New Product"),
     *                 @OA\Property(property="price", type="number", format="float", example="19.99"),
     *             )
     *         )
     *     ),
     *     @OA\Response(response="201", description="Product created"),
     *     @OA\Response(response="422", description="Validation error"),
     * )
     */
    public function store(ProductRequest $request): ProductResource
    {
        $product = new Product();
        $product->fill([
            'id_categoria_produto' => $request->input('categoryId'),
            'nome_produto' => $request->input('productName'),
            'valor_produto' => $request->input('price'),
        ]);
        $product->data_cadastro = now();
        $product->save();
        return new ProductResource(
            Product::with('category')->findOrFail($product->id_produto)
        );
    }

    /**
     * @OA\Put(
     *     path="/api/product/{id}",
     *     summary="Update a product by ID",
     *     tags={"Product"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 required={"categoryId", "productName", "price"},
     *                 @OA\Property(property="categoryId", type="integer", example="1"),
     *                 @OA\Property(property="productName", type="string", example="Updated Product"),
     *                 @OA\Property(property="price", type="number", format="float", example="24.99"),
     *             )
     *         )
     *     ),
     *     @OA\Response(response="200", description="Product updated"),
     *     @OA\Response(response="404", description="Product not found"),
     *     @OA\Response(response="422", description="Validation error"),
     * )
     */
    public function update(ProductRequest $request, $id): ProductResource
    {
        $product = Product::with('category')->findOrFail($id);
        $product->fill([
            'id_categoria_produto' => $request->input('categoryId'),
            'nome_produto' => $request->input('productName'),
            'valor_produto' => $request->input('price'),
        ]);
        $product->update();
        $product->refresh();
        return new ProductResource($product);
    }

    /**
     * @OA\Delete(
     *     path="/api/product/{id}",
     *     summary="Delete a product by ID",
     *     tags={"Product"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\Response(response="204", description="Product deleted"),
     *     @OA\Response(response="404", description="Product not found"),
     * )
     */
    public function destroy($id): \Illuminate\Http\JsonResponse
    {
        $product = Product::findOrFail($id);
        $product->delete();
        return response()->json(null, 204);
    }
}
