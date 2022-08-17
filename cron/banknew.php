<?php

    define("IN_SITE", true);
    require_once(__DIR__.'/../libs/db.php');
    require_once(__DIR__.'/../config.php');
    require_once(__DIR__.'/../libs/helper.php');
    require_once(__DIR__.'/../libs/database/users.php');
    $CMSNT = new DB();
    $user = new users();

    /* START CHỐNG SPAM */
    if (time() > $CMSNT->site('check_time_cron_bank')) {
        if (time() - $CMSNT->site('check_time_cron_bank') < 5) {
            die('[ÉT O ÉT ]Thao tác quá nhanh, vui lòng đợi');
        }
    }
    $CMSNT->update("settings", ['value' => time()], " `name` = 'check_time_cron_bank' ");
    if ($CMSNT->site('status_bank') != 1) {
        die('Chức năng đang tắt.');
    }
    if ($CMSNT->site('token_bank') == '') {
        die('Thiếu Token Bank');
    }
    /* END CHỐNG SPAM */
    $token = $CMSNT->site('token_bank');
    $stk = $CMSNT->site('stk_bank');
    $mk = $CMSNT->site('mk_bank');

    
    if ($CMSNT->site('type_bank') == 'MBBank') {
        $result = curl_get("https://api.dailysieure.com/api-mbbank?taikhoan=$token&matkhau=$mk&sotaikhoan=$stk");
        $result = json_decode($result, true);
        foreach ($result['data'] as $data) {
            $tid            = check_string($data['refNo']);
            $description    = check_string($data['description']);
            $amount         = check_string($data['creditAmount']);
            $user_id        = parse_order_id($description, $CMSNT->site('prefix_autobank'));         // TÁCH NỘI DUNG CHUYỂN TIỀN
            if($CMSNT->site('status_bank') == 1){
                if($getUser = $CMSNT->get_row(" SELECT * FROM `users` WHERE `id` = '$user_id' ")){
                    if($CMSNT->num_rows(" SELECT * FROM `bank_auto` WHERE `tid` = '$tid' ") == 0){
                        $insertSv2 = $CMSNT->insert("bank_auto", array(
                            'tid'               => $tid,
                            'user_id'           => $getUser['id'],
                            'description'       => $description,
                            'amount'            => $amount,
                            'received'          => checkPromotion($amount),
                            'create_gettime'    => gettime(),
                            'create_time'       => time()
                        ));
                        if ($insertSv2){
                            $received = checkPromotion($amount);
                            $isCong = $user->AddCredits($getUser['id'], $received, "Nạp tiền tự động qua MBBank (#$tid - $description - $amount)");
                            if($isCong){
                                echo '[<b style="color:green">-</b>] Xử lý thành công 1 hoá đơn.'.PHP_EOL;
                            }
                        }
                    }
                }
            }
        }
        die();
    }
   
