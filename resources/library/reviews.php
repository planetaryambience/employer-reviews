<?php
    function getRecentReviews($emp_id) {
        $reviews = array();

        $pdo = openConnection();
        $query = "SELECT summary, reviewDateTime, ratingOverall
                  FROM employerReview_S
                  WHERE employerID = $emp_id
                  ORDER BY reviewDateTime DESC
                  LIMIT 10";
        
        try {
            $result = $pdo->query($query);
        } catch (PDOException $e) {
            echo($e);
            die($e->getMessage());
        }

        $pdo = null;

        while($row = $result->fetch(PDO::FETCH_ASSOC)) {
            $date = htmlspecialchars($row['reviewDateTime']);
            $summary = htmlspecialchars($row['summary']);
            $rating = htmlspecialchars($row['ratingOverall']);

            $review = [$date, $summary, $rating];
            array_push($reviews, $review);
        }

        return $reviews;
    }

    function getReview($revId) {
        $pdo = openConnection();
        $query = "SELECT * FROM employerReview_S WHERE reviewId = $revId";

        try {
            $result = $pdo->query($query);
        } catch (PDOException $e) {
            echo($e);
            die($e->getMessage());
        }

        $pdo = null;

        $review = $result->fetch(PDO::FETCH_ASSOC);
        return $review;
    }

    function getReviews($emp_id, $o) {
        $reviews = array();

        $pdo = openConnection();
        $query = "SELECT reviewDateTime, summary, pros, cons, advice, ratingOverall, reviewId
                  FROM employerReview_S
                  WHERE employerId = $emp_id
                  ORDER BY reviewDateTime DESC
                  LIMIT 10 OFFSET $o";
        try {
            $result = $pdo->query($query);
        } catch (PDOException $e) {
            echo($e);
            die($e->getMessage());
        }

        $pdo = null;

        // reviews data
        while($row = $result->fetch(PDO::FETCH_ASSOC)) {
            $date = htmlspecialchars($row['reviewDateTime']);
            $summary = htmlspecialchars($row['summary']);
            $pros = htmlspecialchars($row['pros']);
            $cons = htmlspecialchars($row['cons']);
            $advice = htmlspecialchars($row['advice']);
            $rating = htmlspecialchars($row['ratingOverall']);
            $revId = htmlspecialchars($row['reviewId']);

            $review = [$date, $summary, $pros, $cons, $advice, $rating, $revId];
            array_push($reviews, $review);
        }

        return $reviews;
    }

    function getStars($value) {
        $rating = str_repeat("&#9733", ceil($value)) . str_repeat("&#9734", (5 - ceil($value)));
        return $rating;
    }

    function insertReview($rev){
        $pdo = openConnection();
        $review = $rev->getReviews();
        $empId = $rev->getEmpId();
        $date = $rev->getDate();
    
        $query = "INSERT INTO employerReview_S (
                    employerId, reviewDateTime, isCurrentJob, lengthOfEmployment, jobEndingYear, jobTitle, employmentStatus, pros, cons, advice, ratingBusinessOutlook, ratingCeo, ratingRecommendToFriend, ratingCareerOpportunities, ratingCompensationAndBenefits, ratingCultureAndValues, ratingDiversityAndInclusion, ratingSeniorLeadership, ratingWorkLifeBalance, summary, ratingOverall)
                VALUES (
                    :empId,
                    :reviewDateTime,
                    :isCurrentJob,
                    :lengthOfEmployment,
                    :jobEndingYear,
                    :jobTitle, 
                    :empStat,
                    :pros,
                    :cons,
                    :advice,
                    :ratingBusinessOutlook,
                    :ratingCeo,
                    :ratingRecommendToFriend,
                    :ratingCareerOpportunities,
                    :ratingCompensationAndBenefits,
                    :ratingCultureAndValues,
                    :ratingDiversityAndInclusion,
                    :ratingSeniorLeadership,
                    :ratingWorkLifeBalance,
                    :summary,
                    :ratingOverall)";
    
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':empId', $empId, PDO::PARAM_STR);
        $stmt->bindParam(':reviewDateTime', $date, PDO::PARAM_STR);
        $stmt->bindParam(':isCurrentJob', $review["isCurrentJob"], PDO::PARAM_STR);
        $stmt->bindParam(':lengthOfEmployment', $review["lengthOfEmployment"], PDO::PARAM_STR);
        $stmt->bindParam(':jobEndingYear', $review["jobEndingYear"], PDO::PARAM_STR);
        $stmt->bindParam(':jobTitle', $review["jobTitle"], PDO::PARAM_STR);
        $stmt->bindParam(':empStat', $review["empStat"], PDO::PARAM_STR);
        $stmt->bindParam(':pros', $review["pros"], PDO::PARAM_STR);
        $stmt->bindParam(':cons', $review["cons"], PDO::PARAM_STR);
        $stmt->bindParam(':advice', $review["advice"], PDO::PARAM_STR);
        $stmt->bindParam(':ratingBusinessOutlook', $review["ratingBusinessOutlook"], PDO::PARAM_STR);
        $stmt->bindParam(':ratingCeo', $review["ratingCeo"], PDO::PARAM_STR);
        $stmt->bindParam(':ratingRecommendToFriend', $review["ratingRecommendToFriend"], PDO::PARAM_STR);
        $stmt->bindParam(':ratingCareerOpportunities', $review["ratingCareerOpportunities"], PDO::PARAM_STR);
        $stmt->bindParam(':ratingCompensationAndBenefits', $review["ratingCompensationAndBenefits"], PDO::PARAM_STR);
        $stmt->bindParam(':ratingCultureAndValues', $review["ratingCultureAndValues"], PDO::PARAM_STR);
        $stmt->bindParam(':ratingDiversityAndInclusion', $review["ratingDiversityAndInclusion"], PDO::PARAM_STR);
        $stmt->bindParam(':ratingSeniorLeadership', $review["ratingSeniorLeadership"], PDO::PARAM_STR);
        $stmt->bindParam(':ratingWorkLifeBalance', $review["ratingWorkLifeBalance"], PDO::PARAM_STR);
        $stmt->bindParam(':summary', $review["summary"], PDO::PARAM_STR);
        $stmt->bindParam(':ratingOverall', $review["ratingOverall"], PDO::PARAM_STR);
        $stmt->execute();
    
        $pdo = null; // close connection to the database
    }
?>