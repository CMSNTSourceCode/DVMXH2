<?php if (!defined('IN_SITE')) {
    die('The Request Not Found');
}
$body = [
    'title' => 'Kết nối API',
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
?>



<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Kết nối API</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?=base_url_admin('home');?>">Dashboard</a></li>
                        <li class="breadcrumb-item active">Kết nối API</li>
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

                                <!-- <li class="nav-item">
                                    <a class="nav-link" data-toggle="pill"
                                        href="#tab-TRAODOISUB" role="tab" aria-controls="tab-TRAODOISUB"
                                        aria-selected="false">TRAODOISUB.COM</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="pill"
                                        href="#tab-TUONGTACCHEO" role="tab" aria-controls="tab-TUONGTACCHEO"
                                        aria-selected="false">TUONGTACCHEO.COM</a>
                                </li> -->
                                <li class="nav-item">
                                    <a class="nav-link active" data-toggle="pill"
                                        href="#tab-SUBGIARE" role="tab" aria-controls="tab-SUBGIARE"
                                        aria-selected="false">SUBGIARE.VN</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="pill"
                                        href="#tab-BAOSTAR" role="tab" aria-controls="tab-BAOSTAR"
                                        aria-selected="false">BAOSTAR.PRO</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="pill"
                                        href="#tab-AUTOLIKE" role="tab" aria-controls="tab-AUTOLIKE"
                                        aria-selected="false">AUTOLIKE.CC</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="pill"
                                        href="#tab-AUTOFB88" role="tab" aria-controls="tab-AUTOFB88"
                                        aria-selected="false">AUTOFB88.COM</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="pill"
                                        href="#tab-DICHVUTIKTOK" role="tab" aria-controls="tab-DICHVUTIKTOK"
                                        aria-selected="false">DICHVUTIKTOK.ORG</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="pill"
                                        href="#tab-HACKLIKE17" role="tab" aria-controls="tab-HACKLIKE17"
                                        aria-selected="false">HACKLIKE17.COM</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="pill"
                                        href="#tab-SHOPTANGLIKE" role="tab" aria-controls="tab-SHOPTANGLIKE"
                                        aria-selected="false">SHOPTANGLIKE.COM</a>
                                </li>
                            </ul>
                        </div>
                        <div class="card-body">
                            <div class="tab-content" id="custom-tabs-three-tabContent">
                                <div class="tab-pane fade" id="tab-TRAODOISUB" role="tabpanel" aria-labelledby="tab-TRAODOISUB">
                                    <form action="" method="POST">
                                        <div class="form-group">
                                            <label>Username</label>
                                            <input type="text" name="username_traodoisub"
                                                value="<?=$CMSNT->site('username_traodoisub');?>" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label>Password</label>
                                            <input type="text" name="password_traodoisub"
                                                value="<?=$CMSNT->site('password_traodoisub');?>" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label>Cookie</label>
                                            <textarea name="cookie_traodoisub" class="form-control"><?=$CMSNT->site('cookie_traodoisub');?></textarea>
                                        </div>
                                        <button name="SaveSettings" class="btn btn-info btn-icon-left m-b-10"
                                            type="submit"><i class="fas fa-save mr-1"></i>Lưu Ngay</button>
                                    </form>
                                </div>
                                <div class="tab-pane fade" id="tab-TUONGTACCHEO" role="tabpanel" aria-labelledby="tab-TUONGTACCHEO">
                                    <form action="" method="POST">
                                        <div class="form-group">
                                            <label>Token</label>
                                            <input type="text" name="access_token_tuongtaccheo"
                                                value="<?=$CMSNT->site('access_token_tuongtaccheo');?>" class="form-control">
                                        </div>
                                        <button name="SaveSettings" class="btn btn-info btn-icon-left m-b-10"
                                            type="submit"><i class="fas fa-save mr-1"></i>Lưu Ngay</button>
                                    </form>
                                </div>
                                <div class="tab-pane fade" id="tab-BAOSTAR" role="tabpanel" aria-labelledby="tab-BAOSTAR">
                                    <form action="" method="POST">
                                        <div class="form-group">
                                            <label>Trạng thái</label>
                                            <select class="form-control select2bs4" name="status_baostar">
                                                <option <?=$CMSNT->site('status_baostar') == 0 ? 'selected' : '';?>
                                                    value="0">OFF
                                                </option>
                                                <option <?=$CMSNT->site('status_baostar') == 1 ? 'selected' : '';?>
                                                    value="1">ON
                                                </option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>Token</label>
                                            <input type="text" name="cookie_baostar"
                                                value="<?=$CMSNT->site('cookie_baostar');?>" class="form-control">
                                        </div>
                                        <button name="SaveSettings" class="btn btn-info btn-icon-left m-b-10"
                                            type="submit"><i class="fas fa-save mr-1"></i>Lưu Ngay</button>
                                    </form>
                                </div>
                                <div class="tab-pane fade show active" id="tab-SUBGIARE" role="tabpanel" aria-labelledby="tab-SUBGIARE">
                                    <form action="" method="POST">
                                        <div class="form-group">
                                            <label>API TOKEN</label>
                                            <input type="text" name="token_subgiare"
                                                value="<?=$CMSNT->site('token_subgiare');?>" class="form-control">
                                        </div>
                                        <button name="SaveSettings" class="btn btn-info btn-icon-left m-b-10"
                                            type="submit"><i class="fas fa-save mr-1"></i>Lưu Ngay</button>
                                    </form>
                                </div>
                                <div class="tab-pane fade" id="tab-AUTOLIKE" role="tabpanel" aria-labelledby="tab-AUTOLIKE">
                                    <form action="" method="POST">
                                        <div class="form-group">
                                            <label>Trạng thái</label>
                                            <select class="form-control select2bs4" name="status_autolike">
                                                <option <?=$CMSNT->site('status_autolike') == 0 ? 'selected' : '';?>
                                                    value="0">OFF
                                                </option>
                                                <option <?=$CMSNT->site('status_autolike') == 1 ? 'selected' : '';?>
                                                    value="1">ON
                                                </option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>Domain</label>
                                            <input type="text" name="domain_autolike"
                                                value="<?=$CMSNT->site('domain_autolike');?>" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label>Tài khoản</label>
                                            <input type="text" name="username_autolike"
                                                value="<?=$CMSNT->site('username_autolike');?>" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label>Mật khẩu</label>
                                            <input type="text" name="password_autolike"
                                                value="<?=$CMSNT->site('password_autolike');?>" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label>Token</label>
                                            <input type="text" readonly
                                                value="<?=$CMSNT->site('token_autolike');?>" class="form-control">
                                                <i>Hệ thống tự động lấy Token sau mỗi phút.</i>
                                        </div>
                                        <button name="SaveSettings" class="btn btn-info btn-icon-left m-b-10"
                                            type="submit"><i class="fas fa-save mr-1"></i>Lưu Ngay</button>
                                    </form>
                                </div>
                                <div class="tab-pane fade" id="tab-AUTOFB88" role="tabpanel" aria-labelledby="tab-AUTOFB88">
                                    <form action="" method="POST">
                                        <div class="form-group">
                                            <label>Trạng thái</label>
                                            <select class="form-control select2bs4" name="status_autofb88">
                                                <option <?=$CMSNT->site('status_autofb88') == 0 ? 'selected' : '';?>
                                                    value="0">OFF
                                                </option>
                                                <option <?=$CMSNT->site('status_autofb88') == 1 ? 'selected' : '';?>
                                                    value="1">ON
                                                </option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>Domain</label>
                                            <input type="text" name="domain_autofb88"
                                                value="<?=$CMSNT->site('domain_autofb88');?>" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label>API Key</label>
                                            <input type="text" name="token_autofb88"
                                                value="<?=$CMSNT->site('token_autofb88');?>" class="form-control">
                                        </div>
                                        <button name="SaveSettings" class="btn btn-info btn-icon-left m-b-10"
                                            type="submit"><i class="fas fa-save mr-1"></i>Lưu Ngay</button>
                                    </form>
                                </div>
                                <div class="tab-pane fade" id="tab-DICHVUTIKTOK" role="tabpanel" aria-labelledby="tab-DICHVUTIKTOK">
                                    <form action="" method="POST">
                                        <div class="form-group">
                                            <label>Trạng thái</label>
                                            <select class="form-control select2bs4" name="status_dichvutiktok">
                                                <option <?=$CMSNT->site('status_dichvutiktok') == 0 ? 'selected' : '';?>
                                                    value="0">OFF
                                                </option>
                                                <option <?=$CMSNT->site('status_dichvutiktok') == 1 ? 'selected' : '';?>
                                                    value="1">ON
                                                </option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>API Key</label>
                                            <input type="text" name="apikey_dichvutiktok"
                                                value="<?=$CMSNT->site('apikey_dichvutiktok');?>" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label>Tên đang nhập API</label>
                                            <input type="text" name="username_dichvutiktok"
                                                value="<?=$CMSNT->site('username_dichvutiktok');?>" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label>Mật khẩu đang nhập API</label>
                                            <input type="text" name="password_dichvutiktok"
                                                value="<?=$CMSNT->site('password_dichvutiktok');?>" class="form-control">
                                        </div>
                                        <button name="SaveSettings" class="btn btn-info btn-icon-left m-b-10"
                                            type="submit"><i class="fas fa-save mr-1"></i>Lưu Ngay</button>
                                    </form>
                                </div>
                                <div class="tab-pane fade" id="tab-HACKLIKE17" role="tabpanel" aria-labelledby="tab-HACKLIKE17">
                                    <form action="" method="POST">
                                        <div class="form-group">
                                            <label>Trạng thái</label>
                                            <select class="form-control select2bs4" name="status_hacklike17">
                                                <option <?=$CMSNT->site('status_hacklike17') == 0 ? 'selected' : '';?>
                                                    value="0">OFF
                                                </option>
                                                <option <?=$CMSNT->site('status_hacklike17') == 1 ? 'selected' : '';?>
                                                    value="1">ON
                                                </option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>API Key</label>
                                            <input type="text" name="apikey_hacklike17"
                                                value="<?=$CMSNT->site('apikey_hacklike17');?>" class="form-control">
                                        </div>
                                        <button name="SaveSettings" class="btn btn-info btn-icon-left m-b-10"
                                            type="submit"><i class="fas fa-save mr-1"></i>Lưu Ngay</button>
                                    </form>
                                </div>
                                <div class="tab-pane fade" id="tab-SHOPTANGLIKE" role="tabpanel" aria-labelledby="tab-SHOPTANGLIKE">
                                    <form action="" method="POST">
                                        <div class="form-group">
                                            <label>Trạng thái</label>
                                            <select class="form-control select2bs4" name="status_shoptanglike">
                                                <option <?=$CMSNT->site('status_shoptanglike') == 0 ? 'selected' : '';?>
                                                    value="0">OFF
                                                </option>
                                                <option <?=$CMSNT->site('status_shoptanglike') == 1 ? 'selected' : '';?>
                                                    value="1">ON
                                                </option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>Token</label>
                                            <input type="text" name="token_shoptanglike"
                                                value="<?=$CMSNT->site('token_shoptanglike');?>" class="form-control">
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