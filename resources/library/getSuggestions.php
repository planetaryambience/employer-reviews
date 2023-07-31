<!-- code mostly from example shown in class (lecture 9) -->

<?php
    require_once("../config.php");

    $pdo = openConnection();
    $suggestions = "";
    $q = $_REQUEST["q"];

    if (isset($_REQUEST["r"]) and $_REQUEST["r"] === "all") {
        $query = "SELECT employer_id, company_name FROM employer
                  WHERE company_name LIKE '$q%'
                  ORDER BY employer_id
                  LIMIT 10";
    } else {
        $query = "SELECT employer_id, company_name FROM reviewedEmployer_S
                  WHERE company_name LIKE '$q%'
                  ORDER BY employer_id
                  LIMIT 10";
    }
    
    try {
        $result = $pdo->query($query); 
    } catch (PDOException $e) {
        die($e->getMessage());
    }

    $pdo = null;

    if (isset($_REQUEST["r"]) and $_REQUEST["r"] === "all") {
        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            $name = $row["company_name"];
            $id = $row["employer_id"];
            if ($suggestions === "") {
                $suggestions = "<a href='review_employer.php?employer={$id}'>{$name}</a>";
            } else {
                $suggestions .= "<br> <a href='review_employer.php?employer={$id}'>{$name}</a>";
            }
        }
    } else {
        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            $name = $row["company_name"];
            $id = $row["employer_id"];
            if ($suggestions === "") {
                $suggestions = "<a href='employer_overview.php?employer={$id}'>{$name}</a>";
            } else {
                $suggestions .= "<br><a href='employer_overview.php?employer={$id}'>{$name}</a>";
            }
        }
    }

    if ($suggestions === "") {
        echo("no suggestions for <i>$q</i>");
    } else {
        echo($suggestions);
    }
?>