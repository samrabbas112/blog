

<?php $__env->startSection('title'); ?>
    <?php if(is_null($user)): ?>
    <?php echo app('translator')->get('translation.Create_User'); ?>
    <?php else: ?>
    <?php echo app('translator')->get('translation.Update_User'); ?>
    <?php endif; ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('css'); ?>
    <!-- Plugins css -->
    <link href="<?php echo e(URL::asset('build/libs/dropzone/dropzone.css')); ?>" rel="stylesheet" type="text/css" />
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>
    <?php $__env->startComponent('components.breadcrumb'); ?>
        <?php $__env->slot('li_1'); ?>
            Users
        <?php $__env->endSlot(); ?>
        <?php $__env->slot('title'); ?>
           <?php echo e(is_null($user) ? 'Create User' : 'Update User'); ?>

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
                    <h4 class="card-title mb-4"><?php echo e(is_null($user) ? 'Create New User' : 'Update User'); ?> </h4>
                    <form class="outer-repeater" id="submitForm" enctype="multipart/form-data">
                        <?php echo csrf_field(); ?>
                        <div class="outer">
                            <div data-repeater-item class="outer">
                                <div class="form-group row mb-4">
                                    <label for="name" class="col-form-label col-lg-2">Name</label>
                                    <div class="col-lg-10">
                                        <input id="name" name="name" type="text" value="<?php echo e($user->name ?? ''); ?>" class="form-control"
                                            placeholder="Enter Name...">
                                        <?php $__errorArgs = ['name'];
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
                                    <label for="email" class="col-form-label col-lg-2">Email</label>
                                    <div class="col-lg-10">
                                        <input id="email" name="email" type="email" value="<?php echo e($user->email ?? ''); ?>" class="form-control"
                                            placeholder="Enter Email...">
                                        <?php $__errorArgs = ['email'];
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
                                    <label for="password" class="col-form-label col-lg-2">Password</label>
                                    <div class="col-lg-10">
                                        <input id="password" name="password" type="password"  class="form-control"
                                            placeholder="Enter Password...">
                                        <?php $__errorArgs = ['password'];
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
                                    <label for="dob" class="col-form-label col-lg-2">Date of Birth</label>
                                    <div class="col-lg-10">
                                        <input id="dob" name="dob" type="date" value="<?php echo e($user->dob ?? ''); ?>" class="form-control">
                                        <?php $__errorArgs = ['dob'];
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
                                    <div>
                                        <h5 class="font-size-14 mb-3">Upload document file for a verification</h5>
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
                                </section>

                                <div class="form-group row mb-4">
                                    <label for="preview" class="col-form-label col-lg-2">Image Preview</label>
                                    <div class="col-lg-10">
                                        <img id="preview" src="" alt="Image Preview" style="display:none; max-width: 150px; border-radius: 50%;">
                                    </div>
                                </div>
                                

                                <div class="form-group row mb-4">
                                    <label for="role" class="col-form-label col-lg-2">Role</label>
                                    <div class="col-lg-10">
                                        <div class="form-check">
                                            <input class="form-check-input" name="roles[Editor]" type="checkbox" id="formCheck2" <?php echo e(!is_null($user) ? ($user->hasRole('Editor') ? 'checked' : '') : ''); ?>>
                                            <label class="form-check-label" for="formCheck2">
                                                Editor
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="roles[Creator]" id="formCheck2" <?php echo e(!is_null($user) ? ($user->hasRole('Creator') ? 'checked' : '') : ''); ?>>
                                            <label class="form-check-label" for="formCheck2">
                                                Creator
                                            </label>
                                        </div>
                                        <?php $__errorArgs = ['role'];
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
                            </div>
                        </div>
                        <input type="hidden" name="id" id="id" value="<?php echo e($user->id ?? ''); ?>">
                        <div class="row justify-content-end">
                            <div class="col-lg-10">
                                <button type="submit" class="btn btn-primary submitBtn" id="submitBtn" data-id="<?php echo e($user->id ?? ''); ?>"><?php echo e(is_null($user) ? 'Create User' : 'Update User'); ?></button>
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

    <script>
        
    $(document).ready(function() {
        var dropzonePreviewNode = document.querySelector("#dropzone-preview-list");
        
        dropzonePreviewNode.id = "";
        if (dropzonePreviewNode) {
            var previewTemplate = dropzonePreviewNode.parentNode.innerHTML;
            dropzonePreviewNode.parentNode.removeChild(dropzonePreviewNode);
          var myDropzone = new Dropzone(".dropzone", {
            url: "<?php echo e(route('users.store')); ?>",  // Set the Laravel route here
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

}
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $('#submitForm').on('submit', function(e) {
            e.preventDefault(); 
            // let btnId = document.querySelector('[data-id]').getAttribute('data-id');
            var formData = new FormData(this); // 'this' refers to the form element
            myDropzone.getAcceptedFiles().forEach((file, index) => {
                formData.append(`file[${index}]`, file);  // Append each file
            });

            $.ajax({
                url: "<?php echo e(route('users.store')); ?>", 
                type: "post",
                data: formData, 
                processData: false, // Important: Prevent jQuery from automatically transforming the data into a query string
                contentType: false,
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

        function previewImage(event) {
            const reader = new FileReader();
        const imageField = document.getElementById('preview');

        reader.onload = function() {
            if (reader.readyState === 2) {
                imageField.src = reader.result;
                imageField.style.display = 'block'; // Show the image
            }
        };

        reader.readAsDataURL(event.target.files[0]);

        }
    });
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\Admin\resources\views\users\create.blade.php ENDPATH**/ ?>