<?php if (!defined('IN_SITE')) {
    die('The Request Not Found');
}
$body = [
    'title' => __('Nạp Tiền').' | '.$CMSNT->site('title'),
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/clipboard.js/2.0.6/clipboard.min.js"></script>
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
                        <h4 class="mb-sm-0"><?=__('Ngân hàng & ví điện tử');?></h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="<?=base_url();?>"><?=__('Trang chủ');?></a></li>
                                <li class="breadcrumb-item"><?=__('Nạp tiền');?></li>
                                <li class="breadcrumb-item active"><?=__('Ngân hàng & ví điện tử');?></li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end page title -->

            <div class="row">
                <div class="col-lg-12">
                    <div class="alert alert-secondary alert-dismissible alert-outline fade show" role="alert">
                        <p><?=$CMSNT->site('recharge_notice');?></p>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                </div>
                <?php foreach ($CMSNT->get_list("SELECT * FROM `banks` ") as $bank) {?>
                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-4 mt-4 mt-lg-0 mb-3">
                    <div class="card">
                        <div class="card-body">
                            <center>
                                <img class="mb-3" src="<?=base_url($bank['image']);?>" width="200px" height="100px">
                            </center>
                            <ul class="list-group mb-2">
                                <li class="list-group-item">Số tài khoản: <b id="copySTK<?=$bank['id'];?>"
                                        style="color: green;"><?=$bank['accountNumber'];?></b> <button onclick="copy()"
                                        data-clipboard-target="#copySTK<?=$bank['id'];?>"
                                        class="copy btn btn-primary btn-sm"><i class="fas fa-copy"></i></button>
                                </li>
                                <li class="list-group-item">Chủ tài khoản: <b><?=$bank['accountName'];?></b>
                                </li>
                                <li class="list-group-item">Ngân hàng: <b><?=$bank['short_name'];?></b></li>
                                <li class="list-group-item">Nội dung nạp: <b id="copyNoiDung<?=$bank['id'];?>"
                                        style="color: red;"><?=$CMSNT->site('prefix_autobank').$getUser['id'];?></b>
                                    <button onclick="copy()" data-clipboard-target="#copyNoiDung<?=$bank['id'];?>"
                                        class="copy btn btn-primary btn-sm"><i class="fas fa-copy"></i></button>
                                </li>
                            </ul>
                            <center><i><i class="fa fa-spinner fa-spin"></i>
                                    <?=__('Xử lý giao dịch tự động trong vài giây...');?></i></center>
                        </div>
                    </div>
                </div>
                <?php }?>
                <div class="col-lg-12">
                </div>
                <div class="col-lg-6">
                    <div class="card ribbon-box">
                        <div class="card-body">
                            <div class="mb-5">
                                <div class="ribbon ribbon-primary round-shape "><?=__('LỊCH SỬ NẠP AUTO BANK');?></div>
                            </div>
                            <div class="table-responsive p-0">
                                <table id="datatable1" class="table table-bordered table-striped table-hover">
                                    <thead class="table-light">
                                        <tr>
                                            <th>STT</th>
                                            <th><?=__('TIỀN NẠP');?></th>
                                            <th><?=__('THỰC NHẬN');?></th>
                                            <th><?=__('NỘI DUNG');?></th>
                                            <th><?=__('THỜI GIAN');?></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i = 0; foreach($CMSNT->get_list(" SELECT * FROM `bank_auto` WHERE `user_id` = '".$getUser['id']."' ORDER BY id DESC ") as $row){ ?>
                                        <tr>
                                            <td width="5%"><?=$i++;?></td>
                                            <td><?=$row['amount'];?></td>
                                            <td><?=$row['received'];?></td>
                                            <td><?=$row['description'];?></td>
                                            <td><?=$row['create_gettime'];?></td>
                                        </tr>
                                        <?php }?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="card ribbon-box">
                        <div class="card-body">
                            <div class="mb-5">
                                <div class="ribbon ribbon-primary round-shape "><?=__('LỊCH SỬ NẠP AUTO MOMO');?></div>
                            </div>
                            <div class="table-responsive p-0">
                                <table id="datatable2" class="table table-bordered table-striped table-hover">
                                    <thead class="table-light">
                                        <tr>
                                            <th>STT</th>
                                            <th><?=__('TIỀN NẠP');?></th>
                                            <th><?=__('THỰC NHẬN');?></th>
                                            <th><?=__('NỘI DUNG');?></th>
                                            <th><?=__('THỜI GIAN');?></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i = 0; foreach($CMSNT->get_list(" SELECT * FROM `momo` WHERE `user_id` = '".$getUser['id']."' ORDER BY id DESC ") as $row){ ?>
                                        <tr>
                                            <td width="5%"><?=$i++;?></td>
                                            <td><?=$row['amount'];?></td>
                                            <td><?=$row['received'];?></td>
                                            <td><?=$row['comment'];?></td>
                                            <td><?=$row['time'];?></td>
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
</div>
<!-- End Page-content -->


<?php require_once(__DIR__.'/footer.php');?>

<script>
function totalPrice() {
    var total = 0;
    var amount = $("#amount").val();
    total = amount - amount * <?=$CMSNT->site('ck_napthe');?> / 100;
    $('#ketqua').html(total.toString().replace(/(.)(?=(\d{3})+$)/g, '$1.'));
}
</script>
<script type="text/javascript">
$("#btnSubmit").on("click", function() {
    $('#btnSubmit').html('<i class="fa fa-spinner fa-spin"></i> <?=__("Đang xử lý...");?>').prop('disabled',
        true);
    $.ajax({
        url: "<?=BASE_URL('ajaxs/client/napthe.php');?>",
        method: "POST",
        dataType: "JSON",
        data: {
            token: $('#token').val(),
            serial: $('#serial').val(),
            pin: $('#pin').val(),
            telco: $('#telco').val(),
            amount: $('#amount').val()
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
            $('#btnSubmit').html('<?=__('Nạp Thẻ');?>').prop('disabled', false);
        }
    })
});
</script>
<script>
$(function() {
    $('#datatable1').DataTable();
    $('#datatable2').DataTable();
});
</script>
<script type="text/javascript">
new ClipboardJS(".copy");

function copy() {
    cuteToast({
        type: "success",
        message: "<?=__('Đã sao chép vào bộ nhớ tạm');?>",
        timer: 5000
    });
}
</script>