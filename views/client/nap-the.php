<?php if (!defined('IN_SITE')) {
    die('The Request Not Found');
}
$body = [
    'title' => __('Nạp Thẻ Cào').' | '.$CMSNT->site('title'),
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
                        <h4 class="mb-sm-0"><?=__('Nạp thẻ cào');?></h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="<?=base_url();?>"><?=__('Trang chủ');?></a></li>
                                <li class="breadcrumb-item active"><?=__('Nạp thẻ cào');?></li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end page title -->
            <div class="row">
                <div class="col-lg-7">
                    <div class="card ribbon-box">
                        <div class="card-body">
                            <div class="mb-5">
                                <div class="ribbon ribbon-primary ribbon-shape "><?=__('KHU NẠP THẺ TỰ ĐỘNG');?></div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-lg-3">
                                    <label for="nameInput" class="form-label"><?=__('Loại thẻ');?></label>
                                </div>
                                <div class="col-lg-9">
                                    <select class="form-control" id="telco">
                                        <option value="">-- <?=__('Chọn loại thẻ');?> --</option>
                                        <option value="VIETTEL">Viettel</option>
                                        <option value="VINAPHONE">Vinaphone</option>
                                        <option value="MOBIFONE">Mobifone</option>
                                        <option value="VNMOBI">Vietnamobile</option>
                                        <option value="ZING">Zing</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-lg-3">
                                    <label for="nameInput" class="form-label"><?=__('Mệnh giá');?></label>
                                </div>
                                <div class="col-lg-9">
                                    <select class="form-control" onchange="totalPrice()" id="amount">
                                        <option value="">-- <?=__('Chọn mệnh giá');?> --</option>
                                        <option value="10000">10.000đ</option>
                                        <option value="20000">20.000đ</option>
                                        <option value="30000">30.000đ</option>
                                        <option value="50000">50.000đ</option>
                                        <option value="100000">100.000đ</option>
                                        <option value="200000">200.000đ</option>
                                        <option value="300000">300.000đ</option>
                                        <option value="500000">500.000đ</option>
                                        <option value="1000000">1.000.000đ</option>
                                        <option value="2000000">2.000.000đ</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-lg-3">
                                    <label for="nameInput" class="form-label"><?=__('Serial');?></label>
                                </div>
                                <div class="col-lg-9">
                                    <input type="text" id="serial" class="form-control"
                                        placeholder="<?=__('Nhập serial thẻ');?>" />
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-lg-3">
                                    <label for="nameInput" class="form-label"><?=__('Pin');?></label>
                                </div>
                                <div class="col-lg-9">
                                    <input type="text" id="pin" class="form-control"
                                        placeholder="<?=__('Nhập mã thẻ');?>" />
                                    <input type="hidden" id="token" class="form-control"
                                        value="<?=$getUser['token'];?>" />
                                </div>
                            </div>
                            <div class="form-group text-center">
                                <div class="alert alert-info alert-dismissible alert-outline fade show" role="alert">
                                    <?=__('Số tiền thực nhận');?>: <b id="ketqua" style="color: red;">0</b>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-lg-12 fv-row text-center">
                                    <button type="button" id="btnSubmit"
                                        class="btn btn-danger"><?=__('Nạp Thẻ');?></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-5">
                    <div class="card ribbon-box">
                        <div class="card-body">
                            <div class="mb-5">
                                <div class="ribbon ribbon-primary ribbon-shape "><?=__('LƯU Ý NẠP THẺ');?></div>
                            </div>
                            <?=$CMSNT->site('notice_napthe');?>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="card ribbon-box">
                        <div class="card-body">
                            <div class="mb-5">
                                <div class="ribbon ribbon-primary ribbon-shape "><?=__('LỊCH SỬ NẠP THẺ');?></div>
                            </div>
                            <div class="table-responsive p-0">
                                <table id="datatable1" class="table table-bordered table-striped table-hover">
                                    <thead class="table-light">
                                        <tr>
                                            <th width="5%">#</th>
                                            <th><?=__('Nhà mạng');?></th>
                                            <th><?=__('Serial');?></th>
                                            <th><?=__('Pin');?></th>
                                            <th><?=__('Mệnh giá');?></th>
                                            <th><?=__('Thực nhận');?></th>
                                            <th><?=__('Trạng thái');?></th>
                                            <th><?=__('Thời gian');?></th>
                                            <th><?=__('Lý do');?></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i=0; foreach ($CMSNT->get_list("SELECT * FROM `cards` WHERE `user_id` = '".$getUser['id']."' ORDER BY `id` DESC ") as $row) {?>
                                        <tr>
                                            <td><?=$i++;?></td>
                                            <td><img width="100px"
                                                    src="<?=BASE_URL('assets/img/'.$row['telco'].'.png');?>">
                                            </td>
                                            <td><?=$row['serial'];?></td>
                                            <td><?=$row['pin'];?></td>
                                            <td><b style="color: red;"><?=format_currency($row['amount']);?></b></td>
                                            <td><b style="color: green;"><?=format_currency($row['price']);?></b></td>
                                            <td><?=display_card($row['status']);?></td>
                                            <td><?=$row['create_date'];?></td>
                                            <td><?=$row['reason'];?></td>
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
});
</script>