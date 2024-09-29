

<?php $__env->startSection('title'); ?>
    <?php if(is_null($post)): ?>
    <?php echo app('translator')->get('translation.Create_Post'); ?>
    <?php else: ?>
    <?php echo app('translator')->get('translation.Update_Post'); ?>
    <?php endif; ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('css'); ?>
    <!-- Plugins css -->
    <link href="<?php echo e(URL::asset('build/libs/dropzone/dropzone.css')); ?>" rel="stylesheet" type="text/css" />
    <link href="<?php echo e(URL::asset('build/libs/select2/css/select2.min.css')); ?>" rel="stylesheet" type="text/css" />

<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <?php $__env->startComponent('components.breadcrumb'); ?>
        <?php $__env->slot('li_1'); ?>
            Posts
        <?php $__env->endSlot(); ?>
        <?php $__env->slot('title'); ?>
           <?php echo e(is_null($post) ? 'Create Post' : 'Update Post'); ?>

        <?php $__env->endSlot(); ?>
    <?php echo $__env->renderComponent(); ?>

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="alert alert-success alert-dismissible fade show d-none" id="successAlert" role="alert">
                    <span id="successMessage"></span>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                <div class="card-body">
                    <h4 class="card-title mb-4"><?php echo e(is_null($post) ? 'Create New Post' : 'Update Post'); ?></h4>
                    <form id="submitForm" enctype="multipart/form-data">
                        <?php echo csrf_field(); ?>
                        <div class="form-group row mb-4">
                            <label for="title" class="col-form-label col-lg-2">Title</label>
                            <div class="col-lg-10">
                                <input id="title" name="title" type="text" value="<?php echo e($post->title ?? ''); ?>" class="form-control" placeholder="Enter Post Title...">
                                <?php $__errorArgs = ['title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <span class="text-danger"><?php echo e($message); ?></span>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                        </div>
    
                        <div class="form-group row mb-4">
                            <label for="slug" class="col-form-label col-lg-2">Slug</label>
                            <div class="col-lg-10">
                                <input id="slug" name="slug" type="text" value="<?php echo e($post->slug ?? ''); ?>" class="form-control" placeholder="Enter Post Slug...">
                                <?php $__errorArgs = ['slug'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <span class="text-danger"><?php echo e($message); ?></span>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                        </div>
    
                        <div class="form-group row mb-4">
                            <label for="body" class="col-form-label col-lg-2">Body</label>
                            <div class="col-lg-10">
                                <textarea name="content" id="editor"></textarea>
                      
                                <?php $__errorArgs = ['body'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <span class="text-danger"><?php echo e($message); ?></span>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                        </div>
    
                        <div class="form-group row mb-4">
                            <label for="excerpt" class="col-form-label col-lg-2">Excerpt</label>
                            <div class="col-lg-10">
                                <textarea id="excerpt" name="excerpt" class="form-control" rows="3" placeholder="Enter Excerpt..."><?php echo e($post->excerpt ?? ''); ?></textarea>
                                <?php $__errorArgs = ['excerpt'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <span class="text-danger"><?php echo e($message); ?></span>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
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
                                    <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($category->id); ?>" <?php echo e((isset($post) && $post->category_id == $category->id) ? 'selected' : ''); ?>><?php echo e($category->name); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                                <?php $__errorArgs = ['category_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <span class="text-danger"><?php echo e($message); ?></span>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                        </div>
    
                        
                        <div class="form-group row mb-4">
                            
                            <label  class="col-form-label col-lg-2">Tags</label>
                            <div class="col-lg-10">
                                <select class="select2 form-control select2-multiple" name="tags[]" multiple="multiple"
                                data-placeholder="Choose ...">
                                <?php $__currentLoopData = $tags; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tag): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($tag->id); ?>" ><?php echo e($tag->name); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                
                            </select>
                                <?php $__errorArgs = ['tags'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <span class="text-danger"><?php echo e($message); ?></span>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
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
                                <input id="published_at" name="published_at" type="datetime-local" value="<?php echo e(isset($post) ? $post->published_at->format('Y-m-d\TH:i') : ''); ?>" class="form-control">
                                <?php $__errorArgs = ['published_at'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <span class="text-danger"><?php echo e($message); ?></span>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                        </div>
    
                        <div class="form-group row mb-4">
                            <label for="meta_description" class="col-form-label col-lg-2">Meta Description</label>
                            <div class="col-lg-10">
                                <input id="meta_description" name="meta_description" type="text" value="<?php echo e($post->meta_description ?? ''); ?>" class="form-control" placeholder="Enter Meta Description...">
                                <?php $__errorArgs = ['meta_description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <span class="text-danger"><?php echo e($message); ?></span>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                        </div>
    
                        <div class="form-group row mb-4">
                            <label for="meta_keywords" class="col-form-label col-lg-2">Meta Keywords</label>
                            <div class="col-lg-10">
                                <input id="meta_keywords" name="meta_keywords" type="text" value="<?php echo e($post->meta_keywords ?? ''); ?>" class="form-control" placeholder="Enter Meta Keywords...">
                                <?php $__errorArgs = ['meta_keywords'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <span class="text-danger"><?php echo e($message); ?></span>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
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
                        <input type="hidden" name="id" id="id" value="<?php echo e($post->id ?? ''); ?>">
                        <div class="row justify-content-end">
                            <div class="col-lg-10">
                                <button type="submit" class="btn btn-primary submitBtn" id="submitBtn"><?php echo e(is_null($post) ? 'Create Post' : 'Update Post'); ?></button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    <!-- end row -->
<?php $__env->stopSection(); ?>
<?php $__env->startSection('script'); ?>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="<?php echo e(URL::asset('build/libs/dropzone/dropzone-min.js')); ?>"></script>
    <script src="<?php echo e(URL::asset('build/libs/select2/js/select2.min.js')); ?>"></script>
        <!-- form advanced init -->
        <script src="<?php echo e(URL::asset('build/js/pages/form-advanced.init.js')); ?>"></script>



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
                url: "<?php echo e(route('posts.store')); ?>",  // Set the Laravel route here
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
                    url: "<?php echo e(route('posts.store')); ?>", 
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
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\Admin\resources\views\posts\create.blade.php ENDPATH**/ ?>