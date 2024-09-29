<!-- ========== Left Sidebar Start ========== -->
<div class="vertical-menu">

    <div data-simplebar class="h-100">

        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <!-- Left Menu Start -->
            <ul class="metismenu list-unstyled" id="side-menu">
                <li class="menu-title" key="t-menu"><?php echo app('translator')->get('translation.Menu'); ?></li>

                

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="bx bx-home-circle"></i>
                        <span key="t-posts"><?php echo app('translator')->get('translation.posts'); ?></span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="<?php echo e(route('posts.create')); ?>" key="t-Create_Post"><?php echo app('translator')->get('translation.Create_Post'); ?></a></li>
                        <li><a href="<?php echo e(route('posts.index')); ?>" key="t-List_Post"><?php echo app('translator')->get('translation.List_Post'); ?></a></li>
                    </ul>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="bx bx-home-circle"></i>
                        <span key="t-categories"><?php echo app('translator')->get('translation.categories'); ?></span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="<?php echo e(route('category.create')); ?>" key="t-Create_Category"><?php echo app('translator')->get('translation.Create_Category'); ?></a></li>
                        <li><a href="<?php echo e(route('category.index')); ?>" key="t-List_Category"><?php echo app('translator')->get('translation.List_Category'); ?></a></li>
                    </ul>
                </li>
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="bx bx-home-circle"></i>
                        <span key="t-tags"><?php echo app('translator')->get('translation.tags'); ?></span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="<?php echo e(route('tags.create')); ?>" key="t-Create_Tag"><?php echo app('translator')->get('translation.Create_Tag'); ?></a></li>
                        <li><a href="<?php echo e(route('tags.index')); ?>" key="t-List_Tag"><?php echo app('translator')->get('translation.List_Tag'); ?></a></li>
                    </ul>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="bx bx-home-circle"></i>
                        <span key="t-user"><?php echo app('translator')->get('translation.users'); ?></span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="<?php echo e(route('users.create')); ?>" key="t-Create_User"><?php echo app('translator')->get('translation.Create_User'); ?></a></li>
                        <li><a href="<?php echo e(route('users.index')); ?>" key="t-List_User"><?php echo app('translator')->get('translation.List_User'); ?></a></li>
                    </ul>
                </li>
            </ul>
        </div>
        <!-- Sidebar -->
    </div>
</div>
<!-- Left Sidebar End -->
<?php /**PATH C:\laragon\www\Admin\resources\views/layouts/sidebar.blade.php ENDPATH**/ ?>