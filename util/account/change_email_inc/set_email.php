<?php

class SetEmail {

    public function  __construct($email, $acc_id){
        $vkey = $this->register_email($email, $acc_id);
        $this->send_verification($email, $vkey);
    }

    private function register_email($email, $acc_id) {
        require (__DIR__ . '/../../../config/db.php');
        require_once (__DIR__ . '/../../../lib/PHPMailer/vendor/autoload.php');
    
        // generate email verification code
        $vkey = md5(time().$email);
    
        if ($stmt = $con->prepare('UPDATE accounts SET pending_email = (?), activation_code = (?), activated = 0 WHERE id = (?)')) {
            $stmt->bind_param('ssi', $email, $vkey, $acc_id);
            $stmt->execute();
        } else {
            die($con->error);
        }

        return $vkey;
    }
    
    private function send_verification($email, $vkey) {
        require_once (__DIR__ . '/../../../config/email.php');
    
        $mail->addAddress($email, 'User');
        //Content
        $mail->isHTML(true);
        $mail->Subject = 'Email verification';
        $mail->Body    = "http://localhost/project-1/util/account/change_email_inc/verify.php?vkey=$vkey";
    
        $mail->send();
    }
}





