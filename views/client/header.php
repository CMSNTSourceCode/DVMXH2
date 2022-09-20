<?php if (!defined('IN_SITE')) {
    die('The Request Not Found');
}?>
<!doctype html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-layout-style="default" data-sidebar-size="lg">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="canonical" href="<?=url();?>" />
    <title><?=isset($body['title']) ? $body['title'] : $CMSNT->site('title');?></title>
    <meta name="description" content="<?=isset($body['desc']) ? $body['desc'] : $CMSNT->site('desc');?>" />
    <meta name="keywords" content="<?=isset($body['keyword']) ? $body['keyword'] : $CMSNT->site('keyword');?>">
    <meta name="copyright" content="<?=$CMSNT->site('author');?>" />
    <meta name="author" content="<?=$CMSNT->site('author');?>" />
    <meta property="og:url" content="<?=base_url('');?>">
    <meta property="og:site_name" content="<?=base_url();?>" />
    <meta property="og:title" content="<?=$body['title'];?>" />
    <meta property="og:type" content="website" />
    <meta property="og:image"
        content="<?=isset($body['image']) ? $body['image'] : BASE_URL($CMSNT->site('image'));?>" />
    <meta property="og:image:secure"
        content="<?=isset($body['image']) ? $body['image'] : BASE_URL($CMSNT->site('image'));?>" />
    <meta name="twitter:title" content="<?=$body['title'];?>" />
    <meta name="twitter:image"
        content="<?=isset($body['image']) ? $body['image'] : BASE_URL($CMSNT->site('image'));?>" />
    <meta name="twitter:image:alt" content="<?=$body['title'];?>" />
    <link rel="icon" type="image/png" href="<?=BASE_URL($CMSNT->site('favicon'));?>" />
    <!-- Cute Alert -->
    <link class="main-stylesheet" href="<?=BASE_URL('public/');?>cute-alert/style.css" rel="stylesheet" type="text/css">
    <script src="<?=BASE_URL('public/');?>cute-alert/cute-alert.js"></script>
    <!-- jQuery -->
    <script src="<?=base_url('public/js/jquery-3.6.0.js');?>"></script>
    <!-- Layout config Js -->
    <script src="<?=base_url('public/themesbrand/');?>js/layout.js"></script>
    <!-- Bootstrap Css -->
    <link href="<?=base_url('public/themesbrand/');?>css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="<?=base_url('public/themesbrand/');?>css/icons.min.css" rel="stylesheet" type="text/css" />
    <!-- Sweet Alert css-->
    <link href="<?=base_url('public/themesbrand/');?>libs/sweetalert2/sweetalert2.min.css" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="<?=base_url('public/themesbrand/');?>css/app.min.css" rel="stylesheet" type="text/css" />
    <!-- custom Css-->
    <link href="<?=base_url('public/themesbrand/');?>css/custom.min.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"
        integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <?=$CMSNT->site('javascript_header');?>
    <?=$body['header'];?>

</head>
<style>
html,
body {
    cursor: url("<?=base_url('assets/img/');?>mouse.png"), progress;
}

a:hover {
    cursor: url("<?=base_url('assets/img/');?>mouse1.png"), progress;
}

.btn:hover {
    cursor: url("<?=base_url('assets/img/');?>mouse1.png"), progress;
}
body{
    <?=$CMSNT->site('font_family');?>
}
.ribbon-box .ribbon-primary {
    background: <?=$CMSNT->site('theme_color');?>;
}
.ribbon-box .ribbon-primary.ribbon-shape::after {
    border-left-color: <?=$CMSNT->site('theme_color');?>;
    border-bottom-color: <?=$CMSNT->site('theme_color');?>;
}
.ribbon-box .ribbon-primary.ribbon-shape::before {
    border-left-color: <?=$CMSNT->site('theme_color');?>;
    border-top-color: <?=$CMSNT->site('theme_color');?>;
}
[data-layout=vertical][data-sidebar=dark] .navbar-menu {

    background: linear-gradient(<?=$CMSNT->site('theme_color'); ?>, <?=$CMSNT->site('theme_color'); ?>, <?=$CMSNT->site('theme_color2'); ?>);
    border-right: <?=$CMSNT->site('theme_color'); ?>;
}
[data-layout=vertical][data-sidebar=dark] .navbar-nav .nav-link {
    color: #dfdfdf;
}
[data-layout=vertical][data-sidebar=dark] .menu-title {
    color: #838fb9;
}
[data-layout=vertical][data-sidebar=dark] .navbar-nav .nav-sm .nav-link {
    color: #c0c0c0;
}
[data-topbar=dark] #page-topbar {
    background-color: <?=$CMSNT->site('theme_color'); ?>;
    border-color: white;
}
[data-topbar=dark] .topbar-user {
    background-color: <?=$CMSNT->site('theme_color'); ?>;
}
.navbar-menu .navbar-nav .nav-link {
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    -webkit-box-align: center;
    -ms-flex-align: center;
    align-items: center;
    padding: 0.625rem 1.5rem;
    color: var(--vz-vertical-menu-item-color);
    font-size: 16px;
    <?=$CMSNT->site('font_family');?>
}
.navbar-menu .navbar-nav .nav-sm .nav-link {
    padding: 0.55rem 1.5rem!important;
    color: var(--vz-vertical-menu-sub-item-color);
    white-space:pre-line;
    position: relative;
    font-size: .813rem;
    <?=$CMSNT->site('font_family');?>
}
.menu-icon {
    font-size: 16px;
    line-height: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    width: 28px;
    transition: transform 0.5s;
    margin-right: 10px;
    color: #6d8bb0;
}
</style>