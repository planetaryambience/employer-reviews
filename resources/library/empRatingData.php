<?php
    require_once("../config.php");
    require_once("employer_db.php");
    require_once("Employer.php");

    $emp = $_REQUEST["emp"];
    $employer = getReviewedEmployer($emp);
    $ratings = $employer->getRatings();

    $data = array();

    foreach ($ratings as $rating => $value) {
        $data[] = ["rating" => $rating, "value" => $value];
    }

    echo json_encode($data);
?>