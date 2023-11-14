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
<!--            <div class="card text-center mt-3">-->
<!--                --><?php
//                    // Get the customer's name and pizza size inputs
//                    $customerName = $_POST["customer-name"];
//                    $pizzaSize = $_POST["pizza-size"];
//
//                    // Check if user got here by submitting an order
//                    if(isset($customerName) && isset($pizzaSize)) {
//                ?>
<!--                    <ul class="list-group list-group-flush">-->
<!--                        <!--Display customer name and pizza size-->-->
<!--                        --><?php
//                            echo "<li class='list-group-item h1 mb-0'>{$customerName}</li>";
//                            echo "<li class='list-group-item h3 mb-0'>Pizza Size: {$pizzaSize}</li>";
//                        ?>
<!---->
<!--                        <!--Display selected toppings-->-->
<!--                        <li class='list-group-item'>-->
<!--                            <h3>Toppings:</h3>-->
<!--                            <ul class="list-group list-group-flush">-->
<!--                                --><?php
//                                // setup array to keep track of all selected toppings
//                                $selectedToppings = array();
//
//                                // if the customer wanted no cheese
//                                if( isset($_POST["no-cheese"]) ) {
//                                    $selectedToppings[] = "No Cheese";
//                                }
//
//                                // if the customer wanted half cheese
//                                if( isset($_POST["half-cheese"]) ) {
//                                    $selectedToppings[] = "Half Cheese";
//                                }
//
//                                // if the customer wanted cheese
//                                if( isset($_POST["cheese"]) ) {
//                                    $selectedToppings[] = "Cheese";
//                                }
//
//                                // if the customer wanted Parmesan
//                                if( isset($_POST["parmesan-cheese"]) ) {
//                                    $selectedToppings[] = "Parmesan";
//                                }
//
//                                // run through the toppings array and display all selected toppings
//                                foreach ($selectedToppings as $currTopping) {
//                                    echo "<li class='list-group-item'>{$currTopping}</li>";
//                                }
//                                ?>
<!--                            </ul>-->
<!--                        </li>-->
<!---->
<!--                        <!--Display pizza cost-->-->
<!--                        --><?php
//                            // setup associative array to hold pizza size and total cost pairs
//                            $totalCosts = array("S" => "$20.99", "M" => "$35.99", "L" => "$55.99");
//
//                            // display total cost based on pizza size
//                            echo "<li class='list-group-item h3 mb-0'>Total Cost: {$totalCosts[$pizzaSize]}</li>";
//                        ?>
<!--                    </ul>-->
<!--                --><?php
//                        // setup sending and receiving addresses
//                        $sendToAddress = $_POST["customer-email"];
//                        $sendFromAddress = "noreply@twotimescheese.com";
//
//                        // setup headers for html email
//                        $headers = "MIME-Version: 1.0" . "\r\n";
//                        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
//                        $headers .= "From: {$sendFromAddress}" . "\r\n";
//
//                        // setup subject
//                        $subject = "2x Cheese Pizza Receipt - Team Gecko";
//
//                        // add all selected toppings from array to display string
//                        $toppingsEmailDisplay = implode(", ", $selectedToppings) . "\r\n";
//
//                        // setup order summary
//                        $orderSummary = "<html lang='en'>
//                                            <body>
//                                                <h2>{$subject}</h2>
//                                                <p>Hey {$customerName}, thanks for placing an order at 2x Cheese Pizza!</p>
//                                                <h3>Your order was:</h3>
//                                                <p><strong>Size</strong>: {$pizzaSize}</p>
//                                                <p><strong>Toppings</strong>: {$toppingsEmailDisplay}</p>
//                                                <h3>Total Cost: {$totalCosts[$pizzaSize]}</h3>
//                                                <br>
//                                                <a href='www.geckos.greenriverdev.com/practice/pizza-ordering/'>
//                                                Liked your pizza? Come place another order!!
//                                                </a>
//                                            </body>
//                                        </html>";
//
//                        // send the receipt to customer
//                        mail($sendToAddress, $subject, $orderSummary, $headers);
//                    }
//
//                    // if user accessed the page w/o submitting an order
//                    else {
//                        // display a link to the order page
//                        echo "<li class='list-group-item h2 p-3 mb-0'>
//                                <a class='nav-link' href='/practice/pizza-ordering'>Click here to order</a>
//                              </li>";
//                    }
//                ?>
<!--            </div>-->
        </div>
        <div class="col-md-2 col-lg-4">
        </div>
    </div>
</div>
</body>
</html>