<?php

define("IN_SITE", true);
require_once(__DIR__."/../../config.php");
require_once(__DIR__."/../../libs/db.php");
require_once(__DIR__."/../../libs/helper.php");
 

$CMSNT = new DB();
$Mobile_Detect = new Mobile_Detect();
use PragmaRX\Google2FAQRCode\Google2FA;


if (isset($_POST['action'])) {





    if($_POST['action'] == 'Login')
    {
        $email = check_string($_POST['email']);
        $password = check_string($_POST['password']);
        if (empty($email = check_string($_POST['email']))) {
            die(json_encode([
                'status'    => 'error',
                'msg'       => 'Email không được để trống'
            ]));
        }
        if (empty($_POST['password'])) {
            die(json_encode([
                'status'    => 'error',
                'msg'       => 'Mật khẩu không được để trống'
            ]));
        }
        if ($CMSNT->site('status_captcha') == 1) {
            $phrase = check_string($_POST['phrase']);
            if (strcasecmp($phrase, $_SESSION['phrase']) != 0) {
                die(json_encode(['status' => 'error', 'msg' => __('Captcha không chính xác')]));
            }
        }
        if(getLocation(myip())['country'] != 'VN'){
            die(json_encode([
                'status'    => 'error',
                'msg'       => __('Vui lòng dùng địa chỉ IP thật để truy cập quản trị')
            ]));
        }
        $getUser = $CMSNT->get_row("SELECT * FROM `users` WHERE `email` = '$email' AND `admin` = 1 ");
        if (!$getUser) {
            die(json_encode([
                'status'    => 'error',
                'msg'       => __('Thông tin đăng nhập không chính xác')
            ]));
        }
        if (time() > $getUser['time_request']) {
            if (time() - $getUser['time_request'] < $config['max_time_load']) {
                die(json_encode(['status' => 'error', 'msg' => __('Bạn đang thao tác quá nhanh, vui lòng chờ')]));
            }
        }
        if ($CMSNT->site('type_password') == 'bcrypt') {
            if (!password_verify($password, $getUser['password'])) {
                die(json_encode([
                    'status'    => 'error',
                    'msg'       => __('Thông tin đăng nhập không chính xác')
                ]));
            }
        } else {
            if ($getUser['password'] != TypePassword($password)) {
                die(json_encode([
                    'status'    => 'error',
                    'msg'       => __('Thông tin đăng nhập không chính xác')
                ]));
            }
        }

        if ($getUser['status_2fa'] == 1) {
            die(json_encode([
                'status'    => 'verify',
                'url'       => base_url('admin/verify/'.base64_encode($getUser['token'])),
                'msg'       => __('Vui lòng xác minh 2FA để hoàn thành đăng nhập')
            ]));
        }
        $CMSNT->insert("logs", [
            'user_id'       => $getUser['id'],
            'ip'            => myip(),
            'device'        => $Mobile_Detect->getUserAgent(),
            'createdate'    => gettime(),
            'action'        => '[Warning] '.__('Đăng nhập thành công vào hệ thống Admin')
        ]);
        $new_token = $getUser['token'];
        $CMSNT->update("users", [
            'ip'        => myip(),
            'time_request' => time(),
            'time_session' => time(),
            'device'    => $Mobile_Detect->getUserAgent()
        ], " `id` = '".$getUser['id']."' ");
        setcookie("token", $new_token, time() + $CMSNT->site('session_login'), "/");
        $_SESSION['admin_login'] = $new_token;
        die(json_encode(['status' => 'success','msg' => 'Đăng nhập thành công!']));
    }


    if ($_POST['action'] == 'VerifyGoogle2FA') {
        if (empty($_POST['token'])) {
            die(json_encode(['status' => 'error', 'msg' => __('Vui lòng đăng nhập')]));
        }
        if (!$getUser = $CMSNT->get_row("SELECT * FROM `users` WHERE `token` = '".check_string($_POST['token'])."' AND `admin` = 1 ")) {
            die(json_encode(['status' => 'error', 'msg' => __('Vui lòng đăng nhập')]));
        }
        if (empty($_POST['code'])) {
            die(json_encode(['status' => 'error', 'msg' => __('Vui lòng nhập mã xác minh')]));
        }
        $google2fa = new Google2FA();
        if ($google2fa->verifyKey($getUser['SecretKey_2fa'], check_string($_POST['code'])) != true) {
            $CMSNT->insert("logs", [
                'user_id'       => $getUser['id'],
                'ip'            => myip(),
                'device'        => $Mobile_Detect->getUserAgent(),
                'createdate'    => gettime(),
                'action'        => '[Warning] Phát hiện có người đang cố gắng nhập mã xác minh'
            ]);
            die(json_encode(['status' => 'error', 'msg' => __('Mã xác minh không chính xác')]));
        }
        $CMSNT->insert("logs", [
            'user_id'       => $getUser['id'],
            'ip'            => myip(),
            'device'        => $Mobile_Detect->getUserAgent(),
            'createdate'    => gettime(),
            'action'        => 'Đăng nhập thành công vào hệ thống Admin.'
        ]);
        $CMSNT->update("users", [
            'ip' => myip(),
            'device' => $Mobile_Detect->getUserAgent()
        ], " `id` = '".$getUser['id']."' ");
        setcookie("token", $getUser['token'], time() + $CMSNT->site('session_login'), "/");
        $_SESSION['admin_login'] = $getUser['token'];
        die(json_encode([
            'status' => 'success',
            'msg' => 'Đăng nhập thành công!'
        ]));
    }
}
