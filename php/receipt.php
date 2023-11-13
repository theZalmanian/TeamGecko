<?php
    // get access to all helper methods
    require_once("../php/helpers.php");

    // save the current pages name to session
    setCurrentPage("Submission Receipt");

    // get current month and year data
    $currMonthNum = date("m");
    $currMonthChar = date("M");
    $currYear = date("y");
    
    // generate four random digits 0 - 9
    $firstDigit = rand(0, 9);
    $secondDigit = rand(0, 9);
    $thirdDigit = rand(0, 9);
    $fourthDigit = rand(0, 9);

  // setup variables to hold Experience Survey form inputs
    $siteAttended = $_POST["q1-site-attended"];
    $enjoyedSite = $_POST["q2-enjoyed-site"];
    $staffSupportive = $_POST["q3-staff-supportive"];
    $siteLearningObjectives = $_POST["q4-site-learning-objectives"];
    $preceptorLearningObjectives = $_POST["q5-preceptor-learning-objectives"];
    $recommendSite = $_POST["q6-recommend-site"];
    $siteOrStaffFeedback = $_POST["q7-site-or-staff-feedback"];
    $instructorFeedback = $_POST["q8-instructor-feedback"];


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
    <?php 
        // include standard nursing header metadata
        require "../php/layouts/nursing-metadata.php";
    ?>
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
        // Levi's changes
            if( isset($siteAttended)
            && isset($enjoyedSite)
            && isset($staffSupportive)
            && isset($siteLearningObjectives)
            && isset($preceptorLearningObjectives)
            && isset($recommendSite)
            && isset($siteOrStaffFeedback)
            && isset($instructorFeedback)) {
            executeQuery("INSERT INTO ExperienceFormSubmissions (SiteAttended, EnjoyedSite, StaffSupportive, SiteLearningObjectives, PreceptorLearningObjectives, RecommendSite, SiteOrStaffFeedback, InstructorFeedback) 
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
                        echo displayMessageWithLink("/sprint-3/experience.php", "Experience Survey",
                                                    "ERROR: No submission received from Experience Survey",
                                                    "Please fill out the survey and try again");
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