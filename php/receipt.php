<?php
    $monthNumber = date("m", time());
    $monthLetters = date("M", time());
    $years = date("y", time());
    $color = "";
    $random1 = rand(0, 9);
    $random2 = rand(0, 9);
    $random3 = rand(0, 9);
    $random4 = rand(0, 9);

    if($monthNumber <= 3)
    {
        $color = "info";
    }
    else if($monthNumber == 4 || $monthNumber == 5 || $monthNumber == 6 )
    {
        $color = "success";
    }
    else if($monthNumber == 7 || $monthNumber == 8 || $monthNumber == 9 )
    {
        $color = "danger";
    }
    else
    {
        $color = "orange";
    }

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
            <div class="card text-center p-4 mt-3 bg-<?php echo $color?> ">
                <div class="p-4">
                    <h5>Submitted on <?php echo "${monthNumber}/${years}"?></h5>
                    <h1>
                        <?php
                        echo "${monthLetters[0]}${random1}${random2}${random3}${random4}${years}";
                        ?>
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