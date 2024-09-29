

<?php $__env->startSection('title'); ?>
    <?php echo app('translator')->get('translation.List_Category'); ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('css'); ?>
<!-- Sweet Alert-->
<link href="<?php echo e(URL::asset('build/libs/sweetalert2/sweetalert2.min.css')); ?>" rel="stylesheet" type="text/css" />
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <?php $__env->startComponent('components.breadcrumb'); ?>
        <?php $__env->slot('li_1'); ?>
            Category
        <?php $__env->endSlot(); ?>
        <?php $__env->slot('title'); ?>
        Category List
        <?php $__env->endSlot(); ?>
    <?php echo $__env->renderComponent(); ?>
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

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
                            <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr id="categoryRow<?php echo e($category->id); ?>">
                                <td>
                                    <p class="text-muted mb-0"><?php echo e($category->name); ?></p>
                                </td>
                                <td>
                                    <div class="dropdown">
                                        <a href="#" class="dropdown-toggle card-drop" data-bs-toggle="dropdown"
                                            aria-expanded="false">
                                            <i class="mdi mdi-dots-horizontal font-size-18"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-end">
                                            <a class="dropdown-item" href="<?php echo e(route('category.create', ['id' => $category->id])); ?>">Edit</a>
                                            <a class="dropdown-item delete-category" href="#" data-id="<?php echo e($category->id); ?>">Delete</a>
                                            
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        
            
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- end row -->

    
<?php $__env->stopSection(); ?>
<?php $__env->startSection('script'); ?>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Sweet Alerts js -->
<script src="<?php echo e(URL::asset('build/libs/sweetalert2/sweetalert2.min.js')); ?>"></script>

<!-- Sweet alert init js-->

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
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\Admin\resources\views\categories\index.blade.php ENDPATH**/ ?>