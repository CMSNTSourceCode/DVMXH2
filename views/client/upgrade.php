<?php if (!defined('IN_SITE')) {
    die('The Request Not Found');
}


$body = [
    'title' => __('Cấp bậc tài khoản') . ' | ' . $CMSNT->site('title'),
    'desc'   => $CMSNT->site('description'),
    'keyword' => $CMSNT->site('keywords')
];
$body['header'] = '
    
';
$body['footer'] = '
 
';

require_once(__DIR__ . '/../../models/is_user.php');


require_once(__DIR__ . '/header.php');
require_once(__DIR__ . '/sidebar.php');
?>

<div class="vertical-overlay"></div>
<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0"><?= __('Cấp bậc tài khoản'); ?></h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="<?= base_url(); ?>"><?= __('Trang chủ'); ?></a></li>
                                <li class="breadcrumb-item active"><?= __('Cấp bậc tài khoản'); ?></li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center mt-4">
                <div class="col-lg-5">
                    <div class="text-center mb-4">
                        <h4 class="fw-semibold fs-22"><?= __('DANH SÁCH CẤP BẬC'); ?></h4>
                        <p class="text-muted mb-4 fs-15"><?= __('Bạn sẽ được hệ thống tự động cập nhật CẤP BẬC khi đạt đủ tổng nạp bằng điều kiện của mốc đó.'); ?></p>
                    </div>
                </div>
                <!--end col-->
            </div>
            <!--end row-->
            <div class="row">
                <?php foreach ($CMSNT->get_list(" SELECT * FROM `ranks` ") as $row) : ?>
                    <div class="col-xxl-3 col-lg-6">
                        <div class="card pricing-box">
                            <div class="card-body bg-light m-2 p-4">
                                <div class="d-flex align-items-center mb-3">
                                    <div class="flex-grow-1">
                                        <h5 class="mb-0 fw-semibold"><?= $row['name']; ?></h5>
                                    </div>
                                    <div class="ms-auto">
                                        <h2 class="month mb-0"><?=format_currency($row['target']);?></h2>
                                    </div>
                                </div>
                                <p class="text-muted"><?=__('Bạn sẽ được nâng lên cấp độ này khi tổng nạp của bạn lớn hơn hoặc bằng');?> <b><?=format_currency($row['target']);?></b></p>
                                <?=base64_decode($row['detail']);?>
                                <div class="mt-3 pt-2">
                                    <?php if($row['discount'] == $getUser['chietkhau']):?>
                                    <a href="javascript:void(0);" class="btn btn-danger disabled w-100"><?=__('Đang Sử Dụng');?></a>
                                    <?php else:?>
                                        <a href="<?=base_url('client/recharge');?>" class="btn btn-info w-100"><?=__('Nâng Cấp');?></a>
                                    <?php endif?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach ?>
            </div>
        </div>
    </div>



    <?php require_once(__DIR__ . '/footer.php'); ?>