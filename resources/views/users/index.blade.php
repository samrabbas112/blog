@extends('layouts.master-layouts')

@section('title') @lang('translation.Blog_List') @endsection

@section('content')

@component('components.breadcrumb')
@slot('li_1') Blog @endslot
@slot('title') Blog List @endslot
@endcomponent

<livewire:blog.post  />

@endsection
@section('script')
{{-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> --}}


{{-- <script>
    $(document).ready(function(){
        $(document).on('click', '.post-details', function (e) {
    $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    e.preventDefault(); // Prevent the default link behavior

    // Get the ID of the tag from the clicked button
    let postId = $(this).data('id');

    $.ajax({
                    url: `/post/details/${postId}`, 
                    type: "GET",
                    success: function(response) {
                        // Show success message
                        // $('#successAlert').removeClass('d-none'); // Show the alert
                        // $('#successMessage').text(response.success);
                    },
                    error: function(xhr) {
                        if (xhr.status === 422) {
                            var errors = xhr.responseJSON.errors;
                            if (errors.name) {
                                // $('#nameError').text(errors.name[0]);
                            }
                        }
                    }
                });
});
    });

</script> --}}
@endsection