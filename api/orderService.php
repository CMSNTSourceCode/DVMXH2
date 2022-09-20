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

    $camxuc         = 'like'; // Loại cảm xúc
    $amount         = check_string($_POST['amount']); // Số lượng cần tăng
    $comment        = NULL; // Nội dung bình luận
    $num_minutes    = 0;    // Số phút tối thiểu
    $days           = 0;    // Số ngày cần chạy    
    $total_amount   = check_string($_POST['amount']); // Tổng số lượng cần tăng
    $server         = 'me';

    // KIỂM TRA CÓ CẢM XÚC HAY KHÔNG
    if(!empty($_POST['camxuc'])){
        $camxuc = check_string($_POST['camxuc']);
    }

    // TÍNH TOÁN MẮT LIVE
    if($row['show_eye'] == 1){
        if(empty($_POST['num_minutes']) && $_POST['num_minutes'] <= 0){
            die(json_encode(['status' => 'error', 'msg' => __('Vui lòng nhập số phút duy trì hợp lệ')]));
        }
        $num_minutes = check_string($_POST['num_minutes']);
        $total_amount = $amount * $num_minutes;
    }

    
    // TÍNH TOÁN VIPLIKE
    if($row['show_viplike'] == 1){
        if(empty($_POST['days'])){
            die(json_encode(['status' => 'error', 'msg' => __('Vui lòng nhập số ngày cần mua hợp lệ')]));
        }
        if(empty($_POST['amount_viplike'])){
            die(json_encode(['status' => 'error', 'msg' => __('Vui lòng nhập số lượng cần mua hợp lệ')]));
        }
        $days = check_string($_POST['days']);
        $amount = check_string($_POST['amount_viplike']);
        $total_amount = $amount * $days;
    }


    // TÍNH TOÁN REVIEW
    if($row['show_review'] == 1){
        if(empty($_POST['review'])){
            die(json_encode(['status' => 'error', 'msg' => __('Vui lòng nhập nội dung review')]));
        }
        $comment = check_string($_POST['review']);
    }

    // TÍNH TOÁN SỐ LƯỢNG BÌNH LUẬN
    if($row['show_comment'] == 1){
        if(!empty($_POST['comment'])){
            $total_amount = substr_count($_POST['comment'], PHP_EOL) + 1;
            $comment = check_string($_POST['comment']);
            $amount = $total_amount;
            if($row['min_order'] > $total_amount){
                die(json_encode([
                    'status' => 'error',
                    'msg'   => __('Số lượng mua tối thiểu là').' '.format_cash($row['min_order'])
                ]));
            }
            if($row['max_order'] < $total_amount){
                die(json_encode([
                    'status' => 'error',
                    'msg'   => __('Số lượng mua tối đa là').' '.format_cash($row['max_order'])
                ]));
            }
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

    // TÍNH TOÁN SỐ LƯỢNG * GIÁ
    $total_payment = $total_amount * $row['price'];
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


        // AUTOLIKE.CC
        if(isset(explode('autolike', $row['server'])[1])) {
            if($CMSNT->site('status_autolike') != 1){
                $User->AddCredits($getUser['id'], $total_payment, 'Hoàn tiền đơn hàng #'.$trans_id.' ('.$row['name'].' số lượng '.$amount.')');
                die(json_encode(['status' => 'error', 'msg' => __('Dịch vụ này đang được bảo trì')]));
            }
            require_once(__DIR__."/../libs/autolike.php");
            $autolike = new autolike;
            $data = $autolike->create(check_string($_POST['url']), $amount, $camxuc, $comment, $row['id_api'], $row['type_api'], $row['type2_api']);
            $data = json_decode($data, true);
            if($data['code'] != 200){
                $User->AddCredits($getUser['id'], $total_payment, 'Hoàn tiền đơn hàng #'.$trans_id.' ('.$row['name'].' số lượng '.$amount.')');
                die(json_encode(['status' => 'error', 'msg' => 'ERROR '.$data['code'].' | '.__($data['message'])]));
            }
            // MUA THÀNH CÔNG
            $id_api = $data['data'][0];
            $task_note = 'Server '.$CMSNT->site('domain_autolike');
            $server = $CMSNT->site('domain_autolike');
        }

        
        // BAOSTAR
        else if(isset(explode('baostar', $row['server'])[1])) {
            if($CMSNT->site('status_baostar') != 1){
                $User->AddCredits($getUser['id'], $total_payment, 'Hoàn tiền đơn hàng #'.$trans_id.' ('.$row['name'].' số lượng '.$amount.')');
                die(json_encode(['status' => 'error', 'msg' => __('Dịch vụ này đang được bảo trì')]));
            }
            require_once(__DIR__."/../libs/baostar.php");
            $baostar = new baostar;
            $uid = check_string($_POST['url']);
            if($row['type2_api'] == 'object_id'){
                $result = $baostar->convertURL(check_string($_POST['url']));
                $result = json_decode($result, true);
                if($result['status'] == 1){
                    $uid = $result['msg'];
                }
            }
            $note = 'Đơn hàng '.$trans_id.' - Khách hàng '.$getUser['username'].' - Thanh toán '.format_currency($total_payment);
            $data = $baostar->create($uid, $amount, $camxuc, $comment, $num_minutes, $days, $row['id_api'], $row['type_api'], $row['type2_api'], $note);
            $data = json_decode($data, true);
            if($data['status'] != 200){
                $User->AddCredits($getUser['id'], $total_payment, 'Hoàn tiền đơn hàng #'.$trans_id.' ('.$row['name'].' số lượng '.$amount.')');
                die(json_encode(['status' => 'error', 'msg' => 'ERROR '.$data['status'].' | '.__($data['message'])]));
            }
            // MUA THÀNH CÔNG
            $id_api = $data['data']['id'];
            $task_note = 'Server BAOSTAR.PRO';
            $server = 'BAOSTAR.PRO';
        }


        // AUTOFB88
        else if(isset(explode('autofb88', $row['server'])[1])) {
            if($CMSNT->site('status_autofb88') != 1){
                $User->AddCredits($getUser['id'], $total_payment, 'Hoàn tiền đơn hàng #'.$trans_id.' ('.$row['name'].' số lượng '.$amount.')');
                die(json_encode(['status' => 'error', 'msg' => __('Dịch vụ này đang được bảo trì')]));
            }
            require_once(__DIR__."/../libs/autofb88.php");
            $autofb88 = new autofb88;
            $note = 'Đơn hàng '.$trans_id.' - Khách hàng '.$getUser['username'].' - Thanh toán '.format_currency($total_payment);
            $data = $autofb88->create(check_string($_POST['url']), $amount, $camxuc, $comment, $num_minutes, $days, $row['id_api'], $row['type_api'], $row['type2_api'], $note);
            $data = json_decode($data, true);
            if($data['status'] != 200){
                $User->AddCredits($getUser['id'], $total_payment, 'Hoàn tiền đơn hàng #'.$trans_id.' ('.$row['name'].' số lượng '.$amount.')');
                die(json_encode(['status' => 'error', 'msg' => 'ERROR '.$data['status'].' | '.__($data['message'])]));
            }
            // MUA THÀNH CÔNG
            $id_api = $data['data']['id'];
            $task_note = 'Server '.$CMSNT->site('domain_autofb88');
            $server = $CMSNT->site('domain_autofb88');
        }


        // DICHVUTIKTOK
        else if(isset(explode('dichvutiktok', $row['server'])[1])) {
            if($CMSNT->site('status_dichvutiktok') != 1){
                $User->AddCredits($getUser['id'], $total_payment, '[Hệ thống bảo trì] Hoàn tiền đơn hàng #'.$trans_id.' ('.$row['name'].' số lượng '.$amount.')');
                die(json_encode(['status' => 'error', 'msg' => __('Dịch vụ này đang được bảo trì')]));
            }
            require_once(__DIR__."/../libs/dichvutiktok.php");
            $dichvutiktok = new dichvutiktok;
            // CHUYỂN ĐỔI URL SANG ID & USERNAME
            $result = $dichvutiktok->convertURL(check_string($_POST['url']));
            $result = json_decode($result, true);
            if($result['error_code'] == 1){
                $uid = check_string($_POST['url']);
            }else{
                if($result['video_id'] == null){
                    $uid = $result['username'];
                }else{
                    $uid = $result['video_id'];
                }
            }//
            $note = 'Đơn hàng '.$trans_id.' - Khách hàng '.$getUser['username'].' - Thanh toán '.format_currency($total_payment);
            $data = $dichvutiktok->create($uid, $amount, $camxuc, $comment, $num_minutes, $days, $row['id_api'], $row['type_api'], $row['type2_api'], $note);
            $data = json_decode($data, true);
            if($data['error_code'] != 0){
                $User->AddCredits($getUser['id'], $total_payment, 'Hoàn tiền đơn hàng #'.$trans_id.' ('.$row['name'].' số lượng '.$amount.')');
                die(json_encode(['status' => 'error', 'msg' => 'ERROR | '.__($data['msg'])]));
            }
            // MUA THÀNH CÔNG
            $id_api = $data['id'];
            $task_note = 'Server dichvutiktok.org';
            $server = 'dichvutiktok.org';
        }


        // HACKLIKE17
        else if(isset(explode('hacklike17', $row['server'])[1])) {
            if($CMSNT->site('status_hacklike17') != 1){
                $User->AddCredits($getUser['id'], $total_payment, '[Hệ thống bảo trì] Hoàn tiền đơn hàng #'.$trans_id.' ('.$row['name'].' số lượng '.$amount.')');
                die(json_encode(['status' => 'error', 'msg' => __('Dịch vụ này đang được bảo trì')]));
            }
            require_once(__DIR__."/../libs/hacklike17.php");
            $hacklike17 = new hacklike17;
            $uid = check_string($_POST['url']);
            if($row['type2_api'] == 'uid'){
                $result = $hacklike17->convertURL(check_string($_POST['url']));
                $result = json_decode($result, true);
                if($result['status'] == 1){
                    $uid = $result['msg'];
                }
            }
            $note = 'Đơn hàng '.$trans_id.' - Khách hàng '.$getUser['username'].' - Thanh toán '.format_currency($total_payment);
            $data = $hacklike17->create($uid, $amount, $camxuc, $comment, $num_minutes, $days, $row['id_api'], $row['type_api'], $row['type2_api'], $note);
            $data = json_decode($data, true);
            if($data['status'] == 0){
                $User->AddCredits($getUser['id'], $total_payment, 'Hoàn tiền đơn hàng #'.$trans_id.' ('.$row['name'].' số lượng '.$amount.') -> '.__($data['msg']));
                die(json_encode(['status' => 'error', 'msg' => 'ERROR | '.__($data['msg'])]));
            }
            // MUA THÀNH CÔNG
            $id_api = $data['order_id'];
            $task_note = 'Server: hacklike17.com
ID Order: '.$id_api;
            $server = 'hacklike17.com';
        }

        // SHOPTANGLIKE
        else if(isset(explode('shoptanglike', $row['server'])[1])) {
            if($CMSNT->site('status_shoptanglike') != 1){
                $User->AddCredits($getUser['id'], $total_payment, '[Hệ thống bảo trì] Hoàn tiền đơn hàng #'.$trans_id.' ('.$row['name'].' số lượng '.$amount.')');
                die(json_encode(['status' => 'error', 'msg' => __('Dịch vụ này đang được bảo trì')]));
            }
            require_once(__DIR__."/../libs/shoptanglike.php");
            $shoptanglike = new shoptanglike;

            $uid = check_string($_POST['url']);
            if($row['type2_api'] == 'id_sub'){
                $result = $shoptanglike->convertURL(check_string($_POST['url']));
                $result = json_decode($result, true);
                if($result['status'] == 1){
                    $uid = $result['msg'];
                }
            }

            $note = 'Đơn hàng '.$trans_id.' - Khách hàng '.$getUser['username'].' - Thanh toán '.format_currency($total_payment);
            $data = $shoptanglike->create($uid, $amount, $camxuc, $comment, $num_minutes, $days, $row['id_api'], $row['type_api'], $row['type2_api'], $note);
            $data = json_decode($data, true);
            if($data['status'] != 100){
                $User->AddCredits($getUser['id'], $total_payment, 'Hoàn tiền đơn hàng #'.$trans_id.' ('.$row['name'].' số lượng '.$amount.') -> '.__($data['message']));
                die(json_encode(['status' => 'error', 'msg' => 'ERROR | '.__($data['message'])]));
            }
            // MUA THÀNH CÔNG
            $id_api = $data['data']['id'];
            $task_note = 'Server: shoptanglike.com
ID Order: '.$id_api;
            $server = 'shoptanglike.com';
        }


        
        $isCreateOrder = $CMSNT->insert('orders', [
            'server'            => $server,
            'id_api'            => isset($id_api) ? $id_api : NULL,
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
            'num_minutes'       => $num_minutes,
            'days'              => $days,
            'task_note'         => isset($task_note) ? $task_note : NULL,
            'create_time'       => time(),
            'create_gettime'    => gettime(),
            'update_time'       => time(),
            'update_gettime'    => gettime()
        ]);
        
        if($isCreateOrder){
            $my_text = $CMSNT->site('text_notification');
            $my_text = str_replace('{domain}', $_SERVER['SERVER_NAME'], $my_text);
            $my_text = str_replace('{username}', $getUser['username'], $my_text);
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
 
 
 






