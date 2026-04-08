@extends('backend.dashboard')

@section('KEYTITLE', 'Hero Settings')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10 grid-margin stretch-card">
            <div class="card shadow">
                <div class="card-body p-4">
                    <h4 class="card-title text-center mb-4">Hero Section Settings</h4>

                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    <form action="{{ route('hero.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        {{-- Title & Description --}}
                        <div class="row mb-4">
                            <div class="col-md-12">
                                <div class="form-group mb-3">
                                    <label for="title" class="form-label">Hero Title</label>
                                    <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title', $hero->title) }}" required>
                                    @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>

                                <div class="form-group mb-3">
                                    <label for="description" class="form-label">Hero Description</label>
                                    <textarea name="description" id="description" class="form-control @error('description') is-invalid @enderror" rows="4" required>{{ old('description', $hero->description) }}</textarea>
                                    @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>
                        </div>

                        {{-- Hero Type Toggle --}}
                        <div class="card mb-4">
                            <div class="card-header bg-light">
                                <h5 class="mb-0">Background Type</h5>
                            </div>
                            <div class="card-body">
                                <div class="d-flex gap-4">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="hero_type" id="type_slider" value="slider"
                                            {{ old('hero_type', $hero->hero_type ?? 'slider') === 'slider' ? 'checked' : '' }}>
                                        <label class="form-check-label fw-semibold" for="type_slider">Image Slider</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="hero_type" id="type_video" value="video"
                                            {{ old('hero_type', $hero->hero_type ?? 'slider') === 'video' ? 'checked' : '' }}>
                                        <label class="form-check-label fw-semibold" for="type_video">Background Video</label>
                                    </div>
                                </div>

                                {{-- Slider info panel --}}
                                <div id="slider_panel" class="mt-3">
                                    <div class="alert alert-info mb-0">
                                        Image slider is active. Manage your slides from the
                                        <a href="{{ route('slider.index') }}">Slider Management</a> page.
                                    </div>
                                </div>

                                {{-- Video upload panel --}}
                                <div id="video_panel" class="mt-3" style="display:none;">
                                    <div class="form-group">
                                        <label for="video" class="form-label">Upload Video <small class="text-muted">(mp4, webm, ogg — max 50 MB)</small></label>
                                        <input type="file" name="video" id="video" class="form-control @error('video') is-invalid @enderror" accept="video/mp4,video/webm,video/ogg">
                                        @error('video')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>

                                    @if($hero->video)
                                    <div class="mt-3">
                                        <label class="form-label">Current Video</label>
                                        <video src="{{ asset('storage/' . $hero->video) }}" controls class="d-block" style="max-width:100%;max-height:240px;border-radius:6px;"></video>
                                        <small class="text-muted">Uploading a new video will replace this one.</small>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between mt-4">
                            <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary">Back to Dashboard</a>
                            <button type="submit" class="btn btn-primary">Save Changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const radios = document.querySelectorAll('input[name="hero_type"]');
        const sliderPanel = document.getElementById('slider_panel');
        const videoPanel = document.getElementById('video_panel');

        function togglePanels() {
            const selected = document.querySelector('input[name="hero_type"]:checked').value;
            sliderPanel.style.display = selected === 'slider' ? '' : 'none';
            videoPanel.style.display  = selected === 'video'  ? '' : 'none';
        }

        radios.forEach(r => r.addEventListener('change', togglePanels));
        togglePanels();
    });
</script>
@endsection
