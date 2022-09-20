<?php

define("IN_SITE", true);

require_once(__DIR__ . '/../libs/db.php');
require_once(__DIR__ . '/../config.php');
require_once(__DIR__ . '/../libs/helper.php');
require_once(__DIR__ . '/../libs/dichvutiktok.php');
require_once(__DIR__ . '/../libs/database/users.php');

if(isset($_GET['type'])){
    $CMSNT = new DB();

    if ($CMSNT->site('status') != 1 && !isset($_SESSION['admin_login'])) {
        die(json_encode(['status' => 'error', 'msg' => __('Hệ thống đang bảo trì')]));
    }
    if ($CMSNT->site('status_dichvutiktok') != 1) {
        die(json_encode(['status' => 'error', 'msg' => __('Chức năng này đang tắt')]));
    }
    if($_GET['type'] == 'like'){
        $id_cron = 17;
        if (time() > getRowRealtime('cronjobs', $id_cron, 'update_time')) {
            if (time() - getRowRealtime('cronjobs', $id_cron, 'update_time') < $config['max_time_load']) {
                die(json_encode(['status' => 'error', 'msg' => __('Thao tác quá nhanh, vui lòng đợi')]));
            }
        }
        $CMSNT->update("cronjobs", ['update_time' => time()], " `id` = $id_cron ");
    }
    if($_GET['type'] == 'follow'){
        $id_cron = 18;
        if (time() > getRowRealtime('cronjobs', $id_cron, 'update_time')) {
            if (time() - getRowRealtime('cronjobs', $id_cron, 'update_time') < $config['max_time_load']) {
                die(json_encode(['status' => 'error', 'msg' => __('Thao tác quá nhanh, vui lòng đợi')]));
            }
        }
        $CMSNT->update("cronjobs", ['update_time' => time()], " `id` = $id_cron ");
    }
    if($_GET['type'] == 'share'){
        $id_cron = 19;
        if (time() > getRowRealtime('cronjobs', $id_cron, 'update_time')) {
            if (time() - getRowRealtime('cronjobs', $id_cron, 'update_time') < $config['max_time_load']) {
                die(json_encode(['status' => 'error', 'msg' => __('Thao tác quá nhanh, vui lòng đợi')]));
            }
        }
        $CMSNT->update("cronjobs", ['update_time' => time()], " `id` = $id_cron ");
    }
    if($_GET['type'] == 'comment'){
        $id_cron = 20;
        if (time() > getRowRealtime('cronjobs', $id_cron, 'update_time')) {
            if (time() - getRowRealtime('cronjobs', $id_cron, 'update_time') < $config['max_time_load']) {
                die(json_encode(['status' => 'error', 'msg' => __('Thao tác quá nhanh, vui lòng đợi')]));
            }
        }
        $CMSNT->update("cronjobs", ['update_time' => time()], " `id` = $id_cron ");
    }

    // SET TRẠNG THÁI ĐƠN THÀNH HOÀN TẤT NẾU ĐÃ TĂNG ĐỦ SỐ LƯỢNG MUA
    $CMSNT->update('orders', [
        'status'    => 1
    ], " `status` = 0 AND `success` >= `amount` ");


    // CẬP NHẬT LỊCH SỬ
    $dichvutiktok = new dichvutiktok;
    $data = $dichvutiktok->history(check_string($_GET['type']));
    $data = json_decode($data, true);
    if(isset($data['data'])){
        foreach($data['data'] as $row){
            // LƯU SỐ LƯỢNG ĐÃ TĂNG
            $CMSNT->update('orders', [
                'success'           => $row['count_success'],
                'update_time'       => time(),
                'update_gettime'    => gettime()
            ], " `id_api` = '".$row['id']."' AND `status` = 0 ");
        }
    }
    die(json_encode(['status' => 'success', 'msg' => __('Cập nhật lịch sử thành công')]));
}else{
    die(json_encode(['status' => 'error', 'msg' => __('Thiếu trường type')]));
}



