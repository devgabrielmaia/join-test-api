<?php

use OpenApi\Annotations as OA;

/**
 * @OA\Get(
 *     path="/api/products",
 *     summary="Get a list of products",
 *     tags={"Products"},
 *     @OA\Response(response="200", description="List of products"),
 * )
 */
/**
 * @OA\Get(
 *     path="/api/products/{id}",
 *     summary="Get a product by ID",
 *     tags={"Products"},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="Product ID",
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(response="200", description="Product details"),
 *     @OA\Response(response="404", description="Product not found"),
 * )
 */
/**
 * @OA\Post(
 *     path="/api/products",
 *     summary="Create a new product",
 *     tags={"Products"},
 *     @OA\RequestBody(
 *         @OA\JsonContent(ref="#/components/schemas/ProductRequest")
 *     ),
 *     @OA\Response(response="201", description="Product created"),
 * )
 */
/**
 * @OA\Put(
 *     path="/api/products/{id}",
 *     summary="Update a product by ID",
 *     tags={"Products"},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="Product ID",
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\RequestBody(
 *         @OA\JsonContent(ref="#/components/schemas/ProductRequest")
 *     ),
 *     @OA\Response(response="200", description="Product updated"),
 *     @OA\Response(response="404", description="Product not found"),
 * )
 */
/**
 * @OA\Delete(
 *     path="/api/products/{id}",
 *     summary="Delete a product by ID",
 *     tags={"Products"},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="Product ID",
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(response="204", description="Product deleted"),
 *     @OA\Response(response="404", description="Product not found"),
 * )
 */
