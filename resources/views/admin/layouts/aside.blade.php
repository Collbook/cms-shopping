<aside class="left-sidebar" data-sidebarbg="skin5">
    <!-- Sidebar scroll-->
    <div class="scroll-sidebar">
        <!-- Sidebar navigation-->
        <nav class="sidebar-nav">
            <ul id="sidebarnav" class="p-t-30">
                <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link" href="{{ route('admin.dashboard') }}" aria-expanded="false"><i class="mdi mdi-view-dashboard"></i><span class="hide-menu">Dashboard</span></a></li>
                <li class="sidebar-item"> <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="m-r-10 mdi mdi-folder"></i><span class="hide-menu">Category </span></a>
                    <ul aria-expanded="false" class="collapse  first-level">
                        <li class="sidebar-item"><a href="{{ route('admin.category.create') }}" class="sidebar-link"><i class="mdi mdi-note-outline"></i><span class="hide-menu"> Add Category </span></a></li>
                        <li class="sidebar-item"><a href="{{ route('admin.category.index') }}" class="sidebar-link"><i class="mdi mdi-note-plus"></i><span class="hide-menu"> List Category </span></a></li>
                    </ul>
                </li>

                <li class="sidebar-item"> <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="fab fa-product-hunt"></i><span class="hide-menu"> &nbsp; Product </span></a>
                    <ul aria-expanded="false" class="collapse  first-level">
                        <li class="sidebar-item"><a href="{{ route('admin.products.create') }}" class="sidebar-link"><i class="mdi mdi-note-outline"></i><span class="hide-menu"> Add Product </span></a></li>
                        <li class="sidebar-item"><a href="{{ route('admin.products.index') }}" class="sidebar-link"><i class="mdi mdi-note-plus"></i><span class="hide-menu"> List Product </span></a></li>
                    </ul>
                </li>

                <li class="sidebar-item"> <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="m-r-10 mdi mdi-tag-multiple"></i><span class="hide-menu">Counpons </span></a>
                    <ul aria-expanded="false" class="collapse  first-level">
                        <li class="sidebar-item"><a href="{{ route('admin.coupons.create') }}" class="sidebar-link"><i class="mdi mdi-note-outline"></i><span class="hide-menu"> Add Counpons </span></a></li>
                        <li class="sidebar-item"><a href="{{ route('admin.coupons.index') }}" class="sidebar-link"><i class="mdi mdi-note-plus"></i><span class="hide-menu"> List Counpons </span></a></li>
                    </ul>
                </li>

                <li class="sidebar-item"> <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="fas fa-sync-alt"></i><span class="hide-menu"> &nbsp;&nbsp;Banner </span></a>
                    <ul aria-expanded="false" class="collapse  first-level">
                        <li class="sidebar-item"><a href="{{ route('admin.banner.create') }}" class="sidebar-link"><i class="mdi mdi-note-outline"></i><span class="hide-menu"> Add Banner </span></a></li>
                        <li class="sidebar-item"><a href="{{ route('admin.banner.index') }}" class="sidebar-link"><i class="mdi mdi-note-plus"></i><span class="hide-menu"> List Banner </span></a></li>
                    </ul>
                </li>

                <li class="sidebar-item"> <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="m-r-10 mdi mdi-account-card-details"></i><span class="hide-menu">Orders </span></a>
                    <ul aria-expanded="false" class="collapse  first-level">
                        <li class="sidebar-item"><a href="{{ route('admin.orders.index') }}" class="sidebar-link"><i class="mdi mdi-note-plus"></i><span class="hide-menu"> View Orders </span></a></li>
                    </ul>
                </li>

                <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link" href="{{ route('admin.settings') }}" aria-expanded="false"><i class="fas fa-cogs"></i><span class="hide-menu"> &nbsp;&nbsp; Settings</span></a></li>
                <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link" href="{{ route('admin.logout') }}" aria-expanded="false"><i class="m-r-10 mdi mdi-logout-variant"></i><span class="hide-menu">Logout</span></a></li>

            </ul>
        </nav>
        <!-- End Sidebar navigation -->
    </div>
    <!-- End Sidebar scroll-->
</aside>
