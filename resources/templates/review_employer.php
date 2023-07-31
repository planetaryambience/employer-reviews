<?php
    require_once("../config.php");
    require_once("../library/reviews.php");
    require_once("../library/Review.php");
    require_once("../library/employer_db.php");
?>
<!DOCTYPE html>
<html lang="en">
<!--START Page header and meta data-->
    <head>
        <meta charset="UTF-8">
        <meta name="description"="Place a review via inteReview. Whether you are a past or present employee place your review for others to see.">
        <meta name="keywords"="inteReview, Employer, Employee, Review, Job, Company, Read, Ratings, Statistics, Recent">

        <title>inteReview - Review an Employer</title>

        <link rel="stylesheet" href="../../public_html/css/style.css" />
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js"></script>
    </head>
<!--END Page header and meta data-->

<!--START Page body content-->
    <body>
    <!--START Navigation-->
    <?php require_once(TEMPLATES_PATH . "/nav.html");?>
    <!--END Navigation-->

        <div class="container">
            <!--START Page content-->
            <div class="row">
                <h1 class="titles">Add an Employer Review</h1>
            </div>
            <!--Add a review description-->
            <div class="row">
                <p class="description">Whether your a past or present employee, inteReview and the various employers would appreciate your review and feedback!</p>
            </div>
            <!--END Add a review description-->

            <!--START Search box option for employers-->
            <form method="POST" action="review_employer.php" class="was-validated">
                <div class="row">
                    <div class="col-3"></div>
                        <div class="col-6 search">
                            <h2 class="subtitles">Employer</h2>
                                    <?php if (isset($_GET['employer'])): ?>
                                        <?php
                                            $emp = getEmployer($_GET['employer']);
                                            $empName = $emp->getName();
                                        ?>
                                        <input id="search-bar" type="text" value="<?=$empName?>"
                                               placeholder="search" onkeyup="showSuggestions(this.value)">
                                        <input hidden="hidden" name="employerid" value="<?= $_GET['employer'] ?>">
                                    <?php else: ?>
                                        <input id="search-bar" type="text" placeholder="search" onkeyup="showSuggestions(this.value)">
                                    <?php endif; ?>
                                <div row>
                                    <div id="suggestions"></div>
                                </div>
                        </div>
                    <div class="col-3"></div>
                </div>
                <!--END Search box option for employers-->


                <!--START Form Inputs (1R)-->
                <div class="row">
                    <!--Job Title-->
                    <div class="form-group col-6">
                        <label for="jtitle" class="form-label">Job Title (* required)</label>
                        <input id="jtitle" type="text" name="jobTitle" placeholder="Job Title here..." class="form-control" required>
                        <div class="valid-feedback">Valid Input.</div>
                        <div class="invalid-feedback">Please fill out this field.</div>
                    </div>

                    <!--Employee Status-->
                    <div class="form-group col-3">
                        <label for="estatus" class="form-label">Employment Status (* required)</label>
                        <select id="estatus" name="employmentStatus" class="form-select" required>
                            <option selected disabled value="">Choose...</option>
                            <option>Full Time</option>
                            <option>Part Time</option>
                            <option>Casual</option>
                        </select>
                        <div id="estatus" class="valid-feedback">
                            Valid option selection.
                        </div>
                        <div id="estatus" class="invalid-feedback">
                            Please select an option.
                        </div>
                    </div>

                    <!--Current Employee-->
                    <div class="form-group col-3">
                        <label for="cJob" class="form-label">Current Employee (* required)</label>
                        <select id="cjob" name="isCurrentJob" class="form-select" required>
                            <option selected disabled value="">Choose...</option>
                            <option>Yes</option>
                            <option>No</option>
                        </select>
                        <div id="cJob" class="valid-feedback">
                            Valid option selection.
                        </div>
                        <div id="cJob" class="invalid-feedback">
                            Please select an option.
                        </div>
                    </div>
                </div>

                <!--START Form Inputs (2R)-->
                <div class="row">
                    <!--Length of Employment-->
                    <div class="form-group col-6">
                        <label for="jlength" class="form-label">Length of Employment (* required)</label>
                        <input id="jlength" type="text" name="lengthOfEmployment" placeholder="Length of Employment" class="form-control" required>
                        <div class="valid-feedback">Valid Input.</div>
                        <div class="invalid-feedback">Please fill out this field.</div>
                    </div>

                    <!--Finish Date-->
                    <div class="form-group col-6">
                        <label for="jfinish" class="form-label">Finished Date (* required)</label>
                        <select id="jfinish" name="jobEndingYear" class="form-select" required>
                            <option selected disabled value="">Choose...</option>
                            <option>Not Applicable</option>
                            <option>Within the past year</option>
                            <option>2+</option>
                            <option>5+</option>
                            <option>8+</option>
                            <option>10+</option>
                        </select>
                        <div id="jfinish" class="valid-feedback">
                            Valid option selection.
                        </div>
                        <div id="jfinish" class="invalid-feedback">
                            Please select an option.
                        </div>
                    </div>
                </div>

                <!--START Form Inputs (3R)-->
                <div class="row">
                    <!--Positives-->
                    <div class="form-group col-6">
                        <label for="positives" class="form-label">Pros: (* required)</label>
                        <textarea class="form-control" id="positives" name="pros" rows="3" required></textarea>
                        <div class="valid-feedback">Valid Input.</div>
                        <div class="invalid-feedback">Please fill out this field.</div>
                    </div>

                    <!--Negatives-->
                    <div class="form-group col-6">
                        <label for="negatives" class="form-label">Cons: (* required)</label>
                        <textarea class="form-control" id="negatives" name="cons" rows="3" required></textarea>
                        <div class="valid-feedback">Valid Input.</div>
                        <div class="invalid-feedback">Please fill out this field.</div>
                    </div>
                </div>

                <!--START Form Inputs (4R)-->
                <div class="row">
                    <!--Advice-->
                    <div class="form-group col-12">
                        <label for="advice" class="form-label">Advice for company: (* required) </label>
                        <textarea class="form-control" id="advice" name="advice" rows="3" required></textarea>
                        <div class="valid-feedback">Valid Input.</div>
                        <div class="invalid-feedback">Please fill out this field.</div>
                    </div>
                </div>

                <!--START Form Inputs (5R)-->
                <div class="row">
                    <!--Business Outlook-->
                    <div class="form-group col-4">
                        <label for="businessOutlook" class="form-label">Business Outlook (* required)</label>
                        <select id="businessOutlook" name="ratingBusinessOutlook" class="form-select" required>
                            <option selected disabled value="">Choose...</option>
                            <option>Positive</option>
                            <option>Neutral</option>
                            <option>Negative</option>
                        </select>
                        <div id="businessOutlook" class="valid-feedback">
                            Valid option selection.
                        </div>
                        <div id="businessOutlook" class="invalid-feedback">
                            Please select an option.
                        </div>
                    </div>


                    <!--CEO Outlook-->
                    <div class="form-group col-4">
                        <label for="ceo" class="form-label">CEO Rating (* required)</label>
                        <select id="ceo" name="ratingCeo" class="form-select" required>
                            <option selected disabled value="">Choose...</option>
                            <option>Approve</option>
                            <option>No Opinion</option>
                            <option>Disapprove</option>
                        </select>
                        <div id="ceo" class="valid-feedback">
                            Valid option selection.
                        </div>
                        <div id="ceo" class="invalid-feedback">
                            Please select an option.
                        </div>
                    </div>

                    <!--Recommended Outlook-->
                    <div class="form-group col-4">
                        <label for="recommended" class="form-label">Recommended Workplace (* required)</label>
                        <select id="recommended" name="ratingRecommendToFriend" class="form-select" required>
                            <option selected disabled value="">Choose...</option>
                            <option>Yes</option>
                            <option>No</option>
                        </select>
                        <div id="recommended" class="valid-feedback">
                            Valid option selection.
                        </div>
                        <div id="recommended" class="invalid-feedback">
                            Please select an option.
                        </div>
                    </div>
                </div>

                <!--START Form Inputs (sliders)-->
                <div class="row">
                    <!--Career Slider-->
                    <div class="form-group col-5">
                        <label for="ratingCareerOpportunities">Career Opportunities (0-5) (* required)</label>
                        <div class="row">
                            <input name="ratingCareerOpportunities" class="slider-horizontal" type="range" min="0" max="5" required>
                        </div>
                    </div>
                    <div class="col-2"></div>
                    <!--Compensation and Benefits Slider-->
                    <div class="form-group col-5">
                        <label for="ratingCompensationAndBenefits">Compensation & Benefits (0-5) (* required)</label>
                        <div class="row">
                            <input name="ratingCompensationAndBenefits" class="slider-horizontal" type="range" min="0" max="5" required>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <!--Career Slider-->
                    <div class="form-group col-5">
                        <label for="ratingCultureAndValues">Culture & Values (0-5) (* required)</label>
                        <div class="row">
                            <input name="ratingCultureAndValues" class="slider-horizontal" type="range" min="0" max="5" required>
                        </div>
                    </div>
                    <div class="col-2"></div>
                    <!--Compensation and Benefits Slider-->
                    <div class="form-group col-5">
                        <label for="ratingDiversityAndInclusion">Diversity & Inclusion (0-5) (* required)</label>
                        <div class="row">
                            <input name="ratingDiversityAndInclusion" class="slider-horizontal" type="range" min="0" max="5" required>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <!--Leadership Slider-->
                    <div class="form-group col-5">
                        <label for="ratingSeniorLeadership">Senior Leadership (0-5) (* required)</label>
                        <div class="row">
                            <input name="ratingSeniorLeadership" class="slider-horizontal" type="range" min="0" max="5" required>
                        </div>
                    </div>
                    <div class="col-2"></div>
                    <!--Worklife Balance Slider-->
                    <div class="form-group col-5">
                        <label for="ratingWorkLifeBalance">Work Life Balance (0-5) (* required)</label>
                        <div class="row">
                            <input name="ratingWorkLifeBalance" class="slider-horizontal" type="range" min="0" max="5" required>
                        </div>
                    </div>
                </div>

                <!--Overall Summary-->
                <div class="row">
                    <div class="form-group col-12">
                        <label for="oSummary" class="form-label">Summary (* required)</label>
                        <textarea class="form-control" id="oSummary" name="summary" rows="6" required></textarea>
                        <div class="valid-feedback">Valid Input.</div>
                        <div class="invalid-feedback">Please fill out this field.</div>
                    </div>
                </div>

                <!--Overall Rating Slider-->
                <div class="row">
                    <div class="form-group col-3"></div>
                        <div class="form-group col-6">
                            <label for="overallRating">Overall Rating (0-5) (* required)</label>
                                <div class="row">
                                    <input name="ratingOverall" class="slider-horizontal" type="range" min="0" max="5" required>
                                </div>
                        </div>
                    <div class="form-group col-3"></div>
                </div>

                <input hidden="hidden" name="action" value="insert" />
                <div class="row text-center">
                    <!--START Cancel Button to index page-->
                    <div class="col-2">
                        <a href="index.php"><button type="button">Cancel</button></a>
                    </div>
                    <!--END Cancel Button to index page-->
                    <div class="col-8"></div>
                    <!--START Submit Button-->
                    <div class="col-2">
                        <button type="submit">Submit</button>
                    </div>
                    <!--END Submit Button-->
                </div>
            </form>
        </div>

        <!--JQuery / JavaScript-->
        <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
        <script src="../../public_html/js/search.js"></script>
        <!--JQuery / JavaScript-->
    </body>
    <!--END Page body content-->

    <!--START Page footer-->
    <?php require_once(TEMPLATES_PATH . "/footer.html")?>
    <!--START Page footer-->
</html>

<?php
    $date = date('Y-m-d h:i:s', time());

    if (isset($_POST['action']))
    {
        $empId = $_POST['employerid'];
        $isCurrentJob = $_POST['isCurrentJob'];
        $lengthOfEmployment = $_POST['lengthOfEmployment'];
        $jobEndingYear = $_POST['jobEndingYear'];
        $jobTitle = $_POST['jobTitle'];
        $empStat = $_POST['employmentStatus'];
        $pros = $_POST['pros'];
        $cons = $_POST['cons'];
        $advice = $_POST['advice'];
        $ratingBusinessOutlook = $_POST['ratingBusinessOutlook'];
        $ratingCeo = $_POST['ratingCeo'];
        $ratingRecommendToFriend = $_POST['ratingRecommendToFriend'];
        $ratingCareerOpportunities = $_POST['ratingCareerOpportunities'];
        $ratingCompensationAndBenefits = $_POST['ratingCompensationAndBenefits'];
        $ratingCultureAndValues = $_POST['ratingCultureAndValues'];
        $ratingDiversityAndInclusion = $_POST['ratingDiversityAndInclusion'];
        $ratingSeniorLeadership = $_POST['ratingSeniorLeadership'];
        $ratingWorkLifeBalance = $_POST['ratingWorkLifeBalance'];
        $summary = $_POST['summary'];
        $ratingOverall = $_POST['ratingOverall'];

        $review = new Review($empId, $date, $isCurrentJob, $lengthOfEmployment, $jobEndingYear, $jobTitle, $empStat,
                             $pros, $cons, $advice, $ratingBusinessOutlook, $ratingCeo, $ratingRecommendToFriend,
                             $ratingCareerOpportunities, $ratingCompensationAndBenefits, $ratingCultureAndValues,
                             $ratingDiversityAndInclusion, $ratingSeniorLeadership, $ratingWorkLifeBalance,
                             $summary, $ratingOverall);

        insertReview($review);?>
        <script type="text/javascript">
            window.location = "index.php";
        </script>
        <?php
    }
?>
