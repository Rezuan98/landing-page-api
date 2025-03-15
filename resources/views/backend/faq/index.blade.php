@extends('backend.dashboard')

@section('KEYTITLE', 'All FAQs')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h6 class="card-title">Frequently Asked Questions</h6>
                        <a href="{{ route('faq.create') }}" class="btn btn-primary">
                            <i data-feather="plus" class="icon-sm"></i> Add New FAQ
                        </a>
                    </div>

                    @if(session('success'))
                    <div class="alert alert-success" role="alert">
                        {{ session('success') }}
                    </div>
                    @endif

                    @if($faqs->isEmpty())
                    <div class="text-center py-5">
                        <i data-feather="help-circle" style="width: 60px; height: 60px;" class="text-muted mb-3"></i>
                        <h4 class="text-muted">No FAQs Found</h4>
                        <p>Start by adding your first FAQ question.</p>
                        <a href="{{ route('faq.create') }}" class="btn btn-primary mt-3">
                            <i data-feather="plus" class="icon-sm"></i> Add New FAQ
                        </a>
                    </div>
                    @else
                    <div class="table-responsive">
                        <table class="table" id="faqTable">
                            <thead>
                                <tr>
                                    <th style="width: 60px;">#</th>
                                    <th>Question</th>
                                    <th>Status</th>
                                    <th style="width: 150px;">Actions</th>
                                </tr>
                            </thead>
                            <tbody id="sortable-faqs">
                                @foreach($faqs as $key => $faq)
                                <tr data-id="{{ $faq->id }}" class="cursor-move">
                                    <td>
                                        <span class="d-flex align-items-center">
                                            <i data-feather="menu" class="text-muted me-2 drag-handle"></i>
                                            {{ $key + 1 }}
                                        </span>
                                    </td>
                                    <td>{{ $faq->question }}</td>
                                    <td>
                                        @if($faq->status)
                                        <span class="badge bg-success">Active</span>
                                        @else
                                        <span class="badge bg-danger">Inactive</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="d-flex">
                                            <a href="{{ route('faq.edit', $faq->id) }}" class="btn btn-warning btn-sm me-2">
                                                <i data-feather="edit" class="icon-sm"></i>
                                            </a>
                                            <form action="{{ route('faq.delete', $faq->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this FAQ?')">
                                                @csrf
                                                <button type="submit" class="btn btn-danger btn-sm">
                                                    <i data-feather="trash" class="icon-sm"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.14.0/Sortable.min.js"></script>
<script>
    $(document).ready(function() {
        // Initialize sortable
        var sortable = new Sortable(document.getElementById('sortable-faqs'), {
            handle: '.drag-handle'
            , animation: 150
            , onEnd: function(evt) {
                updateOrder();
            }
        });

        function updateOrder() {
            var ids = [];
            $('#sortable-faqs tr').each(function() {
                ids.push($(this).data('id'));
            });

            // Send the updated order to the server
            $.ajax({
                url: "{{ route('faq.update-order') }}"
                , type: "POST"
                , data: {
                    ids: ids
                    , _token: "{{ csrf_token() }}"
                }
                , success: function(response) {
                    if (response.success) {
                        // Update the row numbers
                        $('#sortable-faqs tr').each(function(index) {
                            $(this).find('td:first').find('span').html('<i data-feather="menu" class="text-muted me-2 drag-handle"></i> ' + (index + 1));
                        });

                        // Re-initialize feather icons
                        feather.replace();

                        // Show success message
                        toastr.success('FAQ order updated successfully');
                    }
                }
            });
        }
    });

</script>
@endpush
