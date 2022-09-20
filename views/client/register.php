<?php if (!defined('IN_SITE')) {
    die('The Request Not Found');
}
$body = [
    'title' => __('Đăng Ký Tài Khoản').' | '.$CMSNT->site('title'),
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
            style="background-image: url(<?=base_url($CMSNT->site('bg_register'));?>)" id="auth-particles">
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
                                    <h5 class="text-primary"><?=__('Tạo Tài Khoản Mới !');?></h5>
                                    <p class="text-muted"><?=__('Đăng ký tài khoản của bạn ngay bây giờ.');?></p>
                                </div>
                                <div class="p-2 mt-4">
                                    <form class="needs-validation" novalidate action="">
                                        <div class="mb-3">
                                            <label for="useremail" class="form-label"><?=__('Địa chỉ Email');?> <span
                                                    class="text-danger">*</span></label>
                                            <input type="email" class="form-control" id="email"
                                                placeholder="<?=__('Vui lòng nhập địa chỉ Email');?>" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="username" class="form-label"><?=__('Tên đăng nhập');?> <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="username"
                                                placeholder="<?=__('Vui lòng nhập tên đăng nhập');?>" required>
                                        </div>

                                        <div class="mb-2">
                                            <label for="userpassword" class="form-label"><?=__('Mật khẩu');?> <span
                                                    class="text-danger">*</span></label>
                                            <input type="password" class="form-control" id="password"
                                                placeholder="<?=__('Vui lòng nhập mật khẩu');?>" required>
                                        </div>
                                        <div class="mb-2">
                                            <label for="userpassword" class="form-label"><?=__('Nhập lại mật khẩu');?> <span
                                                    class="text-danger">*</span></label>
                                            <input type="password" class="form-control" id="repassword"
                                                placeholder="<?=__('Vui lòng nhập lại mật khẩu');?>" required>
                                        </div>
                                        <?php
use Gregwar\Captcha\CaptchaBuilder;
$builder = new CaptchaBuilder();
if ($CMSNT->site('status_captcha') == 1) {
$builder->build();
$_SESSION['phrase'] = $builder->getPhrase(); ?>

                                        <div class="mb-2">
                                            <label for="userpassword" class="form-label"><?=__('Xác minh Captcha');?> <span
                                                    class="text-danger">*</span></label>
                                                    <img width="100%" src="<?php echo $builder->inline(); ?>" />        
                                            <input type="text" class="form-control" id="phrase"
                                                placeholder="<?=__('Vui lòng nhập mã captcha để xác minh'); ?>" required>
                                        </div>

<?php }?>
                                        <div class="mt-4">
                                            <button class="btn btn-success w-100" id="btnRegister" type="button"><?=__('Đăng Ký');?></button>
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
                            <p class="mb-0"><?=__('Bạn đã có tài khoản ?');?> <a
                                    href="<?=base_url('client/login');?>"
                                    class="fw-semibold text-primary text-decoration-underline"> <?=__('Đăng Nhập Ngay');?>
                                </a> </p>
                        </div>

                    </div>
                </div>
                <!-- end row -->
            </div>
            <!-- end container -->
        </div>
        <!-- end auth page content -->

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
    <!-- Sweet Alerts js -->
    <script src="<?=base_url('public/themesbrand/');?>libs/sweetalert2/sweetalert2.min.js"></script>
    <!-- particles js -->
    <script src="<?=base_url('public/themesbrand/');?>libs/particles.js/particles.js"></script>
    <!-- particles app js -->
    <script src="<?=base_url('public/themesbrand/');?>js/pages/particles.app.js"></script>
    <!-- password-addon init -->
    <script src="<?=base_url('public/themesbrand/');?>js/pages/password-addon.init.js"></script>
</body>

</html>




<script type="text/javascript">
$("#btnRegister").on("click", function() {
    $('#btnRegister').html('<i class="fa fa-spinner fa-spin"></i> <?=__('Đang xử lý...');?>').prop('disabled',
        true);
    $.ajax({
        url: "<?=base_url('ajaxs/client/auth.php');?>",
        method: "POST",
        dataType: "JSON",
        data: {
            action: 'Register',
            username: $("#username").val(),
            email: $("#email").val(),
            password: $("#password").val(),
            repassword: $("#repassword").val(),
            phrase: $("#phrase").val()
        },
        success: function(respone) {
            if (respone.status == 'success') {
                Swal.fire({
                    title: '<?=__('Thành công !');?>',
                    text: respone.msg,
                    icon: 'success',
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: 'OK'
                }).then((result) => {
                    if (result.isConfirmed) {
                        location.href = '<?=BASE_URL('');?>';
                    }
                });
                location.href = '<?=BASE_URL('');?>';
            } else {
                cuteToast({
                    type: "error",
                    message: respone.msg,
                    timer: 5000
                });
            }
            $('#btnRegister').html('<?=__('Đăng Ký');?>').prop('disabled', false);
        },
        error: function() {
            cuteToast({
                type: "error",
                message: 'Không thể xử lý',
                timer: 5000
            });
            $('#btnRegister').html('<?=__('Đăng Ký');?>').prop('disabled', false);
        }

    });
});
</script>