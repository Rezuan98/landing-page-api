@extends('backend.dashboard')

@section('KEYTITLE', 'Add Size')

@section('content')
<div class="container">
    <div class="row justify-content-center" style="min-height: 80vh; display: flex; align-items: center;">
        <div class="col-md-6 grid-margin stretch-card">
            <div class="card shadow">
                <div class="card-body p-4">
                    <h3 class="card-title text-center mb-4">Add Size</h3>

                    <form action="{{ route('size.store') }}" method="POST">
                        @csrf
                        <div class="form-group mb-4">
                            <label for="size" class="form-label">Size</label>
                            <input type="text" name="size" id="size" class="form-control" placeholder="Enter size" required>
                        </div>

                        <div class="d-flex justify-content-between mt-4">
                            <a href="{{ route('size.index') }}" class="btn btn-outline-secondary">
                                Back to Sizes
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
