<?php

define("IN_SITE", true);

require_once(__DIR__ . '/../libs/db.php');
require_once(__DIR__ . '/../config.php');
require_once(__DIR__ . '/../libs/helper.php');
require_once(__DIR__ . '/../libs/hacklike17.php');
require_once(__DIR__ . '/../libs/database/users.php');

 
    $CMSNT = new DB();

    if ($CMSNT->site('status') != 1 && !isset($_SESSION['admin_login'])) {
        die(json_encode(['status' => 'error', 'msg' => __('Hệ thống đang bảo trì')]));
    }
    if ($CMSNT->site('status_hacklike17') != 1) {
        die(json_encode(['status' => 'error', 'msg' => __('Chức năng này đang tắt')]));
    }


    if(checkCron(21) == false){
        die(json_encode(['status' => 'error', 'msg' => __('Thao tác quá nhanh, vui lòng đợi')]));
    }
 


    // SET TRẠNG THÁI ĐƠN THÀNH HOÀN TẤT NẾU ĐÃ TĂNG ĐỦ SỐ LƯỢNG MUA
    $CMSNT->update('orders', [
        'status'    => 1
    ], " `status` = 0 AND `success` >= `amount` ");

    $order_id = [];
    foreach($CMSNT->get_list("SELECT * FROM `orders` WHERE `server` = 'hacklike17.com' AND `success` < `amount` AND `status` = 0 ") as $row){
        $order_id[] = $row['id_api'];
    }
    // CẬP NHẬT LỊCH SỬ
    $hacklike17 = new hacklike17;
    $data = $hacklike17->history($order_id);
    $data = json_decode($data, true);
    if($data && $data['status'] == 1){
        foreach($data['data'] as $item){
            // LƯU SỐ LƯỢNG ĐÃ TĂNG
            $CMSNT->update('orders', [
                'success'           => $item['present'],
                'update_time'       => time(),
                'update_gettime'    => gettime()
            ], " `id_api` = '".$item['id']."' AND `status` = 0 ");
        }
    }
    die(json_encode(['status' => 'success', 'msg' => __('Cập nhật lịch sử thành công')]));
 



