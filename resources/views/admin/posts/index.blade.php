@extends('layouts.master')

@section('title')
    @lang('translation.posts')
@endsection

@section('css')
    <!--datatable css-->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css">
@endsection

@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            Posts
        @endslot
        @slot('title')
            Posts
        @endslot
    @endcomponent

    <table class="table table-bordered yajra-datatable">
        <thead>
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Slug</th>
                <th>Category</th>
                <th>Author</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
@endsection
@section('script')
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/dataTables.bootstrap4.min.js"></script>
    <script type="text/javascript">
        $(function() {
            // Initialize the DataTable
            var table = $('.yajra-datatable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('posts.index') }}",
                columns: [
                    {
                        data: 'id',
                        name: 'id',
                    },
                    {
                        data: 'title',
                        name: 'title',
                    },
                    {
                        data: 'slug',
                        name: 'slug',
                    },
                    {
                        data: 'category',
                        name: 'category',
                    },
                    {
                        data: 'author',
                        name: 'author',
                    },
                    {
                        data: 'status',
                        name: 'status',
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false,
                    },
                ]
            });
    
            // Setup the CSRF token for all AJAX requests
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
    
            // Event listener for delete action
            $(document).on('click', '.delete-post', function(e) {
                e.preventDefault(); // Prevent the default link behavior
    
                // Get the ID of the post from the clicked button
                let postId = $(this).data('id');
                var row = $(this).closest('tr'); // Find the row of the clicked button
    
                // Confirmation modal using SweetAlert
                Swal.fire({
                    title: "Are you sure?",
                    text: "You won't be able to undo this!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#34c38f",
                    cancelButtonColor: "#f46a6a",
                    confirmButtonText: "Yes, delete it!"
                }).then(function(result) {
                    if (result.isConfirmed) {
                        // Perform the AJAX request to delete the post
                        $.ajax({
                            url: `/posts/destroy/${postId}`, // Update the URL to your delete route
                            type: 'DELETE',
                            success: function(response) {
                                // Show success message and remove the row from DataTable
                                Swal.fire("Deleted!", "The post has been deleted.", "success");
                                table.row(row).remove().draw();
                            },
                            error: function(xhr) {
                                // Handle error if needed
                                Swal.fire("Error!", "There was a problem deleting the post.", "error");
                            }
                        });
                    }
                });
            });
        });
    </script>
    
@endsection
