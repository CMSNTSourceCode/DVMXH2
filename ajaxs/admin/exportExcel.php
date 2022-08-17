<?php

define("IN_SITE", true);

require_once(__DIR__."/../../libs/db.php");
require_once(__DIR__."/../../libs/helper.php");
require_once(__DIR__.'/../../models/is_admin.php');
$CMSNT = new DB();
$Mobile_Detect = new Mobile_Detect();


if ($CMSNT->site('status_demo') != 0) {
    $data = json_encode([
        'status'    => 'error',
        'msg'       => 'Không được dùng chức năng này vì đây là trang web demo'
    ]);
    die($data);
}

if (isset($_POST['type'])) {

    if($_POST['type'] == 'users'){
        $content = 'ID,TÀI KHOẢN,EMAIL,MẬT KHẨU,SỐ DƯ KHẢ DỤNG,TỔNG NẠP,GIẢM GIÁ,ĐĂNG KÝ,ĐĂNG NHẬP,IP,BANNED,CTV,ADMIN'.PHP_EOL;
        foreach($CMSNT->get_list(" SELECT * FROM `users` ORDER BY `id` ") as $row){
            $content .= $row['id'].
            ','.$row['username'].
            ','.$row['email'].
            ','.$row['password'].
            ','.format_currency($row['money']).
            ','.format_currency($row['total_money']).
            ','.$row['chietkhau'].'%'.
            ','.$row['create_date'].
            ','.$row['update_date'].
            ','.$row['ip'].
            ','.$row['banned'].
            ','.$row['ctv'].
            ','.$row['admin'].
            PHP_EOL;
        }
        if (isset($content)) {
            $file = "Users.csv";
            $Mobile_Detect = new Mobile_Detect();
            $CMSNT->insert("logs", [
                'user_id'       => $getUser['id'],
                'ip'            => myip(),
                'device'        => $Mobile_Detect->getUserAgent(),
                'createdate'    => gettime(),
                'action'        => 'Tải về dữ liệu Users.csv'
            ]);
            die(json_encode([
                'status'    => 'success',
                'filename'  => $file,
                'accounts'  => $content,
                'msg'       => __('Đang tải xuống...')
            ]));
        } else {
            die(json_encode([
                'status'    => 'error',
                'msg'       => __('Tải về đơn hàng thất bại')
            ]));
        }
    }






    die(json_encode([
        'status'    => 'error',
        'msg'       => __('Dữ liệu không hợp lệ')
    ]));
}
die(json_encode([
    'status'    => 'error',
    'msg'       => __('Dữ liệu không hợp lệ')
]));
