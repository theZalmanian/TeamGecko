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
                    /**
                     * Constructs and returns a string made up of the given # of stars: ★
                     * @param int $numStars The # of stars to be generated and displayed
                     * @return string A string displaying "You selected:" in bold, followed by the given # of stars
                     */
                    function displayStars($numStars) {
                        // setup display string
                        $display = "<strong>You selected</strong>: ";

                        // add the given number of # stars to the display
                        for ($currStar = 0; $currStar < $numStars; $currStar++) {
                            $display .= "★";
                        }

                        return $display;
                    }

                    /**
                     * Constructs a bootstrap card element containing the given question, along with a response to it
                     * @param int $questionNum The number of the question being displayed
                     * @param string $questionText The text making up the question
                     * @param string $response The given response to that question
                     * @return string A bootstrap card element containing a question and the given response to it
                     */
                    function displayQuestion($questionNum, $questionText, $response) {
                        // setup display string w/ the given values
                        $display = "<div class='card p-3 my-1'>
                                        <ul class='list-group list-group-flush'>
                                        <li class='list-group-item'>
                                            {$questionNum}. {$questionText} <span class='text-danger'>*</span>
                                        </li>
                                        <li class='list-group-item'>
                                            {$response} 
                                        </li>
                                        </ul>
                                    </div>";
       
                        return $display;
                    }

                    // check that all required questions were answered on the Experience Survey
                    if( isset($_POST["q1-site-attended"]) 
                        && isset($_POST["q2-enjoyed-site"])
                        && isset($_POST["q3-staff-supportive"]) 
                        && isset($_POST["q4-site-learning-objectives"])
                        && isset($_POST["q5-preceptor-learning-objectives"]) 
                        && isset($_POST["q6-recommend-site"]) ) {
                ?>
                        <form class="my-2" action="/php/receipt.php" method="post">
                            <!-- Question 1 -->
                            <div class="card p-3 my-1">
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item">
                                        1. What Clinical Site did you attend? <span class="text-danger">*</span>
                                    </li>
                                    <li class="list-group-item">
                                        <strong>You said</strong>: <?php echo $_POST["q1-site-attended"]; ?>
                                    </li>
                                </ul>
                            </div>
                            <?php echo displayQuestion(1, "What Clinical Site did you attend?", 
                                                        "<strong>You said</strong>" . $_POST["q1-site-attended"]); ?>
                            <!-- End of question 1 -->

                            <!-- question 2 -->
                            <?php echo displayQuestion(2, "I enjoyed my time at this clinical site", displayStars($_POST["q2-enjoyed-site"])); ?>
                            <!-- End of question 2 -->

                            <!-- questions 3 -->
                            <?php echo displayQuestion(3, "The clinical staff was supportive of my role", displayStars($_POST["q3-staff-supportive"])); ?>
                            <!-- end of question 3 -->

                            <!-- question 4 -->
                            <?php echo displayQuestion(4, "The site helped facilitate my learning objectives.", displayStars($_POST["q4-site-learning-objectives"])); ?>
                            <!-- end of question 4-->

                            <!-- question 5 -->
                            <?php echo displayQuestion(5, "My preceptor helped facilitate my learning objectives.", displayStars($_POST["q5-preceptor-learning-objectives"])); ?>
                            <!-- end of question 5 -->

                            <!-- question 6 -->
                            <?php echo displayQuestion(6, "I would recommend this site to another student.", displayStars($_POST["q6-recommend-site"])); ?>
                            <!-- end of question 6-->

                            <div class="my-1">
                                <!-- question 7 -->
                                <?php if( !empty($_POST["q7-site-or-staff-feedback"]) ) { ?>
                                    <div class="card p-3 my-1">
                                        <ul class="list-group list-group-flush">
                                            <li class="list-group-item">
                                                7. If you have any comments you would like to leave about the site or
                                                staff at this facility please add below.
                                            </li>
                                            <li class="list-group-item">
                                                <strong>You said</strong>: <?php echo $_POST["q7-site-or-staff-feedback"]; ?>
                                            </li>
                                        </ul>
                                    </div>
                                <?php } ?>
                                <!-- end of question 7 -->

                                <!-- question 8-->
                                <?php if( !empty($_POST["q8-instructor-feedback"]) ) { ?>
                                    <div class="card p-3 my-1">
                                        <ul class="list-group list-group-flush">
                                            <li class="list-group-item">
                                                8. If you have any feedback you would like to leave about your clinical
                                                instructor please add below. <strong>None of the instructors will see this</strong>.
                                                We will just be using this to gage if an instructor needs to improve in areas,
                                                or to highlight instructors who go above and beyond.
                                            </li>
                                            <li class="list-group-item">
                                                <strong>You said</strong>: <?php echo $_POST["q8-instructor-feedback"]; ?>
                                            </li>
                                        </ul>
                                    </div>
                                <?php } ?>
                                <!-- end of question 8 -->
                            </div>
                            <div class="card container p-3 my-1">
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