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
        <meta name="description" = "inteReview is an Employer Review Portal with over 27,000 reviews. Providing both past and present employee reviews for over 18,000 employers and the ability to read or write your own.">
        <meta name ="keywords" content="inteReview, Employer, Employee, Review, Job, Company, Read, Ratings, Statistics, Recent">

        <title>inteReview - Employer Review Portal</title>

        <link rel="stylesheet" href="../../public_html/css/style.css" />
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js"></script>
    </head>
<!--END Page header and meta data-->

<!--START Page body content-->
    <body>
    <!--START Navigation-->
    <?php require_once(TEMPLATES_PATH . "/nav.html"); ?>
    <!--END Navigation-->

        <div class="container">
            <!--START Page content-->
            <div class="row">
                <h1 class="titles">Employer Review Portal</h1>
            </div>
            <!--inteReview Description-->
            <div class="row">
                <p class="description">inteReview is an open review portal providing insight into over 18,000 companies globally.<br>
                    Providing the ability to view, read and write reviews by past and present employees.<br>
                    Submit your own personal review and see rating statistics for various employers.<br>
                    Over 27,000 reviews waiting to be read!</p>
            </div>
            <!--END inteReview Description-->

            <hr>

            <h2 class="subtitles">Recent Employer Reviews</h2>

            <!--PHP DB Query - Retrieves all employer reviews-->
            <?php $employers = getReviewedEmployers(); ?>

            <!--PHP DB Query - Retrieves each individual employer as $emp-->
            <?php foreach($employers as $emp): ?>
                <?php
                    $name = $emp->getName();
                    $hq = $emp->getHq();
                    $url = $emp->getUrl();
                    $id = $emp->getId();

                    $imgPath = "../../public_html/img/employer_logos/{$name}.png";
                ?>
                <!--inteReview Recent Employer Reviews | UPDATED WHEN NEW REVIEW ADDED-->
                <div class="row home-page-reviews">

                    <!--START Company Details - Displays IMAGE / HQ / URL-->
                    <div class="col-4">
                        <a href="employer_overview.php?employer=<?=$id;?>">
                            <img class='employer_logo' src="<?=$imgPath;?>" alt="<?=$name;?>">
                            <h3><?=$name;?></h3>
                        </a>
                            <p><?=$hq;?></p>
                            <p><a href=<?=$url;?>><?=$url;?></a></p>
                    </div>
                    <!--END Company Details - Displays IMAGE / HQ / URL-->

                    <!--START Recent Company Reviews - Displays DATETIME / SUMMARY / OVERALL RATING-->
                    <div class="col-8 reviews">
                        <h4 class="subtitles">Recent Reviews</h4>
                        <div class="row">
                            <!--PHP DB Query - Retrieves all reviews associated to each employer ID-->
                            <?php $reviews = getRecentReviews($emp->getId()); ?>

                                <!--PHP DB Query - Retrieves each review as $rev-->
                                <?php foreach($reviews as $rev): ?>
                                    <?php
                                        $format = "d/m/y - H:i";
                                        $date = date($format, strtotime($rev[0]));
                                    ?>
                                    <!--displays the recent reviews as date / summary / overall rating-->
                                    <div class="col-3">
                                        <?=$date;?>
                                    </div>
                                    <div class="col-8">
                                        <?=$rev[1];?>
                                    </div>
                                    <div class="col-1 small-stars">
                                        <?php $rating = getStars($rev[2]); ?>
                                        <?=$rating?>
                                    </div>
                                <?php endforeach; ?>
                        </div>
                    </div>
                    <!--END Recent Company Reviews - Displays DATETIME / SUMMARY / OVERALL RATING-->
                </div>
                <hr>
            <?php endforeach; ?>
        </div>

        <!--JQuery / JavaScript-->
        <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
        <script src="../../public_html/js/search.js"></script>
        <!--JQuery / JavaScript-->
    </body>
    <!--END Page body content-->

    <!--START Page footer-->
    <?php require_once(TEMPLATES_PATH . "/footer.html")?>
    <!--END Page footer-->
</html>
