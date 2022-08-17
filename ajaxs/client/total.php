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
            if(empty($_POST['amount'])){
                die(json_encode([
                    'status' => 'success',
                    'total' => format_currency(0),
                    'msg'   => __($row['content'])
                ]));
            }
            $ck = 0;
            if(isset($_POST['token'])){
                if($getUser = $CMSNT->get_row("SELECT * FROM `users` WHERE `token` = '".check_string($_POST['token'])."' AND `banned` = 0 ")){
                    $ck = $getUser['chietkhau'];
                }
            }
            $amount = check_string($_POST['amount']);
            if(!empty($_POST['comment'])){
                $amount = substr_count($_POST['comment'], PHP_EOL) + 1;
            }
            $total = $amount * $row['price'];
            $total = $total - $total * $ck / 100;
            die(json_encode([
                'status' => 'success',
                'total' => format_currency($total),
                'show_camxuc'   => $row['show_camxuc'],
                'show_comment'   => $row['show_comment'],
                'msg'   => __($row['content'])
            ]));
        }
    }

    die(format_currency(0));
    
}
die(format_currency(0));
