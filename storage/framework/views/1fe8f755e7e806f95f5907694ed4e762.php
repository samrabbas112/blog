

<?php $__env->startSection('title'); ?>
    <?php if(is_null($category)): ?>
    <?php echo app('translator')->get('translation.Create_Category'); ?>
    <?php else: ?>
    <?php echo app('translator')->get('translation.Update_Category'); ?>
    <?php endif; ?>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>
    <?php $__env->startComponent('components.breadcrumb'); ?>
        <?php $__env->slot('li_1'); ?>
            Category
        <?php $__env->endSlot(); ?>
        <?php $__env->slot('title'); ?>
           <?php echo e(is_null($category) ? 'Create Category' : 'Update Category'); ?>

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
                    <h4 class="card-title mb-4"><?php echo e(is_null($category) ? 'Create New Category' : 'Update Category'); ?> </h4>
                    <form class="outer-repeater" id="submitForm">
                        <?php echo csrf_field(); ?>
                        <div  class="outer">
                            <div data-repeater-item class="outer">
                                <div class="form-group row mb-4">
                                    <label for="tagname" class="col-form-label col-lg-2">Category Name</label>
                                    <div class="col-lg-10">
                                        <input id="name" name="name" type="text" id="name" value="<?php echo e($category->name ?? ''); ?>" class="form-control"
                                            placeholder="Enter Category Name...">
                                            <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <span class="red"><?php echo e($message); ?></span>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="id" id="id" value="<?php echo e($category->id ?? ''); ?>">
                        <div class="row justify-content-end">
                            <div class="col-lg-10">
                                <button type="submit" class="btn btn-primary submitBtn" id="submitBtn" data-id="<?php echo e($category->id ?? ''); ?>"><?php echo e(is_null($category) ? 'Create Category' : 'Update Category'); ?></button>
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
                url: "<?php echo e(route('category.store')); ?>", 
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
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\Admin\resources\views\categories\create.blade.php ENDPATH**/ ?>