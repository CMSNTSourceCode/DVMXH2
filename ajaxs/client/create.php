<?php

define("IN_SITE", true);
require_once(__DIR__."/../../config.php");
require_once(__DIR__."/../../libs/db.php");
require_once(__DIR__."/../../libs/helper.php");

$CMSNT = new DB();
$Mobile_Detect = new Mobile_Detect();
use PragmaRX\Google2FAQRCode\Google2FA;


if (isset($_POST['action'])) {
    if ($CMSNT->site('status') != 1 && !isset($_SESSION['admin_login'])) {
        die(json_encode(['status' => 'error', 'msg' => __('Hệ thống đang bảo trì định kỳ, vui lòng quay lại sau !')]));
    }

    if($_POST['action'] == 'add-create-website'){
        if (empty($_POST['token'])) {
            die(json_encode(['status' => 'error', 'msg' => __('Vui lòng đăng nhập')]));
        }
        if (!$getUser = $CMSNT->get_row("SELECT * FROM `users` WHERE `token` = '".check_string($_POST['token'])."' AND `banned` = 0 ")) {
            die(json_encode(['status' => 'error', 'msg' => __('Vui lòng đăng nhập')]));
        }
        if (time() - $getUser['time_request'] < $config['max_time_load']) {
            die(json_encode(['status' => 'error', 'msg' => __('Bạn đang thao tác quá nhanh, vui lòng chờ')]));
        }
        if (empty($_POST['domain'])) {
            die(json_encode(['status' => 'error', 'msg' => __('Vui lòng nhập tên miền')]));
        }
        $domain = check_string($_POST['domain']);
        if(is_valid_domain_name($domain) != true){
            die(json_encode(['status' => 'error', 'msg' => __('Vui lòng nhập tên miền hợp lệ')]));
        }
        if(strpos($domain, '.') == false){
            die(json_encode(['status' => 'error', 'msg' => __('Vui lòng nhập tên miền hợp lệ')]));
        }
        if($CMSNT->get_row(" SELECT COUNT(id) FROM `domains` WHERE `domain` = '$domain' ")['COUNT(id)'] > 0){
            die(json_encode(['status' => 'error', 'msg' => __('Tên miền này đã tồn tại trong hệ thống')]));
        }
        $isInsert = $CMSNT->insert('domains', [
            'user_id'           => $getUser['id'],
            'domain'            => $domain,
            'status'            => 0,
            'create_gettime'    => gettime(),
            'update_gettime'    => gettime()
        ]);
        if($isInsert){
            die(json_encode(['status' => 'success', 'msg' => __('Thêm tên miền thành công')]));
        }
    }

   
    
}
