<?php
    defined("TEMPLATES_PATH")
        or define("TEMPLATES_PATH", realpath(dirname(__FILE__) . "/templates"));

    /**
     * create connection to database.
     * 
     * @return PDO object which is connected to the database.
     */
    function openConnection() {
        try {
            $pdo = new PDO("sqlite:../open_review_s_sqlite.db");
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die($e->getMessage());
        }

        return $pdo;
    }
?>