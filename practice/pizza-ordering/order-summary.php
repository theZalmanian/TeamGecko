<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Summary</title>
    <link rel="icon" type="image/x-icon" href="/gecko-images/geckos-logo.svg">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="/css/gecko.css">
</head>
<body>
<div class="container">
    <div class="row">
        <div class="col-md-3">
        </div>
        <div class="col-12 col-md-6">
            <div class="card text-center p-3">
                <!--Display customer name-->
                <?php echo "<h3>" . $_POST["customer-name"] . "</h3>" ?>

                <!--Display pizza size-->
                <?php

                echo "<h3> Pizza Size: " . $_POST["pizza-size"] . "</h3>"  ?>

                <h3>Toppings:</h3>
                <ul>
                    <?php
                    // if the customer wanted no cheese
                    if( isset($_POST["no-cheese"]) ) {
                        // display cheese
                        echo "<li>" . "No Cheese" . "</li>";
                    }

                    // if the customer wanted half cheese
                    if( isset($_POST["half-cheese"]) ) {
                        // display cheese
                        echo "<li>" . "Half Cheese" . "</li>";
                    }

                    // if the customer wanted cheese
                    if( isset($_POST["cheese"]) ) {
                        // display cheese
                        echo "<li>" . "Cheese" . "</li>";
                    }

                    // if the customer wanted parmesan
                    if( isset($_POST["parmesan"]) ) {
                        // display parmesan
                        echo "<li>" . "Parmesan" . "</li>";
                    }
                    ?>
                </ul>

                <?php
                if($_POST["pizza-size"] == "S") {
                    echo "<h3>" . "Cost: $20.99"  . "</h3>";
                }
                elseif($_POST["pizza-size"] == "M") {
                    echo "<h3>" . "Cost: $35.99"  . "</h3>";
                }
                elseif($_POST["pizza-size"] == "L") {
                    echo "<h3>" . "Cost: $55.99"  . "</h3>";
                }
                ?>
            </div>
        </div>
        <div class="col-md-3">
        </div>
    </div>
</div>
</body>
</html>