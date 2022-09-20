<?php if (!defined('IN_SITE')) {
    die('The Request Not Found');
}


$body = [
    'title' => __('Lịch sử đơn hàng').' | '.$CMSNT->site('title'),
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
<div class="vertical-overlay"></div>
<!-- ============================================================== -->
<!-- Start right Content here -->
<!-- ============================================================== -->
<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0"><?=__('Lịch sử đơn hàng');?></h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="<?=base_url();?>"><?=__('Trang chủ');?></a></li>
                                <li class="breadcrumb-item active"><?=__('Lịch sử đơn hàng');?></li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end page title -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="card ribbon-box">
                        <div class="card-body">
                            <div class="mb-5">
                                <div class="ribbon ribbon-primary ribbon-shape "><?=__('LỊCH SỬ ĐƠN HÀNG');?></div>
                            </div>
                            <div class="table-responsive p-0">
                                <table id="datatable1" class="table table-bordered table-striped table-hover">
                                    <thead class="table-light">
                                        <tr>
                                            <th width="5%"><?=__('TRANSID');?></th>
                                            <th><?=__('THAO TÁC');?></th>
                                            <th><?=__('DỊCH VỤ');?></th>
                                            <th><?=__('SỐ LƯỢNG/ĐÃ TĂNG');?></th>
                                            <th><?=__('THANH TOÁN');?></th>
                                            <th><?=__('URL/ID');?></th>
                                            <th><?=__('THỜI GIAN');?></th>
                                            <th><?=__('CẬP NHẬT');?></th>
                                            <th><?=__('TRẠNG THÁI');?></th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i=0; foreach ($CMSNT->get_list("SELECT * FROM `orders` WHERE `buyer` = '".$getUser['id']."' ORDER BY id DESC  ") as $row) {?>
                                        <tr>
                                            <td><?=$row['trans_id'];?></td>
                                            <td><a type="button" href="<?=base_url('client/order/'.$row['trans_id']);?>"
                                                    class="btn btn-primary btn-sm waves-effect waves-light"><?=__('Xem thêm');?></a>
                                            </td>
                                            <td><?=getRowRealtime('services', $row['service_id'], 'name');?> -
                                                <?=getRowRealtime('service_packs', $row['service_pack_id'], 'name');?>
                                            </td>
                                            <td><b style="color: red;"><?=format_cash($row['amount']);?></b>/<b style="color: green;"><?=format_cash($row['success']);?></b></td>
                                            <td><b style="color: blue;"><?=format_currency($row['price']);?></b></td>
                                            <td><textarea class="form-control" rows="1"
                                                    readonly><?=$row['url'];?></textarea></td>
                                            <td><?=$row['create_gettime'];?></td>
                                            <td><?=$row['update_gettime'];?></td>
                                            <td><?=display_service_client($row['status']);?></td>
                                        </tr>
                                        <?php }?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- container-fluid -->
 


<?php require_once(__DIR__.'/footer.php');?>


<script>
$(function() {
    $('#datatable1').DataTable({
        order: [
            [6, "desc"]
        ]
    });
});
</script>