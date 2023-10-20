<!DOCTYPE html>
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
        <div class="col-md-4">
        </div>
        <div class="col-12 col-md-4">
            <div class="card text-center mt-3">
                <ul class="list-group list-group-flush">
                    <!--Display customer name-->
                    <?php echo "<li class='list-group-item h1 mb-0'>" . $_POST["customer-name"] . "</li>" ?>

                    <!--Display pizza size-->
                    <?php echo "<li class='list-group-item h3 mb-0'> Pizza Size: " . $_POST["pizza-size"] . "</li>"  ?>

                    <!--Display selected toppings-->
                    <li class='list-group-item'>
                        <h3>Toppings:</h3>
                        <ul class="list-group list-group-flush">
                            <?php
                            // if the customer wanted no cheese
                            if( isset($_POST["no-cheese"]) ) {
                                // display cheese
                                echo "<li class='list-group-item'>" . "No Cheese" . "</li>";
                            }

                            // if the customer wanted half cheese
                            if( isset($_POST["half-cheese"]) ) {
                                // display cheese
                                echo "<li class='list-group-item'>" . "Half Cheese" . "</li>";
                            }

                            // if the customer wanted cheese
                            if( isset($_POST["cheese"]) ) {
                                // display cheese
                                echo "<li class='list-group-item'>" . "Cheese" . "</li>";
                            }

                            // if the customer wanted parmesan
                            if( isset($_POST["parmesan"]) ) {
                                // display parmesan
                                echo "<li class='list-group-item'>" . "Parmesan" . "</li>";
                            }
                            ?>
                        </ul>
                    </li>

                    <!--Display pizza cost-->
                    <?php
                    echo "<li class='list-group-item h3 mb-0'>Total Cost: $";
                    if($_POST["pizza-size"] == "S") {
                        echo "20.99";
                    }
                    elseif($_POST["pizza-size"] == "M") {
                        echo "35.99";
                    }
                    elseif($_POST["pizza-size"] == "L") {
                        echo "55.99";
                    }
                    echo "</li>";
                    ?>
                </ul>
            </div>
        </div>
        <div class="col-md-4">
        </div>
    </div>
</div>
</body>
</html>