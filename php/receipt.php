<?php
    // get current month and year data
    $currMonthNum = date("m");
    $currMonthChar = date("M");
    $currYear = date("y");
    
    // generate four random digits 0 - 9
    $firstDigit = rand(0, 9);
    $secondDigit = rand(0, 9);
    $thirdDigit = rand(0, 9);
    $fourthDigit = rand(0, 9);

    // select background color based on month
    $backgroundColor = "";
    
    // if Jan, Feb, or Mar
    if($currMonthNum >= 1 && $currMonthNum <= 3) {
        $backgroundColor = "blue"; // background will be blue
    }

    // if Apr, May, June
    if($currMonthNum >= 4 && $currMonthNum <= 6 ) {
        $backgroundColor = "green"; // background will be green
    }

    // if July, Aug, Sep
    if($currMonthNum >= 7 && $currMonthNum <= 9 ) {
        $backgroundColor = "red"; // background will be red
    }

    // if Oct, Nov, Dec
    if($currMonthNum >= 10 && $currMonthNum <= 12) {
        $backgroundColor = "orange"; // background will be orange
    }

    // setup code (First letter of month, four random digits, last two digits of year)
    $receiptCode = "{$currMonthChar[0]}{$firstDigit}{$secondDigit}{$thirdDigit}{$fourthDigit}{$currYear}";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirm Submission</title>
    <link rel="icon" type="image/x-icon" href="/nursing-images/nursing-logo.png">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="/css/nursing-sprint-2.css">
</head>
<body>
    <div class="container">
        <div class="row">
        <?php
            // check that user came here from confirm.php
            if( isset($_POST["survey-submitted"]) && $_POST["survey-submitted"] == "confirmed" ) {
        ?>
            <div class="col-md-4">
            </div>
            <div class="col-12 col-md-4 mt-3">
                <div class="card text-center p-5 bg-<?php echo $backgroundColor; ?>">
                    <div class="p-4">
                        <h5>
                            Submitted on <?php echo "{$currMonthNum}/{$currYear}"; ?>
                        </h5>
                        <h1>
                            <?php echo $receiptCode; ?>
                        </h1>
                    </div>
                    <div>
                        <p class="py-2">
                            Screenshot this page as a receipt for your instructor
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
            </div>
        <?php
            }

            // otherwise display error and link to experience survey
            else { 
        ?>
                <div class="col-md-2 col-lg-3">
                </div>
                <div class="col-12 col-md-8 col-lg-6 mt-3">
                <?php
                    echo displayError("No submission received from Experience Survey.");

                    echo displayCardWithContent("<h4>
                                                    Please fill out the survey and try again:
                                                </h4>
                                                <a class='btn btn-success py-2 m-2' href='/sprint-2/experience.html'>
                                                    Experience Survey
                                                </a>");

                ?>
                </div>
                <div class="col-md-2 col-lg-3">
                </div>
        <?php
            }
        ?>
        </div>
    </div>
</body>
</html>

<?php 
    /**
     * Returns a Bootstrap card containing the given error message
     * @param string $errorMessage The error message being displayed in the Bootstrap card
     * @return string a Bootstrap card containing the given error message
     */
    function displayError($errorMessage) {
        // setup error content
        $errorContent = "<h4>
                            Error: {$errorMessage}
                        </h4>";

        return displayCardWithContent($errorContent);
    }

    /**
     * Returns a Bootstrap card containing the given HTML content
     * @param string $content The HTML element(s) being displayed in the Bootstrap card
     * @return string a Bootstrap card containing the given HTML content
     */
    function displayCardWithContent($content) {
        return "<div class='card p-3 my-1 text-center'>{$content}</div>";
    }
?>