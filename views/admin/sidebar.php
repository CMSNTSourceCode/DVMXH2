<?php if (!defined('IN_SITE')) {
    die('The Request Not Found');
}?>
<body class="hold-transition light-mode sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
    <div class="wrapper">
        <?php require_once(__DIR__.'/nav.php');?>
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <a href="<?=base_url('admin/');?>" class="brand-link">
               <center> <img width="100%" src="<?=base_url('assets/img/logo_dark.png');?>" alt="CMSNT.CO"></center>
            </a>
            <div class="sidebar">
                <div class="form-inline">
                    <div class="input-group" data-widget="sidebar-search">
                        <input class="form-control form-control-sidebar" type="search" placeholder="Search"
                            aria-label="Search">
                        <div class="input-group-append">
                            <button class="btn btn-sidebar">
                                <i class="fas fa-search fa-fw"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                        data-accordion="false">
                        <li class="nav-item has-treeview">
                            <a href="<?=BASE_URL('admin/home');?>"
                                class="nav-link <?=active_sidebar(['home', '']);?>">
                                <i class="nav-icon fas fa-tachometer-alt"></i>
                                <p>
                                    Bảng điều khiển
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?=BASE_URL('admin/users');?>"
                                class="nav-link <?=active_sidebar(['users', 'user-edit']);?>">
                                <i class="nav-icon fas fa-user-alt"></i>
                                <p>
                                    Thành viên
                                </p>
                            </a>
                        </li>
                        <li class="nav-item <?=menuopen_sidebar(['category-list', 'category-edit', 'service-list', 'service-edit', 'service-pack', 'order-list', 'order-edit']);?>">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-thumbs-up"></i>
                                <p>
                                    Dịch vụ Order
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="<?=BASE_URL('admin/category-list');?>"
                                        class="nav-link <?=active_sidebar(['category-list', 'category-edit']);?>">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>
                                            Chuyên mục
                                        </p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="<?=BASE_URL('admin/service-list');?>"
                                        class="nav-link <?=active_sidebar(['service-list', 'service-edit']);?>">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Nhóm dịch vụ</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="<?=BASE_URL('admin/service-pack');?>"
                                        class="nav-link <?=active_sidebar(['service-pack']);?>">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Gói dịch vụ</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="<?=BASE_URL('admin/order-list');?>"
                                        class="nav-link <?=active_sidebar(['order-list', 'order-edit']);?>">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Đơn hàng</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item <?=menuopen_sidebar(['auto-bank', 'auto-momo', 'logs', 'dong-tien', 'nap-the']);?>">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-history"></i>
                                <p>
                                    Lịch Sử
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="<?=BASE_URL('admin/logs');?>"
                                        class="nav-link <?=active_sidebar(['logs']);?>">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Nhật ký hoạt động</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="<?=BASE_URL('admin/dong-tien');?>"
                                        class="nav-link <?=active_sidebar(['dong-tien']);?>">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Biến động số dư</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="<?=BASE_URL('admin/nap-the');?>"
                                        class="nav-link <?=active_sidebar(['nap-the']);?>">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Lịch sử nạp thẻ</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="<?=BASE_URL('admin/auto-bank');?>"
                                        class="nav-link <?=active_sidebar(['auto-bank']);?>">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Lịch sử nạp auto bank</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="<?=BASE_URL('admin/auto-momo');?>"
                                        class="nav-link <?=active_sidebar(['auto-momo']);?>">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Lịch sử nạp auto momo</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a href="<?=BASE_URL('admin/bank-list');?>"
                                class="nav-link <?=active_sidebar(['bank-list', 'bank-edit']);?>">
                                <i class="nav-icon fas fa-university"></i>
                                <p>
                                    Ngân Hàng
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?=BASE_URL('admin/menu-list');?>"
                                class="nav-link <?=active_sidebar(['menu-list', 'menu-edit']);?>">
                                <i class="nav-icon fas fa-bars"></i>
                                <p>
                                    Cài đặt menu
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?=BASE_URL('admin/theme');?>"
                                class="nav-link <?=active_sidebar(['theme']);?>">
                                <i class="nav-icon fas fa-image"></i>
                                <p>
                                    Giao diện
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?=BASE_URL('admin/settings');?>"
                                class="nav-link <?=active_sidebar(['settings']);?>">
                                <i class="nav-icon fas fa-cog"></i>
                                <p>
                                    Cài đặt hệ thống
                                </p>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
        </aside>

        