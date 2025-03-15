@extends('backend.dashboard')

@section('KEYTITLE', 'Hero Settings')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10 grid-margin stretch-card">
            <div class="card shadow">
                <div class="card-body p-4">
                    <h4 class="card-title text-center mb-4">Hero Section Settings</h4>

                    <form action="{{ route('hero.update') }}" method="POST">
                        @csrf

                        <div class="row mb-4">
                            <div class="col-md-12">
                                <div class="form-group mb-3">
                                    <label for="title" class="form-label">Hero Title</label>
                                    <input type="text" name="title" id="title" class="form-control" value="{{ $hero->title }}" required>
                                    <small class="text-muted">This will be the main heading on your home page</small>
                                </div>

                                <div class="form-group mb-3">
                                    <label for="description" class="form-label">Hero Description</label>
                                    <textarea name="description" id="description" class="form-control" rows="4" required>{{ $hero->description }}</textarea>
                                    <small class="text-muted">This will appear below the title on your home page</small>
                                </div>
                            </div>
                        </div>

                        <div class="card mb-4">
                            <div class="card-header bg-light">
                                <h5 class="mb-0">Preview</h5>
                            </div>
                            <div class="card-body">
                                <div class="preview-container p-4 border rounded bg-white">
                                    <h1 class="preview-title h3 fw-bold mb-3" id="preview-title">{{ $hero->title }}</h1>
                                    <p class="preview-description text-muted" id="preview-description">{{ $hero->description }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between mt-4">
                            <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary">
                                Back to Dashboard
                            </a>
                            <button type="submit" class="btn btn-primary">
                                Save Changes
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add JavaScript for live preview -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const titleInput = document.getElementById('title');
        const descriptionInput = document.getElementById('description');
        const previewTitle = document.getElementById('preview-title');
        const previewDescription = document.getElementById('preview-description');

        // Update preview when inputs change
        titleInput.addEventListener('input', function() {
            previewTitle.textContent = this.value;
        });

        descriptionInput.addEventListener('input', function() {
            previewDescription.textContent = this.value;
        });
    });

</script>
@endsection
