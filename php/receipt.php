<?php
    // get access to all PHP helpers
    require_once("/home/geckosgr/public_html/initial.php");

    // store the current page's title for dynamic HTML generation
    $currPageTitle = "Submission Receipt";
    $cookie_name = "cookie";
    $AlreadySubmitted = $_POST["survey-submitted"] && $_POST["survey-submitted"] == "confirmed" ;
    setcookie($cookie_name,$AlreadySubmitted,time() + (86400 * 30), "/");
    /**
     * A numeric representation of the current month
     */
    $currMonthNum = date("m");

    /**
     * The first character of the current month
     */
    $currMonthChar = substr(date("M"), 0, 1);

    /**
     * The last two digits of the current year
     */
    $currYear = date("y");

    /**
     * The background color of the receipt block, based on month
     */
    $backgroundColor = calculateBackgroundColor($currMonthNum);

    /**
     * Contains four random digits 0 - 9
     */
    $randomDigits = array(
        rand(0, 9),
        rand(0, 9),
        rand(0, 9),
        rand(0, 9)
    );

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
    <main class="container">
        <div class="row">
        <?php
        // check that user came here from confirm.php
            if( isset($_POST["survey-submitted"]) && $_POST["survey-submitted"] == "confirmed" ) {

                ?>
            <div class="col-md-4">
            </div>
            <div class="col-12 col-md-4 mt-3">
                <?php echo generateReceipt($backgroundColor, $randomDigits, $currMonthNum, $currMonthChar, $currYear) ?>
            </div>
            <div class="col-md-4">
            </div>
        <?php
            }

            // if all Experience Survey data came through
            if( isset($siteAttended)
                && isset($enjoyedSite)
                && isset($staffSupportive)
                && isset($siteLearningObjectives)
                && isset($preceptorLearningObjectives)
                && isset($recommendSite)
                && isset($siteOrStaffFeedback)
                && isset($instructorFeedback)) {
                // insert the submission into DB
                executeQuery("INSERT INTO ExperienceFormSubmissions (SiteAttended, EnjoyedSite, StaffSupportive, 
                                          SiteLearningObjectives, PreceptorLearningObjectives, 
                                          RecommendSite, SiteOrStaffFeedback, InstructorFeedback) 
                                VALUES('{$siteAttended}', '{$enjoyedSite}', '{$staffSupportive}', 
                                       '{$siteLearningObjectives}', '{$preceptorLearningObjectives}', 
                                       '{$recommendSite}', '{$siteOrStaffFeedback}', '{$instructorFeedback}')");

        }
            // otherwise display error and link to experience survey
            else { 
        ?>
                <div class="col-md-2 col-lg-3">
                </div>
                <div class="col-12 col-md-8 col-lg-6">
                    <?php
                        echo generateMessageWithLink("/sprint-4/experience.php", "Experience Survey",
                                                     "Please fill out the survey and try again",
                                                     "ERROR: No submission received from Experience Survey");
                    ?>
                </div>
                <div class="col-md-2 col-lg-3">
                </div>
        <?php
            }
        ?>
        </div>
    </main>
</body>
</html>

<?php 
    /**
     * Generates and returns a Bootstrap Card containing a submission receipt for the Experience Survey
     * @param string $backgroundColor The background color of the receipt block, based on month
     * @param array $randomDigits An array containing four random digits (0 - 9)
     * @param string $currMonthNum A numeric representation of the current month
     * @param string $currMonthChar The first character of the current month 
     * @param string $currYear The last two digits of the current year
     * @return string a Bootstrap Card containing a submission receipt for the Experience Survey
     */
    function generateReceipt($backgroundColor, $randomDigits, $currMonthNum, $currMonthChar, $currYear) {
        return "<div class='card text-center p-5 bg-{$backgroundColor}'>
                    <div class='p-4'>
                        <h5>
                            Submitted on {$currMonthNum}/{$currYear}
                        </h5>
                        <h1>
                            " . generateConfirmationCode($currMonthChar, $randomDigits, $currYear) . "
                        </h1>
                    </div>
                    <div>
                        <p class='py-2'>
                            Screenshot this page as a receipt for your instructor
                        </p>
                    </div>
                </div>";
    }

    /**
     * Generates and returns a code generated using the given month, array of four random digits, and year
     * @param string $currMonthChar The first character of the current month 
     * @param array $randomDigits An array containing four random digits (0 - 9)
     * @param string $currYear The last two digits of the current year
     * @return string the generated submission confirmation code
     */
    function generateConfirmationCode($currMonthChar, $randomDigits, $currYear) {
        // combine all given digits together to form a four digit number
        $randomDigitsCombined = "{$randomDigits[0]}{$randomDigits[1]}{$randomDigits[2]}{$randomDigits[3]}";

        // generate and return code (first letter of month, four random digits, last two digits of year)
        return "{$currMonthChar}{$randomDigitsCombined}{$currYear}";
    }

    /**
     * Calculates and returns a background color based on the given month
     * @param string $currMonthNum A numeric representation of the current month
     * @return string the name of the calculated color
     */
    function calculateBackgroundColor($currMonthNum) {
        // if Jan, Feb, or Mar
        if ($currMonthNum >= 1 && $currMonthNum <= 3) {
            // background color will be blue
            return "blue";
        }

        // if Apr, May, June
        elseif ($currMonthNum >= 4 && $currMonthNum <= 6 ) {
            // background color will be green
            return "green";
        }

        // if July, Aug, Sep
        elseif ($currMonthNum >= 7 && $currMonthNum <= 9 ) {
            // background color will be red
            return "red";
        }

        // if Oct, Nov, Dec
        elseif ($currMonthNum >= 10 && $currMonthNum <= 12) {
            // background color will be orange
            return "orange";
        }

        // if none of the above, an incorrect month was given
        else {
            return "none";
        }
    }
?>