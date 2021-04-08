<?php

class GetAccountDetails {
    private $username;
    private $email;

    public function __construct($id) {
        require __DIR__ . '../../../util/db.php';

        if ($stmt = $con->prepare('SELECT username, email FROM accounts WHERE id = (?)')) {
            $stmt->bind_param('i', $id);
            $stmt->execute();
            $stmt->bind_result($this->username, $this->email);
            $stmt->fetch();
            $stmt->close();
        } else {
            die('db error');
        }
    }

    public function get_username() {
        return $this->username;
    }

    public function get_email() {
        return $this->email;
    }
}
