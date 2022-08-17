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
    if(!$getUser = $CMSNT->get_row("SELECT * FROM `users` WHERE `token` = '".check_string($_POST['token'])."' AND `banned` = 0 ")){
        die(json_encode([
            'status'    => 'error',
            'msg'       => __('Token không tồn tại trong hệ thống')
        ]));
    }
    $categories = [];
    foreach($CMSNT->get_list("SELECT * FROM `categories` WHERE `display` = 1 ") as $category){
        $service = [];
        foreach($CMSNT->get_list(" SELECT * FROM `services` WHERE `category_id` = '".$category['id']."' AND `display` = 1 ") as $row_service){
            $pack = [];
            foreach($CMSNT->get_list(" SELECT * FROM `service_packs` WHERE `service_id` = '".$row_service['id']."' AND `display` = 1 ") as $row_pack){
                $pack[] = [
                    'id'            => $row_pack['id'],
                    'name'          => $row_pack['name'],
                    'price'         => $row_pack['price'],
                    'min_order'     => $row_pack['min_order'],
                    'max_order'     => $row_pack['max_order'],
                    'content'       => $row_pack['content'],
                    'show_comment'  => $row_pack['show_comment'],
                    'show_camxuc'   => $row_pack['show_camxuc']
                ];
            }
            $service[] = [
                'id'                => $row_service['id'],
                'name'              => $row_service['name'],
                'icon'              => base_url($row_service['icon']),
                'content'           => $row_service['content'],
                'text_input'        => $row_service['text_input'],
                'text_placeholder'  => $row_service['text_placeholder'],
                'pack'              => $pack
            ];
        }
        $categories[] = [
            'id'        => $category['id'],
            'name'      => $category['name'],
            'icon'      => base_url($category['icon']),
            'content'   => $category['content'],
            'service'   => $service
        ];
    }
    die(json_encode([
        'status'    => 'success',
        'msg'       => 'Lấy danh sách dịch vụ thành công!',
        'category'  => $categories
    ]));
    echo json_encode($data, JSON_PRETTY_PRINT);


    
}
 
 
 