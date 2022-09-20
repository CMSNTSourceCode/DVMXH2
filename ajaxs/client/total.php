<?php

define("IN_SITE", true);
require_once(__DIR__."/../../libs/db.php");
require_once(__DIR__."/../../libs/helper.php");
$CMSNT = new DB();
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
 


    if($_POST['action'] == 'service'){
        if(empty($_POST['service_pack'])){
            die(json_encode([
                'status' => 'success',
                'total' => format_currency(0),
                'msg'   => ''
            ]));
        }
        if ($row = $CMSNT->get_row("SELECT * FROM `service_packs` WHERE `id` = '".check_string($_POST['service_pack'])."' ")) {
            // if(empty($_POST['amount'])){
            //     die(json_encode([
            //         'status' => 'success',
            //         'total' => format_currency(0),
            //         'msg'   => __($row['content'])
            //     ]));
            // }
            $ck = 0;
            if(isset($_POST['token'])){
                if($getUser = $CMSNT->get_row("SELECT * FROM `users` WHERE `token` = '".check_string($_POST['token'])."' AND `banned` = 0 ")){
                    $ck = $getUser['chietkhau'];
                }
            }
            $amount = check_string($_POST['amount']);

            // TÍNH TOÁN SỐ LƯỢNG BÌNH LUẬN
            if($row['show_comment'] == 1){
                if(!empty($_POST['comment'])){
                    $amount = substr_count($_POST['comment'], PHP_EOL) + 1;
                }
            }

            // TÍNH TOÁN MẮT LIVE
            if($row['show_eye'] == 1){
                if(!empty($_POST['num_minutes']) && $_POST['num_minutes'] >= 1){
                    $amount = $amount * check_string($_POST['num_minutes']);
                }
            }

            // TÍNH TOÁN VIPLIKE
            if($row['show_viplike'] == 1){
                if(!empty($_POST['amount_viplike'])){
                    $amount = check_string($_POST['amount_viplike']);
                    $amount = $amount * check_string($_POST['days']);
                }
            }
            
            $total = $amount * $row['price'];
            $total = $total - $total * $ck / 100;
            die(json_encode([
                'status'        => 'success',
                'total'         => format_currency($total),
                'show_camxuc'   => $row['show_camxuc'],
                'show_comment'  => $row['show_comment'],
                'show_eye'      => $row['show_eye'],
                'show_viplike'  => $row['show_viplike'],
                'show_review'   => $row['show_review'],
                'msg'           => __($row['content'])
            ]));
        }
    }

    die(format_currency(0));
    
}
die(format_currency(0));
