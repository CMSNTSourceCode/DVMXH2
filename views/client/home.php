<?php if (!defined('IN_SITE')) {
    die('The Request Not Found');
}
$body = [
    'title' => __('Home').' | '.$CMSNT->site('title'),
    'desc'   => $CMSNT->site('description'),
    'keyword' => $CMSNT->site('keywords')
];
$body['header'] = '';
$body['footer'] = '';

if($CMSNT->site('sign_view_product') == 0){
    if (isset($_COOKIE["token"])) {
        $getUser = $CMSNT->get_row(" SELECT * FROM `users` WHERE `token` = '".check_string($_COOKIE['token'])."' ");
        if (!$getUser) {
            header("location: ".BASE_URL('client/logout'));
            exit();
        }
        $_SESSION['login'] = $getUser['token'];
    }
    if (isset($_SESSION['login'])) {
        require_once(__DIR__.'/../../models/is_user.php');
    }
}else{
    require_once(__DIR__.'/../../models/is_user.php');
}


require_once(__DIR__.'/header.php');
require_once(__DIR__.'/sidebar.php');
?>

<!-- Vertical Overlay-->
<div class="vertical-overlay"></div>

<!-- ============================================================== -->
<!-- Start right Content here -->
<!-- ============================================================== -->
<div class="main-content">

    <div class="page-content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-lg-12">
                    <div class="card rounded-0 bg-soft-success border-top">
                        <div class="px-4">
                            <div class="row">
                                <div class="col-xxl-5 align-self-center">
                                    <div class="py-4">
                                        <h4 class="display-6 coming-soon-text">Xin chào
                                            <?=isset($getUser) ? $getUser['username'] : __('Khách');?>!</h4>
                                        <p class="text-success fs-15 mt-3"><?=$CMSNT->site('notice_home');?></p>
                                        <div class="hstack flex-wrap gap-2">
                                            <?php if(!isset($getUser)):?>
                                            <a type="button" href="<?=base_url('client/login');?>"
                                                class="btn btn-danger btn-label waves-effect waves-light"><i
                                                    class="las la-user label-icon align-middle fs-16 me-2"></i>
                                                <?=__('ĐĂNG NHẬP');?></a>
                                            <a type="button" href="<?=base_url('client/register');?>"
                                                class="btn btn-info btn-label waves-effect waves-light"><i
                                                    class="ri-user-add-line label-icon align-middle fs-16 me-2"></i>
                                                <?=__('ĐĂNG KÝ');?></a>
                                            <?php endif?>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xxl-3 ms-auto">
                                    <div class="mb-n5 pb-1 faq-img d-none d-xxl-block">
                                        <img src="<?=base_url('public/themesbrand/');?>images/faq-img.png" alt=""
                                            class="img-fluid">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- end card body -->
                    </div>
                    <!-- end card -->

                    <div class="row justify-content-evenly">
                        <?php foreach($CMSNT->get_list("SELECT * FROM `categories` WHERE `display` = 1 ORDER BY stt ASC ") as $category):?>
                        <div class="col-lg-4 mb-3">
                            <div class="mt-3">
                                <div class="d-flex align-items-center mb-3">
                                    <div class="flex-shrink-0 me-1">
                                        <i class="menu-icon me-1">
                                            <img width="100%" src="<?=base_url($category['icon']);?>">
                                        </i>
                                    </div>
                                    <div class="flex-grow-1">
                                        <h5 class="fs-16 mb-0 fw-semibold"><?=$category['name'];?></h5>
                                    </div>
                                </div>
                                <div class="accordion accordion-border-box" id="genques-accordion<?=$category['id'];?>">
                                    <?php foreach($CMSNT->get_list("SELECT * FROM `services` WHERE `category_id` = '".$category['id']."' AND `display` = 1 ORDER BY stt ASC ") as $service):?>
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="genques-headingTwo<?=$service['id'];?>">
                                            <button class="accordion-button collapsed" type="button"
                                                data-bs-toggle="collapse"
                                                data-bs-target="#genques-<?=$service['id'];?>" aria-expanded="false"
                                                aria-controls="genques-<?=$service['id'];?>">
                                                <i class="menu-icon">
                                                    <img width="100%" src="<?=base_url($service['icon']);?>">
                                                </i> <?=$service['name'];?>
                                            </button>
                                        </h2>
                                        <div id="genques-<?=$service['id'];?>" class="accordion-collapse collapse"
                                            aria-labelledby="genques-headingTwo<?=$service['id'];?>" data-bs-parent="#genques-accordion<?=$category['id'];?>">
                                            <div class="accordion-body p-2">
                                                <div class="list-group list-group-fill-success">
                                                <?php foreach($CMSNT->get_list("SELECT * FROM `service_packs` WHERE `service_id` = '".$service['id']."' AND `display` = 1 ORDER BY stt ASC ") as $pack):?>
                                                    <a href="<?=base_url('client/service/'.$category['slug'].'/'.$service['slug']);?>" class="list-group-item list-group-item-action"><i
                                                            class="bx bxs-send align-middle me-2"></i><?=$pack['name'];?> <span class="badge badge-label bg-primary"><?=__('Giá');?>
                                                    <?=$pack['price'];?>đ</span></a>
                                                        <?php endforeach?>
     
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php endforeach?>
                                </div>
                            </div>
                        </div>
                        <?php endforeach?>
                    </div>
                </div>
                <!--end col-->
            </div>
            <!--end row-->

        </div>
        <!-- container-fluid -->
    </div>
    <!-- End Page-content -->


    <?php require_once(__DIR__.'/footer.php');?>

    <script>
    var tour = new Shepherd.Tour({
        defaultStepOptions: {
            cancelIcon: {
                enabled: !0
            },
            classes: "shadow-md bg-purple-dark",
            scrollTo: {
                behavior: "smooth",
                block: "center"
            }
        },
        useModalOverlay: {
            enabled: !0
        }
    });
    document.querySelector("#logo-tour") && tour.addStep({
        title: "Welcome Back !",
        text: "This is Step 1",
        attachTo: {
            element: "#logo-tour",
            on: "bottom"
        },
        buttons: [{
            text: "Next",
            classes: "btn btn-success",
            action: tour.next
        }]
    }), document.querySelector("#register-tour") && tour.addStep({
        title: "Register your account",
        text: "Get your Free Velzon account now.",
        attachTo: {
            element: "#register-tour",
            on: "bottom"
        },
        buttons: [{
            text: "Back",
            classes: "btn btn-light",
            action: tour.back
        }, {
            text: "Next",
            classes: "btn btn-success",
            action: tour.next
        }]
    }), document.querySelector("#login-tour") && tour.addStep({
        title: "Login your account",
        text: "Sign in to continue to Velzon.",
        attachTo: {
            element: "#login-tour",
            on: "bottom"
        },
        buttons: [{
            text: "Back",
            classes: "btn btn-light",
            action: tour.back
        }, {
            text: "Next",
            classes: "btn btn-success",
            action: tour.next
        }]
    }), document.querySelector("#getproduct-tour") && tour.addStep({
        title: "Get yout Product",
        text: "Sign in to continue to Velzon.",
        attachTo: {
            element: "#getproduct-tour",
            on: "bottom"
        },
        buttons: [{
            text: "Back",
            classes: "btn btn-light",
            action: tour.back
        }, {
            text: "Next",
            classes: "btn btn-success",
            action: tour.next
        }]
    }), document.querySelector("#thankyou-tour") && tour.addStep({
        title: "Thank you !",
        text: "Sign in to continue to Velzon.",
        attachTo: {
            element: "#thankyou-tour",
            on: "bottom"
        },
        buttons: [{
            text: "Back",
            classes: "btn btn-light",
            action: tour.back
        }, {
            text: "Thank you !",
            classes: "btn btn-primary",
            action: tour.complete
        }]
    }), tour.start();
    </script>