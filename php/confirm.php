<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirm Submission</title>
    <link rel="icon" type="image/x-icon" href="/nursing-images/nursing-logo.png">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="/css/nursing.css">
</head>
<body>
<div class="container">
    <div class="row">
        <div class="col-md-2 col-lg-4">
        </div>
        <div class="col-12 col-md-8 col-lg-4">
            <div class="card text-center mt-3">
                <?php
                    // check that all required questions were answered on the experience survey
                    if( isset($_POST["q1-site-attended"]) &&
                        isset($_POST["q2-enjoyed-site"]) &&
                        isset($_POST["q3-staff-supportive"]) &&
                        isset($_POST["q4-site-learning-objectives"]) &&
                        isset($_POST["q5-preceptor-learning-objectives"]) &&
                        isset($_POST["q6-recommend-site"]) ) {
                        echo var_dump($_POST);
                    }
                    else {
                        echo "<div class='h4 p-3 mb-0'>
                                <p>
                                    Please fill out the Clinical Experience Questionnaire:
                                </p>
                                <a class='nav-link btn' href='/sprint-2/experience.html'>
                                    Experience Form
                                </a>
                              </div>";
                    }
                ?>
            </div>
        </div>
        <div class="col-md-2 col-lg-4">
        </div>
    </div>
</div>
</body>
</html>