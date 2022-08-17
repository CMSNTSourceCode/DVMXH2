<?php if (!defined('IN_SITE')) {
    die('The Request Not Found');
}
$body = [
    'title' => 'Đăng nhập trang quản trị',
    'desc'   => 'CMSNT.CO - Hệ thống quản trị website',
    'keyword' => ''
];
$body['header'] = '
<link rel="stylesheet" href="'.base_url('public/css/LoginAdmin.css').'">
';
$body['footer'] = '';
require_once(__DIR__.'/header.php');
?>

<div class="background-wrap">
    <div class="background"></div>
</div>
<form id="accesspanel" action="" method="post">
    <h1 id="litheader">CMSNT.CO</h1>
    <div class="inset">
        <p>
            <input type="text" name="email" value="<?=$CMSNT->site('status_demo') == 1 ? 'admin@cmsnt.co' : '';?>" id="email" placeholder="Email">
        </p>
        <p>
            <input type="password" name="password" value="<?=$CMSNT->site('status_demo') == 1 ? 'admin' : '';?>" id="password" placeholder="Password">
        </p>
        <?php
        use Gregwar\Captcha\CaptchaBuilder;

        $builder = new CaptchaBuilder();
        if ($CMSNT->site('status_captcha') == 1) {
            $builder->build();
            $_SESSION['phrase'] = $builder->getPhrase(); ?>
        <p>
            <img width="100%" src="<?php echo $builder->inline(); ?>" />
        </p>
        <p>
            <input type="text" id="phrase" placeholder="<?=__('Vui lòng nhập mã captcha để xác minh'); ?>">
        </p>
        <?php
        }?>
        <div style="text-align: center;">
            <label>Vui lòng đăng nhập</label>
        </div>
    </div>
    <p class="p-container">
        <button class="btn-login" type="button" name="btnLogin" id="btnLogin">Login</button>
    </p>
</form>
<script type="text/javascript">
$("#btnLogin").on("click", function() {
    $('#btnLogin').html('<i class="fa fa-spinner fa-spin"></i> Loading...').prop('disabled',
        true);
    $.ajax({
        url: "<?=base_url('ajaxs/admin/auth.php');?>",
        method: "POST",
        dataType: "JSON",
        data: {
            action: 'Login',
            email: $("#email").val(),
            password: $("#password").val(),
            phrase: $("#phrase").val()
        },
        success: function(respone) {
            if (respone.status == 'success') {
                cuteToast({
                    type: "success",
                    message: respone.msg,
                    timer: 5000
                });
                setTimeout("location.href = '<?=BASE_URL('admin/');?>';", 100);
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
            $('#btnLogin').html('Login').prop('disabled', false);
        },
        error: function() {
            $('#btnLogin').html('Login').prop('disabled', false);
            cuteToast({
                type: "error",
                message: 'Không thể xử lý',
                timer: 5000
            });
        }

    });
});
</script>