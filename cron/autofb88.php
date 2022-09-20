<?php

define("IN_SITE", true);

require_once(__DIR__ . '/../libs/db.php');
require_once(__DIR__ . '/../config.php');
require_once(__DIR__ . '/../libs/helper.php');
require_once(__DIR__ . '/../libs/autofb88.php');
require_once(__DIR__ . '/../libs/database/users.php');

if(isset($_GET['type'])){
    $CMSNT = new DB();

    if ($CMSNT->site('status') != 1 && !isset($_SESSION['admin_login'])) {
        die(json_encode(['status' => 'error', 'msg' => __('Hệ thống đang bảo trì')]));
    }
    if ($CMSNT->site('status_autofb88') != 1) {
        die(json_encode(['status' => 'error', 'msg' => __('Chức năng này đang tắt')]));
    }
    if($_GET['type'] == 'facebook'){
        $id_cron = 11;
        if (time() > getRowRealtime('cronjobs', $id_cron, 'update_time')) {
            if (time() - getRowRealtime('cronjobs', $id_cron, 'update_time') < $config['max_time_load']) {
                die(json_encode(['status' => 'error', 'msg' => __('Thao tác quá nhanh, vui lòng đợi')]));
            }
        }
        $CMSNT->update("cronjobs", ['update_time' => time()], " `id` = $id_cron ");
    }
    if($_GET['type'] == 'instagram'){
        $id_cron = 12;
        if (time() > getRowRealtime('cronjobs', $id_cron, 'update_time')) {
            if (time() - getRowRealtime('cronjobs', $id_cron, 'update_time') < $config['max_time_load']) {
                die(json_encode(['status' => 'error', 'msg' => __('Thao tác quá nhanh, vui lòng đợi')]));
            }
        }
        $CMSNT->update("cronjobs", ['update_time' => time()], " `id` = $id_cron ");
    }
    if($_GET['type'] == 'tiktok'){
        $id_cron = 13;
        if (time() > getRowRealtime('cronjobs', $id_cron, 'update_time')) {
            if (time() - getRowRealtime('cronjobs', $id_cron, 'update_time') < $config['max_time_load']) {
                die(json_encode(['status' => 'error', 'msg' => __('Thao tác quá nhanh, vui lòng đợi')]));
            }
        }
        $CMSNT->update("cronjobs", ['update_time' => time()], " `id` = $id_cron ");
    }
    if($_GET['type'] == 'youtube'){
        $id_cron = 14;
        if (time() > getRowRealtime('cronjobs', $id_cron, 'update_time')) {
            if (time() - getRowRealtime('cronjobs', $id_cron, 'update_time') < $config['max_time_load']) {
                die(json_encode(['status' => 'error', 'msg' => __('Thao tác quá nhanh, vui lòng đợi')]));
            }
        }
        $CMSNT->update("cronjobs", ['update_time' => time()], " `id` = $id_cron ");
    }
    if($_GET['type'] == 'shopee'){
        $id_cron = 15;
        if (time() > getRowRealtime('cronjobs', $id_cron, 'update_time')) {
            if (time() - getRowRealtime('cronjobs', $id_cron, 'update_time') < $config['max_time_load']) {
                die(json_encode(['status' => 'error', 'msg' => __('Thao tác quá nhanh, vui lòng đợi')]));
            }
        }
        $CMSNT->update("cronjobs", ['update_time' => time()], " `id` = $id_cron ");
    }
    if($_GET['type'] == 'telegram'){
        $id_cron = 16;
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
    $autofb88 = new autofb88;
    $data = $autofb88->history(check_string($_GET['type']));
    $data = json_decode($data, true);
    if($data['status'] == 200){
        foreach($data['data'] as $row){
            // LƯU SỐ LƯỢNG ĐÃ TĂNG
            $CMSNT->update('orders', [
                'success'           => $row['count_is_run'],
                'update_time'       => time(),
                'update_gettime'    => gettime()
            ], " `id_api` = '".$row['id']."' AND `status` = 0 ");
        }
    }
    die(json_encode(['status' => 'success', 'msg' => __('Cập nhật lịch sử thành công')]));
}else{
    die(json_encode(['status' => 'error', 'msg' => __('Thiếu trường type')]));
}



