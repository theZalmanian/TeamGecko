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
            <div class="col-md-1 col-lg-2">
            </div>
            <div class="col-12 col-md-10 col-lg-8 text-center">
                <div class="card p-3">
                    <!--Display pizza size-->
                    <?php echo "<h3> Pizza Size: " . $_POST["pizza-size"] . "</h3>"  ?>

                    <!--Display customer name-->
                    <?php echo "<h3> Customer Name: " . $_POST["customer-name"] . "</h3>" ?>

                    <?php
                        if($_POST["pizza-size"] == "s") {
                            echo "<h1>" . "Cost: 20.99"  . "</h1>";
                        }
                        elseif($_POST["pizza-size"] == "m") {
                            echo "<h1>" . "Cost: 35.99"  . "</h1>";
                        }
                        elseif($_POST["pizza-size"] == "l") {
                            echo "<h1>" . "Cost: 55.99"  . "</h1>";
                        }
                    ?>
                </div>
            </div>
            <div class="col-md-1 col-lg-2">
            </div>
        </div>
    </div>
</body>
</html>