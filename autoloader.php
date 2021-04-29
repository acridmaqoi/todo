<?php

ob_start();

if(!isset($_SESSION)) {
    session_start();
}

require_once __DIR__ . (PHP_OS == 'Linux' ? ' ' : '/') . 'config/config.php';
require_once __DIR__ . '/defines.php';



use PHPMailer\PHPMailer\PHPMailer;

require __DIR__ . '/lib/PHPMailer/vendor/autoload.php';

$mail = new PHPMailer(true);

try {
    //Server settings                     
    $mail->isSMTP();                                        
    $mail->Host       = EMAIL_HOST;
    $mail->SMTPAuth   = true;                                  
    $mail->Username   = EMAIL_USER;                    
    $mail->Password   = EMAIL_PASS;                            
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;         
    $mail->Port       = 465;                                    

    $mail->setFrom(EMAIL_USER, 'Mailer');
} catch (Exception $e) {
    die('error setting email settings');
}