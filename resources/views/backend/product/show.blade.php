@extends('backend.dashboard')

@section('KEYTITLE', 'Product Details')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h4 class="mb-0">Product Details</h4>
                <div>
                    <a href="{{ route('product.edit', $product->id) }}" class="btn btn-warning me-2">
                        <i data-feather="edit" class="icon-sm me-1"></i> Edit
                    </a>
                    <a href="{{ route('product.index') }}" class="btn btn-outline-secondary">
                        <i data-feather="arrow-left" class="icon-sm me-1"></i> Back to Products
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Product Images -->
        <div class="col-lg-5 mb-4">
            <div class="card">
                <div class="card-body">
                    <!-- Primary Image (large) -->
                    @if($product->images->where('is_primary', true)->first())
                    <img src="{{ asset('storage/' . $product->images->where('is_primary', true)->first()->image_path) }}" class="img-fluid mb-3 w-100" style="height: 350px; object-fit: contain;" alt="{{ $product->name }}">
                    @else
                    <div class="text-center py-5 bg-light mb-3">
                        <i data-feather="image" style="width: 60px; height: 60px;" class="text-muted"></i>
                        <p class="mt-2">No primary image available</p>
                    </div>
                    @endif

                    <!-- Thumbnail Gallery -->
                    @if($product->images->count() > 0)
                    <div class="row">
                        @foreach($product->images as $image)
                        <div class="col-3 mb-3">
                            <div class="position-relative">
                                <img src="{{ asset('storage/' . $image->image_path) }}" class="img-thumbnail {{ $image->is_primary ? 'border-primary' : '' }}" style="height: 80px; object-fit: cover; width: 100%;" alt="Product Image">
                                @if($image->is_primary)
                                <span class="badge bg-primary position-absolute bottom-0 end-0">Primary</span>
                                @endif
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Product Details -->
        <div class="col-lg-7">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Basic Information</h5>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-4 fw-bold">Product Name:</div>
                        <div class="col-md-8">{{ $product->name }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4 fw-bold">Brand:</div>
                        <div class="col-md-8">{{ $product->brand->name }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4 fw-bold">Price:</div>
                        <div class="col-md-8">
                            @if($product->discount_price)
                            <span class="text-decoration-line-through text-muted">${{ $product->price }}</span>
                            <span class="ms-2 text-success">${{ $product->discount_price }}</span>
                            <span class="ms-2 badge bg-danger">
                                {{ round((($product->price - $product->discount_price) / $product->price) * 100) }}% OFF
                            </span>
                            @else
                            ${{ $product->price }}
                            @endif
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4 fw-bold">Status:</div>
                        <div class="col-md-8">
                            @if($product->status)
                            <span class="badge bg-success">Active</span>
                            @else
                            <span class="badge bg-danger">Inactive</span>
                            @endif
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4 fw-bold">Featured:</div>
                        <div class="col-md-8">
                            @if($product->featured)
                            <span class="badge bg-primary">Yes</span>
                            @else
                            <span class="badge bg-secondary">No</span>
                            @endif
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4 fw-bold">Created At:</div>
                        <div class="col-md-8">{{ $product->created_at->format('F d, Y h:i A') }}</div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 fw-bold">Last Updated:</div>
                        <div class="col-md-8">{{ $product->updated_at->format('F d, Y h:i A') }}</div>
                    </div>
                </div>
            </div>

            <!-- Product Description -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Description</h5>
                </div>
                <div class="card-body">
                    <p>{{ $product->description }}</p>
                </div>
            </div>

            <!-- Size and Inventory -->
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Size & Inventory</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead class="table-light">
                                <tr>
                                    <th>Size</th>
                                    <th>Quantity</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($product->productSizes as $productSize)
                                <tr>
                                    <td>{{ $productSize->size->size }}</td>
                                    <td>{{ $productSize->quantity }}</td>
                                    <td>
                                        @if($productSize->quantity > 10)
                                        <span class="badge bg-success">In Stock</span>
                                        @elseif($productSize->quantity > 0)
                                        <span class="badge bg-warning text-dark">Low Stock</span>
                                        @else
                                        <span class="badge bg-danger">Out of Stock</span>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr class="fw-bold">
                                    <td>Total</td>
                                    <td colspan="2">{{ $product->getTotalStock() }} units</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
