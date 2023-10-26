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
        <div class="col-md-2 col-lg-3">
        </div>
        <div class="col-12 col-md-8 col-lg-6">
            <div class="mt-3">
                <?php
                    // setup function to set up radios
                    function displayStars($numStarsSelected) {
                        // setup display string
                        $display = "You selected: ";

                        // display the number of stars chosen by user
                        for ($currStar = 0; $currStar < $numStarsSelected; $currStar++) {
                            $display .= "★";
                        }

                        return $display;
                    }

                    // check that all required questions were answered on the experience survey
                    if( isset($_POST["q1-site-attended"]) && isset($_POST["q2-enjoyed-site"])
                        && isset($_POST["q3-staff-supportive"]) && isset($_POST["q4-site-learning-objectives"])
                        && isset($_POST["q5-preceptor-learning-objectives"]) && isset($_POST["q6-recommend-site"]) ) {
                ?>

                <form class="my-2" action="/php/receipt.php" method="post">
                    <!-- Question 1 -->
                    <div class="card p-3 my-1">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">
                                1. What Clinical Site did you attend? <span class="text-danger">*</span>
                            </li>
                            <li class="list-group-item"><?php echo $_POST["q1-site-attended"]; ?></li>
                        </ul>
                    </div>
                    <!-- End of question 1 -->

                    <!-- question 2 -->
                    <div class="card p-3 my-1">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">
                                2. I enjoyed my time at this clinical site <span class="text-danger">*</span>
                            </li>
                            <li class="list-group-item">
                                <?php echo displayStars($_POST["q2-enjoyed-site"]); ?>
                            </li>
                        </ul>
                    </div>
                    <!-- End of question 2 -->

                    <!-- questions 3 -->
                    <div class="card p-3 my-1">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">
                                3. The clinical staff was supportive of my role <span class="text-danger">*</span>
                            </li>
                            <li class="list-group-item">
                                <?php echo displayStars($_POST["q3-staff-supportive"]); ?>
                            </li>
                        </ul>
                    </div>
                    <!-- end of question 3 -->

                    <!-- question 4 -->
                    <div class="card p-3 my-1">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">
                                4. The site helped facilitate my learning objectives. <span class="text-danger">*</span>
                            </li>
                            <li class="list-group-item">
                                <?php echo displayStars($_POST["q4-site-learning-objectives"]); ?>
                            </li>
                        </ul>
                    </div>
                    <!-- end of question 4-->

                    <!-- question 5 -->
                    <div class="card p-3 my-1">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">
                                5. My preceptor helped facilitate my learning objectives. <span class="text-danger">*</span>
                            </li>
                            <li class="list-group-item">
                                <?php echo displayStars($_POST["q5-preceptor-learning-objectives"]); ?>
                            </li>
                        </ul>
                    </div>
                    <!-- end of question 5 -->

                    <!-- question 6 -->
                    <div class="card p-3 my-1">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">
                                6. I would recommend this site to another student. <span class="text-danger">*</span>
                            </li>
                            <li class="list-group-item">
                                <?php echo displayStars($_POST["q6-recommend-site"]); ?>
                            </li>
                        </ul>   
                    </div>
                    <!-- end of question 6-->

                    <div class="my-1" id="optional-questions">
                        <!-- question 7 -->
                        <div class="card p-3 my-1">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item">
                                    7. If you have any comments you would like to leave about the site or
                                    staff at this facility please add below.
                                </li>
                                <li class="list-group-item">
                                    <?php echo $_POST["q7-site-or-staff-feedback"]; ?>
                                </li>
                            </ul>
                        </div>
                        <!-- end of question 7 -->

                        <!-- question 8-->
                        <div class="card p-3 my-1">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item">
                                    8. If you have any feedback you would like to leave about your clinical
                                    instructor please add below. <strong>None of the instructors will see this</strong>.
                                    We will just be using this to gage if an instructor needs to improve in areas,
                                    or to highlight instructors who go above and beyond.
                                </li>
                                <li class="list-group-item">
                                    <?php echo $_POST["q8-instructor-feedback"]; ?>
                                </li>
                            </ul>
                        </div>
                        <!-- end of question 8 -->
                    </div>
                    <div class="card container">
                        <div class="row justify-content-center">
                            <button class="col-4 btn py-2 m-2" id="submit-experience">Confirm</button>
                            <a class="col-4 btn btn-danger py-2 m-2" href="/sprint-2/experience.html">Cancel</a>
                        </div>
                    </div>
                </form>

                <?php
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
        <div class="col-md-2 col-lg-3">
        </div>
    </div>
</div>
</body>
</html>