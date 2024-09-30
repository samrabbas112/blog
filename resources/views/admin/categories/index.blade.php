@extends('layouts.master')

@section('title')
    @lang('translation.List_Category')
@endsection
@section('css')
<!-- Sweet Alert-->
<link href="{{ URL::asset('build/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />
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

    <div class="row">
        <div class="col-lg-12">
            <div class="">
                <div class="table-responsive">
                    <table class="table project-list-table table-nowrap align-middle table-borderless">
                        <thead>
                            <tr>
                                <th scope="col">Category</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($categories as $category)
                            <tr id="categoryRow{{$category->id}}">
                                <td>
                                    <p class="text-muted mb-0">{{ $category->name }}</p>
                                </td>
                                <td>
                                    <div class="dropdown">
                                        <a href="#" class="dropdown-toggle card-drop" data-bs-toggle="dropdown"
                                            aria-expanded="false">
                                            <i class="mdi mdi-dots-horizontal font-size-18"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-end">
                                            <a class="dropdown-item" href="{{ route('category.create', ['id' => $category->id]) }}">Edit</a>
                                            <a class="dropdown-item delete-category" href="#" data-id="{{ $category->id }}">Delete</a>
                                            {{-- {{ route('tags.destroy', ['id' => $tag->id]) }} --}}
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        
            
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
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

<!-- Sweet alert init js-->
{{-- <script src="{{ URL::asset('build/js/pages/sweet-alerts.init.js') }}"></script> --}}
<script>
// Use a delegate event handler to attach the click event to dynamically generated elements
$(document).on('click', '.delete-category', function (e) {
    $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    e.preventDefault(); // Prevent the default link behavior

    // Get the ID of the tag from the clicked button
    let categoryId = $(this).data('id');

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
                url: `/category/destroy/${categoryId}`, // Update the URL to your delete route
                type: 'DELETE',
                success: function (response) {
                    // Show success message
                    Swal.fire("Deleted!", "Your file has been deleted.", "success");
                    $(`#categoryRow${categoryId}`).remove(); 
                },
                error: function (xhr) {
                    // Handle error if needed
                    Swal.fire("Error!", "There was a problem deleting the tag.", "error");
                }
            });
        }
    });
});
</script>
@endsection
