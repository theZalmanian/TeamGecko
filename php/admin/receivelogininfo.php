<?php
    session_start();
    require_once("/home/geckosgr/public_html/initial.php");
    $email = $_POST["email"];
    $password = $_POST["password"];


    $result = executeQuery("SELECT * FROM login");
    while ($rows = mysqli_fetch_assoc($result))
    {
        $dbEmail = $rows["Email"];
        $dbPassword = $rows["Password"];
        if($email == $dbEmail && $password == $dbPassword)
        {
            $fullName = $_SESSION["Name"] = $rows["FirstName"]. " ". $rows["LastName"];
            echo "Hello ${fullName}, Welcome to our page ";
        }
        else {
            echo "Email and password incorrect, please try again ";
            session_unset();
            session_destroy();
        }
    }
?>
