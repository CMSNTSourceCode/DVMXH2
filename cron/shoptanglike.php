<?php

define("IN_SITE", true);

require_once(__DIR__ . '/../libs/db.php');
require_once(__DIR__ . '/../config.php');
require_once(__DIR__ . '/../libs/helper.php');
require_once(__DIR__ . '/../libs/shoptanglike.php');
require_once(__DIR__ . '/../libs/database/users.php');

 
    $CMSNT = new DB();

    if ($CMSNT->site('status') != 1 && !isset($_SESSION['admin_login'])) {
        die(json_encode(['status' => 'error', 'msg' => __('Hệ thống đang bảo trì')]));
    }
    if ($CMSNT->site('status_shoptanglike') != 1) {
        die(json_encode(['status' => 'error', 'msg' => __('Chức năng này đang tắt')]));
    }


    if(checkCron(22) == false){
        die(json_encode(['status' => 'error', 'msg' => __('Thao tác quá nhanh, vui lòng đợi')]));
    }
 
    // SET TRẠNG THÁI ĐƠN THÀNH HOÀN TẤT NẾU ĐÃ TĂNG ĐỦ SỐ LƯỢNG MUA
    $CMSNT->update('orders', [
        'status'    => 1
    ], " `status` = 0 AND `success` >= `amount` ");
    $shoptanglike = new shoptanglike;
    foreach($CMSNT->get_list("SELECT * FROM `orders` WHERE `server` = 'shoptanglike.com' AND `success` < `amount` AND `status` = 0 ") as $row){
        $data = $shoptanglike->history($row['id_api']);
        $data = json_decode($data, true);
        if($data['status'] == 100){
            $CMSNT->update('orders', [
                'success'           => $data['data']['count_success'],
                'update_time'       => time(),
                'update_gettime'    => gettime()
            ], " `id` = '".$row['id']."' ");
        }
    }



    die(json_encode(['status' => 'success', 'msg' => __('Cập nhật lịch sử thành công')]));
 



