<?php
class User
{
    private $username;
    private $password;

    function __construct($user, $pass) {
        $this->username = $user;
        $this->password = $this->encryptPassword($pass);
    }

    public function getName() {
        return $this->username;
    }

    public function getPass() {
        return $this->password;
    }

    public function encryptPassword($pass) {
        return base64_encode($pass);
    }
}

?>

