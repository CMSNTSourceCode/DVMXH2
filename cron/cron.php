<?php

define("IN_SITE", true);

require_once(__DIR__ . '/../libs/db.php');
require_once(__DIR__ . '/../config.php');
require_once(__DIR__ . '/../libs/helper.php');
require_once(__DIR__ . '/../libs/database/users.php');
$CMSNT = new DB();


/* START CHỐNG SPAM */
if (time() > getRowRealtime('cronjobs', 4, 'update_time')) {
    if (time() - getRowRealtime('cronjobs', 4, 'update_time') < $config['max_time_load']) {
        die(json_encode(['status' => 'error', 'msg' => __('Thao tác quá nhanh, vui lòng đợi')]));
    }
}
$CMSNT->update("cronjobs", ['update_time' => time()], " `id` = 4 ");



// CẬP NHẬT CẤP BẬC
foreach($CMSNT->get_list(" SELECT * FROM `ranks` ORDER BY `target` ASC ") as $rank){
    $CMSNT->update('users', [
        'chietkhau' => $rank['discount']
    ], " `total_money` >= '".$rank['target']."' ");
}


die(json_encode(['status' => 'success', 'msg' => __('Cron thành công!')]));