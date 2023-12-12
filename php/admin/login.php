<?php
    session_start();

    // get access to all PHP helpers
    require_once("/home/geckosgr/public_html/initial.php");

    // store the current page's title for dynamic HTML generation
    $currPageTitle = "Login";
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
                <form action="receive-login-info.php" method="POST">
                    <div class="card p-3 my-1">
                        <div class='form-floating'>
                            <input type='text' class='form-control' id='email' name='email'
                                placeholder='' value='' required>
                            <label for='email'>
                                Email <?php echo displayRequired(); ?>
                            </label>
                        </div>
                    </div>
                    <div class="card p-3 my-1">
                        <div class='form-floating'>
                            <input type='password' class='form-control' id='password' name='password'
                                placeholder='' value='' required>
                            <label for='password'>
                                Password <?php echo displayRequired(); ?>
                            </label>
                        </div>
                    </div>
                    <div class="card p-3 my-1">
                        <button type='submit' class='col-12 btn btn-success py-2 border' id='login'>
                            Login
                        </button>
                    </div>
                </form>
            </div>
            <div class="col-md-3 col-lg-3">
            </div>
        </div>
    </main>
</body>
</html>