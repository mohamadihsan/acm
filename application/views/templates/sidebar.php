<!-- BEGIN SIDEBAR -->
<div class="page-sidebar-wrapper">
    <!-- BEGIN SIDEBAR -->
    <!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
    <!-- DOC: Change data-auto-speed="200" to adjust the sub menu slide up/down speed -->
    <div class="page-sidebar navbar-collapse collapse">
        <!-- BEGIN SIDEBAR MENU -->
        <!-- DOC: Apply "page-sidebar-menu-light" class right after "page-sidebar-menu" to enable light sidebar menu style(without borders) -->
        <!-- DOC: Apply "page-sidebar-menu-hover-submenu" class right after "page-sidebar-menu" to enable hoverable(hover vs accordion) sub menu mode -->
        <!-- DOC: Apply "page-sidebar-menu-closed" class right after "page-sidebar-menu" to collapse("page-sidebar-closed" class must be applied to the body element) the sidebar sub menu mode -->
        <!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
        <!-- DOC: Set data-keep-expand="true" to keep the submenues expanded -->
        <!-- DOC: Set data-auto-speed="200" to adjust the sub menu slide up/down speed -->
        <ul class="page-sidebar-menu  page-header-fixed " data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200" style="padding-top: 20px">
            <!-- DOC: To remove the sidebar toggler from the sidebar you just need to completely remove the below "sidebar-toggler-wrapper" LI element -->
            <!-- BEGIN SIDEBAR TOGGLER BUTTON -->
            <li class="sidebar-toggler-wrapper hide">
                <div class="sidebar-toggler">
                    <span></span>
                </div>
            </li>
            <!-- END SIDEBAR TOGGLER BUTTON -->
            <!-- DOC: To remove the search box from the sidebar you just need to completely remove the below "sidebar-search-wrapper" LI element -->
            <li class="nav-item start active open">
                <a href="javascript:;" class="nav-link nav-toggle">
                    <i class="icon-home"></i>
                    <span class="title">Dashboard</span>
                    <span class="selected"></span>
                </a>
            </li>
            <li class="heading">
                <h3 class="uppercase">Management</h3>
            </li>
            <li class="nav-item  ">
                <a href="<?= site_url('card') ?>" class="nav-link nav-toggle">
                    <i class="icon-puzzle"></i>
                    <span class="title">Card</span>
                </a>
            </li>
            <li class="nav-item  ">
                <a href="javascript:;" class="nav-link nav-toggle">
                    <i class="icon-diamond"></i>
                    <span class="title">Card Owner</span>
                    <span class="arrow"></span>
                </a>
                <ul class="sub-menu">
                    <li class="nav-item  ">
                        <a href="<?= site_url('employee') ?>" class="nav-link">
                            <span class="title">Employee</span>
                        </a>
                    </li>
                    <li class="nav-item  ">
                        <a href="<?= site_url('tenant') ?>" class="nav-link ">
                            <span class="title">Tenant / Vendor</span>
                        </a>
                    </li>
                    <li class="nav-item  ">
                        <a href="<?= site_url('non_employee') ?>" class="nav-link ">
                            <span class="title">Non Employee</span>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="nav-item  ">
                <a href="javascript:;" class="nav-link nav-toggle">
                <i class="icon-docs"></i>
                    <span class="title">Report</span>
                    <span class="arrow"></span>
                </a>
                <ul class="sub-menu">
                    <li class="nav-item  ">
                        <a href="<?= site_url('report/registration') ?>" class="nav-link">
                            <span class="title">Registration Card</span>
                        </a>
                    </li>
                    <li class="nav-item  ">
                        <a href="<?= site_url('report/update_card') ?>" class="nav-link ">
                            <span class="title">Update Card</span>
                        </a>
                    </li>
                    <li class="nav-item  ">
                        <a href="<?= site_url('report/replacement') ?>" class="nav-link ">
                            <span class="title">Replacement</span>
                        </a>
                    </li>
                    <li class="nav-item  ">
                        <a href="<?= site_url('report/deletion') ?>" class="nav-link ">
                            <span class="title">Card Deletion</span>
                        </a>
                    </li>
                    <li class="nav-item  ">
                        <a href="<?= site_url('report/card_blocked') ?>" class="nav-link ">
                            <span class="title">Card Bocked</span>
                        </a>
                    </li>
                </ul>
            </li>
        </ul>
        <!-- END SIDEBAR MENU -->
    </div>
    <!-- END SIDEBAR -->
</div>
<!-- END SIDEBAR -->