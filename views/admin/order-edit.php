<?php if (!defined('IN_SITE')) {
    die('The Request Not Found');
}
if(!$row = $CMSNT->get_row("SELECT * FROM `orders` WHERE `trans_id` = '".check_string($_GET['trans_id'])."' ")){
    redirect(base_url());
}
$body = [
    'title' => 'Chỉnh sửa đơn hàng #'.$row['trans_id'],
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
<?php
if(isset($_POST['SaveOrder'])){
    if ($CMSNT->site('status_demo') != 0) {
        die('<script type="text/javascript">if(!alert("Không được dùng chức năng này vì đây là trang web demo.")){window.history.back().location.reload();}</script>');
    }
    if($row['status'] != $_POST['status']){
        if($row['status'] == 2){
            die('<script type="text/javascript">if(!alert("Đơn hàng này đã huỷ và hoàn tiền, không thể chỉnh trạng thái")){window.history.back().location.reload();}</script>');
        }
    }
    if($_POST['status'] == 2){
        $DBUser = new users();
        $DBUser->AddCredits($row['buyer'], $row['price'], "Hoàn tiền đơn hàng #".$row['trans_id']);
    }
    $isUpdate = $CMSNT->update('orders', [
        'seller'        => $getUser['id'],
        'status'        => check_string($_POST['status']),
        'seller_note'   => check_string($_POST['seller_note']),
        'task_note'     => check_string($_POST['task_note']),
        'success'       => check_string($_POST['success']),
        'update_gettime'    => gettime(),
        'update_time'       => time()
    ], " `id` = '".$row['id']."' ");
    if ($isUpdate) {
        $Mobile_Detect = new Mobile_Detect();
        $CMSNT->insert("logs", [
            'user_id'       => $getUser['id'],
            'ip'            => myip(),
            'device'        => $Mobile_Detect->getUserAgent(),
            'createdate'    => gettime(),
            'action'        => "Chỉnh sửa đơn hàng (#".$row['trans_id'].")."
        ]);
        die('<script type="text/javascript">if(!alert("Thay đổi thông tin đơn hàng thành công!")){window.history.back().location.reload();}</script>');
    }
    else {
        die('<script type="text/javascript">if(!alert("Lưu thất bại!")){window.history.back().location.reload();}</script>');
    }
}
?>
<style>
.reaction:checked+img {
    border: 3px solid rgba(0, 35, 71, 0.8);
    position: relative;
    top: -10px;
    transform: scale(1.2);
}
</style>
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Chỉnh sửa đơn hàng #<?=$row['trans_id'];?></h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?=base_url_admin('home');?>">Dashboard</a></li>
                        <li class="breadcrumb-item active">Chỉnh sửa đơn hàng #<?=$row['trans_id'];?></li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <section class="col-lg-6">
                    <div class="mb-3">
                        <a class="btn btn-danger btn-icon-left m-b-10" href="<?=base_url_admin('order-list');?>"
                            type="button"><i class="fas fa-undo-alt mr-1"></i>Quay Lại</a>
                    </div>
                </section>
                <section class="col-lg-6">
                </section>
                <section class="col-lg-12 connectedSortable">
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-eye mr-1"></i>
                                CHI TIẾT ĐƠN HÀNG #<?=$row['trans_id'];?>
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
                        <form action="" method="POST">
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-lg-3">
                                    <label for="nameInput" class="form-label"><?=__('Mã đơn hàng');?></label>
                                </div>
                                <div class="col-lg-9">
                                    <b>#<?=$row['trans_id'];?></b>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-lg-3">
                                    <label for="nameInput" class="form-label"><?=__('Khách hàng');?></label>
                                </div>
                                <div class="col-lg-9">
                                Username: <b><?=getRowRealtime("users", $row['buyer'], "username");?></b>
                                    <a
                                        href="<?=base_url('admin/user-edit/'.$row['buyer']);?>"><i class="fas fa-edit"></i></a><br>
                                        Số dư hiện tại: <b style="color: blue;"><?=format_currency(getRowRealtime("users", $row['buyer'], 'money'));?></b>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-lg-3">
                                    <label for="nameInput"
                                        class="form-label"><?=__(getRowRealtime('services', $row['service_id'], 'text_input'));?></label>
                                </div>
                                <div class="col-lg-9">
                                    <input type="text" class="form-control copy" readonly value="<?=$row['url'];?>" id="copyURL" onclick="copy()"
                                        data-clipboard-target="#copyURL"
                                        placeholder="<?=__(getRowRealtime('services', $row['service_id'], 'text_placeholder'));?>" />
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-lg-3">
                                    <label for="nameInput" class="form-label"><?=__('Gói dịch vụ');?></label>
                                </div>
                                <div class="col-lg-9">
                                    <?php foreach($CMSNT->get_list("SELECT * FROM `service_packs` WHERE `display` = 1 AND `service_id` = '".$row['service_id']."' ") as $pack):?>
                                    <div class="form-check">
                                        <input onchange="totalPayment()" type="radio" class="form-check-input"
                                            <?=$row['service_pack_id'] == $pack['id'] ? 'checked' : '';?>
                                            id="servicePack<?=$pack['id'];?>" disabled value="<?=$pack['id'];?>"><label
                                            class="form-check-label" for="servicePack<?=$pack['id'];?>">
                                            <?=__($pack['name']);?>
                                            <span class="badge badge-label bg-primary"><?=__('Giá');?>
                                                <?=format_cash($pack['price']);?>đ</span>
                                        </label>
                                    </div>
                                    <?php endforeach?>
                                </div>
                            </div>
                            <?php if($row['comment'] != ''):?>
                            <div class="row mb-3" id="show_comment">
                                <div class="col-lg-3">
                                    <label for="nameInput" class="form-label"><?=__('Nội dung comment/review/checkin:');?></label>
                                </div>
                                <div class="col-lg-9">
                                <textarea class="form-control" rows="4" id="comment" readonly
                                        placeholder="<?=__('Nhập nội dung bình luận, mỗi dòng tương đương với 1 bình luận');?>"><?=$row['comment'];?></textarea>
                                </div>
                            </div>
                            <?php else:?>  
                            <div class="row mb-3">
                                <div class="col-lg-3">
                                    <label for="nameInput" class="form-label"><?=__('Số lượng cần mua');?></label>
                                </div>
                                <div class="col-lg-9">
                                    <input type="number" class="form-control" value="<?=format_cash($row['amount']);?>"
                                        readonly placeholder="<?=__('Nhập số lượng cần mua');?>" />
                                </div>
                            </div>
                            <?php endif?>
                            <div class="row mb-3">
                                <div class="col-lg-3">
                                    <label for="nameInput" class="form-label"><?=__('Đã chạy');?></label>
                                </div>
                                <div class="col-lg-9">
                                    <input type="number" class="form-control" value="<?=format_cash($row['success']);?>"
                                        name="success" />
                                </div>
                            </div>
                            <?php if($row['review'] != ''):?>
                            <div class="row mb-3" id="show_comment">
                                <div class="col-lg-3">
                                    <label for="nameInput" class="form-label"><?=__('Nội dung comment/review/checkin:');?></label>
                                </div>
                                <div class="col-lg-9">
                                <textarea class="form-control" rows="4" id="review" readonly ><?=$row['review'];?></textarea>
                                </div>
                            </div>
                            <?php endif?> 

                            <?php if($row['days'] > 0):?>
                            <div class="row mb-3">
                                <div class="col-lg-3">
                                    <label for="nameInput" class="form-label"><?=__('Số ngày cần mua');?></label>
                                </div>
                                <div class="col-lg-9">
                                    <select class="form-select mb-3" disabled aria-label=".form-select-lg example">
                                        <option value="<?=$row['days'];?>"><?=$row['days'];?> Ngày</option>
                                    </select>
                                </div>
                            </div>
                            <?php endif?>
                            <?php if($row['num_minutes'] != ''):?>
                            <div class="row mb-3" id="show_eye">
                                <div class="col-lg-3">
                                    <label for="nameInput" class="form-label"><?=__('Số phút duy trì:');?></label>
                                </div>
                                <div class="col-lg-9">
                                    <input class="form-control" type="number" id="num_minutes" readonly
                                        value="<?=$row['num_minutes'];?>" />
                                </div>
                            </div>
                            <?php endif?>
                            <?php if($row['camxuc'] == 'like' || $row['camxuc'] == 'care' || $row['camxuc'] == 'love' || $row['camxuc'] == 'haha' || $row['camxuc'] == 'wow' || $row['camxuc'] == 'sad' || $row['camxuc'] == 'angry'):?>
                            <div id="show_loaicamxuc"  class="row mb-3">
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
                                                        id="inlineRadio1" name="camxuc" <?=$row['camxuc'] == 'like' ? 'checked' : '';?> readonly value="like">
                                                    <img src="<?=base_url('assets/img/');?>like.svg" alt="image"
                                                        class="d-block ml-2 rounded-circle" width="40">
                                                </label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <label class="form-check-label " for="inlineRadio2">
                                                    <input class="form-check-input reaction d-none" type="radio"
                                                        id="inlineRadio2" name="camxuc" <?=$row['camxuc'] == 'care' ? 'checked' : '';?> readonly value="care">
                                                    <img src="<?=base_url('assets/img/');?>care.svg" alt="image"
                                                        class="d-block ml-2 rounded-circle" width="40">
                                                </label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <label class="form-check-label " for="inlineRadio3">
                                                    <input class="form-check-input reaction d-none" type="radio"
                                                        id="inlineRadio3" name="camxuc" <?=$row['camxuc'] == 'love' ? 'checked' : '';?> readonly value="love">
                                                    <img src="<?=base_url('assets/img/');?>love.svg" alt="image"
                                                        class="d-block ml-2 rounded-circle" width="40">
                                                </label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <label class="form-check-label " for="inlineRadio4">
                                                    <input class="form-check-input reaction d-none" type="radio"
                                                        id="inlineRadio4" name="camxuc" <?=$row['camxuc'] == 'haha' ? 'checked' : '';?> readonly value="haha">
                                                    <img src="<?=base_url('assets/img/');?>haha.svg" alt="image"
                                                        class="d-block ml-2 rounded-circle" width="40">
                                                </label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <label class="form-check-label " for="inlineRadio5">
                                                    <input class="form-check-input reaction d-none" type="radio"
                                                        id="inlineRadio5" name="camxuc" <?=$row['camxuc'] == 'wow' ? 'checked' : '';?> readonly value="wow">
                                                    <img src="<?=base_url('assets/img/');?>wow.svg" alt="image"
                                                        class="d-block ml-2 rounded-circle" width="40">
                                                </label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <label class="form-check-label " for="inlineRadio6">
                                                    <input class="form-check-input reaction d-none" type="radio"
                                                        id="inlineRadio6" name="camxuc" <?=$row['camxuc'] == 'sad' ? 'checked' : '';?> readonly value="sad">
                                                    <img src="<?=base_url('assets/img/');?>sad.svg" alt="image"
                                                        class="d-block ml-2 rounded-circle" width="40">
                                                </label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <label class="form-check-label " for="inlineRadio7">
                                                    <input class="form-check-input reaction d-none" type="radio"
                                                        id="inlineRadio7" name="camxuc" <?=$row['camxuc'] == 'angry' ? 'checked' : '';?> readonly value="angry">
                                                    <img src="<?=base_url('assets/img/');?>angry.svg" alt="image"
                                                        class="d-block ml-2 rounded-circle" width="40">
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php endif?>
                            <div class="row mb-3">
                                <div class="col-lg-3">
                                    <label for="nameInput" class="form-label"><?=__('Ghi chú đơn hàng');?></label>
                                </div>
                                <div class="col-lg-9">
                                    <textarea class="form-control copy" rows="4" readonly id="copyNOTE" onclick="copy()"
                                        data-clipboard-target="#copyNOTE"
                                        placeholder="<?=__('Nhập ghi chú đơn hàng nếu có');?>"><?=$row['note'];?></textarea>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-lg-3">
                                    <label for="nameInput" class="form-label"><?=__('Số tiền thanh toán');?></label>
                                </div>
                                <div class="col-lg-9">
                                    <b style="color: red;"><?=format_currency($row['price']);?></b>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-lg-3">
                                    <label for="nameInput" class="form-label"><?=__('Trạng thái');?> (*)</label>
                                </div>
                                <div class="col-lg-9">
                                    <select class="form-control" name="status" required>
                                        <option <?=$row['status'] == 0 ? 'selected' : '';?> value="0">Đang chờ xử lý</option>
                                        <option <?=$row['status'] == 3 ? 'selected' : '';?> value="3">Đang chạy</option>
                                        <option <?=$row['status'] == 1 ? 'selected' : '';?> value="1">Hoàn tất</option>
                                        <option <?=$row['status'] == 2 ? 'selected' : '';?> value="2">Huỷ đơn (hoàn
                                            tiền)</option>
                                    </select>
                                    <i>Hệ thống sẽ tự động hoàn lại tiền cho người mua nếu bạn chọn trạng thái thành Huỷ.</i>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-lg-3">
                                    <label for="nameInput" class="form-label"><?=__('Thời gian đặt hàng');?></label>
                                </div>
                                <div class="col-lg-9">
                                    <b><?=$row['create_gettime'];?> - <?=timeAgo($row['create_time']);?></b>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-lg-3">
                                    <label for="nameInput"
                                        class="form-label"><?=__('Cập nhật đơn hàng gần đây');?></label>
                                </div>
                                <div class="col-lg-9">
                                    <b><?=$row['update_gettime'];?> - <?=timeAgo($row['update_time']);?></b>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-lg-3">
                                    <label for="nameInput" class="form-label"><?=__('Ghi chú của Admin');?> (*)</label>
                                </div>
                                <div class="col-lg-9">
                                    <textarea class="form-control" name="seller_note" placeholder="Nhập ghi chú bạn muốn gửi đến người mua"
                                        rows="4"><?=$row['seller_note'];?></textarea>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-lg-3">
                                    <label for="nameInput" class="form-label"><?=__('Ghi chú riêng đơn hàng');?> (*)</label>
                                </div>
                                <div class="col-lg-9">
                                    <textarea class="form-control" name="task_note" placeholder="Nhập ghi chú cho công việc nếu có"
                                        rows="4"><?=$row['task_note'];?></textarea>
                                        <i>Chỉ có ADMIN mới có thể xem ghi chú này.</i>
                                </div>
                            </div>
                            <button name="SaveOrder" class="btn btn-info btn-icon-left m-b-10" type="submit"><i
                                    class="fas fa-save mr-1"></i>Lưu Ngay</button>
                        </div>
                        </form>
                    </div>
                </section>
            </div>
        </div>
    </div>
</div>
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
<?php
require_once(__DIR__.'/footer.php');
?>