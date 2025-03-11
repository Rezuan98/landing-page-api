@extends('backend.dashboard')

@section('KEYTITLE', 'Add Size')

@section('content')
<div class="container">
    <div class="row justify-content-center" style="min-height: 80vh; display: flex; align-items: center;">
        <div class="col-md-6 grid-margin stretch-card">
            <div class="card shadow">
                <div class="card-body p-4">
                    <h3 class="card-title text-center mb-4">Add Brand</h3>

                    <form action="{{ route('brand.store') }}" method="POST">
                        @csrf
                        <div class="form-group mb-4">
                            <label for="size" class="form-label">Brand</label>
                            <input type="text" name="brand" id="size" class="form-control" placeholder="Enter Brand Name" required>
                        </div>

                        <div class="d-flex justify-content-between mt-4">
                            <a href="{{ route('brand.index') }}" class="btn btn-outline-secondary">
                                Back to Brand
                            </a>
                            <button type="submit" class="btn btn-primary">
                                Submit
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
