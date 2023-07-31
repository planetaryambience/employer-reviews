<?php
    require_once "../config.php";
    require_once "User.php";

    function createUser($name, $pass) {
        $user = new User($name, $pass);
        return $user;
    }

    function getUsers() {
        $users = array();

        $pdo = openConnection();  // connect to database

        $query = "SELECT * FROM user";

        try {
            $result = $pdo->query($query);
        } catch (PDOException $e) {
            die($e->getMessage());
        }

        $pdo = null;  // close connection to database

        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            $user = createUser($row['username'], $row['password']);
            array_push($users, $user);
        }

        return $users;
    }

    function insertUser($user)
    {
        $pdo = openConnection();
        $query = "INSERT INTO user (username, password) VALUES (:param1, :param2)";

        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':param1', $user->getName(), PDO::PARAM_STR);
        $stmt->bindParam(':param2', $user->getPass(), PDO::PARAM_STR);
        $stmt->execute();

        $pdo = null;
    }
?>