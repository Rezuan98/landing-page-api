@extends('backend.dashboard')

@section('KEYTITLE', 'All Products')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">All Products</h6>
                    <div class="d-flex justify-content-end mb-3">
                        <a href="{{ route('product.create') }}" class="btn btn-primary">Add New Product</a>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Brand</th>
                                    <th>Price</th>
                                    <th>Stock</th>
                                    <th>Status</th>
                                    <th>Featured</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($products as $key => $product)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $product->name }}</td>
                                    <td>{{ $product->brand->name }}</td>
                                    <td>
                                        @if($product->discount_price)
                                        <del class="text-muted">${{ $product->price }}</del>
                                        <span class="text-success">${{ $product->discount_price }}</span>
                                        @else
                                        ${{ $product->price }}
                                        @endif
                                    </td>
                                    <td>
                                        {{ $product->getTotalStock() }} units
                                        <small class="d-block text-muted">
                                            ({{ $product->productSizes->count() }} sizes)
                                        </small>
                                    </td>
                                    <td>
                                        @if($product->status)
                                        <span class="badge bg-success">Active</span>
                                        @else
                                        <span class="badge bg-danger">Inactive</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($product->featured)
                                        <span class="badge bg-primary">Featured</span>
                                        @else
                                        <span class="badge bg-secondary">No</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="d-flex">
                                            <a href="{{ route('product.show', $product->id) }}" class="btn btn-info btn-sm me-1">
                                                <i data-feather="eye" class="icon-sm"></i>
                                            </a>
                                            <a href="{{ route('product.edit', $product->id) }}" class="btn btn-warning btn-sm me-1">
                                                <i data-feather="edit" class="icon-sm"></i>
                                            </a>
                                            <form action="{{ route('product.delete', $product->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this product?')">
                                                @csrf
                                                <button type="submit" class="btn btn-danger btn-sm">
                                                    <i data-feather="trash" class="icon-sm"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    @if($products->isEmpty())
                    <div class="text-center py-4">
                        <h4 class="text-muted">No products found</h4>
                        <p>Start by adding your first product</p>
                        <a href="{{ route('product.create') }}" class="btn btn-primary mt-2">
                            <i data-feather="plus" class="icon-sm me-1"></i> Add New Product
                        </a>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
