<?php
    // get access to all PHP helpers
    require_once("/home/geckosgr/public_html/initial.php");

    // check if name cookie is stored
    $customerName = "";
    if( isset($_COOKIE["customer-name"]) ) {
        // get the customers name
        $customerName = $_COOKIE["customer-name"];
    }

    // get admin flag from session
    $isAdmin = $_SESSION["pizza-admin"];
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
    <!--Start of Nav-->
    <nav class="navbar sticky-top navbar-expand-md mb-3">
        <div class="container">
            <a class="navbar-brand" href="/index.html">
                <img src="/gecko-images/geckos-logo.svg" height="40" alt="A logo of a green gecko">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon">
                    </span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <div class="navbar-nav">
                    <a class="nav-link" href="/index.html">
                        Home
                    </a>
                    <div class="nav-item dropdown-center">
                        <button class="nav-link dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                            Practice
                        </button>
                        <div class="dropdown-menu">
                            <a class="dropdown-item active disabled" aria-current="page" href="/practice/pizza-ordering/index.php">
                                Order Pizza
                            </a>
                            <hr class="dropdown-divider">
                            <?php if($isAdmin) { ?>
                                <a class="dropdown-item" href="/practice/php/view-pizza-orders.php">
                                    View Pizza Orders
                                </a>
                                <hr class="dropdown-divider">
                            <?php } ?>
                            <a class="dropdown-item" href="/practice/php/display-students.php">
                                Display Students
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>
    <!--End of Nav-->

    <div class="container">
        <div class="row">
            <div class="col-md-1 col-lg-2">
            </div>
            <div class="col-12 col-md-10 col-lg-8 text-center">
                <form id="pizza-shop" action="/practice/php/add-pizza-order.php" target="_blank" method="post">
                    <div class="card p-3">
                        <h1>2x Cheese Pizza</h1>
                        <div class="form-floating my-1">
                            <input type="text" class="form-control" id="customer-name" name="customer-name" 
                                    placeholder="" required value="<?php echo $customerName ?>">
                            <label for="customer-name">Name</label>
                        </div>
                        <div class="form-floating my-2">
                            <input type="email" class="form-control" id="customer-email" name="customer-email" 
                                    placeholder="" required>
                            <label for="customer-email">Email</label>
                        </div>
                        <div class="container">
                            <h4 class="col-12 card py-2 input-heading">Pizza Size</h4>
                            <div class="row input-group-text justify-content-center py-2 my-2">
                                <input type="radio" class="btn-check" name="pizza-size" id="small-pizza" value="S">
                                <label class="btn col-3 m-2" for="small-pizza">Small</label>

                                <input type="radio" class="btn-check" name="pizza-size" id="medium-pizza" value="M">
                                <label class="btn col-3 m-2" for="medium-pizza">Medium</label>

                                <input type="radio" class="btn-check" name="pizza-size" id="large-pizza" value="L" required>
                                <label class="btn col-3 m-2" for="large-pizza">Large</label>
                            </div>
                        </div>
                        <div class="container">
                            <h4 class="col-12 card py-2 input-heading">Toppings</h4>
                            <div class="row input-group-text justify-content-center py-2 my-2">
                                <input class="btn-check topping-check" id="no-cheese" type="checkbox" name="no-cheese">
                                <label class="btn col-4 col-lg-2 m-2" for="no-cheese">No Cheese</label>
                
                                <input class="btn-check topping-check" id="half-cheese" type="checkbox" name="half-cheese">
                                <label class="btn col-4 col-lg-2 m-2" for="half-cheese">Half Cheese</label>
        
                                <input class="btn-check topping-check" id="cheese" type="checkbox" name="cheese">
                                <label class="btn col-4 col-lg-2 m-2" for="cheese">Cheese</label>
                                
                                <input class="btn-check topping-check" id="parmesan" type="checkbox" name="parmesan-cheese">
                                <label class="btn col-4 col-lg-2 m-2" for="parmesan">Parmesan</label>
                            </div>
                        </div>
                        <button class="btn w-100 py-2 my-2" type="submit" id="submit">Submit</button>
                    </div>
                </form>
            </div>
            <div class="col-md-1 col-lg-2">
            </div>
        </div>
    </div>

    <script>
        // when the page loads
        window.addEventListener('load', function() {            
            // setup onclick for the "Submit" button so it triggers form validation
            setupButtonOnClick('submit', validateCheckBox);
        })

        /**
         * Ensures the user selected exactly two toppings. If not, form is not submitted
         */
        function validateCheckBox() {
            // get all topping checkboxes
            let toppingsCheckBoxes = document.querySelectorAll('.topping-check') 

            // run through all checkboxes on page
            let numChecked = 0;
            toppingsCheckBoxes.forEach((currentCheckBox) => {
                if(currentCheckBox.checked) {
                    numChecked++;
                }
            })

            // user must choose exactly two toppings
            if(numChecked !== 2) {
                // display error
                alert("You must choose exactly two toppings!");
                
                // stop the form from being submitted
                event.preventDefault();
            }
        }

        /**
         * Sets up an onclick event for the given button using the given function
         * @param buttonID The button's id
         * @param useFunction The function to be called when button is clicked
         */
        function setupButtonOnClick(buttonID, useFunction) {
            // get the button
            let button = getByID(buttonID);

            // set it's onclick event
            button.addEventListener("click", useFunction);
        }

        /**
         * Shortened form of the document.getElementById method
         * @param elementID The element's id
         * @returns The corresponding HTML Element
         */
        function getByID(elementID) {
            return document.getElementById(elementID);
        }
    </script>
</body>
</html>