@extends('layouts.master')

@section('title')
    @if(is_null($post))
    @lang('translation.Create_Post')
    @else
    @lang('translation.Update_Post')
    @endif
@endsection
@section('css')
    <!-- Plugins css -->
    <link href="{{ URL::asset('build/libs/dropzone/dropzone.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('build/libs/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />

@endsection

@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            Posts
        @endslot
        @slot('title')
           {{ is_null($post) ? 'Create Post' : 'Update Post'}}
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
                    <h4 class="card-title mb-4">{{ is_null($post) ? 'Create New Post' : 'Update Post' }}</h4>
                    <form id="submitForm" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group row mb-4">
                            <label for="title" class="col-form-label col-lg-2">Title</label>
                            <div class="col-lg-10">
                                <input id="title" name="title" type="text" value="{{ $post->title ?? '' }}" class="form-control" placeholder="Enter Post Title...">
                                @error('title')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
    
                        <div class="form-group row mb-4">
                            <label for="slug" class="col-form-label col-lg-2">Slug</label>
                            <div class="col-lg-10">
                                <input id="slug" name="slug" type="text" value="{{ $post->slug ?? '' }}" class="form-control" placeholder="Enter Post Slug...">
                                @error('slug')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
    
                        <div class="form-group row mb-4">
                            <label for="body" class="col-form-label col-lg-2">Body</label>
                            <div class="col-lg-10">
                                <textarea name="content" id="editor"></textarea>
                      
                                @error('body')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
    
                        <div class="form-group row mb-4">
                            <label for="excerpt" class="col-form-label col-lg-2">Excerpt</label>
                            <div class="col-lg-10">
                                <textarea id="excerpt" name="excerpt" class="form-control" rows="3" placeholder="Enter Excerpt...">{{ $post->excerpt ?? '' }}</textarea>
                                @error('excerpt')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
    
                        <section>
                            <div class="form-group row mb-4">
                                <label for="body" class="col-form-label col-lg-2">Body</label>
                                <div class="col-lg-10">

                                <div class="dropzone">
                                    <div class="fallback">
                                        <input id="file" name="file" type="file" multiple="multiple">
                                    </div>
                                    <div class="dz-message needsclick">
                                        <div class="mb-3">
                                            <i class="display-4 text-muted bx bxs-cloud-upload"></i>
                                        </div>

                                        <h4>Drop files here or click to upload.</h4>
                                    </div>
                                </div>

                                <ul class="list-unstyled mb-0" id="dropzone-preview">
                                    <li class="mt-2" id="dropzone-preview-list">
                                        <!-- This is used as the file preview template -->
                                        <div class="border rounded">
                                            <div class="d-flex p-2">
                                                <div class="flex-shrink-0 me-3">
                                                    <div class="avatar-sm bg-light rounded">
                                                        <img data-dz-thumbnail
                                                            class="img-fluid rounded d-block"
                                                            src="https://img.themesbrand.com/judia/new-document.png"
                                                            alt="Dropzone-Image">
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <div class="pt-1">
                                                        <h5 class="fs-md mb-1" data-dz-name>&nbsp;</h5>
                                                        <p class="fs-sm text-muted mb-0" data-dz-size></p>
                                                        <strong class="error text-danger"
                                                            data-dz-errormessage></strong>
                                                    </div>
                                                </div>
                                                <div class="flex-shrink-0 ms-3">
                                                    <button data-dz-remove
                                                        class="btn btn-sm btn-danger">Delete</button>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                            </div>
                        </section>

                        <div class="form-group row mb-4">
                            <label for="preview" class="col-form-label col-lg-2">Image Preview</label>
                            <div class="col-lg-10">
                                <img id="preview" src="" alt="Image Preview" style="display:none; max-width: 150px; border-radius: 50%;">
                            </div>
                        </div>
    
                        <div class="form-group row mb-4">
                            <label for="category_id" class="col-form-label col-lg-2">Category</label>
                            <div class="col-lg-10">
                                <select id="category_id" name="category_id" class="form-control">
                                    <option value="">Select Category</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ (isset($post) && $post->category_id == $category->id) ? 'selected' : '' }}>{{ $category->name }}</option>
                                    @endforeach
                                </select>
                                @error('category_id')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
    
                        
                        <div class="form-group row mb-4">
                            {{-- {{ (isset($post) && $post->author_id == $author->id) ? 'selected' : '' }} --}}
                            <label  class="col-form-label col-lg-2">Tags</label>
                            <div class="col-lg-10">
                                <select class="select2 form-control select2-multiple" name="tags[]" multiple="multiple"
                                data-placeholder="Choose ...">
                                @foreach($tags as $tag)
                                <option value="{{ $tag->id }}" >{{ $tag->name }}</option>
                            @endforeach
                                
                            </select>
                                @error('tags')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
    
                        <div class="form-group row mb-4">
                            <label for="status" class="col-form-label col-lg-2">Status</label>
                            <div class="col-xl-3 col-sm-6">
                                <div class="d-flex align-items-center">
                                    <div class="form-check me-3">
                                        <input class="form-check-input" type="radio" name="status" id="draft" value="draft" checked>
                                        <label class="form-check-label" for="formRadios1">
                                            Draft
                                        </label>
                                    </div>
                                    <div class="form-check me-3">
                                        <input class="form-check-input" type="radio" name="status" id="published" value="published">
                                        <label class="form-check-label" for="formRadios2">
                                            Published
                                        </label>
                                    </div>

                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="status" id="archived" value="archived">
                                        <label class="form-check-label" for="formRadios2">
                                            Archived
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        
                        
    
                        <div class="form-group row mb-4">
                            <label for="published_at" class="col-form-label col-lg-2">Published At</label>
                            <div class="col-lg-10">
                                <input id="published_at" name="published_at" type="datetime-local" value="{{ isset($post) ? $post->published_at->format('Y-m-d\TH:i') : '' }}" class="form-control">
                                @error('published_at')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
    
                        <div class="form-group row mb-4">
                            <label for="meta_description" class="col-form-label col-lg-2">Meta Description</label>
                            <div class="col-lg-10">
                                <input id="meta_description" name="meta_description" type="text" value="{{ $post->meta_description ?? '' }}" class="form-control" placeholder="Enter Meta Description...">
                                @error('meta_description')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
    
                        <div class="form-group row mb-4">
                            <label for="meta_keywords" class="col-form-label col-lg-2">Meta Keywords</label>
                            <div class="col-lg-10">
                                <input id="meta_keywords" name="meta_keywords" type="text" value="{{ $post->meta_keywords ?? '' }}" class="form-control" placeholder="Enter Meta Keywords...">
                                @error('meta_keywords')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                       
                        <div class="form-group row mb-4">
                            <label for="status" class="col-form-label col-lg-2">Flag</label>

                            <div class="col-xl-3 col-sm-6">
                                <div class="d-flex align-items-center">
                                    <div class="form-check me-3">
                                        <input class="form-check-input" type="radio" name="flag" id="trending" value="trending" checked>
                                        <label class="form-check-label" for="trending">
                                            Trending
                                        </label>
                                    </div>
                                    <div class="form-check me-3">
                                        <input class="form-check-input" type="radio" name="flag" id="featured" value="featured">
                                        <label class="form-check-label" for="featured">
                                            Featured
                                        </label>
                                    </div>

                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="flag" id="top" value="top">
                                        <label class="form-check-label" for="top">
                                            Top
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="id" id="id" value="{{ $post->id ?? '' }}">
                        <div class="row justify-content-end">
                            <div class="col-lg-10">
                                <button type="submit" class="btn btn-primary submitBtn" id="submitBtn">{{ is_null($post) ? 'Create Post' : 'Update Post' }}</button>
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
    <script src="{{ URL::asset('build/libs/dropzone/dropzone-min.js') }}"></script>
    <script src="{{ URL::asset('build/libs/select2/js/select2.min.js') }}"></script>
        <!-- form advanced init -->
        <script src="{{ URL::asset('build/js/pages/form-advanced.init.js') }}"></script>



    <script>
    $(document).ready(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var dropzonePreviewNode = document.querySelector("#dropzone-preview-list");
        
        dropzonePreviewNode.id = "";
        if (dropzonePreviewNode) {
            var previewTemplate = dropzonePreviewNode.parentNode.innerHTML;
            dropzonePreviewNode.parentNode.removeChild(dropzonePreviewNode);

            var myDropzone = new Dropzone(".dropzone", {
                url: "{{ route('posts.store') }}",  // Set the Laravel route here
                method: "post",
                paramName: "file",  // The name used for the file upload in the backend
                previewTemplate: previewTemplate,
                previewsContainer: "#dropzone-preview",
                autoProcessQueue: false,  // Prevent automatic file processing
                addRemoveLinks: true,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(file, response) {
                    console.log("File successfully uploaded", response);
                },
                error: function(file, response) {
                    console.log("File upload failed", response);
                }
            });

            $('#submitForm').on('submit', function(e) {
                e.preventDefault(); 

                var formData = new FormData(this); // 'this' refers to the form element
                myDropzone.getAcceptedFiles().forEach((file, index) => {
                    formData.append(`file[${index}]`, file);  // Append each file
                });
                $.ajax({
                    url: "{{ route('posts.store') }}", 
                    type: "post",
                    data: formData,
                    processData: false,  // Important for FormData
                    contentType: false,  // Important for FormData
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
        }
    });
    </script>
@endsection

