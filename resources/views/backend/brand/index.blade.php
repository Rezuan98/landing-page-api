@extends('backend.dashboard')

@section('KEYTITLE', 'All Sizes')

@section('content')
<div class="d-flex justify-content-center align-items-center flex-grow-1">
    <div class="col-md-8 grid-margin stretch-card d-flex justify-content-center align-items-center">
        <div class="card">
            <div class="card-body">
                <h6 class="card-title text-center">All Brand</h6>
                <div class="text-center mb-3">
                    <a href="{{ route('brand.create') }}" class="btn btn-primary">Add New Brand</a>
                </div>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Brand Name</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($brands as $key => $brand)
                            <tr>
                                <th>{{ $key + 1 }}</th>
                                <td>{{ $brand->name }}</td>
                                <td>
                                    <form action="{{ route('brand.delete', $brand->id) }}" method="POST">
                                        @csrf

                                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
