<?php

    define("IN_SITE", true);
    require_once(__DIR__.'/../libs/db.php');
    require_once(__DIR__.'/../config.php');
    require_once(__DIR__.'/../libs/helper.php');
    require_once(__DIR__.'/../libs/database/users.php');

    $CMSNT = new DB();
    $user = new users();


    /* START CHỐNG SPAM */
    if (time() > $CMSNT->site('check_time_cron_momo')) {
        if (time() - $CMSNT->site('check_time_cron_momo') < 5) {
            die('Thao tác quá nhanh, vui lòng đợi');
        }
    }
    $CMSNT->update("settings", ['value' => time()], " `name` = 'check_time_cron_momo' ");
    /* END CHỐNG SPAM */
    if ($CMSNT->site('status_momo') != 1) {
        die('Chức năng đang bảo trì.');
    }
    if ($CMSNT->site('token_momo') == '') {
        die('Thiếu Token Momo');
    }
    $result = curl_get("https://api.web2m.com/historyapimomo1h/".$CMSNT->site('token_momo'));
    $result = json_decode($result, true);
    foreach ($result['momoMsg']['tranList'] as $data) {
        $partnerId      = $data['partnerId'];               // SỐ ĐIỆN THOẠI CHUYỂN
        $comment        = $data['comment'];                 // NỘI DUNG CHUYỂN TIỀN
        $tranId         = $data['tranId'];                  // MÃ GIAO DỊCH
        $partnerName    = $data['partnerName'];             // TÊN CHỦ VÍ
        $amount         = $data['amount'];                  // SỐ TIỀN CHUYỂN
        $user_id        = parse_order_id($comment, $CMSNT->site('prefix_autobank'));         // TÁCH NỘI DUNG CHUYỂN TIỀN
        if($getUser = $CMSNT->get_row(" SELECT * FROM `users` WHERE `id` = '$user_id' ")){
            if($CMSNT->num_rows(" SELECT * FROM `momo` WHERE `tranId` = '$tranId' ") == 0){
                $insertSv2 = $CMSNT->insert("momo", array(
                    'tranId'        => $tranId,
                    'user_id'       => $user_id,
                    'comment'       => $comment,
                    'time'          => gettime(),
                    'partnerId'     => $partnerId,
                    'amount'        => $amount,
                    'received'      => checkPromotion($amount),
                    'partnerName'   => $partnerName
                ));
                if ($insertSv2){
                    // kiểm tra có được khuyến mãi hay không
                    $received = checkPromotion($amount);
                    $isCong = $user->AddCredits($getUser['id'], $received, "Nạp tiền tự động qua ví MOMO (#$tranId - $amount - $comment - $partnerId - $partnerName)");
                    if($isCong){
                        echo '[<b style="color:green">-</b>] Xử lý thành công 1 hoá đơn.'.PHP_EOL;
                    }
                }
            }
        }
    }
