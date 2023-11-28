<?php
    // get access to all PHP helpers
    require_once("/home/geckosgr/public_html/initial.php");

    setcookie(ADMIN_ROLE_KEY, "current", time() * 7, "/");
?>