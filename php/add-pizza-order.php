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
        <div class="col-md-2 col-lg-4">
        </div>
        <div class="col-12 col-md-8 col-lg-4">
            <div class="card text-center mt-3">
                <?php
                    // connect to DB
                    require '/home/geckosgr/db-connect-pizza.php';

                    // get pizza order form fields
                    $customerName = $_POST["customer-name"];
                    $customerEmail = $_POST["customer-email"];
                    $pizzaSize = $_POST["pizza-size"];

                    // get all selected toppings
                    $selectedToppings = array();

                    // if the customer wanted no cheese
                    if( isset($_POST["no-cheese"]) ) {
                        $selectedToppings[] = "No Cheese";
                    }

                    // if the customer wanted half cheese
                    if( isset($_POST["half-cheese"]) ) {
                        $selectedToppings[] = "Half Cheese";
                    }

                    // if the customer wanted cheese
                    if( isset($_POST["cheese"]) ) {
                        $selectedToppings[] = "Cheese";
                    }

                    // if the customer wanted Parmesan
                    if( isset($_POST["parmesan-cheese"]) ) {
                        $selectedToppings[] = "Parmesan";
                    }

                    // setup associative array to hold pizza size and total cost pairs
                    $totalCosts = array("S" => "20.99", "M" => "35.99", "L" => "55.99");

                    // setup query to insert order with given data into DB
                    $insertQuery = "INSERT INTO PizzaOrder (CustomerName, CustomerEmail, PizzaSize, Topping1, Topping2, PizzaCost) 
                                        VALUES ('{$customerName}', '{$customerEmail}', '{$pizzaSize}', '{$selectedToppings[0]}', '{$selectedToppings[1]}', '{$totalCosts[$pizzaSize]}')";

                    // Execute the query
                    $querySuccess = mysqli_query($dbConnection, $insertQuery);

                    if ($querySuccess) {
                        echo "Pizza order inserted successfully!";
                    }

                    else {
                        echo "Error: " . mysqli_error($dbConnection);
                    }

                    // close the DB connection when done
                    mysqli_close($dbConnection);
                ?>
            </div>
        </div>
        <div class="col-md-2 col-lg-4">
        </div>
    </div>
</div>
</body>
</html>