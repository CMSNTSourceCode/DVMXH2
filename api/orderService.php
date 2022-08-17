<?php

define("IN_SITE", true);
require_once(__DIR__."/../config.php");
require_once(__DIR__."/../libs/db.php");
require_once(__DIR__."/../libs/helper.php");
require_once(__DIR__."/../libs/database/users.php");
$User = new users();
$CMSNT = new DB();
$Mobile_Detect = new Mobile_Detect();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if ($CMSNT->site('status') != 1 && !isset($_SESSION['admin_login'])) {
        die(json_encode([
            'status' => 'error',
            'msg'   => __('Hệ thống đang bảo trì')
        ]));
    }
    if(empty($_POST['token'])){
        die(json_encode([
            'status' => 'error',
            'msg'   => __('Vui lòng đăng nhập để sử dụng chức năng này')
        ]));
    }
    if(empty($_POST['url'])){
        die(json_encode([
            'status' => 'error',
            'msg'   => __('Vui lòng điền URL hoặc ID cần tăng')
        ]));
    }
    if(empty($_POST['service_pack'])){
        die(json_encode([
            'status' => 'error',
            'msg'   => __('Vui lòng gói dịch vụ cần mua')
        ]));
    }
    if(empty($_POST['amount'])){
        die(json_encode([
            'status' => 'error',
            'msg'   => __('Vui nhập số lượng cần mua')
        ]));
    }
    if(!$getUser = $CMSNT->get_row("SELECT * FROM `users` WHERE `token` = '".check_string($_POST['token'])."' AND `banned` = 0 ")){
        die(json_encode([
            'status' => 'error',
            'msg'   => __('Thông tin đăng nhập không chính xác')
        ]));
    }
    if (time() > $getUser['time_request']) {
        if (time() - $getUser['time_request'] < $config['max_time_load']) {
            die(json_encode(['status' => 'error', 'msg' => __('Bạn đang thao tác quá nhanh, vui lòng chờ')]));
        }
    }
    if(!$row = $CMSNT->get_row("SELECT * FROM `service_packs` WHERE `id` = '".check_string($_POST['service_pack'])."' ")){
        die(json_encode([
            'status' => 'error',
            'msg'   => __('Gói dịch vụ không tồn tại trong hệ thống')
        ]));
    }
    if($row['display'] != 1){
        die(json_encode([
            'status' => 'error',
            'msg'   => __('Gói dịch vụ đang bảo trì')
        ]));
    }
    if(getRowRealtime('services', $row['service_id'], 'display') != 1){
        die(json_encode([
            'status' => 'error',
            'msg'   => __('Dịch vụ này đang bảo trì')
        ]));
    }
    if(getRowRealtime('categories', getRowRealtime('services', $row['service_id'], 'category_id'), 'display') != 1){
        die(json_encode([
            'status' => 'error',
            'msg'   => __('Chuyên mục này đang bảo trì')
        ]));
    }
    $camxuc = NULL;
    if(!empty($_POST['camxuc'])){
        $camxuc = check_string($_POST['camxuc']);
    }
    $amount = check_string($_POST['amount']);
    $comment = NULL;
    if(!empty($_POST['comment'])){
        $amount = substr_count($_POST['comment'], PHP_EOL) + 1;
        $comment = check_string($_POST['comment']);
        if($row['min_order'] > $amount){
            die(json_encode([
                'status' => 'error',
                'msg'   => __('Số lượng mua tối thiểu là').' '.format_cash($row['min_order'])
            ]));
        }
        if($row['max_order'] < $amount){
            die(json_encode([
                'status' => 'error',
                'msg'   => __('Số lượng mua tối đa là').' '.format_cash($row['max_order'])
            ]));
        }
    }else{
        if($row['min_order'] > $_POST['amount']){
            die(json_encode([
                'status' => 'error',
                'msg'   => __('Số lượng mua tối thiểu là').' '.format_cash($row['min_order'])
            ]));
        }
        if($row['max_order'] < $_POST['amount']){
            die(json_encode([
                'status' => 'error',
                'msg'   => __('Số lượng mua tối đa là').' '.format_cash($row['max_order'])
            ]));
        }
    }
    $total_payment = $amount * $row['price'];
    $total_payment = $total_payment - $total_payment * $getUser['chietkhau'] / 100;
    if(getRowRealtime('users', $getUser['id'], 'money') < $total_payment){
        die(json_encode([
            'status' => 'error',
            'msg'   => __('Số dư không đủ, vui lòng nạp thêm tiền để tiếp tục sử dụng')
        ]));
    }
    $trans_id = random('QWERTYUPASDFGHKZXCVBN0123456798', 6);
    $isBuy = $User->RemoveCredits($getUser['id'], $total_payment, 'Thanh toán đơn hàng #'.$trans_id.' ('.$row['name'].' số lượng '.$amount.')');
    if($isBuy){
        if (getRowRealtime("users", $getUser['id'], "money") < 0) {
            $User->Banned($getUser['id'], 'Gian lận khi mua dịch vụ');
            die(json_encode(['status' => 'error', 'msg' => __('Bạn đã bị khoá tài khoản vì gian lận')]));
        }   
        $isCreateOrder = $CMSNT->insert('orders', [
            'buyer'             => $getUser['id'],
            'service_id'        => $row['service_id'],
            'service_pack_id'   => $row['id'],
            'amount'            => $amount,
            'price'             => $total_payment,
            'url'               => check_string($_POST['url']),
            'note'              => !empty($_POST['note']) ? check_string($_POST['note']) : NULL,
            'trans_id'          => $trans_id,
            'camxuc'            => $camxuc,
            'comment'           => $comment,
            'create_time'       => time(),
            'create_gettime'    => gettime(),
            'update_time'       => time(),
            'update_gettime'    => gettime()
        ]);
        if($isCreateOrder){
            $my_text = $CMSNT->site('text_notification');
            $my_text = str_replace('{domain}', $_SERVER['SERVER_NAME'], $my_text);
            $my_text = str_replace('{service_name}', getRowRealtime('services', $row['service_id'], 'name'), $my_text);
            $my_text = str_replace('{service_pack_name}', $row['name'], $my_text);
            $my_text = str_replace('{amount}', $amount, $my_text);
            $my_text = str_replace('{price}', $total_payment, $my_text);
            $my_text = str_replace('{url}', check_string($_POST['url']), $my_text);
            $my_text = str_replace('{note}', !empty($_POST['note']) ? check_string($_POST['note']) : NULL, $my_text);
            sendMessTelegram($my_text);
            
            die(json_encode(['status' => 'success', 'msg' => __('Tạo đơn hàng thành công')]));
        }
        die(json_encode(['status' => 'error', 'msg' => __('Không thể tạo đơn hàng, vui lòng liên hệ Admin !')]));
    }
    

}
 
 
 






