<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Summary</title>
    <link rel="icon" type="image/x-icon" href="/gecko-images/geckos-logo.svg">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="/css/practice.css">
</head>
<body>
<div class="container">
    <div class="row">
        <div class="col-md-2">
        </div>
        <div class="col-12 col-md-8">
            <div class="card text-center mt-3">
                <?php
                    // connect to DB
                    require '/home/geckosgr/db-connect-pizza.php';

                    $selectQuery = "SELECT * FROM PizzaOrder;";

                    // execute query
                    $querySuccess = mysqli_query($dbConnection, $selectQuery);

                    if ($querySuccess) {
                        // display all orders in DB
                        while ($currSite = mysqli_fetch_assoc($querySuccess)) {
                            $name = $currSite['CustomerName'];
                            $email = $currSite['CustomerEmail'];
                            $size = $currSite['PizzaSize'];
                            $toppingOne = $currSite['Topping1'];
                            $toppingTwo = $currSite['Topping2'];
                            $cost = $currSite['PizzaCost'];
                            echo "<p>Name: ${name} </p> <br>";
                            echo "<p>Email: ${email} </p> <br>";
                            echo "<p>Toppings: ${toppingOne} ${toppingTwo} </p> <br>";
                            echo "<p>Cost: ${cost} </p>";
                            echo "<hr>";
                        }
                    }

                    else {
                        echo "Error: " . mysqli_error($dbConnection);
                    }

                    // close the DB connection when done
                    mysqli_close($dbConnection);
                ?>
            </div>
        </div>
        <div class="col-md-2">
        </div>
    </div>
</div>
</body>
</html>