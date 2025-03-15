@extends('backend.dashboard')

@section('KEYTITLE', 'Add FAQ')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-9 grid-margin stretch-card">
            <div class="card shadow">
                <div class="card-body p-4">
                    <h3 class="card-title text-center mb-4">Add New FAQ</h3>

                    <form action="{{ route('faq.store') }}" method="POST">
                        @csrf

                        <div class="mb-4">
                            <label for="question" class="form-label">Question</label>
                            <input type="text" name="question" id="question" class="form-control @error('question') is-invalid @enderror" placeholder="Enter the question" value="{{ old('question') }}" required>
                            @error('question')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="answer" class="form-label">Answer</label>
                            <textarea name="answer" id="answer" class="form-control @error('answer') is-invalid @enderror" rows="6" placeholder="Enter the answer" required>{{ old('answer') }}</textarea>
                            @error('answer')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Write a clear and concise answer to the question.</small>
                        </div>

                        <div class="mb-4">
                            <label for="status" class="form-label">Status</label>
                            <select name="status" id="status" class="form-select @error('status') is-invalid @enderror">
                                <option value="1" {{ old('status') == '1' ? 'selected' : '' }}>Active</option>
                                <option value="0" {{ old('status') == '0' ? 'selected' : '' }}>Inactive</option>
                            </select>
                            @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-between mt-4">
                            <a href="{{ route('faq.index') }}" class="btn btn-outline-secondary">
                                <i data-feather="arrow-left" class="icon-sm"></i> Back to FAQs
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i data-feather="save" class="icon-sm"></i> Save FAQ
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
