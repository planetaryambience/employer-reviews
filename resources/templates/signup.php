<?php
    require_once("../config.php");
    require_once ("../library/user_db.php");
    require_once ("../library/User.php");
?>

<!DOCTYPE html>
<html lang="en">
    <!--Page header and meta data-->
    <head>
        <meta charset="UTF-8">
        <meta name="description"="Sign Up to inteReview. Read, write and place your review. Over 27,000 reviews already present!">
        <meta name="keywords"="inteReview, Employer, Employee, Review, Job, Company, Sign Up">

        <title>inteReview - Sign Up</title>

        <link rel="stylesheet" href="../../public_html/css/style.css" />
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js"></script>
    </head>
    <!--END Page header and meta data-->

    <!--Page body content-->
    <body>
    <div class="container">
        <div class="logo text-center">
            <a href="index.php"><img src="../../public_html/img/inteReview_logo.png" alt="inteReview"></a>
        </div>

        <div class="row">
            <div class="col-2"></div>
            <div class="col-8">
                <h2 class="subtitles">Sign Up</h2>
                <p class="description">Please fill out the form to create an account.</p>
                <div class="row"></div>

                <form method="post" action="signup.php">
                    <div class="form-group">
                        <label>Username</label>
                        <input type="text" name="username" class="form-control" required/>
                    </div>

                    <div class="row"></div>

                    <div class="form-group">
                        <label>Password</label>
                        <input type="password" name="password" class="form-control" required/>
                    </div>

                    <div class="row"></div>

                    <div class="form-group">
                        <label>Confirm Password</label>
                        <input type="password" name="confirm-pw" class="form-control" required/>
                    </div>

                    <div class="row"></div>

                    <div class="form-group">
                            <a href="index.php"><button type="submit" name="submit" value="Submit">Submit</button></a>
                    </div>

                    <div class="row"></div>

                        <?php
                            if (isset($_POST["submit"]) && isset($_POST['username']) &&
                                isset($_POST['password']) && isset($_POST['confirm-pw'])) {

                                $name = $_POST['username'];
                                $pass = $_POST['password'];

                                if ($pass !== $_POST['confirm-pw']) {
                                    echo "Passwords don't match!<br>";
                                }

                                $pdo = openConnection();
                                $query = "SELECT COUNT(*) AS Count FROM user WHERE username='$name'";
                                $result = $pdo->query($query);
                                $row = $result->fetch(PDO::FETCH_ASSOC);
                                if ($row['Count'] > 0) {
                                    echo "Username already taken!";
                                }

                                if ($row['Count'] === 0 && $pass === $_POST['confirm-pw']) {
                                    $user = new User($name, $pass);
                                    insertUser($user);
                                }
                            }
                        ?>

                        <p class="description">Already have an account?<a href="login.php"> Login here</a>.</p>
                </form>
                    <a href="index.php"><button class="cancel">Cancel</button></a>
                </div>
            </div>
        </div>
    </body>
    <!--END Page body content-->

<!--Page footer-->
<?php require_once(TEMPLATES_PATH . "/footer.html")?>
<!--END Page Footer-->
</html>

