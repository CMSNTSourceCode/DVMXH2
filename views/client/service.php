<?php if (!defined('IN_SITE')) {
    die('The Request Not Found');
}

if(!$row = $CMSNT->get_row("SELECT * FROM `services` WHERE `display` = 1 AND `slug` = '".check_string($_GET['service'])."' ")){
    redirect(base_url());
}

$body = [
    'title' => __($row['name']).' | '.$CMSNT->site('title'),
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

if($CMSNT->site('sign_view_product') == 0){
    if (isset($_COOKIE["token"])) {
        $getUser = $CMSNT->get_row(" SELECT * FROM `users` WHERE `token` = '".check_string($_COOKIE['token'])."' ");
        if (!$getUser) {
            header("location: ".BASE_URL('client/logout'));
            exit();
        }
        $_SESSION['login'] = $getUser['token'];
    }
    if (isset($_SESSION['login'])) {
        require_once(__DIR__.'/../../models/is_user.php');
    }
}else{
    require_once(__DIR__.'/../../models/is_user.php');
}


require_once(__DIR__.'/header.php');
require_once(__DIR__.'/sidebar.php');
?>
<style>
.reaction:checked+img {
    border: 3px solid rgba(0, 35, 71, 0.8);
    position: relative;
    top: -10px;
    transform: scale(1.2);
}
</style>
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
                        <h4 class="mb-sm-0"><?=__($row['name']);?></h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="<?=base_url();?>"><?=__('Trang chủ');?></a></li>
                                <li class="breadcrumb-item">
                                    <?=__(getRowRealtime('categories', $row['category_id'], 'name'));?></li>
                                <li class="breadcrumb-item active"><?=__($row['name']);?></li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end page title -->
            <div class="row">
                <div class="col-lg-8">
                    <div class="card ribbon-box">
                        <div class="card-body">
                            <div class="mb-5">
                                <div class="ribbon ribbon-primary ribbon-shape "><?=__('TẠO ĐƠN HÀNG');?>
                                    <?=mb_strtoupper(__($row['name']), 'UTF-8');?></div>
                            </div>
                            <form id="form">
                                <div class="row mb-3">
                                    <div class="col-lg-3">
                                        <label for="nameInput" class="form-label"><?=__($row['text_input']);?></label>
                                    </div>
                                    <div class="col-lg-9">
                                        <input type="text" id="url" class="form-control"
                                            placeholder="<?=__($row['text_placeholder']);?>" />
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-lg-3">
                                        <label for="nameInput" class="form-label"><?=__('Gói dịch vụ');?></label>
                                    </div>
                                    <div class="col-lg-9">
                                        <?php foreach($CMSNT->get_list("SELECT * FROM `service_packs` WHERE `display` = 1 AND `service_id` = '".$row['id']."' ") as $pack):?>
                                        <div class="form-check">
                                            <input onchange="totalPayment()" type="radio" class="form-check-input"
                                                id="servicePack<?=$pack['id'];?>" name="service_pack"
                                                value="<?=$pack['id'];?>"><label class="form-check-label"
                                                for="servicePack<?=$pack['id'];?>">
                                                <?=__($pack['name']);?>
                                                <span class="badge badge-label bg-primary"><?=__('Giá');?>
                                                    <?=$pack['price'];?>đ</span>
                                            </label>
                                        </div>
                                        <?php endforeach?>
                                    </div>
                                </div>

                                <div id="load_note"
                                    class="alert alert-danger alert-dismissible alert-label-icon label-arrow fade show"
                                    role="alert">
                                    <i
                                        class="ri-error-warning-line label-icon"></i><?=__('Vui lòng chọn gói dịch vụ cần mua');?>
                                    <button type="button" class="btn-close" data-bs-dismiss=" alert"
                                        aria-label="Close"></button>
                                </div>
                                <div id="show_camxuc" style="display: none;" class="row mb-3">
                                    <div class="col-lg-3">
                                        <label for="nameInput" class="form-label"><?=__('Loại cảm xúc:');?></label>
                                    </div>
                                    <div class="col-lg-9">
                                        <div id="form-reaction" class="form-group form-reaction"
                                            style="display: block;">
                                            <div class="text-left mt-3">
                                                <div class="form-check form-check-inline">
                                                    <label class="form-check-label " for="inlineRadio1">
                                                        <input class="form-check-input reaction d-none" type="radio"
                                                            id="inlineRadio1" name="camxuc" value="like">
                                                        <img src="<?=base_url('assets/img/');?>like.svg" alt="image"
                                                            class="d-block ml-2 rounded-circle" width="40">
                                                    </label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <label class="form-check-label " for="inlineRadio2">
                                                        <input class="form-check-input reaction d-none" type="radio"
                                                            id="inlineRadio2" name="camxuc" value="care">
                                                        <img src="<?=base_url('assets/img/');?>care.svg" alt="image"
                                                            class="d-block ml-2 rounded-circle" width="40">
                                                    </label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <label class="form-check-label " for="inlineRadio3">
                                                        <input class="form-check-input reaction d-none" type="radio"
                                                            id="inlineRadio3" name="camxuc" value="love">
                                                        <img src="<?=base_url('assets/img/');?>love.svg" alt="image"
                                                            class="d-block ml-2 rounded-circle" width="40">
                                                    </label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <label class="form-check-label " for="inlineRadio4">
                                                        <input class="form-check-input reaction d-none" type="radio"
                                                            id="inlineRadio4" name="camxuc" value="haha">
                                                        <img src="<?=base_url('assets/img/');?>haha.svg" alt="image"
                                                            class="d-block ml-2 rounded-circle" width="40">
                                                    </label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <label class="form-check-label " for="inlineRadio5">
                                                        <input class="form-check-input reaction d-none" type="radio"
                                                            id="inlineRadio5" name="camxuc" value="wow">
                                                        <img src="<?=base_url('assets/img/');?>wow.svg" alt="image"
                                                            class="d-block ml-2 rounded-circle" width="40">
                                                    </label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <label class="form-check-label " for="inlineRadio6">
                                                        <input class="form-check-input reaction d-none" type="radio"
                                                            id="inlineRadio6" name="camxuc" value="sad">
                                                        <img src="<?=base_url('assets/img/');?>sad.svg" alt="image"
                                                            class="d-block ml-2 rounded-circle" width="40">
                                                    </label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <label class="form-check-label " for="inlineRadio7">
                                                        <input class="form-check-input reaction d-none" type="radio"
                                                            id="inlineRadio7" name="camxuc" value="angry">
                                                        <img src="<?=base_url('assets/img/');?>angry.svg" alt="image"
                                                            class="d-block ml-2 rounded-circle" width="40">
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-3" style="display: none;" id="show_comment">
                                    <div class="col-lg-3">
                                        <label for="nameInput" class="form-label"><?=__('Nội dung bình luận:');?></label>
                                    </div>
                                    <div class="col-lg-9">
                                    <textarea class="form-control" rows="4" id="comment" onkeyup="totalPayment()"
                                            placeholder="<?=__('Nhập nội dung bình luận, mỗi dòng tương đương với 1 bình luận');?>"></textarea>
                                    </div>
                                </div>
                                <div id="show_soluong" class="row mb-3">
                                    <div class="col-lg-3">
                                        <label for="nameInput" class="form-label"><?=__('Số lượng cần mua');?></label>
                                    </div>
                                    <div class="col-lg-9">
                                        <input type="number" id="amount" class="form-control" value="1"
                                            onkeyup="totalPayment()" placeholder="<?=__('Nhập số lượng cần mua');?>" />
                                        <input type="hidden" id="token" class="form-control"
                                            value="<?=$getUser['token'];?>" />
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-lg-3">
                                        <label for="nameInput" class="form-label"><?=__('Ghi chú đơn hàng');?></label>
                                    </div>
                                    <div class="col-lg-9">
                                        <textarea class="form-control" rows="4" id="note"
                                            placeholder="<?=__('Nhập ghi chú đơn hàng nếu có');?>"></textarea>
                                    </div>
                                </div>
                                <div class="form-group text-center">
                                    <div class="alert alert-primary alert-dismissible alert-outline fade show"
                                        role="alert">
                                        <?=__('Số tiền thanh toán');?>: <b id="total" style="color: red;">0</b>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-lg-12 fv-row text-center">
                                        <button type="button" id="btnSubmit"
                                            class="btn btn-danger"><?=__('Tạo Tiến Trình');?></button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="card ribbon-box">
                        <div class="card-body">
                            <div class="mb-5">
                                <div class="ribbon ribbon-primary ribbon-shape "><?=__('LƯU Ý');?></div>
                            </div>
                            <?=base64_decode($row['content']);?>
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
function totalPayment() {
    $('#total').html('<i class="fa fa-spinner fa-spin"></i> <?=__('Đang xử lý...');?>');
    var amount = $("#amount").val();
    $.ajax({
        url: "<?=BASE_URL("ajaxs/client/total.php");?>",
        method: "POST",
        dataType: "JSON",
        data: {
            service_pack: $('input[name=service_pack]:checked', '#form').val(),
            amount: $("#amount").val(),
            comment: $("#comment").val(),
            token: $("#token").val(),
            action: 'service'
        },
        success: function(respone) {
            $("#total").html(respone.total);
            $("#total_amount").html(amount.toString().replace(/(.)(?=(\d{3})+$)/g, '$1.'));
            $("#total_money_input").val(amount.toString().replace(/(.)(?=(\d{3})+$)/g, '$1.'));
            $("#load_note").html('<i class="ri-error-warning-line label-icon"></i>' + respone.msg
            .toString());
            if(respone.show_camxuc == 1){
                $("#show_camxuc").show();
            }else{
                $("#show_camxuc").hide();
            }
            if(respone.show_comment == 1){
                $("#show_comment").show();
                $("#show_soluong").hide();
            }else{
                $("#show_comment").hide();
                $("#show_soluong").show();
            }
        },
        error: function() {
            cuteToast({
                type: "error",
                message: 'Không thể tính kết quả thanh toán',
                timer: 5000
            });
        }
    });
}
</script>
<script type="text/javascript">
$("#btnSubmit").on("click", function() {
    Swal.fire({
        title: '<?=__('Xác nhận thanh toán !');?>',
        text: '<?=__('Đơn hàng sẽ được gửi đi và không thể huỷ nếu bạn nhấn Thanh Toán');?>',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: '<?=__('Thanh Toán');?>',
        cancelButtonText: '<?=__('Đóng');?>'
    }).then((result) => {
        if (result.isConfirmed) {
            $('#btnSubmit').html('<i class="fa fa-spinner fa-spin"></i> <?=__("Đang xử lý...");?>')
                .prop('disabled', true);
            $.ajax({
                url: "<?=BASE_URL('api/orderService.php');?>",
                method: "POST",
                dataType: "JSON",
                data: {
                    token: $('#token').val(),
                    url: $('#url').val(),
                    service_pack: $('input[name=service_pack]:checked', '#form').val(),
                    camxuc: $('input[name=camxuc]:checked', '#form-reaction').val(),
                    note: $('#note').val(),
                    comment: $('#comment').val(),
                    amount: $('#amount').val()
                },
                success: function(respone) {
                    if (respone.status == 'success') {
                        Swal.fire({
                            icon: 'success',
                            title: '<?=__('Thành công !');?>',
                            text: respone.msg,
                            showDenyButton: true,
                            confirmButtonText: '<?=__('Mua thêm');?>',
                            denyButtonText: `<?=__('Xem lịch sử đơn hàng');?>`,
                            }).then((result) => {
                            if (result.isConfirmed) {
                                location.reload();
                            } else if (result.isDenied) {
                                window.location.href = '<?=base_url('client/orders');?>';
                            }
                            });
                    } else {
                        Swal.fire('<?=__('Thất bại !');?>', respone.msg, 'error');
                    }
                    $('#btnSubmit').html('<?=__('Tạo Tiến Trình');?>').prop('disabled',
                        false);
                }
            })
        }
    })

});
</script>
<script>
$(function() {
    $('#datatable1').DataTable();
});
</script>