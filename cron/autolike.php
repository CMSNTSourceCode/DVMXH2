<?php

define("IN_SITE", true);

require_once(__DIR__ . '/../libs/db.php');
require_once(__DIR__ . '/../config.php');
require_once(__DIR__ . '/../libs/helper.php');
require_once(__DIR__ . '/../libs/autolike.php');
require_once(__DIR__ . '/../libs/database/users.php');

if(isset($_GET['limit'])){
    $CMSNT = new DB();
    /* START CHỐNG SPAM */
    if (time() > getRowRealtime('cronjobs', 3, 'update_time')) {
        if (time() - getRowRealtime('cronjobs', 3, 'update_time') < 4) {
            die(json_encode(['status' => 'error', 'msg' => __('Thao tác quá nhanh, vui lòng đợi')]));
        }
    }
    $CMSNT->update("cronjobs", ['update_time' => time()], " `id` = 3 ");
    if ($CMSNT->site('status') != 1 && !isset($_SESSION['admin_login'])) {
        die(json_encode(['status' => 'error', 'msg' => __('Hệ thống đang bảo trì')]));
    }
    if ($CMSNT->site('status_autolike') != 1) {
        die(json_encode(['status' => 'error', 'msg' => __('Chức năng này đang tắt')]));
    }
    $autolike = new autolike;

    // SET TRẠNG THÁI ĐƠN THÀNH HOÀN TẤT NẾU ĐÃ TĂNG ĐỦ SỐ LƯỢNG MUA
    $CMSNT->update('orders', [
        'status'    => 1
    ], " `status` = 0 AND `success` >= `amount` ");

    // LẤY TOKEN
    $result_login = $autolike->login($CMSNT->site('username_autolike'), $CMSNT->site('password_autolike'));
    $result_login = json_decode($result_login, true);
    if($result_login['code'] == 200){
        $CMSNT->update('settings', [
            'value' => $result_login['data']['token']
        ], " `name` = 'token_autolike' ");
    }

    // CẬP NHẬT LỊCH SỬ
    $data = $autolike->history(check_string($_GET['limit']));
    $data = json_decode($data, true);
    if($data['code'] == 200){
        $data = $data['data'];
        foreach($data['data'] as $row){
            // LƯU SỐ LƯỢNG ĐÃ TĂNG
            $CMSNT->update('orders', [
                'success'           => $row['number_success'],
                'update_time'       => time(),
                'update_gettime'    => gettime()
            ], " `id_api` = '".$row['service_code']."' AND `status` = 0 ");
        }
    }


    die(json_encode(['status' => 'success', 'msg' => __('Cập nhật lịch sử thành công')]));
}else{
    die(json_encode(['status' => 'error', 'msg' => __('Thiếu trường limit')]));
}



