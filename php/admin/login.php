<?php
    session_start();
    require_once("/home/geckosgr/public_html/initial.php");
?>
<html>
<head>

    <?php
    // THIS IS THE PAGE TITLE
    $currPageTitle = "Login";
    // include standard nursing header metadata
    require_once(LAYOUTS_PATH . "/nursing-metadata.php");
    ?>
</head>
<!--    Create a form to get userinput for login -->
    <form action="receivelogininfo.php" method="POST">
        <body>
        <label for="email">
            Email
        </label>
        <input type="text" name="email" placeholder="geckos@greenriver.edu" required="required">
        <label for="password">
            Password
        </label>
        <input type="password" name="password">
        <button>Submit</button>
        </body>
    </form>
</html>
