@extends('layouts.master')

@section('title')
    @lang('translation.List_Category')
@endsection
@section('css')
<!-- Sweet Alert-->
<link href="{{ URL::asset('build/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" />
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css">
@endsection
@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            Category
        @endslot
        @slot('title')
        Category List
        @endslot
    @endcomponent
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <table class="table table-bordered yajra-datatable">
        <thead>
            <tr>
                <th>ID</th>
                <th>Tag</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
    <!-- end row -->

    {{-- <div class="row">
        <div class="col-12">
            <div class="text-center my-3">
                <a href="javascript:void(0);" class="text-success"><i
                        class="bx bx-loader bx-spin font-size-18 align-middle me-2"></i> Load more </a>
            </div>
        </div> <!-- end col-->
    </div>
    <!-- end row --> --}}
@endsection
@section('script')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Sweet Alerts js -->
<script src="{{ URL::asset('build/libs/sweetalert2/sweetalert2.min.js') }}"></script>

<script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.1/js/dataTables.bootstrap4.min.js"></script>
<script type="text/javascript">
    $(function() {
        // Initialize the DataTable
        var table = $('.yajra-datatable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('category.index') }}",
            columns: [
                {
                    data: 'id',
                    name: 'id',
                },
                {
                    data: 'name',
                    name: 'name',
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false,
                },
            ]
        });

        $(document).on('click', '.delete-category', function (e) {
    $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    e.preventDefault(); // Prevent the default link behavior

    // Get the ID of the tag from the clicked button
    let categoryId = $(this).data('id');
    var row = $(this).closest('tr');
    Swal.fire({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#34c38f",
        cancelButtonColor: "#f46a6a",
        confirmButtonText: "Yes, delete it!"
    }).then(function (result) {
        if (result.isConfirmed) {
            // Perform the AJAX request to delete the tag
            $.ajax({
                url: `/categories/destroy/${categoryId}`, // Update the URL to your delete route
                type: 'DELETE',
                success: function (response) {
                    // Show success message
                    Swal.fire("Deleted!", "Your file has been deleted.", "success");
                    table.row(row).remove().draw();
                },
                error: function (xhr) {
                    // Handle error if needed
                    Swal.fire("Error!", "There was a problem deleting the tag.", "error");
                }
            });
        }
    });
  });
        
    });
</script>

@endsection
