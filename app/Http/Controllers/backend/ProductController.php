<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Size;
use App\Models\Brand;
use App\Models\ProductSize;
use App\Models\ProductImage;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use DB;

class ProductController extends Controller
{
    /**
     * Display a listing of the products.
     */
    public function index()
    {
        $products = Product::with(['brand', 'productSizes.size'])->latest()->get();
        return view('backend.product.index', compact('products'));
    }

    /**
     * Show the form for creating a new product.
     */
    public function create()
    {
        $brands = Brand::all();
        $sizes = Size::all();
        return view('backend.product.create', compact('brands', 'sizes'));
    }

    /**
     * Store a newly created product in storage.
     */
    public function store(Request $request)
    {
        // Validate the request
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'discount_price' => 'nullable|numeric|min:0',
            'brand_id' => 'required|exists:brands,id',
            'featured' => 'required|boolean',
            'status' => 'required|boolean',
            'product_images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'sizes' => 'required|array|min:1',
            'sizes.*' => 'required|exists:sizes,id',
            'quantities' => 'required|array|min:1',
            'quantities.*' => 'required|integer|min:0',
        ]);

        
        // Begin transaction
        DB::beginTransaction();

        try {
            // Create the product
            $product = Product::create([
                'name' => $request->name,
                'description' => $request->description,
                'price' => $request->price,
                'discount_price' => $request->discount_price,
                'brand_id' => $request->brand_id,
                'featured' => $request->featured,
                'status' => $request->status,
            ]);

            // Handle sizes and quantities
            foreach ($request->sizes as $key => $sizeId) {
                ProductSize::create([
                    'product_id' => $product->id,
                    'size_id' => $sizeId,
                    'quantity' => $request->quantities[$key]
                ]);
            }

            // Handle product images
            if ($request->hasFile('product_images')) {
                $isPrimary = true; // First image is primary
                
                foreach ($request->file('product_images') as $image) {
                    // Generate a unique name for the image
                    $imageName = 'product_' . $product->id . '_' . Str::random(10) . '.' . $image->getClientOriginalExtension();
                    
                    // Store the image
                    $path = $image->storeAs('products', $imageName, 'public');
                    
                    // Create image record
                    ProductImage::create([
                        'product_id' => $product->id,
                        'image_path' => $path,
                        'is_primary' => $isPrimary
                    ]);
                    
                    $isPrimary = false; // Only the first image is primary
                }
            }

            DB::commit();
            
            return redirect()->route('product.index')->with('success', 'Product added successfully!');
        } catch (\Exception $e) {
            DB::rollback();
            
            return redirect()->back()
                ->with('error', 'An error occurred while creating the product: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Display the specified product.
     */
    public function show($id)
    {
        $product = Product::with(['brand', 'productSizes.size', 'images'])->findOrFail($id);
        return view('backend.product.show', compact('product'));
    }

    /**
     * Show the form for editing the specified product.
     */
    public function edit($id)
    {
        $product = Product::with(['productSizes.size', 'images'])->findOrFail($id);
        $brands = Brand::all();
        $sizes = Size::all();
        
        return view('backend.product.edit', compact('product', 'brands', 'sizes'));
    }

    /**
     * Update the specified product in storage.
     */
    public function update(Request $request, $id)
    {

        
        // Validate the request
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'discount_price' => 'nullable|numeric|min:0',
            'brand_id' => 'required|exists:brands,id',
            'featured' => 'required|boolean',
            'status' => 'required|boolean',
            'product_images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'sizes' => 'required|array|min:1',
            'sizes.*' => 'required|exists:sizes,id',
            'quantities' => 'required|array|min:1',
            'quantities.*' => 'required|integer|min:0',
        ]);

        // Begin transaction
        DB::beginTransaction();

        try {
            $product = Product::findOrFail($id);
            
            // Update product details
            $product->update([
                'name' => $request->name,
                'description' => $request->description,
                'price' => $request->price,
                'discount_price' => $request->discount_price,
                'brand_id' => $request->brand_id,
                'featured' => $request->featured,
                'status' => $request->status,
            ]);

            // Update sizes and quantities
            // First, remove any existing sizes that aren't in the new list
            $product->productSizes()->whereNotIn('size_id', $request->sizes)->delete();
            
            // Then update or create the sizes from the request
            foreach ($request->sizes as $key => $sizeId) {
                ProductSize::updateOrCreate(
                    [
                        'product_id' => $product->id,
                        'size_id' => $sizeId
                    ],
                    [
                        'quantity' => $request->quantities[$key]
                    ]
                );
            }

            // Handle new product images
            if ($request->hasFile('product_images')) {
                $hasExistingImages = $product->images()->exists();
                
                foreach ($request->file('product_images') as $image) {
                    // Generate a unique name for the image
                    $imageName = 'product_' . $product->id . '_' . Str::random(10) . '.' . $image->getClientOriginalExtension();
                    
                    // Store the image
                    $path = $image->storeAs('products', $imageName, 'public');
                    
                    // Create image record
                    ProductImage::create([
                        'product_id' => $product->id,
                        'image_path' => $path,
                        'is_primary' => !$hasExistingImages // Only set as primary if there are no existing images
                    ]);
                    
                    $hasExistingImages = true; // Once we've added at least one image
                }
            }

            DB::commit();
            
            return redirect()->route('product.index')->with('success', 'Product updated successfully!');
        } catch (\Exception $e) {
            DB::rollback();
            
            return redirect()->back()
                ->with('error', 'An error occurred while updating the product: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Remove the specified product from storage.
     */
    public function delete($id)
    {
        try {
            $product = Product::findOrFail($id);
            
            // Delete associated images from storage
            foreach ($product->images as $image) {
                Storage::disk('public')->delete($image->image_path);
            }
            
            // Delete the product (cascades to related records due to foreign key constraints)
            $product->delete();
            
            return redirect()->route('product.index')->with('success', 'Product deleted successfully!');
        } catch (\Exception $e) {
            return redirect()->route('product.index')->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }
    
    /**
     * Remove a specific product image.
     */
    public function deleteImage($id)
    {
        try {
            $image = ProductImage::findOrFail($id);
            $productId = $image->product_id;
            
            // Delete the image file from storage
            Storage::disk('public')->delete($image->image_path);
            
            // Delete the image record
            $image->delete();
            
            // If this was a primary image, set another image as primary if available
            if ($image->is_primary) {
                $newPrimaryImage = ProductImage::where('product_id', $productId)->first();
                if ($newPrimaryImage) {
                    $newPrimaryImage->update(['is_primary' => true]);
                }
            }
            
            return redirect()->back()->with('success', 'Image deleted successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }
    
    /**
     * Set a specific image as primary.
     */
    public function setPrimaryImage($id)
    {
        try {
            $image = ProductImage::findOrFail($id);
            $productId = $image->product_id;
            
            // Reset all images for this product to non-primary
            ProductImage::where('product_id', $productId)
                ->update(['is_primary' => false]);
            
            // Set the selected image as primary
            $image->update(['is_primary' => true]);
            
            return redirect()->back()->with('success', 'Primary image updated successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }
}
