<?php
    require_once("/home/geckosgr/public_html/initial.php");

    // store the current page's title for dynamic HTML generation
    $currPageTitle = "Pizza Login";
if(isset($_POST["username"]) && isset($_POST["password"]))
{
    $userName = $_POST["username"];
    $password = $_POST["password"];
    $result = executeQuery("SELECT * FROM login WHERE Email ='$userName' AND Password = '$password';");
    
    if(mysqli_num_rows($result) === 1)
    {
        $login = mysqli_fetch_assoc($result);
        if($userName === $login["Email"] && $password === $login["Password"]) {
            $_SESSION["username"] = $userName;
            echo $userName;
            echo $_SESSION["username"];
            ?>

            <html>
            <head>
                <?php
                // include standard nursing header metadata
                require_once(LAYOUTS_PATH . "/nursing-metadata.php");
                ?>
            </head>
            <body>

           <h1>Hello</h1>
            </body>
            </html>
            <?php
        }
    }
}


?>
