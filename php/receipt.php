<?php
    // get month and year data
    $currMonthNum = date("m", time());
    $currMonthChar = date("M", time());
    $currYear = date("y", time());
    
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
    if($currMonthNum >= 7 &&  $currMonthNum <= 9 ) {
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
    <div class="row d-flex align-items-center justify-content-center">
        <div class="col-12 col-md-8 col-lg-4">
            <div class="card text-center p-4 mt-3 bg-<?php echo $backgroundColor?>">
                <div class="p-4">
                    <h5>
                        Submitted on <?php echo "{$currMonthNum}/{$currYear}"?>
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
    </div>
</div>
</body>
</html>