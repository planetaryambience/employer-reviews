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
    </head>
<!--END Page header and meta data-->

<!--START Page body content-->
    <body>
    <!--START Navigation-->
    <?php require_once(TEMPLATES_PATH . "/nav.html");

        if (isset($_REQUEST["employer"])) {
            $employer = getReviewedEmployer($_REQUEST["employer"]);
        } else {
            // default show Google overview
            $employer = getReviewedEmployer(9079);
        }

        $empName = $employer->getName();
        $empHq = $employer->getHq();
        $empUrl = $employer->getUrl();
        $empRevCount = $employer->getReviewsCount();
        $empId = $employer->getId();
        $empRatings = $employer->getRatings();

        //PHP DB Query + Pagination - Retrieves all employer reviews
        $currP = isset($_REQUEST["page"]) ? $_REQUEST["page"] : 1 ;
        $offset = ((int)$currP - 11) + 10;
        $reviews = getReviews($empId, $offset);
    ?>

        <div class="container">
            <!--START Page content-->
            <div class="row">
                <!--START Back Button to index page-->
                <div class="col-2">
                    <a href="index.php"><button type="button">BACK</button></a>
                </div>
                <!--END Back Button to index page-->
            </div>

            <!--START Search box option for employers-->
            <div class="row">
                <div class="col-3"></div>
                    <div class="col-6 search">
                        <h1>Employers</h1>
                            <form>
                                <input id="search-bar" type="text" placeholder="search" onkeyup="showReviewedEmployerSuggs(this.value)">
                            </form>
                        <div id="suggestions"></div>
                    </div>
                <div class="col-3"></div>
            </div>
            <!--END Search box option for employers-->

            <!--START Employer Details Overview-->
            <div class="row">
                 <div class="col-3"></div>
                    <div class="col-7">
                        <!--PHP DB Query - Retrieves each employer's overall rating as $rating-->
                        <?php $rating = getStars($empRatings["Overall Ratings"]); ?>
                        <!--START Employer Description-->
                        <h1><?=$empName?><span class="big-stars">  <?=$rating?></span></h1>
                        <p><?=$empHq?></p>
                        <p><a href=<?=$empUrl;?>><?=$empUrl;?></a></p>
                        <!--END Employer Description-->
                    </div>

                    <!--START Write a Review Button-->
                    <div class="col-2">
                        <a href="review_employer.php?employer=<?=$empId;?>">
                            <button class="review">Write a Review</button>
                        </a>
                    </div>
                    <!--END Write a Review Button-->
            </div>
            <!--END Employer Overview-->

            <hr>

            <!--START Overall Employer Statistics-->
            <div class="row">
                <h2 class="subtitles">Review Statistics</h2>
            </div>

            <div class="row">
                <div class="col-4">
                    <!--PHP DB Query - Retrieves all ratings of the employer as $empRatings-->
                    <?php foreach($empRatings as $rating => $value): ?>
                        <!--PHP DB Query - Takes each individual rating from empRatings and displays the value as the star rating-->
                        <?php $stars = getStars($value); ?>
                        <p class="sectiontitles"><?=$rating?>: <span class="small-stars"><?=$stars?></span></p>
                    <?php endforeach; ?>
                </div>

                <!--Implementing an advanced feature using Javascript chart JS-->
                <div class="col-8">
                    <canvas id="empRating-bChart"></canvas>
                </div>
            </div>
            <!--END Overall Employer Statistics-->

            <hr>

            <!--START Employer Reviews-->
            <div class="row" id="reviews">
                <h2 class="subtitles">Employer Reviews</h2>
            </div>

            <div class="row">
                <div class="col-2"><h5>Date</h5></div>
                <div class="col-8"><h5>Review</h5></div>
                <div class="col-2"><h5>Overall Rating</h5></div>
            </div>

            <!--PHP DB Query - Retrieves each employers reviews as $rev-->
            <?php foreach($reviews as $rev): ?>
                <div class="row reviews">
                    <?php
                    $format = "d/m/y - H:i";
                    $date = date($format, strtotime($rev[0]));
                    ?>
                    <div class="col-2">
                        <?=$date;?>
                    </div>

                    <div class="col-8">
                        <p>Summary: <?=$rev[1];?></p>
                        <p>Pros: <?=$rev[2];?></p>
                        <p>Cons: <?=$rev[3];?></p>

                        <!--PHP DB Query - As not all reviews have advice only include advice if present-->
                        <?php if ($rev[4] != null): ?>
                            <p>Advice: <?=$rev[4];?></p>
                        <?php endif; ?>

                        <!--START Button to link to full review details-->
                        <a href="display_review.php?r=<?=$rev[6];?>&e=<?=$empId;?>">
                            <button class="review">View full review</button>
                        </a>
                        <!--END Button to link to full review details-->
                    </div>

                    <div class="col stars">
                        <?php $rating = getStars($rev[5]); ?>
                        <?=$rating?>
                    </div>
                </div>
            <?php endforeach; ?>

            <!--START Implementing an advanced feature using Pagination-->
            <div class="row">
                <div class="col-8"></div>
                <div class="col-1" id="revPageCount">
                    <?=$currP;?>/<?=$empRevCount;?>
                </div>
                <div class="col-3">
                    <nav class="pagination-nav" aria-label="page nav">
                        <ul class="pagination pagination-sm">
                            <?php if ($currP <= 1): ?>
                                <li class="page-item disabled">
                            <?php else: ?>
                                <li class="page-item">
                            <?php endif; ?>
                                    <a class="page-link" href="employer_overview.php?employer=<?=$empId?>&page=<?=(int)$currP-10;?>#reviews" tabindex="-1">Previous</a>
                                </li>

                            <li class="page-item">
                                <a class="page-link" href="employer_overview.php?employer=<?=$empId?>&page=<?=(int)$currP+10;?>/#reviews" tabindex="-1">Next</a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
            <!--END Implementing an advanced feature using Pagination-->
        </div>

        <!--JQuery / JavaScript-->
        <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js" integrity="sha512-ElRFoEQdI5Ht6kZvyzXhYG9NqjtkmlkfYk0wr6wHxU9JEHakS7UJZNeml5ALk+8IKlU6jDgMabC3vkumRokgJA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script src="../../public_html/js/search.js"></script>
        <script> var employer = <?php echo(json_encode($empId)); ?>;</script>
        <script src="../../public_html/js/barChart.js"></script>
        <!--JQuery / JavaScript-->
    </body>
    <!--END Page body content-->

    <!--START Page footer-->
    <?php require_once(TEMPLATES_PATH . "/footer.html")?>
    <!--START Page footer-->
</html>
