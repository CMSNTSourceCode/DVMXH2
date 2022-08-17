<?php

define("IN_SITE", true);
require_once(__DIR__."/../../libs/db.php");
require_once(__DIR__."/../../libs/helper.php");
require_once(__DIR__.'/../../models/is_admin.php');
if ($CMSNT->site('status_demo') != 0) {
    $data = json_encode([
        'status'    => 'error',
        'msg'       => 'Không được dùng chức năng này vì đây là trang web demo'
    ]);
    die($data);
}
if(!isset($_POST['action'])){
    $data = json_encode([
        'status'    => 'error',
        'msg'       => 'The Request Not Found'
    ]);
    die($data);   
}


//  XOÁ CATEGORY
if($_POST['action'] == 'removeCategory'){
    $id = check_string($_POST['id']);
    if (!$row = $CMSNT->get_row("SELECT * FROM `categories` WHERE `id` = '$id' ")) {
        die(json_encode([
            'status'    => 'error',
            'msg'       => 'ID chuyên mục không tồn tại trong hệ thống'
        ]));
    }
    $isRemove = $CMSNT->remove("categories", " `id` = '$id' ");
    if ($isRemove) {
        unlink("../../".$row['icon']);
        $Mobile_Detect = new Mobile_Detect();
        $CMSNT->insert("logs", [
            'user_id'       => $getUser['id'],
            'ip'            => myip(),
            'device'        => $Mobile_Detect->getUserAgent(),
            'createdate'    => gettime(),
            'action'        => 'Xoá chuyên mục ('.$row['name'].' ID '.$row['id'].')'
        ]);
        $data = json_encode([
            'status'    => 'success',
            'msg'       => 'Xóa chuyên mục thành công'
        ]);
        die($data);
    }
}

//  XOÁ SERVICE
if($_POST['action'] == 'removeService'){
    $id = check_string($_POST['id']);
    if (!$row = $CMSNT->get_row("SELECT * FROM `services` WHERE `id` = '$id' ")) {
        die(json_encode([
            'status'    => 'error',
            'msg'       => 'ID dịch vụ không tồn tại trong hệ thống'
        ]));
    }
    $isRemove = $CMSNT->remove("services", " `id` = '$id' ");
    if ($isRemove) {
        unlink("../../".$row['icon']);
        $Mobile_Detect = new Mobile_Detect();
        $CMSNT->insert("logs", [
            'user_id'       => $getUser['id'],
            'ip'            => myip(),
            'device'        => $Mobile_Detect->getUserAgent(),
            'createdate'    => gettime(),
            'action'        => 'Xoá dịch vụ ('.$row['name'].' ID '.$row['id'].')'
        ]);
        $data = json_encode([
            'status'    => 'success',
            'msg'       => 'Xóa dịch vụ thành công'
        ]);
        die($data);
    }
}

//  XOÁ OST
if($_POST['action'] == 'removePost'){
    $id = check_string($_POST['id']);
    if (!$row = $CMSNT->get_row("SELECT * FROM `posts` WHERE `id` = '$id' ")) {
        die(json_encode([
            'status'    => 'error',
            'msg'       => 'ID bài viết không tồn tại trong hệ thống'
        ]));
    }
    $isRemove = $CMSNT->remove("posts", " `id` = '$id' ");
    if ($isRemove) {
        $Mobile_Detect = new Mobile_Detect();
        $CMSNT->insert("logs", [
            'user_id'       => $getUser['id'],
            'ip'            => myip(),
            'device'        => $Mobile_Detect->getUserAgent(),
            'createdate'    => gettime(),
            'action'        => 'Xoá bài viết ('.$row['title'].' ID '.$row['id'].')'
        ]);
        $data = json_encode([
            'status'    => 'success',
            'msg'       => 'Xóa bài viết thành công'
        ]);
        die($data);
    }
}

// XOÁ USER
if($_POST['action'] == 'removeUser'){
    if (isset($_POST['id'])) {
        $id = check_string($_POST['id']);
        $row = $CMSNT->get_row("SELECT * FROM `users` WHERE `id` = '$id' ");
        if (!$row) {
            $data = json_encode([
                'status'    => 'error',
                'msg'       => 'ID user không tồn tại trong hệ thống'
            ]);
            die($data);
        }
        $isRemove = $CMSNT->remove("users", " `id` = '$id' ");
        if ($isRemove) {
            $Mobile_Detect = new Mobile_Detect();
            $CMSNT->insert("logs", [
                'user_id'       => $getUser['id'],
                'ip'            => myip(),
                'device'        => $Mobile_Detect->getUserAgent(),
                'createdate'    => gettime(),
                'action'        => 'Xoá người dùng ('.$row['username'].' ID '.$row['id'].')'
            ]);
            $data = json_encode([
                'status'    => 'success',
                'msg'       => 'Xóa người dùng thành công'
            ]);
            die($data);
        }
    } 
}

//  XOÁ MENU
if($_POST['action'] == 'removeMenu'){
    $id = check_string($_POST['id']);
    if (!$row = $CMSNT->get_row("SELECT * FROM `menu` WHERE `id` = '$id' ")) {
        die(json_encode([
            'status'    => 'error',
            'msg'       => 'ID menu không tồn tại trong hệ thống'
        ]));
    }
    $isRemove = $CMSNT->remove("menu", " `id` = '$id' ");
    if ($isRemove) {
        unlink("../../".$row['icon']);
        $Mobile_Detect = new Mobile_Detect();
        $CMSNT->insert("logs", [
            'user_id'       => $getUser['id'],
            'ip'            => myip(),
            'device'        => $Mobile_Detect->getUserAgent(),
            'createdate'    => gettime(),
            'action'        => 'Xoá menu ('.$row['name'].' ID '.$row['id'].')'
        ]);
        $data = json_encode([
            'status'    => 'success',
            'msg'       => 'Xóa menu thành công'
        ]);
        die($data);
    }
}

//  XOÁ SERVICE PACK
if($_POST['action'] == 'removeServicePack'){
    $id = check_string($_POST['id']);
    if (!$row = $CMSNT->get_row("SELECT * FROM `service_packs` WHERE `id` = '$id' ")) {
        die(json_encode([
            'status'    => 'error',
            'msg'       => 'ID gói dịch vụ không tồn tại trong hệ thống'
        ]));
    }
    $isRemove = $CMSNT->remove("service_packs", " `id` = '$id' ");
    if ($isRemove) {
        $Mobile_Detect = new Mobile_Detect();
        $CMSNT->insert("logs", [
            'user_id'       => $getUser['id'],
            'ip'            => myip(),
            'device'        => $Mobile_Detect->getUserAgent(),
            'createdate'    => gettime(),
            'action'        => 'Xoá gói dịch vụ ('.$row['name'].' ID '.$row['id'].')'
        ]);
        $data = json_encode([
            'status'    => 'success',
            'msg'       => 'Xóa dịch vụ thành công'
        ]);
        die($data);
    }
}

//  XOÁ BANK
if($_POST['action'] == 'removeBank'){
    $id = check_string($_POST['id']);
    if (!$row = $CMSNT->get_row("SELECT * FROM `banks` WHERE `id` = '$id' ")) {
        die(json_encode([
            'status'    => 'error',
            'msg'       => 'ID ngân hàng không tồn tại trong hệ thống'
        ]));
    }
    $isRemove = $CMSNT->remove("banks", " `id` = '$id' ");
    if ($isRemove) {
        // XÓA LOGO BANK
        unlink("../../".$row['image']);
        $Mobile_Detect = new Mobile_Detect();
        $CMSNT->insert("logs", [
            'user_id'       => $getUser['id'],
            'ip'            => myip(),
            'device'        => $Mobile_Detect->getUserAgent(),
            'createdate'    => gettime(),
            'action'        => 'Xoá ngân hàng ('.$row['short_name'].' ID '.$row['id'].')'
        ]);
        $data = json_encode([
            'status'    => 'success',
            'msg'       => 'Xóa ngân hàng thành công'
        ]);
        die($data);
    }
}


die(json_encode([
    'status'    => 'error',
    'msg'       => 'Dữ liệu không hợp lệ'
]));

