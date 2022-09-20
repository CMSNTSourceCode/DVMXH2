<?php if (!defined('IN_SITE')) {
    die('The Request Not Found');
}
$body = [
    'title' => 'Dashboard',
    'desc'   => 'CMSNT Panel',
    'keyword' => 'cmsnt, CMSNT, cmsnt.co,'
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
require_once(__DIR__.'/../../models/is_admin.php');
require_once(__DIR__.'/header.php');
require_once(__DIR__.'/sidebar.php');
require_once(__DIR__.'/nav.php');

 
?>
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Dashboard</h1>
                </div>
                <div class="col-sm-6">
                   
                </div>
            </div>
        </div>
    </div>
    <div class="content">
        <div class="container-fluid">
        <div class="alert alert-dark">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <b>Phiên bản hiện tại: <span style="color: yellow;"><?=$config['version'];?></span></b>
                <ul>
                    <li>03/09/2022: Lại fix API Baostar :)</li>
                    <li>02/09/2022: Fix TPBank</li>
                    <li>31/08/2022: Fix mua comment/review Baostar.</li>
                    <li>30/08/2022: Fix API Baostar.</li>
                    <li>25/08/2022: Thêm nạp tiền tự động qua PayPal - (shop nào đấu API Baostar vui lòng cấu hình thêm API hacklike17 để hệ thống tự động convert URL sang UID khi order).</li>
                    <li>16/08/2022; Fix lỗi không hiện ô comment tính giá theo số lượng, tự convert URL sang ID khi order dịch vụ Facebook API BAOSTAR.</li>
                    <li>10/07/2022: Fix tổng nạp khi hoàn lại tiền đơn hàng.</li>
                    <li>05/06/2022: Tuỳ chỉnh ô nhập comment và chọn cảm xúc.</li>
                    <li>28/05/2022: Thêm trạng thái đang chạy cho đơn hàng, fix lỗi auto TPBank.</li>
                    <li>12/05/2022: Cập nhật hệ thống...</li>
                </ul>
                <i>Hệ thống tự động cập nhật phiên bản mới nhất khi vào trang Quản Trị.</i>
            </div>
            <div class="row">
            <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3><?=format_cash($CMSNT->get_row("SELECT COUNT(id) FROM `orders` WHERE `status` = 0 ")['COUNT(id)']);?></h3>
                            <p>Đơn hàng đang chờ xử lý</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-bag"></i>
                        </div>
                        <a href="<?=base_url_admin('order-list');?>" class="small-box-footer">Xem thêm <i
                                class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3><?=format_cash($CMSNT->get_row("SELECT COUNT(id) FROM `orders` WHERE `status` = 1 ")['COUNT(id)']);?>
                            </h3>
                            <p>Đơn hàng hoàn tất</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-stats-bars"></i>
                        </div>
                        <a href="<?=base_url_admin('order-list');?>" class="small-box-footer">Xem thêm <i
                                class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3><?=format_cash($CMSNT->get_row("SELECT COUNT(id) FROM `users` ")['COUNT(id)']);?></h3>
                            <p>Tổng thành viên</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-person-add"></i>
                        </div>
                        <a href="<?=base_url_admin('users');?>" class="small-box-footer">Xem thêm <i
                                class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-danger">
                        <div class="inner">
                            <h3><?=format_currency($CMSNT->get_row("SELECT SUM(`price`) FROM `orders` WHERE `status` = 1 ")['SUM(`price`)']);?>
                            </h3>
                            <p>Doanh thu đơn hàng</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-pie-graph"></i>
                        </div>
                        <a href="<?=base_url_admin('order-list');?>" class="small-box-footer">Xem thêm <i
                                class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <div class="col-lg-4 col-6">
                    <div class="card">
                        <div class="card-header border-0">
                            <h3 class="card-title">Thống kê tháng <?=date('m', time());?></h3>
                        </div>
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center border-bottom mb-3">
                                <p class="text-success text-xl">
                                    <i class="ion ion-ios-refresh-empty"></i>
                                </p>
                                <p class="d-flex flex-column text-right">
                                    <span class="font-weight-bold">
                                        <?=format_currency($CMSNT->get_row(" SELECT SUM(`price`) FROM `orders` WHERE `status` = 1  AND YEAR(create_gettime) = ".date('Y')." AND MONTH(create_gettime) = ".date('m')." ")['SUM(`price`)']);?>
                                    </span>
                                    <span class="text-muted">DOANH THU ĐƠN HÀNG</span>
                                </p>
                            </div>
                            <div class="d-flex justify-content-between align-items-center border-bottom mb-0">
                                <p class="text-danger text-xl">
                                    <i class="ion ion-ios-people-outline"></i>
                                </p>
                                <p class="d-flex flex-column text-right">
                                    <span class="font-weight-bold">
                                        <?=format_cash($CMSNT->get_row("SELECT COUNT(id) FROM `users` WHERE YEAR(create_date) = ".date('Y')." AND MONTH(create_date) = ".date('m')." ")['COUNT(id)']);?>
                                    </span>
                                    <span class="text-muted">THÀNH VIÊN MỚI</span>
                                </p>
                            </div>
                            <div class="d-flex justify-content-between align-items-center mb-0">
                                <p class="text-info text-xl">
                                    <i class="ion ion-card"></i>
                                </p>
                                <p class="d-flex flex-column text-right">
                                    <span class="font-weight-bold">
                                        <?=format_currency(
                                            $CMSNT->get_row(" SELECT SUM(amount) FROM `momo` WHERE  YEAR(time) = ".date('Y')." AND MONTH(time) = ".date('m')." ")['SUM(amount)'] +
                                            $CMSNT->get_row(" SELECT SUM(amount) FROM `bank_auto` WHERE YEAR(create_gettime) = ".date('Y')." AND MONTH(create_gettime) = ".date('m')." ")['SUM(amount)'] + 
                                            $CMSNT->get_row(" SELECT SUM(price) FROM `cards` WHERE `status` = 1  AND YEAR(create_date) = ".date('Y')." AND MONTH(create_date) = ".date('m')." ")['SUM(price)']
                                        );?>
                                    </span>
                                    <span class="text-muted">SỐ TIỀN NẠP</span>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-6">
                    <div class="card">
                        <div class="card-header border-0">
                            <h3 class="card-title">Thống kê tuần</h3>
                        </div>
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center border-bottom mb-3">
                                <p class="text-success text-xl">
                                    <i class="ion ion-ios-refresh-empty"></i>
                                </p>
                                <p class="d-flex flex-column text-right">
                                    <span class="font-weight-bold">
                                        <?=format_currency($CMSNT->get_row("SELECT SUM(`price`) FROM `orders` WHERE `status` = 1 AND WEEK(create_gettime, 1) = WEEK(CURDATE(), 1) ")['SUM(`price`)']);?>
                                    </span>
                                    <span class="text-muted">DOANH THU ĐƠN HÀNG</span>
                                </p>
                            </div>
                            <!-- /.d-flex -->
                            <div class="d-flex justify-content-between align-items-center border-bottom mb-0">
                                <p class="text-danger text-xl">
                                    <i class="ion ion-ios-people-outline"></i>
                                </p>
                                <p class="d-flex flex-column text-right">
                                    <span class="font-weight-bold">
                                        <?=format_cash($CMSNT->get_row("SELECT COUNT(id) FROM `users` WHERE WEEK(create_date, 1) = WEEK(CURDATE(), 1) ")['COUNT(id)']);?>
                                    </span>
                                    <span class="text-muted">THÀNH VIÊN MỚI</span>
                                </p>
                            </div>
                            <div class="d-flex justify-content-between align-items-center mb-0">
                                <p class="text-info text-xl">
                                    <i class="ion ion-card"></i>
                                </p>
                                <p class="d-flex flex-column text-right">
                                    <span class="font-weight-bold">
                                        <?=format_currency(
                                            $CMSNT->get_row(" SELECT SUM(amount) FROM `momo` WHERE WEEK(TIME, 1) = WEEK(CURDATE(), 1) ")['SUM(amount)'] +
                                            $CMSNT->get_row(" SELECT SUM(amount) FROM `bank_auto` WHERE WEEK(create_gettime, 1) = WEEK(CURDATE(), 1) ")['SUM(amount)'] + 
                                            $CMSNT->get_row(" SELECT SUM(price) FROM `cards` WHERE `status` = 1  AND WEEK(create_date, 1) = WEEK(CURDATE(), 1) ")['SUM(price)']
                                        );?>
                                    </span>
                                    <span class="text-muted">SỐ TIỀN NẠP</span>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-6">
                    <div class="card">
                        <div class="card-header border-0">
                            <h3 class="card-title">Thống kê hôm nay</h3>
                        </div>
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center border-bottom mb-3">
                                <p class="text-success text-xl">
                                    <i class="ion ion-ios-refresh-empty"></i>
                                </p>
                                <p class="d-flex flex-column text-right">
                                    <span class="font-weight-bold">
                                        <?=format_currency($CMSNT->get_row("SELECT SUM(`price`) FROM `orders` WHERE `status` = 1 AND `create_gettime` >= DATE(NOW()) AND `create_gettime` < DATE(NOW()) + INTERVAL 1 DAY ")['SUM(`price`)']);?>
                                    </span>
                                    <span class="text-muted">DOANH THU ĐƠN HÀNG</span>
                                </p>
                            </div>
                            <!-- /.d-flex -->
                            <div class="d-flex justify-content-between align-items-center border-bottom mb-0">
                                <p class="text-danger text-xl">
                                    <i class="ion ion-ios-people-outline"></i>
                                </p>
                                <p class="d-flex flex-column text-right">
                                    <span class="font-weight-bold">
                                        <?=format_cash($CMSNT->get_row("SELECT COUNT(id) FROM `users` WHERE `create_date` >= DATE(NOW()) AND `create_date` < DATE(NOW()) + INTERVAL 1 DAY ")['COUNT(id)']);?>
                                    </span>
                                    <span class="text-muted">THÀNH VIÊN MỚI</span>
                                </p>
                            </div>
                            <div class="d-flex justify-content-between align-items-center mb-0">
                                <p class="text-info text-xl">
                                    <i class="ion ion-card"></i>
                                </p>
                                <p class="d-flex flex-column text-right">
                                    <span class="font-weight-bold">
                                        <?=format_currency(
                                            $CMSNT->get_row(" SELECT SUM(amount) FROM `momo` WHERE `time` >= DATE(NOW()) AND `time` < DATE(NOW()) + INTERVAL 1 DAY ")['SUM(amount)'] +
                                            $CMSNT->get_row(" SELECT SUM(amount) FROM `bank_auto` WHERE `create_gettime` >= DATE(NOW()) AND `create_gettime` < DATE(NOW()) + INTERVAL 1 DAY ")['SUM(amount)'] + 
                                            $CMSNT->get_row(" SELECT SUM(price) FROM `cards` WHERE `status` = 1  AND `create_date` >= DATE(NOW()) AND `create_date` < DATE(NOW()) + INTERVAL 1 DAY ")['SUM(price)']
                                        );?>
                                    </span>
                                    <span class="text-muted">SỐ TIỀN NẠP</span>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <section class="col-lg-12 connectedSortable">
                    <div class="card card-primary card-outline">
                        <div class="card-header ">
                            <h3 class="card-title">
                                <i class="fas fa-history mr-1"></i>
                                500 BIẾN ĐỘNG SỐ DƯ GẦN ĐÂY
                            </h3>
                            <div class="card-tools">
                                <button type="button" class="btn bg-success btn-sm" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                                <button type="button" class="btn bg-warning btn-sm" data-card-widget="maximize"><i
                                        class="fas fa-expand"></i>
                                </button>
                                <button type="button" class="btn bg-danger btn-sm" data-card-widget="remove">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive p-0">
                                <table id="datatable1" class="table table-bordered table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th width="5%">#</th>
                                            <th>Username</th>
                                            <th>Số tiền trước</th>
                                            <th>Số tiền thay đổi</th>
                                            <th>Số tiền hiện tại</th>
                                            <th>Thời gian</th>
                                            <th>Nội dung</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i=0; foreach ($CMSNT->get_list("SELECT * FROM `dongtien` ORDER BY id DESC LIMIT 500  ") as $row) {?>
                                        <tr>
                                            <td class="text-center"><?=$i++;?></td>
                                            <td class="text-center"><a
                                                    href="<?=base_url('admin/user-edit/'.$row['user_id']);?>"><?=getRowRealtime("users", $row['user_id'], "username");?></a>
                                            </td>
                                            <td class="text-center"><b
                                                    style="color: green;"><?=format_currency($row['sotientruoc']);?></b>
                                            </td>
                                            <td class="text-center"><b
                                                    style="color:red;"><?=format_currency($row['sotienthaydoi']);?></b>
                                            </td>
                                            <td class="text-center"><b
                                                    style="color: blue;"><?=format_currency($row['sotiensau']);?></b>
                                            </td>
                                            <td class="text-center"><i><?=$row['thoigian'];?></i></td>
                                            <td><i><?=$row['noidung'];?></i></td>
                                        </tr>
                                        <?php }?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </section>
                <section class="col-lg-12 connectedSortable">
                    <div class="card card-primary card-outline">
                        <div class="card-header ">
                            <h3 class="card-title">
                                <i class="fas fa-history mr-1"></i>
                               500 NHẬT KÝ HOẠT ĐỘNG GẦN ĐÂY
                            </h3>
                            <div class="card-tools">
                                <button type="button" class="btn bg-success btn-sm" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                                <button type="button" class="btn bg-warning btn-sm" data-card-widget="maximize"><i
                                        class="fas fa-expand"></i>
                                </button>
                                <button type="button" class="btn bg-danger btn-sm" data-card-widget="remove">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive p-0">
                                <table id="datatable2" class="table table-bordered table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th width="5%">#</th>
                                            <th>Username</th>
                                            <th width="40%">Action</th>
                                            <th>Time</th>
                                            <th>Ip</th>
                                            <th width="25%">Device</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i=0; foreach ($CMSNT->get_list("SELECT * FROM `logs` ORDER BY id DESC LIMIT 500 ") as $row) {?>
                                        <tr>
                                            <td><?=$i++;?></td>
                                            <td><a
                                                    href="<?=base_url('admin/user-edit/'.$row['user_id']);?>"><?=getRowRealtime("users", $row['user_id'], "username");?></a>
                                            </td>
                                            <td><?=$row['action'];?></td>
                                            <td><?=$row['createdate'];?></td>
                                            <td><?=$row['ip'];?></td>
                                            <td><?=$row['device'];?></td>
                                        </tr>
                                        <?php }?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
</div>


 
<?php
require_once(__DIR__.'/footer.php');
?>
 