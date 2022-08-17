<?php if (!defined('IN_SITE')) {
    die('The Request Not Found');
}
require_once(__DIR__.'/../../models/is_user.php');

if(!$row = $CMSNT->get_row("SELECT * FROM `orders` WHERE `buyer` = '".$getUser['id']."' AND `trans_id` = '".check_string($_GET['trans_id'])."' ")){
    redirect(base_url());
}

$body = [
    'title' => __('Chi tiết đơn hàng #').$row['trans_id'].' | '.$CMSNT->site('title'),
    'desc'   => $CMSNT->site('description'),
    'keyword' => $CMSNT->site('keywords')
];
$body['header'] = '
 
';
$body['footer'] = '
 
';




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
                        <h4 class="mb-sm-0"><?=__('Chi tiết đơn hàng #').$row['trans_id'];?></h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="<?=base_url();?>"><?=__('Trang chủ');?></a></li>
                                <li class="breadcrumb-item"><a
                                        href="<?=base_url('client/orders');?>"><?=__('Lịch sử đơn hàng');?></a></li>
                                <li class="breadcrumb-item active"><?=__('Chi tiết đơn hàng #').$row['trans_id'];?></li>
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
                                <div class="ribbon ribbon-primary ribbon-shape ">
                                    <?=__('CHI TIẾT ĐƠN HÀNG #').$row['trans_id'];?></div>
                            </div>
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
                                    <label for="nameInput"
                                        class="form-label"><?=__(getRowRealtime('services', $row['service_id'], 'text_input'));?></label>
                                </div>
                                <div class="col-lg-9">
                                    <input type="text" class="form-control" readonly value="<?=$row['url'];?>"
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
                                                <?=format_currency($pack['price']);?></span>
                                        </label>
                                    </div>
                                    <?php endforeach?>
                                </div>
                            </div>
                            <?php if($row['comment'] != ''):?>
                            <div class="row mb-3" id="show_comment">
                                <div class="col-lg-3">
                                    <label for="nameInput" class="form-label"><?=__('Nội dung bình luận:');?></label>
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
                                    <textarea class="form-control" rows="4" readonly
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
                                    <label for="nameInput" class="form-label"><?=__('Trạng thái');?></label>
                                </div>
                                <div class="col-lg-9">
                                    <?=display_service_client($row['status']);?>
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
                                    <label for="nameInput" class="form-label"><?=__('Ghi chú của Admin');?></label>
                                </div>
                                <div class="col-lg-9">
                                    <textarea class="form-control" rows="4"
                                        readonly><?=$row['seller_note'];?></textarea>
                                </div>
                            </div>

                            <a type="button" href="<?=base_url('client/orders');?>" class="btn btn-danger btn-sm waves-effect waves-light"><i class="ri-arrow-go-back-line"></i> <?=__('Quay lại');?></a>
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