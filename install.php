<?php

    define("IN_SITE", true);
    require_once(__DIR__.'/libs/db.php');
    require_once(__DIR__.'/config.php');
    require_once(__DIR__.'/libs/helper.php');

    $CMSNT = new DB();    
 



    function insert_options($name, $value){
        global $CMSNT;
        if (!$CMSNT->get_row("SELECT * FROM `settings` WHERE `name` = '$name' ")) {
            $CMSNT->insert("settings", [
                'name'  => $name,
                'value' => $value
            ]);
        }
    }
    
    insert_options('text_create_website', '<ul>
    <li>Bước 1: Nhập tên miền muốn đăng ký đại lý và nhấn Thêm Ngay.</li>
    <li>Bước 2: Trỏ NameServer (NS) tên miền về <b
            style="color: red;">gina.ns.cloudflare.com</b> và <b
            style="color: red;">hak.ns.cloudflare.com</b>.</li>
    <li>Bước 3: Chờ đợi QTV setup website (thanh trạng thái thay đổi thành <b
            style="color: green;">Hoạt Động</b>).</li>
    <li>Bước 4: Truy cập Website bạn vừa tạo và nhập thông tin token và đăng ký
        1 tài khoản quản trị của
        bạn (tài khoản đầu tiên sẽ là tài khoản admin, lưu ý không để lộ tên
        miền ra khi chưa setup xong website).</li>
</ul>
<i>Liên hệ Zalo 0947838128 để được hỗ trợ.</i>');
    insert_options('status_create_website', 1);
    insert_options('cookie_baostar', '');
    insert_options('cookie_subgiare', '');
    insert_options('access_token_tuongtaccheo', '');
    insert_options('username_traodoisub', '');
    insert_options('password_traodoisub', '');
    insert_options('cookie_traodoisub', '');
    insert_options('token_autolike', '');
    insert_options('username_autolike', '');
    insert_options('password_autolike', '');
    insert_options('domain_autolike', 'autolike.cc');
    insert_options('status_autolike', 1);
    insert_options('copyright', '');
    insert_options('popup_noti', '');
    insert_options('token_subgiare', '');
    insert_options('display_customizer_theme', 1);
    insert_options('license_key', '');
    insert_options('status_baostar', 1);
    

    $CMSNT->query(" ALTER TABLE `service_packs` ADD `note_admin` LONGTEXT NULL AFTER `display` ");
    $CMSNT->query(" ALTER TABLE `service_packs` ADD `show_comment` INT(11) NOT NULL DEFAULT '0' AFTER `note_admin`, ADD `show_camxuc` INT(11) NOT NULL DEFAULT '0' AFTER `show_comment` ");
    $CMSNT->query(" ALTER TABLE `orders` ADD `comment` TEXT NULL AFTER `status`, ADD `camxuc` VARCHAR(255) NULL DEFAULT NULL AFTER `comment` ");
    $CMSNT->query(" ALTER TABLE `service_packs` ADD `server` VARCHAR(255) NULL DEFAULT 'me' AFTER `show_camxuc` ");
    $CMSNT->query(" ALTER TABLE `service_packs` ADD `cost` FLOAT NOT NULL DEFAULT '0' AFTER `price` ");
    $CMSNT->query(" ALTER TABLE `orders` ADD `start` INT(11) NOT NULL DEFAULT '0' AFTER `camxuc`, ADD `success` INT(11) NOT NULL DEFAULT '0' AFTER `start` ");
    $CMSNT->query(" ALTER TABLE `services` ADD `id_api` INT(11) NOT NULL DEFAULT '0' AFTER `id` ");
    $CMSNT->query(" ALTER TABLE `categories` ADD `id_api` INT(11) NOT NULL DEFAULT '0' AFTER `id` ");
    $CMSNT->query(" ALTER TABLE `service_packs` ADD `id_api` INT(11) NOT NULL DEFAULT '0' AFTER `id` ");
    $CMSNT->query(" CREATE TABLE `domains` ( `id` INT(11) NOT NULL AUTO_INCREMENT , `user_id` INT(11) NOT NULL DEFAULT '0' , `domain` VARCHAR(50) NULL DEFAULT NULL , `status` INT(11) NOT NULL DEFAULT '0' , PRIMARY KEY (`id`), UNIQUE (`domain`)) ");
    $CMSNT->query(" ALTER TABLE `domains` ADD `admin_note` TEXT NULL DEFAULT NULL AFTER `status` ");
    $CMSNT->query(" ALTER TABLE `domains` ADD `create_gettime` DATETIME NOT NULL AFTER `admin_note`, ADD `update_gettime` DATETIME NOT NULL AFTER `create_gettime` ");
    $CMSNT->query(" ALTER TABLE `service_packs` ADD `show_viplike` INT(11) NOT NULL DEFAULT '0' AFTER `show_camxuc`    ");
    $CMSNT->query(" ALTER TABLE `service_packs` ADD `show_eye` INT(11) NOT NULL DEFAULT '0' AFTER `show_viplike`    ");
    $CMSNT->query(" ALTER TABLE `orders` ADD `num_minutes` INT(11) NOT NULL DEFAULT '0' AFTER `comment` ");
    $CMSNT->query(" ALTER TABLE `orders` ADD `days` INT(11) NOT NULL DEFAULT '0' AFTER `num_minutes`    ");
    $CMSNT->query(" ALTER TABLE `service_packs` CHANGE `id_api` `id_api` VARCHAR(255) NULL DEFAULT NULL    ");
    $CMSNT->query(" ALTER TABLE `service_packs` ADD `type_api` VARCHAR(255) NULL DEFAULT NULL AFTER `id_api`    ");
    $CMSNT->query(" ALTER TABLE `service_packs` ADD `type2_api` VARCHAR(255) NULL DEFAULT NULL AFTER `type_api` ");
    $CMSNT->query(" ALTER TABLE `orders` ADD `id_api` VARCHAR(255) NULL DEFAULT NULL AFTER `id`, ADD `server` VARCHAR(255) NOT NULL DEFAULT 'me' AFTER `id_api` ");
    $CMSNT->query(" CREATE TABLE `cronjobs` ( `id` INT(11) NOT NULL AUTO_INCREMENT , `name` VARCHAR(255) NULL DEFAULT NULL , `url` TEXT NULL , `update_time` INT(11) NOT NULL DEFAULT '0' , `update_gettime` DATETIME NOT NULL , PRIMARY KEY (`id`)) ");
    $CMSNT->query(" ALTER TABLE `services` ADD `notification` TEXT NULL AFTER `content` ");
    $CMSNT->query(" CREATE TABLE `ranks` ( `id` INT(11) NOT NULL AUTO_INCREMENT , `name` VARCHAR(255) NULL , `discount` FLOAT NOT NULL DEFAULT '0' , `target` INT(11) NOT NULL DEFAULT '0' , `detail` TEXT NULL , PRIMARY KEY (`id`)) ");
    $CMSNT->query(" ALTER TABLE `ranks` CHANGE `name` `name` VARCHAR(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL  ");
    if($CMSNT->num_rows(" SELECT * FROM `cronjobs` WHERE `id` = 1 ") == 0){
        $CMSNT->insert("cronjobs", [
            'id'            => 1,
            'name'          => 'Cập nhật lịch sử nạp MOMO',
            'url'           => 'cron/momo.php',
            'update_time'   => 0
        ]);
    }
    if($CMSNT->num_rows(" SELECT * FROM `cronjobs` WHERE `id` = 2 ") == 0){
        $CMSNT->insert("cronjobs", [
            'id'            => 2,
            'name'          => 'Cập nhật lịch sử nạp Bank',
            'url'           => 'cron/bank.php',
            'update_time'   => 0
        ]);
    }
    if($CMSNT->num_rows(" SELECT * FROM `cronjobs` WHERE `id` = 3 ") == 0){
        $CMSNT->insert("cronjobs", [
            'id'            => 3,
            'name'          => 'Cập nhật lịch sử autolike.cc',
            'url'           => 'cron/autolike.php?limit=100',
            'update_time'   => 0
        ]);
    }
    if($CMSNT->num_rows(" SELECT * FROM `cronjobs` WHERE `id` = 4 ") == 0){
        $CMSNT->insert("cronjobs", [
            'id'            => 4,
            'name'          => 'Cập nhật thông tin website',
            'url'           => 'cron/cron.php',
            'update_time'   => 0
        ]);
    }
    if($CMSNT->num_rows(" SELECT * FROM `cronjobs` WHERE `id` = 5 ") == 0){
        $CMSNT->insert("cronjobs", [
            'id'            => 5,
            'name'          => 'Cập nhật lịch sử baostar.pro',
            'url'           => 'cron/baostar.php?type=facebook',
            'update_time'   => 0
        ]);
    }
    if($CMSNT->num_rows(" SELECT * FROM `cronjobs` WHERE `id` = 6 ") == 0){
        $CMSNT->insert("cronjobs", [
            'id'            => 6,
            'name'          => 'Cập nhật lịch sử baostar.pro',
            'url'           => 'cron/baostar.php?type=instagram',
            'update_time'   => 0
        ]);
    }
    if($CMSNT->num_rows(" SELECT * FROM `cronjobs` WHERE `id` = 7 ") == 0){
        $CMSNT->insert("cronjobs", [
            'id'            => 7,
            'name'          => 'Cập nhật lịch sử baostar.pro',
            'url'           => 'cron/baostar.php?type=tiktok',
            'update_time'   => 0
        ]);
    }
    if($CMSNT->num_rows(" SELECT * FROM `cronjobs` WHERE `id` = 8 ") == 0){
        $CMSNT->insert("cronjobs", [
            'id'            => 8,
            'name'          => 'Cập nhật lịch sử baostar.pro',
            'url'           => 'cron/baostar.php?type=youtube',
            'update_time'   => 0
        ]);
    }
    if($CMSNT->num_rows(" SELECT * FROM `cronjobs` WHERE `id` = 9 ") == 0){
        $CMSNT->insert("cronjobs", [
            'id'            => 9,
            'name'          => 'Cập nhật lịch sử baostar.pro',
            'url'           => 'cron/baostar.php?type=shopee',
            'update_time'   => 0
        ]);
    }
    if($CMSNT->num_rows(" SELECT * FROM `cronjobs` WHERE `id` = 10 ") == 0){
        $CMSNT->insert("cronjobs", [
            'id'            => 10,
            'name'          => 'Cập nhật lịch sử baostar.pro',
            'url'           => 'cron/baostar.php?type=telegram',
            'update_time'   => 0
        ]);
    }
    insert_options('status_autofb88', 0);
    insert_options('domain_autofb88', '');
    insert_options('token_autofb88', '');
    if($CMSNT->num_rows(" SELECT * FROM `cronjobs` WHERE `id` = 11 ") == 0){
        $CMSNT->insert("cronjobs", [
            'id'            => 11,
            'name'          => 'Cập nhật lịch sử autofb88.com',
            'url'           => 'cron/autofb88.php?type=facebook',
            'update_time'   => 0
        ]);
    }
    if($CMSNT->num_rows(" SELECT * FROM `cronjobs` WHERE `id` = 12 ") == 0){
        $CMSNT->insert("cronjobs", [
            'id'            => 12,
            'name'          => 'Cập nhật lịch sử autofb88.com',
            'url'           => 'cron/autofb88.php?type=instagram',
            'update_time'   => 0
        ]);
    }
    if($CMSNT->num_rows(" SELECT * FROM `cronjobs` WHERE `id` = 13 ") == 0){
        $CMSNT->insert("cronjobs", [
            'id'            => 13,
            'name'          => 'Cập nhật lịch sử autofb88.com',
            'url'           => 'cron/autofb88.php?type=tiktok',
            'update_time'   => 0
        ]);
    }
    if($CMSNT->num_rows(" SELECT * FROM `cronjobs` WHERE `id` = 14 ") == 0){
        $CMSNT->insert("cronjobs", [
            'id'            => 14,
            'name'          => 'Cập nhật lịch sử autofb88.com',
            'url'           => 'cron/autofb88.php?type=youtube',
            'update_time'   => 0
        ]);
    }
    if($CMSNT->num_rows(" SELECT * FROM `cronjobs` WHERE `id` = 15 ") == 0){
        $CMSNT->insert("cronjobs", [
            'id'            => 15,
            'name'          => 'Cập nhật lịch sử autofb88.com',
            'url'           => 'cron/autofb88.php?type=shopee',
            'update_time'   => 0
        ]);
    }
    if($CMSNT->num_rows(" SELECT * FROM `cronjobs` WHERE `id` = 16 ") == 0){
        $CMSNT->insert("cronjobs", [
            'id'            => 16,
            'name'          => 'Cập nhật lịch sử autofb88.com',
            'url'           => 'cron/autofb88.php?type=telegram',
            'update_time'   => 0
        ]);
    }
    insert_options('status_dichvutiktok', 0);
    insert_options('apikey_dichvutiktok', '');
    if($CMSNT->num_rows(" SELECT * FROM `cronjobs` WHERE `id` = 17 ") == 0){
        $CMSNT->insert("cronjobs", [
            'id'            => 17,
            'name'          => 'Cập nhật lịch sử dichvutiktok.org',
            'url'           => 'cron/dichvutiktok.php?type=like',
            'update_time'   => 0
        ]);
    }
    if($CMSNT->num_rows(" SELECT * FROM `cronjobs` WHERE `id` = 18 ") == 0){
        $CMSNT->insert("cronjobs", [
            'id'            => 18,
            'name'          => 'Cập nhật lịch sử dichvutiktok.org',
            'url'           => 'cron/dichvutiktok.php?type=follow',
            'update_time'   => 0
        ]);
    }
    if($CMSNT->num_rows(" SELECT * FROM `cronjobs` WHERE `id` = 19 ") == 0){
        $CMSNT->insert("cronjobs", [
            'id'            => 19,
            'name'          => 'Cập nhật lịch sử dichvutiktok.org',
            'url'           => 'cron/dichvutiktok.php?type=share',
            'update_time'   => 0
        ]);
    }
    if($CMSNT->num_rows(" SELECT * FROM `cronjobs` WHERE `id` = 20 ") == 0){
        $CMSNT->insert("cronjobs", [
            'id'            => 20,
            'name'          => 'Cập nhật lịch sử dichvutiktok.org',
            'url'           => 'cron/dichvutiktok.php?type=comment',
            'update_time'   => 0
        ]);
    }
    insert_options('username_dichvutiktok', '');
    insert_options('password_dichvutiktok', '');
    insert_options('home_page', 'home');
    insert_options('status_hacklike17', 0);
    insert_options('apikey_hacklike17', '');
    $CMSNT->query(" ALTER TABLE `service_packs` ADD `show_review` INT(11) NOT NULL DEFAULT '0' AFTER `show_eye`  ");
    $CMSNT->query(" ALTER TABLE `orders` ADD `review` LONGTEXT NULL DEFAULT NULL AFTER `comment`    ");
    $CMSNT->query(" CREATE TABLE `translate` ( `id` INT NOT NULL AUTO_INCREMENT , `lang_id` INT(11) NOT NULL DEFAULT '0' , `name` LONGTEXT NULL DEFAULT NULL , `value` LONGTEXT NULL DEFAULT NULL , PRIMARY KEY (`id`)) ");
    $CMSNT->query(" CREATE TABLE `languages` ( `id` INT NOT NULL AUTO_INCREMENT , `lang` VARCHAR(255) NULL DEFAULT NULL , `icon` TEXT NULL DEFAULT NULL , `lang_default` INT(11) NOT NULL DEFAULT '0' , `status` INT(11) NOT NULL DEFAULT '1' , PRIMARY KEY (`id`)) ");
    if($CMSNT->num_rows(" SELECT * FROM `cronjobs` WHERE `id` = 21 ") == 0){
        $CMSNT->insert("cronjobs", [
            'id'            => 21,
            'name'          => 'Cập nhật lịch sử hacklike17.com',
            'url'           => 'cron/hacklike17.php',
            'update_time'   => 0
        ]);
    }
    insert_options('token_shoptanglike', '');
    insert_options('status_shoptanglike', 0);
    if($CMSNT->num_rows(" SELECT * FROM `cronjobs` WHERE `id` = 22 ") == 0){
        $CMSNT->insert("cronjobs", [
            'id'            => 22,
            'name'          => 'Cập nhật lịch sử shoptanglike.com',
            'url'           => 'cron/shoptanglike.php',
            'update_time'   => 0
        ]);
    }
    $CMSNT->query(" CREATE TABLE `payment_paypal` ( `id` INT NOT NULL AUTO_INCREMENT , `user_id` INT(11) NOT NULL , `trans_id` VARCHAR(50) NULL DEFAULT NULL , `amount` FLOAT NOT NULL DEFAULT '0' , `price` FLOAT NOT NULL DEFAULT '0' , `create_date` DATETIME NOT NULL , `create_time` DATETIME NOT NULL , PRIMARY KEY (`id`)) ");
    insert_options('status_paypal', 0);
    insert_options('paypal_notice', '');
    insert_options('rate_paypal', 23000);
    insert_options('clientSecret_paypal', '');
    insert_options('clientId_paypal', '');
    


    die('Success!');