<?php
    require_once("Employer.php");
    require_once("../config.php");

    function createEmployer($row) {
        $id = htmlspecialchars($row["employer_id"]);
        $name = htmlspecialchars($row["company_name"]);
        $hq = htmlspecialchars($row["company_hq"]);
        $url = htmlspecialchars($row["company_url"]);

        $reviews_count = htmlspecialchars($row["reviews_count"]);
        $out_r = htmlspecialchars($row["business_outlook_rating"]);
        $opp_r = htmlspecialchars($row["career_opportunities_rating"]);
        $ceo_r = htmlspecialchars($row["ceo_rating"]);
        $ben_r = htmlspecialchars($row["compensation_and_benefits_rating"]);
        $cul_r = htmlspecialchars($row["culture_and_values_rating"]);
        $div_r = htmlspecialchars($row["diversity_and_inclusion_rating"]);
        $rec_r = htmlspecialchars($row["recommend_to_friend_rating"]);
        $lea_r = htmlspecialchars($row["senior_leadership_rating"]);
        $bal_r = htmlspecialchars($row["work_life_balance_rating"]);
        $ove_r = htmlspecialchars($row["overall_rating"]);

        $employer = new Employer($id, $name, $hq, $url, $reviews_count, 
                                 $out_r, $opp_r, $ceo_r, $ben_r, $cul_r, 
                                 $div_r, $rec_r, $lea_r, $bal_r, $ove_r);

        return $employer;
    }

    function getEmployer($empId) {
        $pdo = openConnection();

        $query = "SELECT * FROM employer WHERE employer_id = $empId";

        try {
            $result = $pdo->query($query); 
        } catch (PDOException $e) {
            die($e->getMessage());
        }

        $row = $result->fetch(PDO::FETCH_ASSOC);
        $emp = createEmployer($row);
        return $emp;
    }

    function getEmployers() {
        $employers = array();

        $pdo = openConnection();  // connect to database

        $query = "SELECT * FROM employer
                  ORDER BY company_name";

        try {
            $result = $pdo->query($query); 
        } catch (PDOException $e) {
            die($e->getMessage());
        }
        
        $pdo = null;  // close connection to database

        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            $emp = createEmployer($row);
            array_push($employers, $emp);
        }

         return $employers;
    }

    function getReviewedEmployers() {
        $employers = array();

        $pdo = openConnection();

        $query = "SELECT * FROM reviewedEmployer_S
                  ORDER BY company_name";

        try {
            $result = $pdo->query($query); 
        } catch (PDOException $e) {
            die($e->getMessage());
        }
        
        $pdo = null;

        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            $emp = createEmployer($row);
            array_push($employers, $emp);
        }

        return $employers;
    }

    function getReviewedEmployer($id) {
        $pdo = openConnection();

        $query = "SELECT * FROM reviewedEmployer_S
                  WHERE employer_id = '{$id}'";

        try {
            $result = $pdo->query($query);
        } catch (PDOException $e) {
            die($e->getMessage());
        }

        $pdo = null;

        $emp = createEmployer($result->fetch(PDO::FETCH_ASSOC));
        return $emp;
    }
?>