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
            <div class="col-md-2 col-lg-3">
            </div>
            <div class="col-12 col-md-8 col-lg-6">
                <div class="my-3">
                    <?php
                        // setup variables to hold Experience Survey form inputs
                        $siteAttended = $_POST["q1-site-attended"];
                        $enjoyedSite = $_POST["q2-enjoyed-site"];
                        $staffSupportive = $_POST["q3-staff-supportive"];
                        $siteLearningObjectives = $_POST["q4-site-learning-objectives"];
                        $preceptorLearningObjectives = $_POST["q5-preceptor-learning-objectives"];
                        $recommendSite = $_POST["q6-recommend-site"];
                        $siteOrStaffFeedback = $_POST["q7-site-or-staff-feedback"];
                        $instructorFeedback = $_POST["q8-instructor-feedback"];

                        // check that all required questions were answered on the Experience Survey
                        if( isset($siteAttended) 
                            && isset($enjoyedSite)
                            && isset($staffSupportive) 
                            && isset($siteLearningObjectives)
                            && isset($preceptorLearningObjectives) 
                            && isset($recommendSite) ) {
                                // setup flag to keep track of textbox requirement status
                                $textQuestionRequired = true;

                                // display questions and responses for questions 1 - 6 (required)
                                echo displayTextQuestion(1, "What Clinical Site did you attend?", $siteAttended, $textQuestionRequired); 
                                echo displayStarQuestion(2, "I enjoyed my time at this clinical site", $enjoyedSite);
                                echo displayStarQuestion(3, "The clinical staff was supportive of my role", $staffSupportive);
                                echo displayStarQuestion(4, "The site helped facilitate my learning objectives.", $siteLearningObjectives);
                                echo displayStarQuestion(5, "My preceptor helped facilitate my learning objectives.", $preceptorLearningObjectives);
                                echo displayStarQuestion(6, "I would recommend this site to another student.", $recommendSite);
                            
                                // if they were answered, display questions and responses for questions 7 & 8 (optional)
                                if( !empty($siteOrStaffFeedback) ) {
                                    $questionText = "If you have any comments you would like to leave about the site or staff at this facility please add below.";
                                    
                                    echo displayTextQuestion(7, $questionText, $siteOrStaffFeedback, !$textQuestionRequired);
                                }

                                if( !empty($instructorFeedback) ) {
                                    $questionText = "If you have any feedback you would like to leave about your 
                                    clinical instructor please add below. <strong>None of the instructors will see this</strong>.
                                    We will just be using this to gage if an instructor needs to improve in areas,
                                    or to highlight instructors who go above and beyond.";

                                    echo displayTextQuestion(8, $questionText, $instructorFeedback, !$textQuestionRequired);
                                }
                    ?>
                                <form class="my-1" action="/php/receipt.php" method="post">
                                    <input type="hidden" name="survey-submitted" value="confirmed">

                                    <div class="card container p-2 my-1">
                                        <div class="row justify-content-center">
                                            <button class="col-5 btn btn-success py-2 m-2" id="submit-experience">Confirm</button>
                                            <a class="col-5 btn btn-danger py-2 m-2" href="/sprint-2/experience.html">Cancel</a>
                                        </div>
                                    </div>
                                </form>
                    <?php
                        }

                        // otherwise display error and link to experience survey
                        else {
                            echo displayError("No submission received from Experience Survey.");

                            echo displayCardWithContent("<h4>
                                                            Please fill out the survey and try again:
                                                        </h4>
                                                        <a class='btn btn-success py-2 m-2' href='/sprint-2/experience.html'>
                                                            Experience Survey
                                                        </a>");
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

    /**
     * Constructs and returns a string made up of the given # of stars: ★
     * @param int $numStars The # of stars to be generated and displayed
     * @return string A string displaying "You selected:" in bold, followed by the given # of stars
     */
    function displayStars($numStars) {
        // add the given number of # stars to the display
        $display = "";
        for ($currStar = 0; $currStar < $numStars; $currStar++) {
            $display .= "★";
        }

        return $display;
    }

    /**
     * Returns an HTML span signifying that an input is required
     * @return string an HTML span signifying that an input is required
     */
    function displayRequired() {
        return " " . "<span class='text-danger'>*</span>";
    }

    /**
     * Returns the given message inside of an HTML strong element
     * @param string $message The message being displayed inside an HTML strong element
     * @return string the given message inside of an HTML strong element
     */
    function displayStrong($message) {
        return "<strong>{$message}</strong>" . " ";
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
        $response = displayStrong("You selected:") . displayStars($numStars);

        // all star questions are required
        $questionText .= displayRequired();

        // construct the card and display the selected # of stars
        return displayQuestion($questionNum, $questionText, $response);
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
        $response = displayStrong("You said:") . $response;

        // if the given question was required
        if($questionRequired) {
            // add the required span after it
            $questionText .= displayRequired();
        }

        // construct the card and display the given response
        return displayQuestion($questionNum, $questionText, $response);
    }
?>