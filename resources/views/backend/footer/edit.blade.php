@extends('backend.dashboard')

@section('KEYTITLE', 'Footer Social Links')

@section('content')
<div class="container">
    <div class="row justify-content-center" style="min-height: 70vh; display: flex; align-items: center;">
        <div class="col-md-8 grid-margin stretch-card">
            <div class="card shadow">
                <div class="card-body p-4">
                    <h3 class="card-title text-center mb-4">Footer Social Media Links</h3>

                    <form action="{{ route('footer.update') }}" method="POST">
                        @csrf

                        <div class="form-group mb-4">
                            <label for="facebook_url" class="form-label">
                                <i data-feather="facebook" class="icon-sm me-2"></i> Facebook URL
                            </label>
                            <input type="url" name="facebook_url" id="facebook_url" class="form-control" placeholder="https://facebook.com/yourbrand" value="{{ $footerSocial->facebook_url }}">
                            @error('facebook_url')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group mb-4">
                            <label for="instagram_url" class="form-label">
                                <i data-feather="instagram" class="icon-sm me-2"></i> Instagram URL
                            </label>
                            <input type="url" name="instagram_url" id="instagram_url" class="form-control" placeholder="https://instagram.com/yourbrand" value="{{ $footerSocial->instagram_url }}">
                            @error('instagram_url')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group mb-4">
                            <label for="twitter_url" class="form-label">
                                <i data-feather="twitter" class="icon-sm me-2"></i> Twitter URL
                            </label>
                            <input type="url" name="twitter_url" id="twitter_url" class="form-control" placeholder="https://twitter.com/yourbrand" value="{{ $footerSocial->twitter_url }}">
                            @error('twitter_url')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group mb-3 alert alert-info">
                            <div class="d-flex align-items-center">
                                <i data-feather="info" class="icon-sm me-2"></i>
                                <small>These links will be displayed in the footer section of your website.</small>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end mt-4">
                            <button type="submit" class="btn btn-primary">
                                <i data-feather="save" class="icon-sm me-1"></i> Save Changes
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
