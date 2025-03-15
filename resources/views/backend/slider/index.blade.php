@extends('backend.dashboard')

@section('KEYTITLE', 'All Sliders')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h6 class="card-title">All Slider Images</h6>
                        <a href="{{ route('slider.create') }}" class="btn btn-primary">
                            <i data-feather="plus" class="icon-sm me-1"></i> Add New Slider
                        </a>
                    </div>

                    @if($sliders->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Image</th>
                                    <th>Status</th>
                                    <th>Order</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($sliders as $key => $slider)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>
                                        <img src="{{ asset('storage/' . $slider->image) }}" alt="Slider Image" class="img-thumbnail" style="max-width: 200px; max-height: 100px;">
                                    </td>
                                    <td>
                                        @if($slider->status)
                                        <span class="badge bg-success">Active</span>
                                        @else
                                        <span class="badge bg-danger">Inactive</span>
                                        @endif
                                    </td>
                                    <td>{{ $slider->order }}</td>
                                    <td>
                                        <form action="{{ route('slider.delete', $slider->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this slider?')">
                                            @csrf
                                            <button type="submit" class="btn btn-danger btn-sm">
                                                <i data-feather="trash" class="icon-sm"></i> Delete
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @else
                    <div class="text-center py-5">
                        <i data-feather="image" style="width: 60px; height: 60px;" class="text-muted mb-3"></i>
                        <h5 class="text-muted">No slider images found</h5>
                        <p>Start by adding your first slider image</p>
                        <a href="{{ route('slider.create') }}" class="btn btn-primary mt-2">
                            <i data-feather="plus" class="icon-sm me-1"></i> Add New Slider
                        </a>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
