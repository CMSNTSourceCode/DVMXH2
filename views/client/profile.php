<?php if (!defined('IN_SITE')) {
    die('The Request Not Found');
}
$body = [
    'title' => __('Trang cá nhân').' | '.$CMSNT->site('title'),
    'desc'   => $CMSNT->site('description'),
    'keyword' => $CMSNT->site('keywords')
];
$body['header'] = '
    <!-- DataTables -->
    <link rel="stylesheet" href="'.BASE_URL('public/AdminLTE3/').'plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="'.BASE_URL('public/AdminLTE3/').'plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="'.BASE_URL('public/AdminLTE3/').'plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
';
$body['footer'] = '
    <!-- DataTables  & Plugins -->
    <script src="'.BASE_URL('public/AdminLTE3/').'plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="'.BASE_URL('public/AdminLTE3/').'plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="'.BASE_URL('public/AdminLTE3/').'plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
    <script src="'.BASE_URL('public/AdminLTE3/').'plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
    <script src="'.BASE_URL('public/AdminLTE3/').'plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
    <script src="'.BASE_URL('public/AdminLTE3/').'plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
    <script src="'.BASE_URL('public/AdminLTE3/').'plugins/jszip/jszip.min.js"></script>
    <script src="'.BASE_URL('public/AdminLTE3/').'plugins/pdfmake/pdfmake.min.js"></script>
    <script src="'.BASE_URL('public/AdminLTE3/').'plugins/pdfmake/vfs_fonts.js"></script>   
    <script src="'.BASE_URL('public/AdminLTE3/').'plugins/datatables-buttons/js/buttons.html5.min.js"></script>
    <script src="'.BASE_URL('public/AdminLTE3/').'plugins/datatables-buttons/js/buttons.print.min.js"></script>
    <script src="'.BASE_URL('public/AdminLTE3/').'plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
';
require_once(__DIR__.'/../../models/is_user.php');
require_once(__DIR__.'/header.php');
require_once(__DIR__.'/sidebar.php');
?>



<!-- Vertical Overlay-->


<!-- ============================================================== -->
<!-- Start right Content here -->
<!-- ============================================================== -->
<div class="main-content">

    <div class="page-content">
        <div class="container-fluid">

            <div class="position-relative mx-n4 mt-n4">
                <div class="profile-wid-bg profile-setting-img">
                    <img src="<?=base_url('public/themesbrand/');?>images/profile-bg.jpg" class="profile-wid-img"
                        alt="">
                    <div class="overlay-content">
                        <div class="text-end p-3">
                            <div class="p-0 ms-auto rounded-circle profile-photo-edit">
                                <a for="profile-foreground-img-file-input" href="<?=base_url('client/logout');?>"
                                    class="profile-photo-edit btn btn-light">
                                    <i class="mdi mdi-logout align-bottom me-1"></i> <?=__('Đăng Xuất');?>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-xxl-3">
                    <div class="card mt-n5">
                        <div class="card-body p-4">
                            <div class="text-center">
                                <div class="profile-user position-relative d-inline-block mx-auto  mb-4">
                                    <img src="<?=base_url('public/themesbrand/');?>images/users/avatar-1.jpg"
                                        class="rounded-circle avatar-xl img-thumbnail user-profile-image"
                                        alt="user-profile-image">
                                </div>
                                <h5 class="fs-16 mb-1"><?=$getUser['username'];?></h5>
                                <p class="text-muted mb-0"><?=format_currency($getUser['money']);?></p>
                            </div>
                        </div>
                    </div>
                    <!--end card-->
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-5">
                                <div class="flex-grow-1">
                                    <h5 class="card-title mb-0"><?=__('Chiếu khấu giảm giá');?></h5>
                                </div>
                                <div class="flex-shrink-0">
                                    <a href="javascript:void(0);"
                                        class="badge bg-light text-primary fs-12"><?=__('ĐẠI LÝ');?></a>
                                </div>
                            </div>
                            <div class="progress animated-progress custom-progress progress-label">
                                <div class="progress-bar bg-danger" role="progressbar"
                                    style="width: <?=$getUser['chietkhau'];?>%"
                                    aria-valuenow="<?=$getUser['chietkhau'];?>" aria-valuemin="0" aria-valuemax="100">
                                    <div class="label"><?=$getUser['chietkhau'];?>%</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--end col-->
                <div class="col-xxl-9">
                    <div class="card mt-xxl-n5">
                        <div class="card-header">
                            <ul class="nav nav-tabs-custom rounded card-header-tabs border-bottom-0" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" data-bs-toggle="tab" href="#personalDetails" role="tab">
                                        <i class="fas fa-home"></i>
                                        <?=__('Thông Tin Cá Nhân');?>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-bs-toggle="tab" href="#changePassword" role="tab">
                                        <i class="far fa-user"></i>
                                        <?=__('Thay Đổi Mật Khẩu');?>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-bs-toggle="tab" href="#logs" role="tab">
                                        <i class="ri-history-line"></i>
                                        <?=__('Nhật Ký Hoạt Động');?>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-bs-toggle="tab" href="#dongtien" role="tab">
                                        <i class="las la-money-check-alt"></i>
                                        <?=__('Biến Động Số Dư');?>
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div class="card-body p-4">
                            <div class="tab-content">
                                <div class="tab-pane active" id="personalDetails" role="tabpanel">
                                    <form action="javascript:void(0);">
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="mb-3">
                                                    <label for="firstnameInput"
                                                        class="form-label"><?=__('Họ và Tên');?></label>
                                                    <input type="hidden" id="token" value="<?=$getUser['token'];?>">
                                                    <input type="text" class="form-control" id="fullname"
                                                        placeholder="<?=__('Nhập họ và tên của bạn');?>"
                                                        value="<?=$getUser['fullname'];?>">
                                                </div>
                                            </div>
                                            <!--end col-->
                                            <div class="col-lg-6">
                                                <div class="mb-3">
                                                    <label for="phonenumberInput"
                                                        class="form-label"><?=__('Số điện thoại')?></label>
                                                    <input type="text" class="form-control" id="phonenumberInput"
                                                        placeholder="<?=__('Nhập số điện thoại của bạn');?>"
                                                        value="<?=$getUser['phone'];?>">
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="mb-3 pb-2">
                                                    <label for="exampleFormControlTextarea"
                                                        class="form-label"><?=__('Giới tính');?></label>
                                                    <select class="form-control" data-choices data-choices-search-false
                                                        id="gender">
                                                        <option <?=$getUser['gender'] == 'Male'?'selected':'';?>
                                                            value="Male">Nam</option>
                                                        <option <?=$getUser['gender'] == 'Female'?'selected':'';?>
                                                            value="Female">Nữ</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <!--end col-->
                                            <div class="col-lg-6">
                                                <div class="mb-3">
                                                    <label for="emailInput" class="form-label"><?=__('IP');?></label>
                                                    <input type="text" class="form-control" value="<?=$getUser['ip'];?>"
                                                        readonly>
                                                </div>
                                            </div>
                                            <!--end col-->
                                            <div class="col-lg-6">
                                                <div class="mb-3">
                                                    <label for="emailInput"
                                                        class="form-label"><?=__('Tên đăng nhập');?></label>
                                                    <input type="text" class="form-control"
                                                        value="<?=$getUser['username'];?>" readonly>
                                                </div>
                                            </div>
                                            <!--end col-->
                                            <div class="col-lg-6">
                                                <div class="mb-3">
                                                    <label for="emailInput"
                                                        class="form-label"><?=__('Địa chỉ Email');?></label>
                                                    <input type="email" class="form-control"
                                                        value="<?=$getUser['email'];?>" readonly>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="mb-3">
                                                    <label for="emailInput"
                                                        class="form-label"><?=__('Thời gian đăng ký');?></label>
                                                    <input type="text" class="form-control"
                                                        value="<?=$getUser['create_date'];?>" readonly>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="mb-3">
                                                    <label for="emailInput"
                                                        class="form-label"><?=__('Đăng nhập gần đây');?></label>
                                                    <input type="text" class="form-control"
                                                        value="<?=$getUser['update_date'];?>" readonly>
                                                </div>
                                            </div>
                                            <!--end col-->
                                            <div class="col-lg-12">
                                                <div class="mb-3 pb-2">
                                                    <label for="exampleFormControlTextarea"
                                                        class="form-label"><?=__('Thiết bị đăng nhập');?></label>
                                                    <textarea class="form-control" readonly
                                                        rows="1"><?=$getUser['device'];?></textarea>
                                                </div>
                                            </div>
                                            <!--end col-->
                                            <div class="col-lg-12">
                                                <div class="hstack gap-2 justify-content-end">
                                                    <button type="button" id="btnSaveProfile"
                                                        class="btn btn-primary"><?=__('Cập Nhật');?></button>
                                                </div>
                                            </div>
                                            <!--end col-->
                                        </div>
                                        <!--end row-->
                                    </form>
                                </div>
                                <!--end tab-pane-->
                                <div class="tab-pane" id="changePassword" role="tabpanel">
                                    <form action="javascript:void(0);">
                                        <div class="row g-2">
                                            <div class="col-lg-4">
                                                <div>
                                                    <label for="oldpasswordInput"
                                                        class="form-label"><?=__('Mật khẩu hiện tại');?>*</label>
                                                    <input type="password" class="form-control" id="password"
                                                        placeholder="<?=__('Nhập mật khẩu hiện tại');?>">
                                                </div>
                                            </div>
                                            <!--end col-->
                                            <div class="col-lg-4">
                                                <div>
                                                    <label for="newpasswordInput"
                                                        class="form-label"><?=__('Mật khẩu mới');?>*</label>
                                                    <input type="password" class="form-control" id="newpassword"
                                                        placeholder="<?=__('Nhập mật khẩu mới');?>">
                                                </div>
                                            </div>
                                            <!--end col-->
                                            <div class="col-lg-4">
                                                <div>
                                                    <label for="confirmpasswordInput"
                                                        class="form-label"><?=__('Nhập lại mật khẩu mới');?>*</label>
                                                    <input type="password" class="form-control" id="renewpassword"
                                                        placeholder="<?=__('Nhập lại mật khẩu mới');?>">
                                                </div>
                                            </div>
                                            <!--end col-->
                                            <div class="col-lg-12">
                                                <div class="mb-3">
                                                    <a href="javascript:void(0);"
                                                        class="link-primary text-decoration-underline"><?=__('Quên mật khẩu ?');?></a>
                                                </div>
                                            </div>
                                            <!--end col-->
                                            <div class="col-lg-12">
                                                <div class="text-end">
                                                    <button type="button" id="btnChangePasswordProfile"
                                                        class="btn btn-success"><?=__('Lưu Thay Đổi');?></button>
                                                </div>
                                            </div>
                                            <!--end col-->
                                        </div>
                                        <!--end row-->
                                    </form>
                                </div>
                                <!--end tab-pane-->
                                <div class="tab-pane" id="logs" role="tabpanel">
                                    <div class="table-responsive p-0">
                                        <table id="datatable1" class="table table-bordered table-striped table-hover">
                                            <thead class="table-light">
                                                <th>Action</th>
                                                <th>Time</th>
                                                <th>Ip</th>
                                                <th>Device</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $i=0; foreach ($CMSNT->get_list("SELECT * FROM `logs` WHERE `user_id` = '".$getUser['id']."' ORDER BY id DESC  ") as $row) {?>
                                                <tr>
                                                    <td width="40%"><?=$row['action'];?></td>
                                                    <td><?=$row['createdate'];?></td>
                                                    <td><?=$row['ip'];?></td>
                                                    <td><?=$row['device'];?></td>
                                                </tr>
                                                <?php }?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <!--end tab-pane-->
                                <div class="tab-pane" id="dongtien" role="tabpanel">
                                    <div class="table-responsive p-0">
                                        <table id="datatable2" class="table table-bordered table-striped table-hover">
                                            <thead class="table-light">
                                                <tr>
                                                    <th>Số tiền trước</th>
                                                    <th>Số tiền thay đổi</th>
                                                    <th>Số tiền hiện tại</th>
                                                    <th>Thời gian</th>
                                                    <th>Nội dung</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $i=0; foreach ($CMSNT->get_list("SELECT * FROM `dongtien` WHERE `user_id` = '".$getUser['id']."' ORDER BY id DESC  ") as $row) {?>
                                                <tr>
                                                    <td><b
                                                            style="color: green;"><?=format_currency($row['sotientruoc']);?></b>
                                                    </td>
                                                    <td><b
                                                            style="color:red;"><?=format_currency($row['sotienthaydoi']);?></b>
                                                    </td>
                                                    <td><b
                                                            style="color: blue;"><?=format_currency($row['sotiensau']);?></b>
                                                    </td>
                                                    <td><i><?=$row['thoigian'];?></i></td>
                                                    <td width="40%"><i><?=$row['noidung'];?></i></td>
                                                </tr>
                                                <?php }?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <!--end tab-pane-->
                            </div>
                        </div>
                    </div>
                </div>
                <!--end col-->
            </div>
            <!--end row-->

        </div>
        <!-- container-fluid -->
    </div><!-- End Page-content -->



    <?php require_once(__DIR__.'/footer.php');?>


    <script type="text/javascript">
    $("#btnSaveProfile").on("click", function() {
        $('#btnSaveProfile').html('<i class="fa fa-spinner fa-spin"></i> <?=__('Đang xử lý...');?>').prop(
            'disabled',
            true);
        $.ajax({
            url: "<?=base_url('ajaxs/client/auth.php');?>",
            method: "POST",
            dataType: "JSON",
            data: {
                action: 'ChangeProfile',
                token: $("#token").val(),
                fullname: $("#fullname").val(),
                phone: $("#phone").val(),
                gender: $("#gender").val()
            },
            success: function(respone) {
                if (respone.status == 'success') {
                    cuteToast({
                        type: "success",
                        message: respone.msg,
                        timer: 5000
                    });
                } else {
                    cuteToast({
                        type: "error",
                        message: respone.msg,
                        timer: 5000
                    });
                }
                $('#btnSaveProfile').html('<?=__('Cập Nhật');?>').prop('disabled', false);
            },
            error: function() {
                cuteToast({
                    type: "error",
                    message: 'Không thể xử lý',
                    timer: 5000
                });
                $('#btnSaveProfile').html('<?=__('Cập Nhật');?>').prop('disabled', false);
            }
        });
    });
    </script>
    <script type="text/javascript">
    $("#btnChangePasswordProfile").on("click", function() {
        $('#btnChangePasswordProfile').html('<i class="fa fa-spinner fa-spin"></i> <?=__('Đang xử lý...');?>')
            .prop('disabled',
                true);
        $.ajax({
            url: "<?=base_url('ajaxs/client/auth.php');?>",
            method: "POST",
            dataType: "JSON",
            data: {
                action: 'ChangePasswordProfile',
                token: $("#token").val(),
                password: $("#password").val(),
                newpassword: $("#newpassword").val(),
                renewpassword: $("#renewpassword").val()
            },
            success: function(respone) {
                if (respone.status == 'success') {
                    cuteToast({
                        type: "success",
                        message: respone.msg,
                        timer: 5000
                    });
                } else {
                    cuteToast({
                        type: "error",
                        message: respone.msg,
                        timer: 5000
                    });
                }
                $('#btnChangePasswordProfile').html('<?=__('Lưu Thay Đổi');?>').prop('disabled',
                    false);
            },
            error: function() {
                cuteToast({
                    type: "error",
                    message: 'Không thể xử lý',
                    timer: 5000
                });
                $('#btnChangePasswordProfile').html('<?=__('Lưu Thay Đổi');?>').prop('disabled',
                    false);
            }

        });
    });
    </script>

    <script>
    $(function() {
        $('#datatable2').DataTable({
            order: [
                [3, "desc"]
            ]
        });
        $('#datatable1').DataTable({
            order: [
                [1, "desc"]
            ]
        });
    });
    </script>