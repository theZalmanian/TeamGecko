<?php
    // get access to all PHP helpers
    require_once("/home/geckosgr/public_html/initial.php");

    // get admin flag from session
    $isAdmin = $_SESSION["username"];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Pizza Orders</title>
    <link rel="icon" type="image/x-icon" href="/gecko-images/geckos-logo.svg">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="/css/practice.css">
</head>
<body>
    <main class="container my-3">
        <div class="row">
            <div class="col-md-1">
            </div>
            <div class="col-12 col-md-10">
                <div class="container"> 
                    <?php if($isAdmin === "christy@greenriver.edu") { ?>
                        <div class="row d-flex justify-content-center"> 
                            <?php
                                // connect to DB
                                require '/home/geckosgr/db-connect-pizza.php';

                                $selectQuery = "SELECT * FROM PizzaOrder;";

                                // execute query
                                $querySuccess = mysqli_query($dbConnection, $selectQuery);

                                if ($querySuccess) {
                                    // run through all returned rows
                                    while ($currSite = mysqli_fetch_assoc($querySuccess)) {
                                        // grab columns in variables
                                        $name = $currSite['CustomerName'];
                                        $email = $currSite['CustomerEmail'];
                                        $size = $currSite['PizzaSize'];
                                        $toppingOne = $currSite['Topping1'];
                                        $toppingTwo = $currSite['Topping2'];
                                        $cost = "$" . $currSite['PizzaCost'];

                                        echo "<div class='card col-12 col-md-5 text-center m-2 p-2'>
                                                <h3><b>{$name} <br> {$email}</b></h3>
                                                <h4>[{$size}] [{$toppingOne}, {$toppingTwo}]</h4>
                                                <h4>Total Cost: {$cost}</h4>
                                            </div>";
                                    }
                                }

                                else {
                                    echo "Error: " . mysqli_error($dbConnection);
                                }

                                // close the DB connection when done
                                mysqli_close($dbConnection);
                            ?>
                        </div>
                    <?php } 
                    
                        else {
                           echo generateMessageWithLink("login.php",
                                                        "Login",
                                                        "Please log in",
                                                        "ERROR: Admin not detected"); 
                        }
                    ?>
                </div>
            </div>
            <div class="col-md-1">
            </div>
        </div>
    </main>
</body>
</html>