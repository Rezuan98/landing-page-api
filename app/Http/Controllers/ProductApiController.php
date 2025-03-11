<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductSize;
use App\Models\Size;

class ProductApiController extends Controller
{
    /**
     * Get all products for the frontend collections
     */
    public function index()
    {
        try {
            // Get active products with their brand, sizes, and primary image
            $products = Product::with(['brand', 'productSizes.size', 'images' => function($query) {
                $query->where('is_primary', true);
            }])
            ->where('status', 1)
            ->latest()
            ->get();
            
            // Format the data for the frontend
            $formattedProducts = $products->map(function($product) {
                // Get primary image or the first image if no primary is set
                $primaryImage = $product->images->first();
                $imageUrl = $primaryImage ? asset('storage/' . $primaryImage->image_path) : null;
                
                // Get all sizes with quantity for this product
                $sizes = $product->productSizes->map(function($productSize) {
                    return [
                        'id' => $productSize->id,
                        'name' => $productSize->size->size,
                        'quantity' => $productSize->quantity
                    ];
                });
                
                // Calculate if product is on sale
                $isOnSale = $product->discount_price && $product->discount_price > 0 && $product->discount_price < $product->price;
                
                return [
                    'id' => $product->id,
                    'title' => $product->name,
                    'brand' => $product->brand->name,
                    'description' => $product->description,
                    'price' => $isOnSale ? $product->discount_price : $product->price,
                    'discount' => $isOnSale ? $product->price : null,
                    'featured' => (bool) $product->featured,
                    'image' => $imageUrl,
                    'hoverImage' => $imageUrl, // You might want to implement a secondary image for hover
                    'sizes' => $sizes
                ];
            });
            
            return response()->json([
                'status' => 'success',
                'data' => $formattedProducts
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to fetch products: ' . $e->getMessage()
            ], 500);
        }
    }
    /**
     * Get featured products
     */
    public function getFeaturedProducts()
    {
        try {
            $products = Product::with(['brand', 'productSizes.size', 'images' => function($query) {
                $query->where('is_primary', true);
            }])
            ->where('status', 1)
            ->where('featured', 1)
            ->latest()
            ->take(8)
            ->get();
            
            // Use the same formatting as the index method
            $formattedProducts = $products->map(function($product) {
                $primaryImage = $product->images->first();
                $imageUrl = $primaryImage ? asset('storage/' . $primaryImage->image_path) : null;
                
                $sizes = $product->productSizes->map(function($productSize) {
                    return [
                        'id' => $productSize->id,
                        'name' => $productSize->size->size,
                        'quantity' => $productSize->quantity
                    ];
                });
                
                $isOnSale = $product->discount_price && $product->discount_price > 0 && $product->discount_price < $product->price;
                
                return [
                    'id' => $product->id,
                    'title' => $product->name,
                    'brand' => $product->brand->name,
                    'description' => $product->description,
                    'price' => $isOnSale ? $product->discount_price : $product->price,
                    'discount' => $isOnSale ? $product->price : null,
                    'featured' => (bool) $product->featured,
                    'image' => $imageUrl,
                    'hoverImage' => $imageUrl,
                    'sizes' => $sizes
                ];
            });
            
            return response()->json([
                'status' => 'success',
                'data' => $formattedProducts
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to fetch featured products: ' . $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Search products
     */
    public function searchProducts(Request $request)
    {
        try {
            $query = $request->input('query', '');
            
            $products = Product::with(['brand', 'productSizes.size', 'images' => function($query) {
                $query->where('is_primary', true);
            }])
            ->where('status', 1)
            ->where(function($q) use ($query) {
                $q->where('name', 'like', "%{$query}%")
                  ->orWhere('description', 'like', "%{$query}%")
                  ->orWhereHas('brand', function($brandQuery) use ($query) {
                      $brandQuery->where('name', 'like', "%{$query}%");
                  });
            })
            ->latest()
            ->get();
            
            // Use the same formatting as before
            $formattedProducts = $products->map(function($product) {
                // Same mapping logic as index method
                $primaryImage = $product->images->first();
                $imageUrl = $primaryImage ? asset('storage/' . $primaryImage->image_path) : null;
                
                $sizes = $product->productSizes->map(function($productSize) {
                    return [
                        'id' => $productSize->id,
                        'name' => $productSize->size->size,
                        'quantity' => $productSize->quantity
                    ];
                });
                
                $isOnSale = $product->discount_price && $product->discount_price > 0 && $product->discount_price < $product->price;
                
                return [
                    'id' => $product->id,
                    'title' => $product->name,
                    'brand' => $product->brand->name,
                    'description' => $product->description,
                    'price' => $isOnSale ? $product->discount_price : $product->price,
                    'discount' => $isOnSale ? $product->price : null,
                    'featured' => (bool) $product->featured,
                    'image' => $imageUrl,
                    'hoverImage' => $imageUrl,
                    'sizes' => $sizes
                ];
            });
            
            return response()->json([
                'status' => 'success',
                'data' => $formattedProducts
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to search products: ' . $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Check if a product size is available
     */
    public function checkProductSize(Request $request)
    {
        try {
            $request->validate([
                'product_size_id' => 'required|exists:product_sizes,id'
            ]);
            
            $productSize = ProductSize::findOrFail($request->product_size_id);
            
            return response()->json([
                'status' => 'success',
                'data' => [
                    'product_size_id' => $productSize->id,
                    'quantity' => $productSize->quantity,
                    'available' => $productSize->quantity > 0
                ]
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to check product size availability: ' . $e->getMessage()
            ], 400);
        }
    }
}
