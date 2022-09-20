<?php if (!defined('IN_SITE')) {
    die('The Request Not Found');
}
$body = [
    'title' => 'Settings',
    'desc'   => 'CMSNT Panel',
    'keyword' => 'cmsnt, CMSNT, cmsnt.co,'
];
$body['header'] = '
<!-- Bootstrap Color Picker -->
<link rel="stylesheet" href="'.BASE_URL('public/AdminLTE3/').'plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css">
<!-- ckeditor -->
<script src="'.BASE_URL('public/ckeditor/ckeditor.js').'"></script>
<!-- Select2 -->
<link rel="stylesheet" href="'.BASE_URL('public/AdminLTE3/').'plugins/select2/css/select2.min.css">
<link rel="stylesheet" href="'.BASE_URL('public/AdminLTE3/').'plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
';
$body['footer'] = '
<!-- bootstrap color picker -->
<script src="'.BASE_URL('public/AdminLTE3/').'plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js"></script>
<!-- Select2 -->
<script src="'.BASE_URL('public/AdminLTE3/').'plugins/select2/js/select2.full.min.js"></script>
<script>
$(function () {
    $(".select2").select2()
    $(".select2bs4").select2({
        theme: "bootstrap4"
    });
});
</script>
';
require_once(__DIR__.'/../../models/is_admin.php');
require_once(__DIR__.'/header.php');
require_once(__DIR__.'/sidebar.php');
require_once(__DIR__.'/nav.php');
require_once(__DIR__.'/../../models/is_license.php');
?>



<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Settings</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?=base_url_admin('home');?>">Dashboard</a></li>
                        <li class="breadcrumb-item active">Settings</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    <?php
    if (isset($_POST['SaveSettings'])) {
        if ($CMSNT->site('status_demo') != 0) {
            die('<script type="text/javascript">if(!alert("Không được dùng chức năng này vì đây là trang web demo.")){window.history.back().location.reload();}</script>');
        }
        foreach ($_POST as $key => $value) {
            $CMSNT->update("settings", array(
                'value' => $value
            ), " `name` = '$key' ");
        }
        die('<script type="text/javascript">if(!alert("Lưu thành công !")){window.history.back().location.reload();}</script>');
    } ?>
    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <section class="col-lg-12">
                    <div class="card card-dark card-tabs">
                        <div class="card-header p-0 pt-1 border-bottom-0">
                            <ul class="nav nav-tabs" id="custom-tabs-three-tab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" data-toggle="pill"
                                        href="#custom-tabs-three-home" role="tab" aria-controls="custom-tabs-three-home"
                                        aria-selected="true">THÔNG TIN CHUNG</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="pill"
                                        href="#tab-notification" role="tab"
                                        aria-controls="tab-notification" aria-selected="false">THÔNG BÁO</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="pill"
                                        href="#tab-auto-bank" role="tab"
                                        aria-controls="tab-auto-bank" aria-selected="false">BANK AUTO</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="pill"
                                        href="#tab-auto-momo" role="tab" aria-controls="tab-auto-bank"
                                        aria-selected="false">MOMO AUTO</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="pill"
                                        href="#tab-nap-the" role="tab" aria-controls="tab-nap-the"
                                        aria-selected="false">NẠP THẺ AUTO</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="pill"
                                        href="#tab-paypal" role="tab" aria-controls="tab-paypal"
                                        aria-selected="false">PAYPAL AUTO</a>
                                </li>
                            </ul>
                        </div>
                        <div class="card-body">
                            <div class="tab-content" id="custom-tabs-three-tabContent">
                                <div class="tab-pane fade show active" id="custom-tabs-three-home" role="tabpanel"
                                    aria-labelledby="custom-tabs-three-home-tab">
                                    <form action="" method="POST">
                                        <div class="row">
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label for="exampleInputEmail1">Title</label>
                                                    <input type="text" class="form-control" name="title"
                                                        value="<?=$CMSNT->site('title');?>" placeholder="VD: CMSNT.CO">
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label for="exampleInputEmail1">Description</label>
                                                    <input type="text" class="form-control" name="description"
                                                        value="<?=$CMSNT->site('description');?>"
                                                        placeholder="VD: Hệ thống bán mã nguồn website MMO uy tín">
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label>Keywords</label>
                                                    <input type="text" class="form-control" name="keywords"
                                                        value="<?=$CMSNT->site('keywords');?>"
                                                        placeholder="VD: cmsnt, bán code, source code mmo">
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label for="exampleInputEmail1">Author</label>
                                                    <input type="text" class="form-control" name="author"
                                                        value="<?=$CMSNT->site('author');?>" placeholder="VD: CMSNT">
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label for="exampleInputEmail1">Copyright</label>
                                                    <textarea class="form-control" name="copyright"><?=$CMSNT->site('copyright');?></textarea>
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label>Màu chủ đạo website:</label>
                                                    <div class="input-group my-colorpicker2">
                                                        <input type="text" name="theme_color"
                                                            value="<?=$CMSNT->site('theme_color');?>"
                                                            class="form-control">
                                                        <div class="input-group-append">
                                                            <span class="input-group-text"><i
                                                                    class="fas fa-square"></i></span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label>Màu phụ website:</label>
                                                    <div class="input-group my-colorpicker1">
                                                        <input type="text" name="theme_color2"
                                                            value="<?=$CMSNT->site('theme_color2');?>"
                                                            class="form-control">
                                                        <div class="input-group-append">
                                                            <span class="input-group-text"><i
                                                                    class="fas fa-square"></i></span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label>Status</label>
                                                    <select class="form-control select2bs4" name="status">
                                                        <option <?=$CMSNT->site('status') == 1 ? 'selected' : '';?>
                                                            value="1">ON
                                                        </option>
                                                        <option <?=$CMSNT->site('status') == 0 ? 'selected' : '';?>
                                                            value="0">
                                                            OFF
                                                        </option>
                                                    </select>
                                                    <i>Chọn OFF website sẽ bật chế độ bảo trì, ADMIN truy cập bình
                                                        thường.</i>
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label>Status Update</label>
                                                    <select class="form-control select2bs4" name="status_update">
                                                        <option
                                                            <?=$CMSNT->site('status_update') == 1 ? 'selected' : '';?>
                                                            value="1">ON
                                                        </option>
                                                        <option
                                                            <?=$CMSNT->site('status_update') == 0 ? 'selected' : '';?>
                                                            value="0">
                                                            OFF
                                                        </option>
                                                    </select>
                                                    <i>Chọn OFF website sẽ tắt chế độ cập nhật phiên bản tự động</i>
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label>Status Captcha</label>
                                                    <select class="form-control select2bs4" name="status_captcha">
                                                        <option
                                                            <?=$CMSNT->site('status_captcha') == 1 ? 'selected' : '';?>
                                                            value="1">ON
                                                        </option>
                                                        <option
                                                            <?=$CMSNT->site('status_captcha') == 0 ? 'selected' : '';?>
                                                            value="0">
                                                            OFF
                                                        </option>
                                                    </select>
                                                    <i>Chọn OFF website sẽ tắt Captcha chống SPAM</i>
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label for="exampleInputEmail1">Thời gian lưu phiên đăng
                                                        nhập</label>
                                                    <input type="number" class="form-control" name="session_login"
                                                        value="<?=$CMSNT->site('session_login');?>"
                                                        placeholder="Nhập thời gian lưu phiên đăng nhập">
                                                    <i>Tính bằng giây (<?=$CMSNT->site('session_login');?> =
                                                        <?=timeAgo2($CMSNT->site('session_login'));?>)</i>
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label>ON/OFF Login Trước Khi Xem Website</label>
                                                    <select class="form-control select2bs4" name="sign_view_product">
                                                        <option
                                                            <?=$CMSNT->site('sign_view_product') == 1 ? 'selected' : '';?>
                                                            value="1">ON</option>
                                                        <option
                                                            <?=$CMSNT->site('sign_view_product') == 0 ? 'selected' : '';?>
                                                            value="0">OFF</option>
                                                    </select>
                                                    <i>Nếu bạn chọn ON, khách sẽ phải đăng nhập vào mới có thể xem được
                                                        dịch vụ của bạn.</i>
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label for="exampleInputEmail1">Font Family</label>
                                                    <input type="text" class="form-control" name="font_family"
                                                        value="<?=$CMSNT->site('font_family');?>">
                                                    <i><a type="button" data-toggle="modal"
                                                            data-target="#modal-hd-font-family" href="#">Hướng dẫn</a>
                                                        thay font website</i>
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label>ON/OFF Theme Customizer</label>
                                                    <select class="form-control select2bs4" name="display_customizer_theme">
                                                        <option
                                                            <?=$CMSNT->site('display_customizer_theme') == 1 ? 'selected' : '';?>
                                                            value="1">ON</option>
                                                        <option
                                                            <?=$CMSNT->site('display_customizer_theme') == 0 ? 'selected' : '';?>
                                                            value="0">OFF</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-lg-12">
                                            </div> 
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label>Script Header</label>
                                                    <textarea id="codeMirrorDemo"
                                                        placeholder="Chứa code live chat hoặc jquery trang trí..."
                                                        name="javascript_header"><?=$CMSNT->site('javascript_header');?></textarea>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label>Script Footer</label>
                                                    <textarea id="codeMirrorDemo2"
                                                        placeholder="Chứa code live chat hoặc jquery trang trí..."
                                                        name="javascript_footer"><?=$CMSNT->site('javascript_footer');?></textarea>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label for="exampleInputEmail1">Thông báo ngoài trang chủ</label>
                                                    <textarea id="notice_home" name="notice_home"><?=$CMSNT->site('notice_home');?></textarea>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label for="exampleInputEmail1">Thông báo nổi ngoài trang chủ</label>
                                                    <textarea class="form-control" rows="6" name="popup_noti"><?=$CMSNT->site('popup_noti');?></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <button name="SaveSettings" class="btn btn-info btn-icon-left m-b-10"
                                            type="submit"><i class="fas fa-save mr-1"></i>Lưu Ngay</button>
                                    </form>
                                </div>
                                <div class="tab-pane fade" id="tab-notification" role="tabpanel"
                                    aria-labelledby="tab-notification">
                                    <form action="" method="POST">
                                        <div class="form-group">
                                            <label>Loại thông báo</label>
                                            <select class="form-control select2bs4" name="type_notification">
                                                <option <?=$CMSNT->site('type_notification') == 'telegram' ? 'selected' : '';?>
                                                    value="telegram">Telegram
                                                </option>
                                                <option <?=$CMSNT->site('type_notification') == 'gmail' ? 'selected' : '';?>
                                                    value="gmail">Gmail
                                                </option>
                                            </select>
                                            <i>Hệ thống sẽ gửi thông báo khi có đơn hàng mới.</i>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Token Telegram (<a target="_blank" href="https://cmsnt.vn/2022/05/huong-dan-cau-hinh-bot-thong-bao-qua-telegram/">Xem
                                                    hướng dẫn</a>)</label>
                                            <input type="text" class="form-control" name="token_telegram"
                                                value="<?=$CMSNT->site('token_telegram');?>"
                                                placeholder="5323330732:AAFpurxAdW9vGGPE_cZ2gU_kDP-__kAsOVc">
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Chat ID Telegram (<a target="_blank" href="https://cmsnt.vn/2022/05/huong-dan-cau-hinh-bot-thong-bao-qua-telegram/">Xem
                                                    hướng dẫn</a>)</label>
                                            <input type="text" class="form-control" name="chat_id_telegram"
                                                value="<?=$CMSNT->site('chat_id_telegram');?>"
                                                placeholder="-788267800">
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Nội dung thông báo</label>
                                            <textarea name="text_notification" class="form-control"><?=$CMSNT->site('text_notification');?></textarea>
                                            <ul>
                                                <li><b>{domain}</b> => Tên website của quý khách.</li>
                                                <li><b>{username}</b> => Tên đăng nhập của khách.</li>
                                                <li><b>{service_name}</b> => Tên dịch vụ khách hàng mua.</li>
                                                <li><b>{service_pack_name}</b> => Tên gói dịch vụ khách hàng mua.</li>
                                                <li><b>{amount}</b> => Số lượng khách hàng mua.</li>
                                                <li><b>{price}</b> => Số tiền khách hàng thanh toán.</li>
                                                <li><b>{url}</b> => Link/ID cần tăng.</li>
                                                <li><b>{note}</b> => Ghi chú của khách hàng.</li>
                                            </ul>
                                        </div>
                                        <button name="SaveSettings" class="btn btn-info btn-icon-left btn-block m-b-10"
                                            type="submit"><i class="fas fa-save mr-1"></i>Lưu Ngay</button>
                                    </form>
                                </div>
                                <div class="tab-pane fade" id="tab-auto-bank" role="tabpanel"
                                    aria-labelledby="tab-auto-bank-tab">
                                    <form action="" method="POST">
                                        <div class="form-group">
                                            <label>Status</label>
                                            <select class="form-control select2bs4" name="status_bank">
                                                <option <?=$CMSNT->site('status_bank') == 0 ? 'selected' : '';?>
                                                    value="0">OFF
                                                </option>
                                                <option <?=$CMSNT->site('status_bank') == 1 ? 'selected' : '';?>
                                                    value="1">ON
                                                </option>
                                            </select>
                                            <i>Chọn OFF hệ thống sẽ tạm dừng auto bank.</i>
                                        </div>
                                        <div class="form-group">
                                            <label>Ngân hàng</label>
                                            <select class="form-control select2bs4" name="type_bank">
                                                <?php foreach ($config_listbank as $bank) {?>
                                                <option <?=$CMSNT->site('type_bank') == $bank ? 'selected' : '';?>
                                                    value="<?=$bank;?>"><?=$bank;?>
                                                </option>
                                                <?php }?>
                                            </select>
                                            <i>Chọn ngân hàng bạn cần sử dụng auto.</i>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Token Bank (<a type="button"
                                                    data-toggle="modal" data-target="#modal-hd-auto-bank" href="#">Xem
                                                    hướng dẫn</a>)</label>
                                            <input type="text" class="form-control" name="token_bank"
                                                value="<?=$CMSNT->site('token_bank');?>"
                                                placeholder="Nhập token ngân hàng">
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Số tài khoản (<a type="button"
                                                    data-toggle="modal" data-target="#modal-hd-auto-bank" href="#">Xem
                                                    hướng dẫn</a>)</label>
                                            <input type="text" class="form-control" name="stk_bank"
                                                value="<?=$CMSNT->site('stk_bank');?>"
                                                placeholder="Nhập số tài khoản ngân hàng cần Auto">
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Mật khẩu Internet Banking (<a type="button"
                                                    data-toggle="modal" data-target="#modal-hd-auto-bank" href="#">Xem
                                                    hướng dẫn</a>)</label>
                                            <input type="text" class="form-control" name="mk_bank"
                                                value="<?=$CMSNT->site('mk_bank');?>"
                                                placeholder="Nhập mật khẩu internet banking">
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Nội dung nạp</label>
                                            <input type="text" class="form-control" name="prefix_autobank"
                                                value="<?=$CMSNT->site('prefix_autobank');?>"
                                                placeholder="Tiền tố nội dung nạp tiền">
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Ghi chú nạp tiền</label>
                                            <textarea id="recharge_notice"
                                                name="recharge_notice"><?=$CMSNT->site('recharge_notice');?></textarea>
                                        </div>
                                        <button name="SaveSettings" class="btn btn-info btn-icon-left btn-block m-b-10"
                                            type="submit"><i class="fas fa-save mr-1"></i>Lưu Ngay</button>
                                    </form>
                                </div>
                                <div class="tab-pane fade" id="tab-auto-momo" role="tabpanel" aria-labelledby="tab-auto-momo">
                                    <form action="" method="POST">
                                        <div class="form-group">
                                            <label>Status</label>
                                            <select class="form-control select2bs4" name="status_momo">
                                                <option <?=$CMSNT->site('status_momo') == 0 ? 'selected' : '';?>
                                                    value="0">OFF
                                                </option>
                                                <option <?=$CMSNT->site('status_momo') == 1 ? 'selected' : '';?>
                                                    value="1">ON
                                                </option>
                                            </select>
                                            <i>Chọn OFF hệ thống sẽ tạm dừng auto momo.</i>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Token MOMO (<a type="button"
                                                    data-toggle="modal" data-target="#modal-hd-auto-momo" href="#">Xem
                                                    hướng dẫn</a>)</label>
                                            <input type="text" class="form-control" name="token_momo"
                                                value="<?=$CMSNT->site('token_momo');?>"
                                                placeholder="Nhập token ví momo">
                                        </div>
                                        <button name="SaveSettings" class="btn btn-info btn-icon-left m-b-10"
                                            type="submit"><i class="fas fa-save mr-1"></i>Lưu Ngay</button>
                                    </form>
                                </div>
                                <div class="tab-pane fade" id="tab-nap-the" role="tabpanel" aria-labelledby="tab-nap-the">
                                    <form action="" method="POST">
                                        <div class="form-group">
                                            <label>Status</label>
                                            <select class="form-control select2bs4" name="status_napthe">
                                                <option <?=$CMSNT->site('status_napthe') == 0 ? 'selected' : '';?>
                                                    value="0">OFF
                                                </option>
                                                <option <?=$CMSNT->site('status_napthe') == 1 ? 'selected' : '';?>
                                                    value="1">ON
                                                </option>
                                            </select>
                                            <i>Chọn OFF hệ thống sẽ tạm dừng nạp thẻ.</i>
                                        </div>
                                        <div class="form-group">
                                            <label>Partner ID (<a type="button" data-toggle="modal"
                                                    data-target="#modal-hd-nap-the" href="#">Xem hướng dẫn</a>)</label>
                                            <input type="text" name="partner_id_card"
                                                value="<?=$CMSNT->site('partner_id_card');?>" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label>Partner Key (<a type="button" data-toggle="modal"
                                                    data-target="#modal-hd-nap-the" href="#">Xem hướng dẫn</a>)</label>
                                            <input type="text" name="partner_key_card"
                                                value="<?=$CMSNT->site('partner_key_card');?>" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Phí Nạp Thẻ</label>
                                            <input type="text" class="form-control" name="ck_napthe"
                                                value="<?=$CMSNT->site('ck_napthe');?>"
                                                placeholder="Nhập phí nạp thẻ nếu có nạp thẻ">
                                            <i>Để <?=$CMSNT->site('ck_napthe');?> tức khách nạp 100.000đ sẽ được
                                                <?=format_currency(100000 - 100000 * $CMSNT->site('ck_napthe') / 100);?></i><br>
                                            <i>Để phí = 0 nếu quý khách muốn cộng cho user giống thực nhận tại hệ thống
                                                card24h.com</i>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Ghi chú nạp thẻ</label>
                                            <textarea id="notice_napthe"
                                                name="notice_napthe"><?=$CMSNT->site('notice_napthe');?></textarea>
                                        </div>
                                        <button name="SaveSettings" class="btn btn-info btn-icon-left m-b-10"
                                            type="submit"><i class="fas fa-save mr-1"></i>Lưu Ngay</button>
                                    </form>
                                </div>
                                <div class="tab-pane fade" id="tab-paypal" role="tabpanel" aria-labelledby="tab-paypal">
                                    <form action="" method="POST">
                                    <div class="form-group">
                                            <label>Status</label>
                                            <select class="form-control select2bs4" name="status_paypal">
                                                <option <?=$CMSNT->site('status_paypal') == 0 ? 'selected' : '';?>
                                                    value="0">OFF
                                                </option>
                                                <option <?=$CMSNT->site('status_paypal') == 1 ? 'selected' : '';?>
                                                    value="1">ON
                                                </option>
                                            </select>
                                            <i>Chọn OFF hệ thống sẽ tạm dừng nạp paypal.</i>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Client ID</label>
                                            <input type="text" class="form-control" name="clientId_paypal"
                                                value="<?=$CMSNT->site('clientId_paypal');?>"
                                                placeholder="Nhập Client ID Paypal">
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Client Secret</label>
                                            <input type="text" class="form-control" name="clientSecret_paypal"
                                                value="<?=$CMSNT->site('clientSecret_paypal');?>"
                                                placeholder="Nhập Client Secret Paypal">
                                            <i>Cách lấy Secret và ID Paypal tại đây: <a
                                                    href="https://youtu.be/6r17Wj3UlNE?t=13" target="_blank">Xem
                                                    Ngay</a></i>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Rate Paypal</label>
                                            <input type="number" class="form-control" name="rate_paypal"
                                                value="<?=$CMSNT->site('rate_paypal');?>"
                                                placeholder="Nhập Rate quy đổi sang VND">
                                            <i>Để <?=$CMSNT->site('rate_paypal');?> tức khách nạp 1 USD sẽ được
                                                <?=format_currency($CMSNT->site('rate_paypal'));?></i>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Ghi chú nạp paypal</label>
                                            <textarea id="paypal_notice"
                                                name="paypal_notice"><?=$CMSNT->site('paypal_notice');?></textarea>
                                        </div>
                                        <button name="SaveSettings" class="btn btn-info btn-icon-left m-b-10"
                                            type="submit"><i class="fas fa-save mr-1"></i>Lưu Ngay</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-hd-nap-the">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">HƯỚNG DẪN TÍCH HỢP NẠP THẺ CÀO</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <ul>
                    <li>Bước 1: Truy cập vào <a target="_blank"
                            href="https://card24h.com/account/login">https://card24h.com/account/login</a> <b>đăng
                            ký</b> tài khoản và <b>đăng nhập</b>.</li>
                    <li>Bước 2: Truy cập vào <a target="_blank" href="https://card24h.com/merchant/list">đây</a> để tiến
                        hành tạo API mới.</li>
                    <li>Bước 3: Nhập lần lượt như sau:</li>
                    <b>Tên mô tả:</b> => <i><?=check_string($_SERVER['SERVER_NAME']);?> - SHOPCLONE6</i><br>
                    <b>Chọn ví giao dịch:</b> => <i>VND</i><br>
                    <b>Kiểu:</b> => <i>GET</i><br>
                    <b>Đường dẫn nhận dữ liệu (Callback Url):</b> => <i><?=BASE_URL('api/card.php');?></i><br>
                    <b>Địa chỉ IP (không bắt buộc):</b> => <i></i><br>
                    <li>Bước 4: Thêm thông tin kết nối và <a target="_blank" href="https://zalo.me/0947838128">inbox</a>
                        ngay cho Admin để duyệt API.</li>
                    <li>Bước 5: Copy Partner ID dán vào ô Partner ID trên hệ thống.</li>
                    <li>Bước 6: Copy Partner Key dán vào ô Partner Key trên hệ thống.</li>
                </ul>
                <h4 class="text-center">Chúc quý khách thành công <img
                        src="https://i.pinimg.com/736x/c4/2c/98/c42c983e8908fdbd6574c2135212f7e4.jpg" width="45px;">
                </h4>

            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<div class="modal fade" id="modal-hd-auto-bank">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">HƯỚNG DẪN TÍCH HỢP NẠP TIỀN TỰ ĐỘNG QUA NGÂN HÀNG</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <ul>
                    <li>Bước 1: Truy cập vào <a target="_blank"
                            href="https://api.web2m.com/Register.html?ref=113">đây</a> để <b>đăng ký</b> tài khoản và
                        <b>đăng nhập</b>.
                    </li>
                    <li>Bước 2: Chọn ngân hàng bạn muốn kết nối Auto, sau đó nhấn vào nút <b>Thêm tài khoản {tên ngân
                            hàng}</b>.</li>
                    <li>Bước 3: Nhập đầy đủ thông tin đăng nhập Internet Banking của bạn vào form để tiến hành kết nối.
                    </li>
                    <li>Bước 4: Nhấn vào <b>Lấy Token</b> sau đó check email để copy <b>Token</b> vừa lấy.</li>
                    <li>Bước 5: Dán <b>Token</b> vào ô <b>Token Bank</b> trong website của bạn.</li>
                    <li>Bước 6: Nhập số tài khoản của bạn vừa kết nối vào ô <b>Số tài khoản</b>.</li>
                    <li>Bước 7: Nhập mật khẩu Internet Banking vào ô <b>Mật khẩu Internet Banking</b> và nhấn lưu.</li>
                    <li>Bước 8: Quay lại <a target="_blank" href="https://api.web2m.com/Home/nangcap">đây</a> và tiến
                        hành gia hạn gói Bank mà bạn cần dùng để bắt đầu sử dụng Auto.</li>
                </ul>
                <p>Hướng dẫn bằng Video xem tại <a target="_blank"
                        href="https://www.youtube.com/watch?v=N8CuOJTD6l8">đây</a>.</p>
                <h4 class="text-center">Chúc quý khách thành công <img
                        src="https://i.pinimg.com/736x/c4/2c/98/c42c983e8908fdbd6574c2135212f7e4.jpg" width="45px;">
                </h4>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<div class="modal fade" id="modal-hd-auto-momo">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">HƯỚNG DẪN TÍCH HỢP NẠP TIỀN TỰ ĐỘNG QUA VÍ MOMO</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Hướng dẫn lấy Token MOMO để cài Auto.</p>
                <ul>
                    <li>Bước 1: Truy cập vào <a target="_blank"
                            href="https://api.web2m.com/Register.html?ref=113">đây</a> để <b>đăng ký</b> tài khoản và
                        <b>đăng nhập</b>.
                    </li>
                    <li>Bước 2: Chọn ngân hàng bạn muốn kết nối Auto, sau đó nhấn vào nút <b>Thêm tài khoản MoMo</b>.
                    </li>
                    <li>Bước 3: Nhập đầy đủ thông tin đăng nhập MoMo của bạn vào form để tiến hành kết nối.</li>
                    <li>Bước 4: Nhấn vào <b>Lấy Token</b> sau đó check email để copy <b>Token</b> vừa lấy.</li>
                    <li>Bước 5: Dán <b>Token</b> vào ô <b>Token MOMO</b> trong website của bạn và nhấn Lưu.</li>
                    <li>Bước 6: Quay lại <a target="_blank" href="https://api.web2m.com/Home/nangcap">đây</a> và tiến
                        hành gia hạn gói MOMO và bắt đầu sử dụng Auto.</li>
                    <li>Hướng dẫn bằng Video xem tại <a target="_blank"
                            href="https://www.youtube.com/watch?v=5WRqOmxzBPc">đây</a>.</li>
                </ul>
                <h4 class="text-center">Chúc quý khách thành công <img
                        src="https://i.pinimg.com/736x/c4/2c/98/c42c983e8908fdbd6574c2135212f7e4.jpg" width="45px;">
                </h4>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<div class="modal fade" id="modal-hd-font-family">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">HƯỚNG DẪN THAY FONT WEBSITE</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <ul>
                    <li>Bước 1: Truy cập vào <a target="_blank"
                            href="https://fonts.google.com/">https://fonts.google.com/</a> tìm và chọn FONT quý khách
                        cần thay.</li>
                    <li>Bước 2: Quý khách nhấn vào FONT quý khách chọn sau đó để ý bên tay phải màn hình có ô <b>Use on
                            the web</b>.</li>
                    <li>Bước 3: Quý khách tích vào <b>
                            < link>
                        </b> và copy toàn bộ dữ liệu trong ô.</li>
                    <li>Bước 4: Quý khách chèn dữ liệu đã copy phía trên vào ô <b>Script Header</b> trên website quý
                        khách.</li>
                    <li>Bước 5: Quý khách nhìn vào ô <b>CSS rules to specify families</b> - Copy 1 dòng
                        <b>font-family</b> quý khách muốn chọn và dán vào ô trên (không bắt buộc thao tác này, tuỳ nhu
                        cầu).
                    </li>
                </ul>
                <h4 class="text-center">Chúc quý khách thành công <img
                        src="https://i.pinimg.com/736x/c4/2c/98/c42c983e8908fdbd6574c2135212f7e4.jpg" width="45px;">
                </h4>

            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<script>
CKEDITOR.replace('paypal_notice');
CKEDITOR.replace('notice_home');
CKEDITOR.replace("notice_napthe");
CKEDITOR.replace("recharge_notice");
</script>
<script>
$(function() {
    //Colorpicker
    $('.my-colorpicker1').colorpicker()
    //color picker with addon
    $('.my-colorpicker2').colorpicker()

    $('.my-colorpicker2').on('colorpickerChange', function(event) {
        $('.my-colorpicker2 .fa-square').css('color', event.color.toString());
    })
    // CodeMirror
    CodeMirror.fromTextArea(document.getElementById("codeMirrorDemo"), {
        mode: "htmlmixed",
        theme: "monokai"
    });
    // CodeMirror
    CodeMirror.fromTextArea(document.getElementById("codeMirrorDemo2"), {
        mode: "htmlmixed",
        theme: "monokai"
    });
})
</script>
<?php
require_once(__DIR__.'/footer.php');
?>