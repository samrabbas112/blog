@extends('layouts.master')

@section('title')
    @if(is_null($category))
    @lang('translation.Create_Category')
    @else
    @lang('translation.Update_Category')
    @endif
@endsection


@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            Category
        @endslot
        @slot('title')
           {{ is_null($category) ? 'Create Category' : 'Update Category'}}
        @endslot
    @endcomponent

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div id="errorAlert" class="alert alert-danger d-none"></div>
                <div id="successAlert" class="alert alert-success d-none">
                    <span id="successMessage"></span>
                </div>
                <div class="card-body">
                    <h4 class="card-title mb-4">{{ is_null($category) ? 'Create New Category' : 'Update Category'}} </h4>
                    <form class="outer-repeater" id="submitForm">
                        @csrf
                        <div  class="outer">
                            <div data-repeater-item class="outer">
                                <div class="form-group row mb-4">
                                    <label for="tagname" class="col-form-label col-lg-2">Category Name</label>
                                    <div class="col-lg-10">
                                        <input id="name" name="name" type="text" id="name" value="{{ $category->name ?? '' }}" class="form-control"
                                            placeholder="Enter Category Name...">
                                            @error('name')
                                            <span class="red">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="id" id="id" value="{{ $category->id ?? ''}}">
                        <div class="row justify-content-end">
                            <div class="col-lg-10">
                                <button type="submit" class="btn btn-primary submitBtn" id="submitBtn" data-id="{{ $category->id ?? '' }}">{{ is_null($category) ? 'Create Category' : 'Update Category'}}</button>
                            </div>
                        </div>
                    </form>


                </div>
            </div>
        </div>
    </div>
    <!-- end row -->
@endsection
@section('script')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
    $(document).ready(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $('#submitForm').on('submit', function(e) {
            e.preventDefault();
            // let btnId = document.querySelector('[data-id]').getAttribute('data-id');
            const formData = $(this).serializeArray();
            const idField = formData.find(item => item.name === 'id');
            let url;

            if (idField.value !== "") {
                // If 'id' is present, set the update URL
                const id = idField.value;
                url = `{{ route('api.v1.category.update', '') }}/${id}`;
            } else {
                // If 'id' is not present, set the create URL
                url = "{{ route('api.v1.category.store') }}";
            }
            $.ajax({
                url: url,
                type: idField.value !== "" ? "put" : "post",  // Use PUT for updates
                data: $(this).serialize(),
                headers: {
                    'Authorization': 'Bearer {{ session()->get('token') }}'
                },
                success: function(response) {
                    if (response.success) {
                        // Handle successful response
                        $('#successAlert').removeClass('d-none'); // Show the success alert
                        $('#successMessage').text(response.message);
                    } else {
                        // Handle validation errors in a successful response structure
                        console.log('Validation errors detected');
                        let errorMessages = Object.values(response.data)
                            .flat() // Flatten in case each error has multiple messages
                            .join('<br>');

                        $('#errorAlert').removeClass('d-none').html(errorMessages); // Show validation errors
                    }

                },
                error: function(xhr) {
                    console.log(xhr.responseJSON.errors);
                    if (xhr.status === 422) {
                        var errors = xhr.responseJSON.errors;
                        if (errors) {
                            console.log('Error detected');

                            // Map through the errors and join them with line breaks
                            let errorMessages = Object.values(errors)
                                .flat() // Flatten in case each error has multiple messages
                                .join('<br>');

                            // Show the error messages in the alert element
                            $('#errorAlert').removeClass('d-none').html(errorMessages);
                        }
                    }
                }
            });
        });
    });
</script>
@endsection
