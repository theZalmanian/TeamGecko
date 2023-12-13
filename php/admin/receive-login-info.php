<?php
    // get access to all PHP helpers
    require_once("/home/geckosgr/public_html/initial.php");

    // store the current page's title for dynamic HTML generation
    $currPageTitle = "Verify Credentials";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php
        // include standard nursing header metadata
        require_once(LAYOUTS_PATH . "/nursing-metadata.php");
    ?>
</head>
<body>
    <main class="container mt-3">
        <div class='row'> 
            <div class="col-md-3 col-lg-3">
            </div>
            <div class="col-12 col-md-6 col-lg-6">
                <?php
                    // if email and password were given
                    if(isset($_POST["email"]) && isset($_POST["password"])) {
                        $email = $_POST["email"];
                        $password = $_POST["password"];

                        // check if credentials are match an entry in DB
                        $credentialsValid = executeQuery("SELECT * 
                                                        FROM login
                                                        WHERE Email = '{$email}' 
                                                            AND Password = '{$password}'");

                        $credentialsValid = mysqli_fetch_assoc($credentialsValid);

                        if(!empty($credentialsValid)) {
                            // set them as admin in session
                            $_SESSION["Admin"] = true;

                            // display success and link to requirements page
                            echo generateMessageWithLink("/sprint-5/requirements.php", "Continue",
                                                        "Logged In successfully");

                        }

                        else {
                            // display error and link to login page
                            echo generateMessageWithLink("login.php", "Login",
                                                        "Please try again", "Login Failed");

                            // cease the session
                            session_unset();
                            session_destroy();
                        }
                    }

                    else {
                        echo displayAccessDenied("login.php", "Login");
                    }
                ?>
            </div>
            <div class="col-md-3 col-lg-3">
            </div>
        </div>
    </main>
</body>
</html>