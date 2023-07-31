<?php
    require_once "User.php";
    require_once "user_db.php";

    if (isset($_POST['username']) && isset($_POST['password'])) {
        $username = htmlentities($_POST["username"]);
        $password = $_POST["password"];

        $user = createUser($username, $password);


        if (authenticate($user)) {
            echo "Please use the login page as your details already exist.";
        } else {
            insertUser($user);
        }
    }

    function authenticate($user) {
        $users = getUsers();

        foreach ($users as $u) {
            if (($u->getName() === $user->getName())
                && ($u->getPass() === $user->getPass())) {
                return true;
            }
        }

        return false;
}