<?php

define("IN_SITE", true);

require_once(__DIR__."/../../libs/db.php");
require_once(__DIR__."/../../libs/helper.php");
require_once(__DIR__.'/../../models/is_admin.php');

if ($CMSNT->site('status_demo') != 0) {
    die(json_encode(['status' => 'error','msg' => 'Không được dùng chức năng này vì đây là trang web demo']));
}
if (isset($_POST['action'])) {

    // EDIT STT POST
    if($_POST['action'] == 'changePOST'){
        $isUpdate = $CMSNT->update("posts", [
            'stt'  => check_string($_POST['stt'])
        ], " `id` = '".check_string($_POST['id'])."' ");
        if($isUpdate){
            die(json_encode(['status' => 'success', 'msg' => 'Cập nhật thành công!']));
        }
        die(json_encode(['status' => 'error', 'msg' => 'Cập nhật thất bại']));
    }

    // EDIT STT CATEGORY
    if($_POST['action'] == 'changeCATEGORY'){
        $isUpdate = $CMSNT->update("categories", [
            'stt'  => check_string($_POST['stt'])
        ], " `id` = '".check_string($_POST['id'])."' ");
        if($isUpdate){
            die(json_encode(['status' => 'success', 'msg' => 'Cập nhật thành công!']));
        }
        die(json_encode(['status' => 'error', 'msg' => 'Cập nhật thất bại']));
    }

    // EDIT STT PRODUCT
    if($_POST['action'] == 'changeService'){
        $isUpdate = $CMSNT->update("services", [
            'stt'  => check_string($_POST['stt'])
        ], " `id` = '".check_string($_POST['id'])."' ");
        if($isUpdate){
            die(json_encode(['status' => 'success', 'msg' => 'Cập nhật thành công!']));
        }
        die(json_encode(['status' => 'error', 'msg' => 'Cập nhật thất bại']));
    }

    // EDIT STT MENU
    if($_POST['action'] == 'changeMenu'){
        $isUpdate = $CMSNT->update("menu", [
            'stt'  => check_string($_POST['stt'])
        ], " `id` = '".check_string($_POST['id'])."' ");
        if($isUpdate){
            die(json_encode(['status' => 'success', 'msg' => 'Cập nhật thành công!']));
        }
        die(json_encode(['status' => 'error', 'msg' => 'Cập nhật thất bại']));
    }

    // EDIT STT SERVICE PACKS
    if($_POST['action'] == 'changeServicePacks'){
        if($_POST['service_id'] == 0){
            die(json_encode(['status' => 'error', 'msg' => 'Vui lòng chọn dịch vụ hợp lệ <br> (dịch vụ phải có dấu --- đầu tiên)']));
        }
        $isUpdate = $CMSNT->update("service_packs", [
            'stt'                   => check_string($_POST['stt']),
            'service_id'            => check_string($_POST['service_id']),
            'name'                  => check_string($_POST['name']),
            'price'                 => check_string($_POST['price']),
            'cost'                  => check_string($_POST['cost']),
            'min_order'             => check_string($_POST['min_order']),
            'max_order'             => check_string($_POST['max_order']),
            'content'               => check_string($_POST['content']),
            'display'               => !empty($_POST['display']) ? check_string($_POST['display']) : 0,
            'show_comment'          => !empty($_POST['show_comment']) ? check_string($_POST['show_comment']) : 0,
            'show_camxuc'           => !empty($_POST['show_camxuc']) ? check_string($_POST['show_camxuc']) : 0
        ], " `id` = '".check_string($_POST['id'])."' ");
        if($isUpdate){
            die(json_encode(['status' => 'success', 'msg' => 'Cập nhật thành công!']));
        }
        die(json_encode(['status' => 'error', 'msg' => 'Cập nhật thất bại']));
    }



} 
$data = json_encode([
    'status'    => 'error',
    'msg'       => 'Dữ liệu không hợp lệ'
]);
die($data);

