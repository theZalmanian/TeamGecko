<?php
    require_once("/home/geckosgr/public_html/initial.php");

    // store the current page's title for dynamic HTML generation
    $currPageTitle = "Pizza Login";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Process Login</title>
    <link rel="icon" type="image/x-icon" href="/gecko-images/geckos-logo.svg">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="/css/practice.css">
</head>
<body>
    <main class="mt-3">
        <?php 
            if(isset($_POST["username"]) && isset($_POST["password"]))
            {
                $userName = $_POST["username"];
                $password = $_POST["password"];
        
                if($userName === "admin" && $password === "admin") {
                    $_SESSION["pizza-admin"] = true;

                    echo generateMessageWithLink("/practice/pizza-ordering/index.php", 
                                                 "Home", 
                                                 "Login successful"); 
                }
                
                else {
                    echo generateMessageWithLink("login.php", 
                                                 "Login", 
                                                 "Login failed"); 
                }
            }

            else {
                echo generateMessageWithLink("login.php", 
                                             "Login", 
                                             "Please log in first"); 
            }
        ?>
    </main>
</body>
</html>