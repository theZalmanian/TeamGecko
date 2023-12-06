<?php
    // get access to all PHP helpers
    require_once("/home/geckosgr/public_html/initial.php");

    // store the current page's title for dynamic HTML generation
    $currPageTitle = "Pizza Login";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pizza Ordering</title>
    <link rel="icon" type="image/x-icon" href="/gecko-images/geckos-logo.svg">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="/css/practice.css">
</head>
<body>
    <main class="mt-3 mx-1">
        <div class="d-flex justify-content-center align-items-center">
            <form class="card p-3" action="/practice/php/process-login.php" method="post">
                <?php 
                    echo generateBootstrapFloatingTextBox("username", "Username", true);
                ?>
                <div class='form-floating my-2'>
                    <input type='password' class='form-control' id='password' name='password'
                        placeholder='' value='' required>
                    <label for='password'>
                        Password <?php echo displayRequired(); ?>
                    </label>
                </div>
                <button type="submit" class="btn btn-success w-100 py-2 my-2">Login</button>
            </form>
        </div>
    </main>
</body>
<script>
    if(window.location.search === '?eUnamePass'){
        let error = document.querySelector(".error");
        error.textContent = "Username and Password incorrect, please try again. ";
        error.style.color = "red";
        error.style.paddingBottom = "10px";
    }
</script>
</html>