
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Summary</title>
    <link rel="icon" type="image/x-icon" href="/gecko-images/geckos-logo.svg">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="/css/practice.css">
</head>
<body>
<div class="container">
    <div class="row">
        <div class='text-center col-12 col-md-5 mt-3'>
            <ul class='list-group text-start'>
            <?php
                    require '/home/geckosgr/db-connect-nursing.php';

                    $sqlCode = "SELECT * FROM ExperienceFormSubmissions; ";
                    $displayResult = mysqli_query($dbConnection, $sqlCode);
                    $nameScore = array();
                while ($row = mysqli_fetch_assoc($displayResult)) {
                        // get data in each column
                        //this is the A.I. ID number
                        $submissionID = $row["SubmissionID"];
                //       question 1
                        $siteAttended = $row["SiteAttended"];
                //        question 2
                        $enjoySite = $row["EnjoyedSite"];
                //        question 3
                        $staffSupportive = $row["StaffSupportive"];
                //        question 4
                        $siteLearningObjectives = $row["SiteLearningObjectives"];
                //        question 5
                        $preceptorLearningObjective = $row["PreceptorLearningObjectives"];
                //        question 6
                        $recommendSite = $row["RecommendSite"];
                //        question 7
                        $siteOrStaffFeedback = $row["SiteOrStaffFeedback"];
                //        question 8
                        $instructorFeedback = $row["InstructorFeedback"];
                        $siteCounter = 0;
                        $nameToCheck = "SiteAttended";

                        $nameScore[$siteAttended]["enjoy site"] +=  $enjoySite;
                        $nameScore[$siteAttended]["staff supporting"] +=  $staffSupportive;
                        $nameScore[$siteAttended]["Site Learning Obs"] +=  $staffSupportive;
                        $nameScore[$siteAttended]["Preceptor Learning Obs"] +=  $staffSupportive;
                        $nameScore[$siteAttended]["Recommend Site"] +=  $staffSupportive;
                        $nameScore[$siteAttended]['count']++;
                        $htmlList = "<div class='text-center col-12 col-md-5 mt-3'>
                                        <ul class='list-group text-start'> 
                                             <li class='list-group-item'>Submission ID: ${submissionID}</li>
                                             <li class='list-group-item'>Site Attended: ${siteAttended}</li>
                                             <li class='list-group-item'>Enjoy site: ${enjoySite}</li>
                                             <li class='list-group-item'>Staff Supportive: ${staffSupportive}</li>
                                             <li class='list-group-item'>Site learning objective: ${siteLearningObjectives}</li>
                                             <li class='list-group-item'>Preceptor Learning Objective : ${preceptorLearningObjective}</li>
                                             <li class='list-group-item'>Recommend Site : ${recommendSite}</li>
                                             <li class='list-group-item'>Site or Staff Feedback: ${siteOrStaffFeedback}</li>
                                             <li class='list-group-item'>Instructor Feedback: ${instructorFeedback}</li>
                                        </ul>
                                      </div> ";
                        echo $htmlList;
                        // display the current student's data
                    }
                    foreach($nameScore as $siteAttended => $data){
                        $enjoySiteAverage = round($data["enjoy site"] / $data["count"]);
                        $staffSupportiveAverage = round($data["staff supporting"] / $data["count"]);
                        $siteLearningAverage = round($data["Site Learning Obs"] / $data["count"]);
                        $preceptorLearningObjectiveAverage = round($data["Preceptor Learning Obs"] / $data["count"]);
                        $recommendSiteAverage = round($data["Recommend Site"] / $data["count"]);
                        $averageHtml = "<div>
                                            <h1>Average for ${siteAttended}</h1>
                                                <ul>
                                                    <li>
                                                        Enjoy Site: ${enjoySiteAverage}
                                                    </li>
                                                    <li>
                                                        Staff Support: ${staffSupportiveAverage}
                                                    </li>
                                                    <li>
                                                        Site learning Objectives: ${siteLearningAverage}
                                                    </li>
                                                    <li>
                                                        Preceptor Learning Objectives: ${preceptorLearningObjectiveAverage}
                                                    </li>
                                                    <li>
                                                        Recommend Site: ${recommendSiteAverage}
                                                    </li>
                                                </ul>
                                         </div>";
                        echo $averageHtml;
                    }


                ?>
    </div>
</div>

</body>
</html>
