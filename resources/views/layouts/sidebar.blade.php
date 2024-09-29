<!-- ========== Left Sidebar Start ========== -->
<div class="vertical-menu">

    <div data-simplebar class="h-100">

        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <!-- Left Menu Start -->
            <ul class="metismenu list-unstyled" id="side-menu">
                <li class="menu-title" key="t-menu">@lang('translation.Menu')</li>

                {{-- <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="bx bx-home-circle"></i>
                        <span key="t-dashboards">@lang('translation.Dashboards')</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="index" key="t-default">@lang('translation.Default')</a></li>
                        <li><a href="dashboard-saas" key="t-saas">@lang('translation.Saas')</a></li>
                        <li><a href="dashboard-crypto" key="t-crypto">@lang('translation.Crypto')</a></li>
                        <li><a href="dashboard-blog" key="t-blog">@lang('translation.Blog')</a></li>
                        <li><a href="dashboard-job">@lang('translation.Jobs')</a></li>
                    </ul>
                </li> --}}

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="bx bx-home-circle"></i>
                        <span key="t-posts">@lang('translation.posts')</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('posts.create') }}" key="t-Create_Post">@lang('translation.Create_Post')</a></li>
                        <li><a href="{{ route('posts.index') }}" key="t-List_Post">@lang('translation.List_Post')</a></li>
                    </ul>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="bx bx-home-circle"></i>
                        <span key="t-categories">@lang('translation.categories')</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('category.create') }}" key="t-Create_Category">@lang('translation.Create_Category')</a></li>
                        <li><a href="{{ route('category.index') }}" key="t-List_Category">@lang('translation.List_Category')</a></li>
                    </ul>
                </li>
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="bx bx-home-circle"></i>
                        <span key="t-tags">@lang('translation.tags')</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('tags.create') }}" key="t-Create_Tag">@lang('translation.Create_Tag')</a></li>
                        <li><a href="{{ route('tags.index') }}" key="t-List_Tag">@lang('translation.List_Tag')</a></li>
                    </ul>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="bx bx-home-circle"></i>
                        <span key="t-user">@lang('translation.users')</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('users.create') }}" key="t-Create_User">@lang('translation.Create_User')</a></li>
                        <li><a href="{{ route('users.index') }}" key="t-List_User">@lang('translation.List_User')</a></li>
                    </ul>
                </li>
            </ul>
        </div>
        <!-- Sidebar -->
    </div>
</div>
<!-- Left Sidebar End -->
