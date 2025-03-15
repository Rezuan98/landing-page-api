@extends('backend.dashboard')

@section('KEYTITLE', 'Update Logo')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8 grid-margin stretch-card">
            <div class="card shadow">
                <div class="card-body p-4">
                    <h3 class="card-title text-center mb-4">Site Logo</h3>

                    @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    @endif

                    <form action="{{ route('logo.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <!-- Logo Section -->
                        <div class="form-group mb-4">
                            <label for="logo" class="form-label fw-bold">Website Logo</label>

                            @if(isset($logo) && $logo->logo)
                            <div class="text-center mb-3">
                                <img src="{{ asset('storage/' . $logo->logo) }}" alt="Current Logo" class="img-fluid" style="max-height: 100px;">
                            </div>
                            @endif

                            <input type="file" name="logo" id="logo" class="form-control">
                            <small class="text-muted">Recommended format: PNG with transparent background. Max file size: 2MB.</small>
                        </div>

                        <hr class="my-4">

                        <!-- Favicon Section -->
                        <div class="form-group mb-4">
                            <label for="favicon" class="form-label fw-bold">Website Favicon</label>

                            @if(isset($logo) && $logo->favicon)
                            <div class="text-center mb-3">
                                <img src="{{ asset('storage/' . $logo->favicon) }}" alt="Current Favicon" class="img-fluid" style="max-height: 32px;">
                            </div>
                            @endif

                            <input type="file" name="favicon" id="favicon" class="form-control">
                            <small class="text-muted">Recommended format: ICO or PNG. Size: 16x16 or 32x32 pixels.</small>
                        </div>

                        <hr class="my-4">

                        <!-- Phone Number Section -->
                        <div class="form-group mb-4">
                            <label for="phone_number" class="form-label fw-bold">Phone Number</label>
                            <input type="text" name="phone_number" id="phone_number" class="form-control" value="{{ isset($logo) ? $logo->phone_number : '' }}" placeholder="e.g. +1 (123) 456-7890">
                        </div>

                        <div class="d-flex justify-content-between mt-4">
                            <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary">
                                Back to Dashboard
                            </a>
                            <button type="submit" class="btn btn-primary">
                                Update Settings
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
