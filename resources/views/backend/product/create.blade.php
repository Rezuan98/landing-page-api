@extends('backend.dashboard')

@section('KEYTITLE', 'Add Product')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10 grid-margin stretch-card">
            <div class="card shadow">
                <div class="card-body p-4">
                    <h3 class="card-title text-center mb-4">Add New Product</h3>

                    <form action="{{ route('product.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="name" class="form-label">Product Name</label>
                                    <input type="text" name="name" id="name" class="form-control" placeholder="Enter product name" required>
                                </div>

                                <div class="form-group mb-3">
                                    <label for="price" class="form-label">Price</label>
                                    <input type="number" name="price" id="price" class="form-control" placeholder="Enter price" step="0.01" required>
                                </div>

                                <div class="form-group mb-3">
                                    <label for="discount_price" class="form-label">Discount Price (Optional)</label>
                                    <input type="number" name="discount_price" id="discount_price" class="form-control" placeholder="Enter discount price" step="0.01">
                                </div>

                                <div class="form-group mb-3">
                                    <label for="brand_id" class="form-label">Brand</label>
                                    <select class="form-select" name="brand_id" id="brand_id" required>
                                        <option value="" selected disabled>Select Brand</option>
                                        @foreach($brands as $brand)
                                        <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="description" class="form-label">Description</label>
                                    <textarea name="description" id="description" class="form-control" rows="4" placeholder="Enter product description" required></textarea>
                                </div>

                                <div class="form-group mb-3">
                                    <label for="featured" class="form-label">Featured Product</label>
                                    <select class="form-select" name="featured" id="featured">
                                        <option value="0">No</option>
                                        <option value="1">Yes</option>
                                    </select>
                                </div>

                                <div class="form-group mb-3">
                                    <label for="status" class="form-label">Status</label>
                                    <select class="form-select" name="status" id="status">
                                        <option value="1">Active</option>
                                        <option value="0">Inactive</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="form-group mb-4">
                            <label for="product_image" class="form-label">Product Images</label>
                            <input type="file" class="form-control" name="product_images[]" id="product_image" multiple accept="image/*">
                            <small class="text-muted">You can select multiple images</small>
                        </div>

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
                            <button type="submit" class="btn btn-primary">
                                Save Product
                            </button>
                        </div>
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
    });

</script>
@endpush
