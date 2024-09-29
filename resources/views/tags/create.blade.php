@extends('layouts.master')

@section('title')
    @if(is_null($tag))
    @lang('translation.Create_Tag')
    @else
    @lang('translation.Update_Tag')
    @endif
@endsection

@section('css')
    <!-- datepicker css -->
    <link href="{{ URL::asset('build/libs/bootstrap-datepicker/css/bootstrap-datepicker.min.css') }}" rel="stylesheet">
@endsection

@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            Tag
        @endslot
        @slot('title')
           {{ is_null($tag) ? 'Create Tag' : 'Update Tag'}}
        @endslot
    @endcomponent

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="alert alert-success alert-dismissible fade show d-none" id="successAlert" role="alert">
                    <span id="successMessage"></span>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                <div class="card-body">
                    <h4 class="card-title mb-4">{{ is_null($tag) ? 'Create New Tag' : 'Update Tag'}} </h4>
                    <form class="outer-repeater" id="submitForm">
                        @csrf
                        <div  class="outer">
                            <div data-repeater-item class="outer">
                                <div class="form-group row mb-4">
                                    <label for="tagname" class="col-form-label col-lg-2">Tag Name</label>
                                    <div class="col-lg-10">
                                        <input id="name" name="name" type="text" id="name" value="{{ $tag->name ?? '' }}" class="form-control"
                                            placeholder="Enter Tag Name...">
                                            @error('name')
                                            <span class="red">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="id" id="id" value="{{ $tag->id ?? ''}}">
                        <div class="row justify-content-end">
                            <div class="col-lg-10">
                                <button type="submit" class="btn btn-primary submitBtn" id="submitBtn" data-id="{{ $tag->id ?? '' }}">{{ is_null($tag) ? 'Create Tag' : 'Update Tag'}}</button>
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
            // console.log(btnId);
            $.ajax({
                url: "{{ route('tags.store') }}", 
                type: "post",
                data: $(this).serialize(), 
                success: function(response) {

                    // Show success message
                    $('#successAlert').removeClass('d-none'); // Show the alert
                    $('#successMessage').text(response.success);
                },
                error: function(xhr) {
                    if (xhr.status === 422) {
                        var errors = xhr.responseJSON.errors;
                        if (errors.name) {
                            $('#nameError').text(errors.name[0]);
                        }
                    }
                }
            });
        });
    });
</script>
@endsection
