<?php

use PHPMailer\PHPMailer\PHPMailer;

require (__DIR__ . '/../lib/PHPMailer/vendor/autoload.php');

$mail = new PHPMailer(true);

try {
    //Server settings                     
    $mail->isSMTP();                                        
    $mail->Host       = 'smtp.gmail.com';
    $mail->SMTPAuth   = true;                                  
    $mail->Username   = 'samquinn120@gmail.com';                    
    $mail->Password   = '4VunAiQZekAKLAzc7WqMCszp';                            
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;         
    $mail->Port       = 465;                                    

    //Recipients
    $mail->setFrom('samquinn120@gmail.com', 'Mailer');
} catch (Exception $e) {
    die('error setting email settings');
}
