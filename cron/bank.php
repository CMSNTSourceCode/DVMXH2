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

    if ($CMSNT->site('type_bank') == 'Techcombank') {
        $result = curl_get("https://api.web2m.com/historyapitcb/$mk/$stk/$token");
        $result = json_decode($result, true);
        foreach ($result['transactions'] as $data) {
            $tid            = check_string($data['TransID']);
            $description    = check_string($data['Description']);
            $amount         = check_string(str_replace(',', '', $data['Amount']));
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
                            $isCong = $user->AddCredits($getUser['id'], $received, "Nạp tiền tự động qua Techcombank (#$tid - $description - $amount)");
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
    if ($CMSNT->site('type_bank') == 'Vietcombank') {
        $result = curl_get("https://api.web2m.com/historyapivcb/$mk/$stk/$token");
        $result = json_decode($result, true);
        foreach ($result['data']['ChiTietGiaoDich'] as $data) {
            $tid            = check_string($data['SoThamChieu']);
            $description    = check_string($data['MoTa']);
            $amount         = check_string(str_replace(',', '', $data['SoTienGhiCo']));
            $user_id        = parse_order_id($description, $CMSNT->site('prefix_autobank'));         // TÁCH NỘI DUNG CHUYỂN TIỀN
            if($CMSNT->site('status_bank') == 1){
                if($getUser = $CMSNT->get_row(" SELECT * FROM `users` WHERE `id` = '$user_id' ")){
                    if($CMSNT->num_rows(" SELECT * FROM `bank_auto` WHERE `tid` = '$tid' AND `description` = '$description' ") == 0){
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
                            $isCong = $user->AddCredits($getUser['id'], $received, "Nạp tiền tự động qua Vietcombank (#$tid - $description - $amount)");
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
    if ($CMSNT->site('type_bank') == 'VPBank') {
        $result = curl_get("https://api.web2m.com/historyapivpb/$mk/$token");
        $result = json_decode($result, true);
        foreach ($result['d']['DepositAccountTransactions']['results'] as $data) {
            $tid            = check_string($data['ReferenceNumber']);
            $description    = check_string($data['Description']);
            $amount         = check_string($data['Amount']);
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
                            $isCong = $user->AddCredits($getUser['id'], $received, "Nạp tiền tự động qua VPBank (#$tid - $description - $amount)");
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
    if ($CMSNT->site('type_bank') == 'ACB') {
        $result = curl_get("https://api.web2m.com/historyapiacb/$mk/$stk/$token");
        $result = json_decode($result, true);
        foreach ($result['transactions'] as $data) {
            $tid            = check_string($data['transactionNumber']);
            $description    = check_string($data['description']);
            $amount         = check_string($data['amount']);
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
                            $isCong = $user->AddCredits($getUser['id'], $received, "Nạp tiền tự động qua ACB (#$tid - $description - $amount)");
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
    if ($CMSNT->site('type_bank') == 'MBBank') {
        $result = curl_get("https://api.web2m.com/historyapimb/$mk/$stk/$token");
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
    if ($CMSNT->site('type_bank') == 'TPBank') {
        $result = curl_get("https://api.web2m.com/historyapitpb/$token");
        $result = json_decode($result, true);
        foreach ($result['transactionInfos'] as $data) {
            $tid            = check_string($data['arrangementId']);
            $description    = check_string($data['description']);
            $amount         = check_string($data['amount']);
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
                            $isCong = $user->AddCredits($getUser['id'], $received, "Nạp tiền tự động qua TPBank (#$tid - $description - $amount)");
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
