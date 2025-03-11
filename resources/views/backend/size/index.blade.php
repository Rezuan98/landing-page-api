@extends('backend.dashboard')

@section('KEYTITLE', 'All Sizes')

@section('content')
<div class="d-flex justify-content-center align-items-center flex-grow-1">
    <div class="col-md-8 grid-margin stretch-card d-flex justify-content-center align-items-center">
        <div class="card">
            <div class="card-body">
                <h6 class="card-title text-center">All Sizes</h6>
                <div class="text-center mb-3">
                    <a href="{{ route('size.create') }}" class="btn btn-primary">Add New Size</a>
                </div>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Size</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($sizes as $key => $size)
                            <tr>
                                <th>{{ $key + 1 }}</th>
                                <td>{{ $size->size }}</td>
                                <td>
                                    <form action="{{ route('size.delete', $size->id) }}" method="POST">
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
