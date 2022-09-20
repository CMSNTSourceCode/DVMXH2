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


   
    
}
