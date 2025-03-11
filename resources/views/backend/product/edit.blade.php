@extends('backend.dashboard')

@section('KEYTITLE', 'Edit Product')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10 grid-margin stretch-card">
            <div class="card shadow">
                <div class="card-body p-4">
                    <h3 class="card-title text-center mb-4">Edit Product</h3>

                    <form action="{{ route('product.update', $product->id) }}" method="POST" enctype="multipart/form-data" id="productUpdateForm">
                        @csrf
                        <!-- Add method field for proper routing -->
                        <input type="hidden" name="_method" value="POST">

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="name" class="form-label">Product Name</label>
                                    <input type="text" name="name" id="name" class="form-control" value="{{ $product->name }}" required>
                                </div>

                                <div class="form-group mb-3">
                                    <label for="price" class="form-label">Price</label>
                                    <input type="number" name="price" id="price" class="form-control" value="{{ $product->price }}" step="0.01" required>
                                </div>

                                <div class="form-group mb-3">
                                    <label for="discount_price" class="form-label">Discount Price (Optional)</label>
                                    <input type="number" name="discount_price" id="discount_price" class="form-control" value="{{ $product->discount_price }}" step="0.01">
                                </div>

                                <div class="form-group mb-3">
                                    <label for="brand_id" class="form-label">Brand</label>
                                    <select class="form-select" name="brand_id" id="brand_id" required>
                                        <option value="" disabled>Select Brand</option>
                                        @foreach($brands as $brand)
                                        <option value="{{ $brand->id }}" {{ $product->brand_id == $brand->id ? 'selected' : '' }}>
                                            {{ $brand->name }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="description" class="form-label">Description</label>
                                    <textarea name="description" id="description" class="form-control" rows="4" required>{{ $product->description }}</textarea>
                                </div>

                                <div class="form-group mb-3">
                                    <label for="featured" class="form-label">Featured Product</label>
                                    <select class="form-select" name="featured" id="featured">
                                        <option value="0" {{ $product->featured == 0 ? 'selected' : '' }}>No</option>
                                        <option value="1" {{ $product->featured == 1 ? 'selected' : '' }}>Yes</option>
                                    </select>
                                </div>

                                <div class="form-group mb-3">
                                    <label for="status" class="form-label">Status</label>
                                    <select class="form-select" name="status" id="status">
                                        <option value="1" {{ $product->status == 1 ? 'selected' : '' }}>Active</option>
                                        <option value="0" {{ $product->status == 0 ? 'selected' : '' }}>Inactive</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Current Images Section -->
                        @if($product->images->count() > 0)
                        <div class="card mb-4">
                            <div class="card-header bg-info text-white">
                                <h5 class="mb-0">Current Images</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    @foreach($product->images as $image)
                                    <div class="col-md-3 col-sm-6 mb-3">
                                        <div class="card h-100">
                                            <img src="{{ asset('storage/' . $image->image_path) }}" class="card-img-top" alt="Product Image" style="height: 150px; object-fit: cover;">
                                            <div class="card-body">
                                                <div class="d-flex justify-content-between">
                                                    @if($image->is_primary)
                                                    <span class="badge bg-success">Primary</span>
                                                    @else
                                                    <button type="button" class="btn btn-outline-primary btn-sm set-primary-btn" data-image-id="{{ $image->id }}">
                                                        Set as Primary
                                                    </button>
                                                    @endif

                                                    <button type="button" class="btn btn-danger btn-sm delete-image-btn" data-image-id="{{ $image->id }}">
                                                        <i data-feather="trash-2" class="icon-sm"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        @endif

                        <!-- New Images Section -->
                        <div class="form-group mb-4">
                            <label for="product_image" class="form-label">Add New Images</label>
                            <input type="file" class="form-control" name="product_images[]" id="product_image" multiple accept="image/*">
                            <small class="text-muted">You can select multiple images</small>
                        </div>

                        <!-- Size and Quantity Section -->
                        <div class="card mb-4">
                            <div class="card-header bg-primary text-white">
                                <h5 class="mb-0">Size and Quantity Management</h5>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="size-quantity-table">
                                        <thead>
                                            <tr>
                                                <th>Size</th>
                                                <th>Quantity</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($product->productSizes as $productSize)
                                            <tr>
                                                <td>
                                                    <select name="sizes[]" class="form-select">
                                                        @foreach($sizes as $size)
                                                        <option value="{{ $size->id }}" {{ $productSize->size_id == $size->id ? 'selected' : '' }}>
                                                            {{ $size->size }}
                                                        </option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td>
                                                    <input type="number" name="quantities[]" class="form-control" value="{{ $productSize->quantity }}" min="0" required>
                                                </td>
                                                <td>
                                                    <button type="button" class="btn btn-danger btn-sm remove-size-row">Remove</button>
                                                </td>
                                            </tr>
                                            @endforeach

                                            <!-- Only show empty row if no existing sizes -->
                                            @if($product->productSizes->count() == 0)
                                            <tr>
                                                <td>
                                                    <select name="sizes[]" class="form-select">
                                                        <option value="" selected disabled>Select Size</option>
                                                        @foreach($sizes as $size)
                                                        <option value="{{ $size->id }}">{{ $size->size }}</option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td>
                                                    <input type="number" name="quantities[]" class="form-control" placeholder="Enter quantity" min="0" required>
                                                </td>
                                                <td>
                                                    <button type="button" class="btn btn-danger btn-sm remove-size-row">Remove</button>
                                                </td>
                                            </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                                <button type="button" class="btn btn-secondary" id="add-size-row">Add Another Size</button>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between mt-4">
                            <a href="{{ route('product.index') }}" class="btn btn-outline-secondary">
                                Back to Products
                            </a>
                            <button type="submit" class="btn btn-primary" id="updateProductBtn">
                                Update Product
                            </button>
                        </div>
                    </form>

                    <!-- Hidden forms for image operations -->
                    <form id="setPrimaryForm" action="" method="POST" style="display: none;">
                        @csrf
                    </form>

                    <form id="deleteImageForm" action="" method="POST" style="display: none;">
                        @csrf
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        // Add new size row
        $("#add-size-row").click(function() {
            var newRow = `
                <tr>
                    <td>
                        <select name="sizes[]" class="form-select">
                            <option value="" selected disabled>Select Size</option>
                            @foreach($sizes as $size)
                                <option value="{{ $size->id }}">{{ $size->size }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                        <input type="number" name="quantities[]" class="form-control" placeholder="Enter quantity" min="0" required>
                    </td>
                    <td>
                        <button type="button" class="btn btn-danger btn-sm remove-size-row">Remove</button>
                    </td>
                </tr>
            `;

            $("#size-quantity-table tbody").append(newRow);
        });

        // Remove size row
        $(document).on("click", ".remove-size-row", function() {
            // Don't remove if it's the only row
            if ($("#size-quantity-table tbody tr").length > 1) {
                $(this).closest("tr").remove();
            } else {
                alert("At least one size is required");
            }
        });

        // Set primary image
        $(".set-primary-btn").click(function() {
            var imageId = $(this).data('image-id');
            var form = $("#setPrimaryForm");
            form.attr('action', '{{ url("product/image/primary") }}/' + imageId);
            form.submit();
        });

        // Delete image
        $(".delete-image-btn").click(function() {
            if (confirm('Are you sure you want to delete this image?')) {
                var imageId = $(this).data('image-id');
                var form = $("#deleteImageForm");
                form.attr('action', '{{ url("product/image/delete") }}/' + imageId);
                form.submit();
            }
        });

        // Add click handler for update button to ensure form submission
        $("#updateProductBtn").click(function(e) {
            e.preventDefault();
            $("#productUpdateForm").submit();
        });
    });

</script>
@endpush
