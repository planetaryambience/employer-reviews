<?php
    require_once("../config.php");
    require_once("../library/reviews.php");
    require_once("../library/employer_db.php");
?>

<!DOCTYPE html>
<html lang="en">
<!--START Page header and meta data-->
    <head>
        <meta charset="UTF-8">
        <meta name="description"="An overview of an employer's ratings and reviews. Displaying a series of statistics associated to the company and all available employee reviews.">
        <meta name="keywords"="inteReview, Employer, Employee, Review, Job, Company, Read, Ratings, Statistics, Recent">

        <title>inteReview — Employer Overview</title>


        <link rel="stylesheet" href="../../public_html/css/style.css" />
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js"></script>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js" integrity="sha512-ElRFoEQdI5Ht6kZvyzXhYG9NqjtkmlkfYk0wr6wHxU9JEHakS7UJZNeml5ALk+8IKlU6jDgMabC3vkumRokgJA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    </head>
    <!--END Page header and meta data-->

    <!--START Page body content-->
    <body>
        <!--START Navigation-->
        <?php
            require_once(TEMPLATES_PATH . "/nav.html");
            $revId = $_GET["r"];
            $empId = $_GET["e"];
            $employer = getEmployer($empId);
            $empName = $employer->getName();
            // PHP DB Query - Retrieves each employers reviews as $rev
            $review = getReview($revId);
        ?>

        <div class="container">
            <!--START Page content-->
            <div class="col-2">
                <a href="employer_overview.php?employer=<?=$empId;?>"><button type="button">BACK</button></a>
            </div>

            <div class="row"></div>

            <!--START Employer Reviews-->
            <div class="row">
                <h2><?=$empName?></h2>
                <div class="col stars">
                    <?php $rating = getStars($review["ratingOverall"]); ?>
                    <?=$rating?>
                </div>
            </div>

            <div class="row">
                <div class="col-2"><h5>Date</h5></div>
                <div class="col-6"><h5>Review</h5></div>
                <div class="col-2"><h5>Details</h5></div>
            </div>

            <div class="row">
                <?php
                $format = "d/m/y - H:i";
                $date = date($format, strtotime($review["reviewDateTime"]));
                ?>
                <div class="col-2">
                    <?=$date;?>
                </div>

                <div class="col-6">
                    <p><span class="fields">Summary: </span><?=$review["summary"];?></p>
                    <p><span class="fields">Pros: </span> <?=$review["pros"];?></p>
                    <p><span class="fields">Cons: </span> <?=$review["cons"];?></p>

                    <!--PHP DB Query - As not all reviews have advice only include advice if present-->
                    <?php if ($review["advice"] != null): ?>
                        <p><span class="fields">Advice: </span> <?=$review["advice"];?></p>
                    <?php endif; ?>
                </div>

                <div class="col-3">
                    <p><span class="fields">Job Title: </span><?=$review["jobTitle"];?></p>
                    <p><span class="fields">Employment Status: </span><?=$review["employmentStatus"];?></p>

                    <?php if ($review["isCurrentJob"] === 1) {
                        $currJ = "Yes";
                        } else {
                        $currJ = "No";
                    } ?>
                    <p><span class="fields">Current Employee: </span><?=$currJ;?></p>
                    <p><span class="fields">Length of Employment: </span><?=$review["lengthOfEmployment"];?> years</p>
                    <p><span class="fields">Finished Date: </span><?=$review["jobEndingYear"];?></p>
                </div>
            </div>

            <h2 class="subtitles">Ratings</h2>
            <div class="row">
                <div class="col-4">
                    <p class="sectiontitles">Career Opportunity: <span class="small-stars"><?=getStars($review["ratingCareerOpportunities"]);?></span></p>
                    <p class="sectiontitles">Compensation & Benefits: <span class="small-stars"><?=getStars($review["ratingCompensationAndBenefits"]);?></span></p>
                    <p class="sectiontitles">Culture & Values: <span class="small-stars"><?=getStars($review["ratingCultureAndValues"]);?></span></p>
                    <p class="sectiontitles">Diversity & Inclusion: <span class="small-stars"><?=getStars($review["ratingDiversityAndInclusion"]);?></span></p>
                    <p class="sectiontitles">Senior Leadership: <span class="small-stars"><?=getStars($review["ratingSeniorLeadership"]);?></span></p>
                    <p class="sectiontitles">Work Life Balance: <span class="small-stars"><?=getStars($review["ratingWorkLifeBalance"]);?></span></p>
                </div>

                <div class="col-7">
                    <canvas id="empChart"></canvas>
                </div>
            </div>

            <!--Implementing an advanced feature using Javascript chart JS-->
            <script>
                const ctx = document.getElementById("empChart");
                const myChart = new Chart(ctx, {
                    type: "polarArea",
                    data: {
                        labels: ["Career Opportunity", "Compensation & Benefits",
                                 "Culture & Values", "Diversity & Inclusion", "Senior Leadership", "Work Life Balance", "Overall Rating"],
                        datasets: [
                            {
                                label: "",
                                data: [
                                       <?php echo "{$review['ratingCareerOpportunities']}"?>,
                                       <?php echo "{$review['ratingCompensationAndBenefits']}"?>,
                                       <?php echo "{$review['ratingCultureAndValues']}"?>,
                                       <?php echo "{$review['ratingDiversityAndInclusion']}"?>,
                                       <?php echo "{$review['ratingSeniorLeadership']}"?>,
                                       <?php echo "{$review['ratingWorkLifeBalance']}"?>,
                                       <?php echo "{$review['ratingOverall']}"?>
                                    ],
                                backgroundColor: ["#ffd70080", "#7fff0080",           
                                                  "#dc143c80", "#6495ed80","#00ff7f80",
                                                  "#ff69b480", "#4b009280"],
                            },
                        ],
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                position: 'right',
                            },
                        },
                        scale: {
                            max: 5,
                            stepSize: 1
                        }
                    },  
                });
            </script>
        </div>
    </body>
    <!--END Page body content-->

    <!--START Page footer-->
    <?php require_once(TEMPLATES_PATH . "/footer.html")?>
    <!--START Page footer-->
</html>
