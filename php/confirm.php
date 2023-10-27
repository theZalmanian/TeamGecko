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
                        $display = "<strong>You selected:</strong>" . " ";

                        // add the given number of # stars to the display
                        for ($currStar = 0; $currStar < $numStars; $currStar++) {
                            $display .= "★";
                        }

                        return $display;
                    }

                    /**
                     * Constructs a Bootstrap card element containing the given question, along with a response to it
                     * @param int $questionNum The question's number on the form
                     * @param string $questionText The question itself
                     * @param string $response The given response to that question
                     * @return string A Bootstrap card element containing a question and the given response to it
                     */
                    function displayQuestion($questionNum, $questionText, $response) {
                        // setup display card w/ the given values
                        $displayCard = "<div class='card p-3 my-1'>
                                        <ul class='list-group list-group-flush'>
                                        <li class='list-group-item'>
                                            {$questionNum}. {$questionText}
                                        </li>
                                        <li class='list-group-item'>
                                            {$response} 
                                        </li>
                                        </ul>
                                    </div>";
       
                        return $displayCard;
                    }

                    /**
                     * Constructs and returns a Bootstrap card element containing the given question, 
                     * along with the # of stars selected in response
                     * @param int $questionNum The question's number on the form
                     * @param string $questionText The question itself
                     * @param int $numStars The # of stars selected in response to the given question
                     * @return string A Bootstrap card element containing a question and the # of stars selected for it 
                     */
                    function displayStarQuestion($questionNum, $questionText, $numStars) {
                        // construct the card and display the selected # of stars
                        return displayQuestion($questionNum, $questionText, displayStars($numStars));
                    }

                    /**
                     * Constructs and returns a Bootstrap card element containing the given question, 
                     * along with a response to it
                     * @param int $questionNum The question's number on the form
                     * @param string $questionText The question itself
                     * @param string $response The given response to that question
                     * @param boolean $questionRequired True if question must be answered; otherwise False
                     * @return string A Bootstrap card element containing a question and the given response to it
                     */
                    function displayTextQuestion($questionNum, $questionText, $response, $questionRequired) {
                        $response = "<strong>You said:</strong> {$response}";

                        // if the given question was required
                        if($questionRequired) {
                            // add the required span to end of it
                            $questionText = "{$questionText} <span class='text-danger'>*</span>";
                        }

                        return displayQuestion($questionNum, $questionText, $response);
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
                            <?php 
                                // display questions and responses for questions 1 - 6 (required)
                                echo displayTextQuestion(1, "What Clinical Site did you attend?", $_POST["q1-site-attended"], true); 
                                echo displayStarQuestion(2, "I enjoyed my time at this clinical site", $_POST["q2-enjoyed-site"]);
                                echo displayStarQuestion(3, "The clinical staff was supportive of my role", $_POST["q3-staff-supportive"]);
                                echo displayStarQuestion(4, "The site helped facilitate my learning objectives.", $_POST["q4-site-learning-objectives"]);
                                echo displayStarQuestion(5, "My preceptor helped facilitate my learning objectives.", $_POST["q5-preceptor-learning-objectives"]);
                                echo displayStarQuestion(6, "I would recommend this site to another student.", $_POST["q6-recommend-site"]);
                            
                                // if they were answered, display questions and responses for questions 7 & 8 (optional)
                                if( !empty($_POST["q7-site-or-staff-feedback"]) ) {
                                    $questionText = "If you have any comments you would like to leave about the site or staff at this facility please add below.";
                                    
                                    echo displayTextQuestion(7, $questionText, $_POST["q7-site-or-staff-feedback"], false);
                                }

                                if( !empty($_POST["q8-instructor-feedback"]) ) {
                                    $questionText = "If you have any feedback you would like to leave about your 
                                    clinical instructor please add below. <strong>None of the instructors will see this</strong>.
                                    We will just be using this to gage if an instructor needs to improve in areas,
                                    or to highlight instructors who go above and beyond.";

                                    echo displayTextQuestion(8, $questionText, $_POST["q8-instructor-feedback"], false);
                                }
                            ?>
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