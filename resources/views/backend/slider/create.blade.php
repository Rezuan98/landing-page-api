@extends('backend.dashboard')

@section('KEYTITLE', 'Add Slider')

@section('content')
<div class="container">
    <div class="row justify-content-center" style="min-height: 70vh; display: flex; align-items: center;">
        <div class="col-md-6 grid-margin stretch-card">
            <div class="card shadow">
                <div class="card-body p-4">
                    <h3 class="card-title text-center mb-4">Add Slider Image</h3>

                    <form action="{{ route('slider.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="form-group mb-4">
                            <label for="image" class="form-label">Slider Image</label>
                            <input type="file" name="image" id="image" class="form-control" accept="image/*" required>
                            <small class="text-muted">Recommended size: 1080x1080 pixels.</small>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="status" class="form-label">Status</label>
                                    <select class="form-select" name="status" id="status">
                                        <option value="1" selected>Active</option>
                                        <option value="0">Inactive</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="order" class="form-label">Display Order</label>
                                    <input type="number" name="order" id="order" class="form-control" value="0" min="0">
                                    <small class="text-muted">Lower numbers will be displayed first.</small>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between mt-4">
                            <a href="{{ route('slider.index') }}" class="btn btn-outline-secondary">
                                Back to Sliders
                            </a>
                            <button type="submit" class="btn btn-primary">
                                Upload Slider
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
