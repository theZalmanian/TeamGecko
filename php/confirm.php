<?php 
    // get access to all PHP helpers
    require_once("/home/geckosgr/public_html/initial.php");

    // store the current page's title for dynamic HTML generation
    $currPageTitle = "Confirm Submission";

    // setup variables to hold Experience Survey form inputs
    $siteAttended = $_POST["q1-site-attended"];
    $enjoyedSite = $_POST["q2-enjoyed-site"];
    $staffSupportive = $_POST["q3-staff-supportive"];
    $siteLearningObjectives = $_POST["q4-site-learning-objectives"];
    $preceptorLearningObjectives = $_POST["q5-preceptor-learning-objectives"];
    $recommendSite = $_POST["q6-recommend-site"];
    $siteOrStaffFeedback = $_POST["q7-site-or-staff-feedback"];
    $instructorFeedback = $_POST["q8-instructor-feedback"];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php 
        // include standard nursing header metadata
        require_once(LAYOUTS_PATH . "/nursing-metadata.php");
    ?>
</head>
<body>
    <main class="container my-3">
        <div class="row">
            <div class="col-md-2 col-lg-3">
            </div>
            <div class="col-12 col-md-8 col-lg-6">
                <?php
                    // check that all required questions were answered on the Experience Survey
                    if( isset($siteAttended) 
                        && isset($enjoyedSite)
                        && isset($staffSupportive) 
                        && isset($siteLearningObjectives)
                        && isset($preceptorLearningObjectives) 
                        && isset($recommendSite) ) {
                            // display questions and responses for questions 1 - 6 (required)
                            echo generateTextQuestionDisplay(1, "What Clinical Site did you attend?", $siteAttended, true); 
                            echo generateStarQuestionDisplay(2, "I enjoyed my time at this clinical site", $enjoyedSite);
                            echo generateStarQuestionDisplay(3, "The clinical staff was supportive of my role", $staffSupportive);
                            echo generateStarQuestionDisplay(4, "The site helped facilitate my learning objectives.", $siteLearningObjectives);
                            echo generateStarQuestionDisplay(5, "My preceptor helped facilitate my learning objectives.", $preceptorLearningObjectives);
                            echo generateStarQuestionDisplay(6, "I would recommend this site to another student.", $recommendSite);
                        
                            // if they were answered, display questions and responses for questions 7 & 8 (optional)
                            if( !empty($siteOrStaffFeedback) ) {
                                $questionText = "If you have any comments you would like to leave about the site or staff at this facility please add below.";
                                
                                echo generateTextQuestionDisplay(7, $questionText, $siteOrStaffFeedback, false);
                            }

                            if( !empty($instructorFeedback) ) {
                                $questionText = "If you have any feedback you would like to leave about your 
                                                 clinical instructor please add below. <strong>None of the instructors will see this</strong>.
                                                 We will just be using this to gage if an instructor needs to improve in areas,
                                                 or to highlight instructors who go above and beyond.";

                                echo generateTextQuestionDisplay(8, $questionText, $instructorFeedback, false);
                            }
                ?>
                            <form class="my-1" action="/php/receipt.php" method="post">
                                <input type="hidden" name="survey-submitted" value="confirmed">

                                <input type="hidden" name="q1-site-attended" value="<?php echo $siteAttended; ?>">
                                <input type="hidden" name="q2-enjoyed-site" value="<?php echo $enjoyedSite; ?>">
                                <input type="hidden" name="q3-staff-supportive" value="<?php echo $staffSupportive; ?>">
                                <input type="hidden" name="q4-site-learning-objectives" value="<?php echo $siteLearningObjectives; ?>">
                                <input type="hidden" name="q5-preceptor-learning-objectives" value="<?php echo $preceptorLearningObjectives; ?>">
                                <input type="hidden" name="q6-recommend-site" value="<?php echo $recommendSite; ?>">
                                <input type="hidden" name="q7-site-or-staff-feedback" value="<?php echo $siteOrStaffFeedback; ?>">
                                <input type="hidden" name="q8-instructor-feedback" value="<?php echo $instructorFeedback; ?>">

                                <div class="card container p-2 my-1">
                                    <div class="row justify-content-center">
                                        <button type="submit" class="col-5 btn btn-success py-2 m-2 border" id="submit-experience">Confirm</button>
                                        <a class="col-5 btn btn-danger py-2 m-2 border" href="/sprint-4/experience.php">Cancel</a>
                                    </div>
                                </div>
                            </form>
                <?php
                    }

                    // otherwise display error and link to experience survey
                    else {
                        echo generateMessageWithLink("/sprint-5/experience.php", "Experience Survey",
                                                        "Please fill out the survey and try again",
                                                        "ERROR: No submission received from Experience Survey");
                    }
                ?>
            </div>
            <div class="col-md-2 col-lg-3">
            </div>
        </div>
    </main>
</body>
</html>

<?php 
    /**
     * Constructs a Bootstrap Card element containing the given question, along with a response to it
     * @param int $questionNum The question's number on the form
     * @param string $questionText The question itself
     * @param string $response The given response to that question
     * @return string A Bootstrap Card element containing a question and the given response to it
     */
    function generateQuestionDisplay($questionNum, $questionText, $response) {
        // setup and return display card w/ the given values
        return "<div class='card p-3 my-1'>
                    <ul class='list-group list-group-flush'>
                        <li class='list-group-item'>
                            {$questionNum}. {$questionText}
                        </li>
                        <li class='list-group-item'>
                            {$response} 
                        </li>
                    </ul>
                </div>";
    }

    /**
     * Constructs and returns a Bootstrap Card element containing the given question, 
     * along with the # of stars selected in response
     * @param int $questionNum The question's number on the form
     * @param string $questionText The question itself
     * @param int $numStars The # of stars selected in response to the given question
     * @return string A Bootstrap Card element containing a question and the # of stars selected for it 
     */
    function generateStarQuestionDisplay($questionNum, $questionText, $numStars) {
        $response = displayStrong("You selected:") . generateStars($numStars);

        // construct the card and display the selected # of stars
        return generateQuestionDisplay($questionNum, $questionText . displayRequired(), $response);
    }

    /**
     * Constructs and returns a Bootstrap Card element containing the given question, 
     * along with a response to it
     * @param int $questionNum The question's number on the form
     * @param string $questionText The question itself
     * @param string $response The given response to that question
     * @param boolean $isRequired True if question must be answered; otherwise False
     * @return string A Bootstrap Card element containing a question and the given response to it
     */
    function generateTextQuestionDisplay($questionNum, $questionText, $response, $isRequired) {
        $response = displayStrong("You said:") . $response;

        // if the given question was required
        if($isRequired) {
            // add the required span after it
            $questionText .= displayRequired();
        }

        // construct the card and display the given response
        return generateQuestionDisplay($questionNum, $questionText, $response);
    }
?>