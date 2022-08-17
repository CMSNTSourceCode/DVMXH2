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


    if($_POST['action'] == 'Login'){
        $username = check_string($_POST['username']);
        $password = check_string($_POST['password']);
        if (empty($username = check_string($_POST['username']))) {
            die(json_encode([
                'status'    => 'error',
                'msg'       => __('Username không được để trống')
            ]));
        }
        if (empty($_POST['password'])) {
            die(json_encode([
                'status'    => 'error',
                'msg'       => __('Mật khẩu không được để trống')
            ]));
        }
        $getUser = $CMSNT->get_row("SELECT * FROM `users` WHERE `username` = '$username' ");
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
        $CMSNT->insert("logs", [
            'user_id'       => $getUser['id'],
            'ip'            => myip(),
            'device'        => $Mobile_Detect->getUserAgent(),
            'createdate'    => gettime(),
            'action'        => '[Warning] '.__('Đăng nhập thành công')
        ]);
        $new_token = md5(random('QWERTYUIOPASDGHJKLZXCVBNMqwertyuiopasdfghjklzxcvbnm0123456789', 6).time());
        $CMSNT->update("users", [
            'ip'        => myip(),
            'time_request' => time(),
            'time_session' => time(),
            'device'    => $Mobile_Detect->getUserAgent(),
            'token'     => $new_token
        ], " `id` = '".$getUser['id']."' ");
        setcookie("token", $new_token, time() + $CMSNT->site('session_login'), "/");
        $_SESSION['login'] = $new_token;
        die(json_encode(['status' => 'success','msg' => __('Đăng nhập thành công!')]));
    }

    if($_POST['action'] == 'Register'){
        if (empty($_POST['username'])) {
            die(json_encode(['status' => 'error', 'msg' => __('Username không được để trống')]));
        }
        if (empty($_POST['email'])) {
            die(json_encode(['status' => 'error', 'msg' => __('Email không được để trống')]));
        }
        if (empty($_POST['password'])) {
            die(json_encode(['status' => 'error', 'msg' => __('Mật khẩu không được để trống')]));
        }
        if (empty($_POST['repassword'])) {
            die(json_encode(['status' => 'error', 'msg' => __('Nhập lại mật khẩu không đúng')]));
        }
        $username = check_string($_POST['username']);
        $email = check_string($_POST['email']);
        $password = check_string($_POST['password']);
        $repassword = check_string($_POST['repassword']);
        if ($password != $repassword) {
            die(json_encode(['status' => 'error', 'msg' => __('Nhập lại mật khẩu không đúng')]));
        }
        if (check_email($email) != true) {
            die(json_encode(['status' => 'error', 'msg' => __('Định dạng Email không đúng')]));
        }
        if ($CMSNT->site('status_captcha') == 1) {
            $phrase = check_string($_POST['phrase']);
            if (strcasecmp($phrase, $_SESSION['phrase']) != 0) {
                die(json_encode(['status' => 'error', 'msg' => __('Captcha không chính xác')]));
            }
        }
        if ($CMSNT->num_rows("SELECT * FROM `users` WHERE `username` = '$username' ") > 0) {
            die(json_encode(['status' => 'error','msg' => __('Tên đăng nhập đã tồn tại trong hệ thống')]));
        }
        if ($CMSNT->num_rows("SELECT * FROM `users` WHERE `email` = '$email' ") > 0) {
            die(json_encode(['status' => 'error', 'msg' => __('Địa chỉ email đã tồn tại trong hệ thống')]));
        }
        if ($CMSNT->num_rows("SELECT * FROM `users` WHERE `ip` = '".myip()."' ") >= 5) {
            die(json_encode(['status' => 'error', 'msg' => __('IP của bạn đã đạt giới hạn tạo tài khoản cho phép')]));
        }
        $google2fa = new Google2FA();
        $token = md5(random('QWERTYUIOPASDGHJKLZXCVBNMqwertyuiopasdfghjklzxcvbnm0123456789', 6).time());
        $isCreate = $CMSNT->insert("users", [
            'token'         => $token,
            'username'      => $username,
            'email'         => $email,
            'password'      => TypePassword($password),
            'ip'            => myip(),
            'device'        => $Mobile_Detect->getUserAgent(),
            'create_date'   => gettime(),
            'update_date'   => gettime(),
            'time_session'  => time(),
            'SecretKey_2fa' => $google2fa->generateSecretKey()
        ]);
        if ($isCreate) {
            $CMSNT->insert("logs", [
                'user_id'       => $CMSNT->get_row("SELECT * FROM `users` WHERE `token` = '$token' ")['id'],
                'ip'            => myip(),
                'device'        => $Mobile_Detect->getUserAgent(),
                'createdate'    => gettime(),
                'action'        => __('Thực hiện tạo tài khoản')
            ]);
            setcookie("token", $token, time() + $CMSNT->site('session_login'), "/");
            $_SESSION['login'] = $token;
            die(json_encode(['status' => 'success', 'msg' => __('Đăng ký thành công')]));
        } else {
            die(json_encode(['status' => 'error', 'msg' => __('Tạo tài khoản thất bại, vui lòng thử lại')]));
        }
    }

    if($_POST['action'] == 'ChangeProfile'){
        if ($CMSNT->site('status_demo') != 0) {
            die(json_encode(['status' => 'error', 'msg' => __('Chức năng này không khả dụng trên trang web demo !')]));
        }
        if (empty($_POST['token'])) {
            die(json_encode(['status' => 'error', 'msg' => __('Vui lòng đăng nhập')]));
        }
        if (!$getUser = $CMSNT->get_row("SELECT * FROM `users` WHERE `token` = '".check_string($_POST['token'])."' ")) {
            die(json_encode(['status' => 'error', 'msg' => __('Vui lòng đăng nhập')]));
        }
        if (empty($_POST['gender'])) {
            die(json_encode(['status' => 'error', 'msg' => __('Vui lòng chọn giới tính')]));
        }
        $isUpdate = $CMSNT->update("users", [
            'fullname' => isset($_POST['fullname']) ? check_string($_POST['fullname']) : null,
            'gender' => isset($_POST['gender']) ? check_string($_POST['gender']) : 'Male',
            'phone' => isset($_POST['phone']) ? check_string($_POST['phone']) : null
        ], " `token` = '".check_string($_POST['token'])."' ");
        if ($isUpdate) {
            $CMSNT->insert("logs", [
                'user_id'       => $getUser['id'],
                'ip'            => myip(),
                'device'        => $Mobile_Detect->getUserAgent(),
                'createdate'    => gettime(),
                'action'        => __('Thay đổi thông tin hồ sơ')
            ]);
            die(json_encode(['status' => 'success', 'msg' => __('Lưu thành công')]));
        }
        die(json_encode(['status' => 'error', 'msg' => __('Lưu thất bại')]));
    }

    if($_POST['action'] == 'ChangePasswordProfile'){
        if ($CMSNT->site('status_demo') != 0) {
            die(json_encode(['status' => 'error', 'msg' => __('Chức năng này không khả dụng trên trang web demo !')]));
        }
        if (empty($_POST['token'])) {
            die(json_encode(['status' => 'error', 'msg' => __('Vui lòng đăng nhập')]));
        }
        if (!$getUser = $CMSNT->get_row("SELECT * FROM `users` WHERE `token` = '".check_string($_POST['token'])."' ")) {
            die(json_encode(['status' => 'error', 'msg' => __('Vui lòng đăng nhập')]));
        }
        if (empty($_POST['password'])) {
            die(json_encode(['status' => 'error', 'msg' => __('Vui lòng nhập mật khẩu hiện tại')]));
        }
        if (empty($_POST['newpassword'])) {
            die(json_encode(['status' => 'error', 'msg' => __('Vui lòng nhập mật khẩu mới')]));
        }
        if(strlen($_POST['newpassword']) < 5){
            die(json_encode(['status' => 'error', 'msg' => __('Mật khẩu của bạn quá ngắn')]));
        }
        if (empty($_POST['renewpassword'])) {
            die(json_encode(['status' => 'error', 'msg' => __('Nhập lại mật khẩu không đúng')]));
        }
        if ($_POST['renewpassword'] != $_POST['newpassword']) {
            die(json_encode(['status' => 'error', 'msg' => __('Nhập lại mật khẩu không đúng')]));
        }
        $password = check_string($_POST['password']);
        if ($CMSNT->site('type_password') == 'bcrypt') {
            if (!password_verify($password, $getUser['password'])) {
                die(json_encode(['status' => 'error', 'msg' => __('Mật khẩu hiện tại không chính xác')]));
            }
        } else {
            if ($getUser['password'] != TypePassword($password)) {
                die(json_encode(['status' => 'error', 'msg' => __('Mật khẩu hiện tại không chính xác')]));
            }
        }
        $isUpdate = $CMSNT->update("users", [
            'password'  => isset($_POST['newpassword']) ? TypePassword(check_string($_POST['newpassword'])) : null,
            'token'     => md5(random('QWERTYUIOPASDGHJKLZXCVBNMqwertyuiopasdfghjklzxcvbnm0123456789', 6).time())
        ], " `token` = '".check_string($_POST['token'])."' ");
        if ($isUpdate) {
            $CMSNT->insert("logs", [
                'user_id'       => $getUser['id'],
                'ip'            => myip(),
                'device'        => $Mobile_Detect->getUserAgent(),
                'createdate'    => gettime(),
                'action'        => __('Thay đổi mật khẩu')
            ]);
            die(json_encode(['status' => 'success', 'msg' => __('Đổi mật khẩu thành công')]));
        }
        die(json_encode(['status' => 'error', 'msg' => __('Đổi mật khẩu thất bại')]));
    }

    
}
