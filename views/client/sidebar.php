<?php if (!defined('IN_SITE')) {
    die('The Request Not Found');
}?>

<body>

    <!-- Begin page -->
    <div id="layout-wrapper">

        <header id="page-topbar">
            <div class="layout-width">
                <div class="navbar-header">
                    <div class="d-flex">
                        <!-- LOGO -->
                        <div class="navbar-brand-box horizontal-logo">
                            <a href="<?=base_url();?>" class="logo logo-dark">
                                <span class="logo-sm">
                                    <img src="<?=base_url($CMSNT->site('favicon'));?>" alt="" height="22">
                                </span>
                                <span class="logo-lg">
                                    <img src="<?=base_url($CMSNT->site('logo_light'));?>" alt="" height="50">
                                </span>
                            </a>

                            <a href="<?=base_url();?>" class="logo logo-light">
                                <span class="logo-sm">
                                    <img src="<?=base_url($CMSNT->site('favicon'));?>" alt="" height="22">
                                </span>
                                <span class="logo-lg">
                                    <img src="<?=base_url($CMSNT->site('logo_dark'));?>" alt="" height="50">
                                </span>
                            </a>
                        </div>

                        <button type="button"
                            class="btn btn-sm px-3 fs-16 header-item vertical-menu-btn topnav-hamburger"
                            id="topnav-hamburger-icon">
                            <span class="hamburger-icon">
                                <span></span>
                                <span></span>
                                <span></span>
                            </span>
                        </button>

                        <!-- App Search-->
                        <form class="app-search d-none d-md-block">
                            <div class="position-relative">
                                <input type="text" class="form-control" placeholder="Search..." autocomplete="off"
                                    id="search-options" value="">
                                <span class="mdi mdi-magnify search-widget-icon"></span>
                                <span class="mdi mdi-close-circle search-widget-icon search-widget-icon-close d-none"
                                    id="search-close-options"></span>
                            </div>
                        </form>
                    </div>

                    <div class="d-flex align-items-center">

                        <div class="dropdown d-md-none topbar-head-dropdown header-item">
                            <button type="button" class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle"
                                id="page-header-search-dropdown" data-bs-toggle="dropdown" aria-haspopup="true"
                                aria-expanded="false">
                                <i class="bx bx-search fs-22"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0"
                                aria-labelledby="page-header-search-dropdown">
                                <form class="p-3">
                                    <div class="form-group m-0">
                                        <div class="input-group">
                                            <input type="text" class="form-control" placeholder="Search ..."
                                                aria-label="Recipient's username">
                                            <button class="btn btn-primary" type="submit"><i
                                                    class="mdi mdi-magnify"></i></button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>




                        <div class="dropdown topbar-head-dropdown ms-1 header-item">
                            <button type="button" class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle"
                                id="page-header-cart-dropdown" data-bs-toggle="dropdown" data-bs-auto-close="outside"
                                aria-haspopup="true" aria-expanded="false">
                                <i class='bx bx-shopping-bag fs-22'></i>
                                <span
                                    class="position-absolute topbar-badge fs-10 translate-middle badge rounded-pill bg-info"><?=format_cash(isset($getUser) ? $CMSNT->get_row("SELECT COUNT(id) FROM `orders` WHERE `status` = 0 OR `status` = 3 AND `buyer` = '".$getUser['id']."' ORDER BY ID DESC ")['COUNT(id)'] : 0);?></span>
                            </button>
                            <div class="dropdown-menu dropdown-menu-xl dropdown-menu-end p-0 dropdown-menu-cart"
                                aria-labelledby="page-header-cart-dropdown">
                                <div class="p-3 border-top-0 border-start-0 border-end-0 border-dashed border">
                                    <div class="row align-items-center">
                                        <div class="col">
                                            <h6 class="m-0 fs-16 fw-semibold"> <?=__('Đơn hàng đang chờ xử lý');?></h6>
                                        </div>
                                        <div class="col-auto">
                                            <span
                                                class="badge badge-soft-warning fs-13"><span><?=format_cash(isset($getUser) ? $CMSNT->get_row("SELECT COUNT(id) FROM `orders` WHERE `status` = 0 OR `status` = 3 AND `buyer` = '".$getUser['id']."' ORDER BY ID DESC ")['COUNT(id)'] : 0);?></span>
                                                <?=__('đơn');?></span>
                                        </div>
                                    </div>
                                </div>
                                <div data-simplebar style="max-height: 300px;">
                                    <div class="p-2">
                                        <?php if(!isset($getUser)):?>
                                        <div class="text-center empty-cart">
                                            <div class="avatar-md mx-auto my-3">
                                                <div class="avatar-title bg-soft-info text-info fs-36 rounded-circle">
                                                    <i class='bx bx-cart'></i>
                                                </div>
                                            </div>
                                            <h5 class="mb-3"><?=__('Bạn không có đơn hàng nào đang xử lý!');?></h5>
                                        </div>
                                        <?php endif?>

                                        <?php if(isset($getUser) && $CMSNT->get_row("SELECT COUNT(id) FROM `orders` WHERE `status` = 0 OR `status` = 3 AND `buyer` = '".$getUser['id']."' ORDER BY ID DESC ")['COUNT(id)'] == 0):?>
                                        <div class="text-center empty-cart">
                                            <div class="avatar-md mx-auto my-3">
                                                <div class="avatar-title bg-soft-info text-info fs-36 rounded-circle">
                                                    <i class='bx bx-cart'></i>
                                                </div>
                                            </div>
                                            <h5 class="mb-3"><?=__('Bạn không có đơn hàng nào đang xử lý!');?></h5>
                                        </div>
                                        <?php endif?>
                                        <?php if(isset($getUser) && $CMSNT->get_row("SELECT COUNT(id) FROM `orders` WHERE `status` = 0 OR `status` = 3 AND `buyer` = '".$getUser['id']."' ORDER BY ID DESC ")['COUNT(id)'] != 0):?>
                                        <?php foreach($CMSNT->get_list(" SELECT * FROM `orders` WHERE `status` = 0 OR `status` = 3 AND `buyer` = '".$getUser['id']."' ORDER BY ID DESC ") as $orderNav):?>
                                        <div class="d-block dropdown-item dropdown-item-cart text-wrap px-3 py-2">
                                            <div class="d-flex align-items-center">
                                                <img src="<?=base_url(getRowRealtime('services', $orderNav['service_id'], 'icon'));?>"
                                                    class="me-3 rounded-circle avatar-sm p-2 bg-light" alt="user-pic">
                                                <div class="flex-1">
                                                    <h6 class="mt-0 mb-1 fs-14">
                                                        <a href="<?=base_url('client/order/'.$orderNav['trans_id']);?>"
                                                            class="text-reset">#<?=$orderNav['trans_id'];?> -
                                                            <?=__(getRowRealtime('services', $orderNav['service_id'], 'name'));?>
                                                            -
                                                            <?=__(getRowRealtime('service_packs', $orderNav['service_pack_id'], 'name'));?></a>
                                                    </h6>
                                                    <div class="row mb-0">
                                                        <div class="col">
                                                            <p class="fs-12 text-muted">
                                                                <?=__('Trạng thái:');?>
                                                                <span><?=display_service_client($orderNav['status']);?></span>
                                                                </span>
                                                            </p>
                                                        </div>
                                                        <div class="col-auto">
                                                            <p class="fs-12 text-muted float-right">
                                                                <?=timeAgo($orderNav['create_time']);?>
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <?php endforeach?>
                                        <?php endif?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="ms-1 header-item d-none d-sm-flex">
                            <button type="button" class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle"
                                data-toggle="fullscreen">
                                <i class='bx bx-fullscreen fs-22'></i>
                            </button>
                        </div>

                        <div class="ms-1 header-item d-none d-sm-flex">
                            <button type="button"
                                class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle light-dark-mode">
                                <i class='bx bx-moon fs-22'></i>
                            </button>
                        </div>

                         

                        <div class="dropdown ms-sm-3 header-item topbar-user">
                            <button type="button" class="btn" id="page-header-user-dropdown" data-bs-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">
                                <span class="d-flex align-items-center">
                                    <img class="rounded-circle header-profile-user"
                                        src="<?=base_url('public/themesbrand/');?>images/users/avatar-1.jpg"
                                        alt="Header Avatar">
                                    <span class="text-start ms-xl-2">
                                        <span
                                            class="d-none d-xl-inline-block ms-1 fw-medium user-name-text"><?=isset($getUser) ? $getUser['username'] : __('Khách');?></span>
                                        <span
                                            class="d-none d-xl-block ms-1 fs-12 text-muted user-name-sub-text"><b style="color: red;"><?=format_currency(isset($getUser['money']) ? $getUser['money'] : 0);?></b></span>
                                    </span>
                                </span>
                            </button>
                            <div class="dropdown-menu dropdown-menu-end">
                                <!-- item-->
                                <h6 class="dropdown-header"><?=__('Xin chào');?>
                                    <?=isset($getUser) ? $getUser['username'] : __('Khách');?>!</h6>
                                <?php if(isset($getUser)):?>
                                <?php if($getUser['admin'] == 1):?>
                                <a class="dropdown-item" href="<?=base_url('admin/home');?>"><i
                                        class="mdi mdi-account-cog text-muted fs-16 align-middle me-1"></i> <span
                                        class="align-middle"><?=__('Admin Panel');?></span></a>
                                <?php endif?>
                                <a class="dropdown-item" href="<?=base_url('client/profile');?>"><i
                                        class="mdi mdi-account-circle text-muted fs-16 align-middle me-1"></i> <span
                                        class="align-middle"><?=__('Trang Cá Nhân');?></span></a>
                                <a class="dropdown-item" href="<?=base_url('client/profile');?>"><i
                                        class="ri-history-line text-muted fs-16 align-middle me-1"></i> <span
                                        class="align-middle"><?=__('Nhật Ký Hoạt Động');?></span></a>
                                <a class="dropdown-item" href="<?=base_url('client/profile');?>"><i
                                        class="las la-money-check-alt text-muted fs-16 align-middle me-1"></i> <span
                                        class="align-middle"><?=__('Biến Động Số Dư');?></span></a>
                                <a class="dropdown-item" href="<?=base_url('client/profile');?>"><i
                                        class="far fa-user text-muted fs-16 align-middle me-1"></i> <span
                                        class="align-middle"><?=__('Thay Đổi Mật Khẩu');?></span></a>
                                <a class="dropdown-item" href="<?=base_url('client/logout');?>"><i
                                        class="mdi mdi-logout text-muted fs-16 align-middle me-1"></i> <span
                                        class="align-middle" data-key="t-logout"><?=__('Đăng Xuất');?></span></a>
                                <?php else:?>
                                <a class="dropdown-item" href="<?=base_url('client/login');?>"><i
                                        class="ri-login-box-line text-muted fs-16 align-middle me-1"></i> <span
                                        class="align-middle"><?=__('Đăng Nhập');?></span></a>
                                <a class="dropdown-item" href="<?=base_url('client/register');?>"><i
                                        class="las la-user-plus text-muted fs-16 align-middle me-1"></i>
                                    <span class="align-middle"><?=__('Đăng Ký');?></span></a>
                                <?php endif?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </header>
        <!-- ========== App Menu ========== -->
        <div class="app-menu navbar-menu">
            <!-- LOGO -->
            <div class="navbar-brand-box">
                <!-- Dark Logo-->
                <a href="<?=base_url();?>" class="logo logo-dark">
                    <span class="logo-sm">
                        <img src="<?=base_url($CMSNT->site('favicon'));?>" alt="" height="22">
                    </span>
                    <span class="logo-lg">
                        <img src="<?=base_url($CMSNT->site('logo_light'));?>" alt="" height="50">
                    </span>
                </a>
                <!-- Light Logo-->
                <a href="<?=base_url();?>" class="logo logo-light">
                    <span class="logo-sm">
                        <img src="<?=base_url($CMSNT->site('favicon'));?>" alt="" height="22">
                    </span>
                    <span class="logo-lg">
                        <img src="<?=base_url($CMSNT->site('logo_dark'));?>" alt="" height="50">
                    </span>
                </a>
                <button type="button" class="btn btn-sm p-0 fs-20 header-item float-end btn-vertical-sm-hover"
                    id="vertical-hover">
                    <i class="ri-record-circle-line"></i>
                </button>
            </div>

            <div id="scrollbar">
                <div class="container-fluid">

                    <div id="two-column-menu">
                    </div>
                    <ul class="navbar-nav" id="navbar-nav">
                    <li class="menu-title" style="font-size:13px;color:white;"><span><?=__('Số dư');?>: <b style="color: yellow;"><?=format_currency(isset($getUser['money']) ? $getUser['money'] : 0);?></b><br>
                    <?=__('Giảm giá');?>: <b><?=isset($getUser['chietkhau']) ? $getUser['chietkhau'] : 0;?>%</b></span></li>

            
                        <li class="menu-title"><span><?=__('MENU');?></span></li>
                        <li class="nav-item">
                            <a class="nav-link menu-link <?=active_sidebar(['','home']);?>"
                                href="<?=base_url('client/home');?>">
                                <i class="menu-icon">
                                    <img width="100%" src="<?=base_url('assets/img/icon-house.png');?>">
                                </i> <span><?=__('Trang Chủ');?></span>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link menu-link" href="#sidebarNapTien" data-bs-toggle="collapse" role="button"
                                aria-expanded="false" aria-controls="sidebarNapTien">
                                <i class="menu-icon">
                                    <img width="100%" src="<?=base_url('assets/img/icon-payment.png');?>">
                                </i>
                                <span><?=__('Nạp Tiền');?></span>
                            </a>
                            <div class="collapse menu-dropdown <?=show_sidebar(['recharge', 'nap-the']);?>"
                                id="sidebarNapTien">
                                <ul class="nav nav-sm flex-column">
                                    <li class="nav-item">
                                        <a href="<?=base_url('client/recharge');?>"
                                            class="nav-link <?=active_sidebar(['recharge']);?>"><?=__('Ngân Hàng & Ví Điện Tử');?></a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="<?=base_url('client/nap-the');?>"
                                            class="nav-link <?=active_sidebar(['nap-the']);?>"><?=__('Nạp Thẻ Cào');?></a>
                                    </li>
                                </ul>
                            </div>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link menu-link <?=active_sidebar(['orders', 'order']);?>"
                                href="<?=base_url('client/orders');?>">
                                <i class="menu-icon">
                                    <img width="100%" src="<?=base_url('assets/img/icon-orders.png');?>">
                                </i>
                                <span><?=__('Lịch Sử Đơn Hàng');?></span>
                                <span
                                    class="badge badge-pill bg-danger"><?=format_cash(isset($getUser) ? $CMSNT->get_row("SELECT COUNT(id) FROM `orders` WHERE `status` = 0 OR `status` = 3 AND `buyer` = '".$getUser['id']."' ORDER BY ID DESC ")['COUNT(id)'] : 0);?></span>
                            </a>
                        </li>
                        <!-- <li class="nav-item">
                            <a class="nav-link menu-link <?=active_sidebar(['api']);?>"
                                href="<?=base_url('client/api');?>">
                                <i class="menu-icon">
                                    <img width="100%" src="<?=base_url('assets/img/icon-api.png');?>">
                                </i>
                                <span><?=__('Tich Hợp API');?></span>
                            </a>
                        </li> -->
                        <li class="menu-title"><i class="ri-more-fill"></i> <span><?=__('DỊCH VỤ');?></span></li>
                        <?php foreach($CMSNT->get_list("SELECT * FROM `categories` WHERE `display` = 1 ORDER BY stt ASC ") as $category):?>
                        <li class="nav-item">
                            <a class="nav-link menu-link" href="#sidebarCategory<?=$category['id'];?>"
                                data-bs-toggle="collapse" role="button" aria-expanded="false"
                                aria-controls="sidebarCategory<?=$category['id'];?>">
                                <i class="menu-icon">
                                    <img width="100%" src="<?=base_url($category['icon']);?>">
                                </i>
                                <span><?=$category['name'];?></span>
                            </a>
                            <div class="collapse menu-dropdown  <?=isset($_GET['category']) && $_GET['category'] == $category['slug'] ? 'show' : '';?>"
                                id="sidebarCategory<?=$category['id'];?>">
                                <ul class="nav nav-sm flex-column">
                                    <?php foreach($CMSNT->get_list("SELECT * FROM `services` WHERE `category_id` = '".$category['id']."' AND `display` = 1 ORDER BY stt ASC ") as $service):?>
                                    <li class="nav-item">
                                        <a href="<?=base_url('client/service/'.$category['slug'].'/'.$service['slug']);?>"
                                            class="nav-link <?=isset($_GET['service']) && $_GET['service'] == $service['slug'] ? 'active' : '';?>"><?=$service['name'];?></a>
                                    </li>
                                    <?php endforeach?>
                                </ul>
                            </div>
                        </li>
                        <?php endforeach?>
                        <li class="menu-title"><i class="ri-more-fill"></i> <span><?=__('KHÁC');?></span></li>
                        <?php foreach($CMSNT->get_list("SELECT * FROM `menu` WHERE `status` = 1 ORDER BY stt ASC ") as $menu):?>
                        <?php if($menu['menu_id'] == 0 && $CMSNT->get_row("SELECT COUNT(id) FROM `menu` WHERE `menu_id` = '".$menu['id']."' ")['COUNT(id)'] == 0):?>
                            <li class="nav-item">
                            <a class="nav-link menu-link" <?=$menu['target'] == '_blank' ? "target='_blank'" : "";?>
                                href="<?=$menu['href'];?>">
                                <i class="menu-icon">
                                    <img width="100%" src="<?=base_url($menu['icon']);?>">
                                </i>
                                <span><?=__($menu['name']);?></span>
                            </a>
                        </li>
                        <?php elseif($menu['menu_id'] == 0 && $CMSNT->get_row("SELECT COUNT(id) FROM `menu` WHERE `menu_id` = '".$menu['id']."' ")['COUNT(id)'] != 0):?>
                        <li class="nav-item">
                            <a class="nav-link menu-link" href="#sidebarMenu<?=$menu['id'];?>" 
                                data-bs-toggle="collapse" role="button" aria-expanded="false" <?=$menu['target'] == '_blank' ? "target='_blank'" : "";?>
                                aria-controls="sidebarMenu<?=$menu['id'];?>">
                                <i class="menu-icon">
                                    <img width="100%" src="<?=base_url($menu['icon']);?>">
                                </i>
                                <span><?=$menu['name'];?></span>
                            </a>
                            <div class="collapse menu-dropdown"
                                id="sidebarMenu<?=$menu['id'];?>">
                                <ul class="nav nav-sm flex-column">
                                    <?php foreach($CMSNT->get_list("SELECT * FROM `menu` WHERE `menu_id` = '".$menu['id']."' AND `status` = 1 ORDER BY stt ASC ") as $menu1):?>
                                    <li class="nav-item">
                                        <a href="<?=$menu1['href'];?>" <?=$menu1['target'] == '_blank' ? "target='_blank'" : "";?>
                                            class="nav-link menu-link"><?=$menu1['name'];?></a>
                                    </li>
                                    <?php endforeach?>
                                </ul>
                            </div>
                        </li>
                        <?php endif?>
                        <?php endforeach?>
                    </ul>
                </div>
                <!-- Sidebar -->
            </div>
        </div>
        <!-- Left Sidebar End -->