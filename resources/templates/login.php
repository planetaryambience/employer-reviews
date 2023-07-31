<?php
    require_once("../config.php");
?>

<!DOCTYPE html>
<html lang="en">
    <!--Page header and meta data-->
    <head>
        <meta charset="UTF-8">
        <meta name="description"="Login to inteReview. Read, write and place your review. Over 27,000 reviews already present!">
        <meta name="keywords"="inteReview, Employer, Employee, Review, Job, Company, Login">

        <title>inteReview - Log In</title>

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
                    <h2 class="subtitles">Login</h2>
                    <div class="row"></div>

                    <form method="post">
                        <div class="form-group">
                            <label>Username</label>
                            <input type="text" name="username" class="form-control" required>
                        </div>

                        <div class="row"></div>

                        <div class="form-group">
                            <label>Password</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>

                        <div class="row"></div>

                        <div class="form-group">
                            <a href="index.php"><button type="submit" name="submit" value="Submit">Submit</button></a>
                        </div>
                        <div class="row"></div>

                        <?php
                            if (isset($_POST["submit"]) && isset($_POST['username']) && isset($_POST['password'])) {

                                $name = $_POST['username'];
                                $pass = $_POST['password'];

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
                        <p class="description">Don't have an account?<a href="signup.php">Sign Up</a>.</p>
                    </form>
                <div class="col-8"></div>
                    <a href="index.php"><button class="cancel">Cancel</button></a>
                </div>
                <div class="col-2"></div>
            </div>
        </div>
    </body>
    <!--END Page body content-->

<!--Page footer-->
<?php require_once(TEMPLATES_PATH . "/footer.html")?>
<!--END Page Footer-->
</html>