<?php if (!defined('IN_SITE')) {
    die('The Request Not Found');
}
$body = [
    'title' => __('Đăng Nhập').' | '.$CMSNT->site('title'),
    'desc'   => $CMSNT->site('description'),
    'keyword' => $CMSNT->site('keywords')
];
$body['header'] = '

';
$body['footer'] = '

';
require_once(__DIR__.'/header.php');
?>

<body>
    <div class="auth-page-wrapper pt-5">
        <!-- auth page bg -->
        <div class="auth-one-bg-position auth-one-bg"
            style="background-image: url(<?=base_url($CMSNT->site('bg_login'));?>)" id="auth-particles">
            <div class="bg-overlay"></div>

            <div class="shape">
                <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink"
                    viewBox="0 0 1440 120">
                    <path d="M 0,36 C 144,53.6 432,123.2 720,124 C 1008,124.8 1296,56.8 1440,40L1440 140L0 140z"></path>
                </svg>
            </div>
        </div>
        <!-- auth page content -->
        <div class="auth-page-content">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="text-center mt-sm-5 mb-4 text-white-50">
                            <div>
                                <a href="<?=base_url();?>" class="d-inline-block auth-logo">
                                    <img src="<?=base_url($CMSNT->site('logo_dark'));?>" alt="" height="100">
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end row -->
                <div class="row justify-content-center">
                    <div class="col-md-8 col-lg-6 col-xl-5">
                        <div class="card mt-4">

                            <div class="card-body p-4">
                                <div class="text-center mt-2">
                                    <h5 class="text-primary"><?=__('Chào Mừng Quay Lại !');?></h5>
                                    <p class="text-muted"><?=__('Vui lòng đăng nhập để tiếp tục.');?></p>
                                </div>
                                <div class="p-2 mt-4">
                                    <form action="">
                                        <div class="mb-3">
                                            <label for="username" class="form-label"><?=__('Tên đăng nhập');?></label>
                                            <input type="text" class="form-control" id="username" value="<?=$CMSNT->site('status_demo') == 1 ? 'admin' : '';?>"
                                                placeholder="<?=__('Vui lòng nhập tên đăng nhập');?>">
                                        </div>
                                        <div class="mb-3">
                                            <div class="float-end">
                                                <a href="#" class="text-muted"><?=__('Quên mật khẩu');?>?</a>
                                            </div>
                                            <label class="form-label" for="password-input"><?=__('Mật khẩu');?></label>
                                            <div class="position-relative auth-pass-inputgroup mb-3">
                                                <input type="password" class="form-control pe-5" value="<?=$CMSNT->site('status_demo') == 1 ? 'admin' : '';?>"
                                                    placeholder="<?=__('Vui lòng nhập mật khẩu');?>" id="password">
                                                <button
                                                    class="btn btn-link position-absolute end-0 top-0 text-decoration-none text-muted"
                                                    type="button" id="password-addon"><i
                                                        class="ri-eye-fill align-middle"></i></button>
                                            </div>
                                        </div>

                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value=""
                                                id="auth-remember-check">
                                            <label class="form-check-label" for="auth-remember-check"><?=__('Remember
                                                me');?></label>
                                        </div>

                                        <div class="mt-4">
                                            <button class="btn btn-success w-100" id="btnLogin"
                                                type="button"><?=__('Đăng Nhập');?></button>
                                        </div>
                                        <div class="mt-4 text-center">
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <!-- end card body -->
                        </div>
                        <!-- end card -->

                        <div class="mt-4 text-center">
                            <p class="mb-0"><?=__('Bạn chưa có tài khoản ?');?> <a
                                    href="<?=base_url('client/register');?>"
                                    class="fw-semibold text-primary text-decoration-underline"> <?=__('Đăng Ký Ngay');?>
                                </a> </p>
                        </div>

                    </div>
                </div>
                <!-- end row -->
            </div>
            <!-- end container -->
        </div>
        <!-- end auth page content -->
        <?=$CMSNT->site('javascript_footer');?>
        <!-- footer -->
        <footer class="footer">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="text-center">
                            <p class="mb-0 text-muted">&copy; <script>
                                document.write(new Date().getFullYear())
                                </script> <?=$CMSNT->site('title');?> <i class="mdi mdi-heart text-danger"></i>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
        <!-- end Footer -->
    </div>
    <!-- end auth-page-wrapper -->

    <!-- JAVASCRIPT -->
    <script src="<?=base_url('public/themesbrand/');?>libs/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="<?=base_url('public/themesbrand/');?>libs/simplebar/simplebar.min.js"></script>
    <script src="<?=base_url('public/themesbrand/');?>libs/node-waves/waves.min.js"></script>
    <script src="<?=base_url('public/themesbrand/');?>libs/feather-icons/feather.min.js"></script>
    <script src="<?=base_url('public/themesbrand/');?>js/pages/plugins/lord-icon-2.1.0.js"></script>
    <script src="<?=base_url('public/themesbrand/');?>js/plugins.js"></script>

    <!-- particles js -->
    <script src="<?=base_url('public/themesbrand/');?>libs/particles.js/particles.js"></script>
    <!-- particles app js -->
    <script src="<?=base_url('public/themesbrand/');?>js/pages/particles.app.js"></script>
    <!-- password-addon init -->
    <script src="<?=base_url('public/themesbrand/');?>js/pages/password-addon.init.js"></script>
</body>

</html>

<script type="text/javascript">
$("#btnLogin").on("click", function() {
    $('#btnLogin').html('<i class="fa fa-spinner fa-spin"></i> <?=__('Đang xử lý...');?>').prop('disabled',
        true);
    $.ajax({
        url: "<?=base_url('ajaxs/client/auth.php');?>",
        method: "POST",
        dataType: "JSON",
        data: {
            action: 'Login',
            username: $("#username").val(),
            password: $("#password").val()
        },
        success: function(respone) {
            if (respone.status == 'success') {
                cuteToast({
                    type: "success",
                    message: respone.msg,
                    timer: 5000
                });
                setTimeout("location.href = '<?=BASE_URL('');?>';", 100);
            } else if (respone.status == 'verify') {
                cuteToast({
                    type: "warning",
                    message: respone.msg,
                    timer: 5000
                });
                setTimeout("location.href = '" + respone.url + "';", 1000);
            } else {
                cuteToast({
                    type: "error",
                    message: respone.msg,
                    timer: 5000
                });
            }
            $('#btnLogin').html('<?=__('Đăng Nhập');?>').prop('disabled', false);
        },
        error: function() {
            cuteToast({
                type: "error",
                message: 'Không thể xử lý',
                timer: 5000
            });
            $('#btnLogin').html('<?=__('Đăng Nhập');?>').prop('disabled', false);
        }

    });
});
</script>