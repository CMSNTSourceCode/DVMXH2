<?php

define("IN_SITE", true);
require_once(__DIR__."/../config.php");
require_once(__DIR__."/../libs/db.php");
require_once(__DIR__."/../libs/helper.php");
require_once(__DIR__."/../libs/database/users.php");
$User = new users();
$CMSNT = new DB();
 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if ($CMSNT->site('status') != 1 && !isset($_SESSION['admin_login'])) {
        die(json_encode([
            'status'    => 'error',
            'msg'       => __('Hệ thống đang bảo trì')
        ]));
    }
    if(empty($_POST['token'])){
        die(json_encode([
            'status'    => 'error',
            'msg'       => __('Vui lòng đăng nhập để sử dụng chức năng này')
        ]));
    }
    if(empty($_POST['limit'])){
        die(json_encode([
            'status'    => 'error',
            'msg'       => __('Vui lòng nhập limit')
        ]));
    }
    if(!$getUser = $CMSNT->get_row("SELECT * FROM `users` WHERE `token` = '".check_string($_POST['token'])."' AND `banned` = 0 ")){
        die(json_encode([
            'status'    => 'error',
            'msg'       => __('Token không tồn tại trong hệ thống')
        ]));
    }
    $limit = check_string($_POST['limit']);
    $order = [];
    foreach($CMSNT->get_list(" SELECT * FROM `orders` WHERE `buyer` = '".$getUser['id']."' ORDER BY id DESC LIMIT $limit ") as $row){
        $order[] = [
            'trans_id'  => $row['trans_id'],
            'service'   => getRowRealtime('services', $row['service_id'], 'name'),
            'pack'      => getRowRealtime('service_packs', $row['service_pack_id'], 'name'),
            'url'       => $row['url'],
            'price'     => $row['price'],
            'note'      => $row['note'],
            'amount'    => $row['amount'],
            'start'     => $row['start'],
            'success'   => $row['success'],
            'status'    => $row['status'],
            'create_gettime'    => $row['create_gettime'],
            'update_gettime'    => $row['update_gettime']
        ];
    }
    die(json_encode([
        'status'    => 'success',
        'msg'       => 'Lấy '.$limit.' lịch sử order thành công',
        'order'    => $order
    ], JSON_PRETTY_PRINT));
}
 
 
 