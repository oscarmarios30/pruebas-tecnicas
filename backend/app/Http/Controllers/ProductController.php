<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        return response()->json(Product::all(), 200);
    }

    public function store(Request $request)
{
    try {
        $request->validate([
            'name' => 'required|unique:products',
            'price' => 'required|numeric|min:0.01',
        ]);

        $product = Product::create($request->all());

        return response()->json([
            'headerStatus' => [
                'code' => 201,
                'description' => 'Success'
            ],
            'serverTime' => now()->toDateTimeString(),
            'message' => 'Product created successfully',
            'data' => $product,
            'success' => true
        ], 201);

    } catch (\Illuminate\Validation\ValidationException $e) {
        $errors = $e->validator->errors();

        return response()->json([
            'headerStatus' => [
                'code' => 422,
                'description' => 'Validation Error'
            ],
            'serverTime' => now()->toDateTimeString(),
            'message' => 'Validation failed',
            'errors' => $errors->messages(), 
            'data' => null,
            'success' => false
        ], 422);

    } catch (\Exception $e) {
        return response()->json([
            'headerStatus' => [
                'code' => 500,
                'description' => 'Internal Server Error'
            ],
            'serverTime' => now()->toDateTimeString(),
            'message' => 'An unexpected error occurred.',
            'data' => null,
            'success' => false
        ], 500);
    }
}


public function show($id)
{
    try {
        $product = Product::find($id);

        if (!$product) {
            return response()->json([
                'headerStatus' => [
                    'code' => 404,
                    'description' => 'Not Found'
                ],
                'serverTime' => now()->toDateTimeString(),
                'message' => 'Product not found',
                'data' => null,
                'success' => false
            ], 404);
        }

        return response()->json([
            'headerStatus' => [
                'code' => 200,
                'description' => 'Success'
            ],
            'serverTime' => now()->toDateTimeString(),
            'message' => 'Product retrieved successfully',
            'data' => $product,
            'success' => true
        ], 200);

    } catch (\Exception $e) {
        return response()->json([
            'headerStatus' => [
                'code' => 500,
                'description' => 'Internal Server Error'
            ],
            'serverTime' => now()->toDateTimeString(),
            'message' => 'An unexpected error occurred.',
            'data' => null,
            'success' => false
        ], 500);
    }
}


public function update(Request $request, $id)
{
    try {
        $product = Product::find($id);

        if (!$product) {
            return response()->json([
                'headerStatus' => [
                    'code' => 404,
                    'description' => 'Not Found'
                ],
                'serverTime' => now()->toDateTimeString(),
                'message' => 'Product not found',
                'data' => null,
                'success' => false
            ], 404);
        }

        $validatedData = $request->validate([
            'name' => 'required|unique:products,name,' . $id,
            'price' => 'required|numeric|min:0.01',
        ]);

        $product->update($validatedData);

        return response()->json([
            'headerStatus' => [
                'code' => 200,
                'description' => 'Success'
            ],
            'serverTime' => now()->toDateTimeString(),
            'message' => 'Product updated successfully',
            'data' => $product,
            'success' => true
        ], 200);

    } catch (\Illuminate\Validation\ValidationException $e) {
        return response()->json([
            'headerStatus' => [
                'code' => 422,
                'description' => 'Unprocessable Entity'
            ],
            'serverTime' => now()->toDateTimeString(),
            'message' => 'Validation errors',
            'data' => $e->errors(),
            'success' => false
        ], 422);
    } catch (\Exception $e) {
        return response()->json([
            'headerStatus' => [
                'code' => 500,
                'description' => 'Internal Server Error'
            ],
            'serverTime' => now()->toDateTimeString(),
            'message' => 'An unexpected error occurred.',
            'data' => null,
            'success' => false
        ], 500);
    }
}


public function destroy($id)
{
    try {
        $product = Product::find($id);

        if (!$product) {
            return response()->json([
                'headerStatus' => [
                    'code' => 404,
                    'description' => 'Not Found'
                ],
                'serverTime' => now()->toDateTimeString(),
                'message' => 'Product not found',
                'data' => null,
                'success' => false
            ], 404);
        }

        $product->delete();

        return response()->json([
            'headerStatus' => [
                'code' => 200,
                'description' => 'Success'
            ],
            'serverTime' => now()->toDateTimeString(),
            'message' => 'Product deleted successfully',
            'data' => null,
            'success' => true
        ], 200);

    } catch (\Exception $e) {
        return response()->json([
            'headerStatus' => [
                'code' => 500,
                'description' => 'Internal Server Error'
            ],
            'serverTime' => now()->toDateTimeString(),
            'message' => 'An unexpected error occurred.',
            'data' => null,
            'success' => false
        ], 500);
    }
}

}
