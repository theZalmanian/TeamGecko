<?php 
    // get access to all helper methods
    require_once("../php/helpers.php");

    // save the current pages name to session
    setCurrentPage("View Entries");
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
			// get all experience form submissions from DB 
			$allSubmissions = executeQuery("SELECT * FROM ExperienceFormSubmissions");

			// run through all returned submissions
			while ($row = mysqli_fetch_assoc($allSubmissions)) {
				// get all relevant columns of current row
				$siteAttended = $row["SiteAttended"];
				$enjoySite = $row["EnjoyedSite"];
				$staffSupportive = $row["StaffSupportive"];
				$siteLearningObjectives = $row["SiteLearningObjectives"];
				$preceptorLearningObjective = $row["PreceptorLearningObjectives"];
				$recommendSite = $row["RecommendSite"];
				$siteOrStaffFeedback = $row["SiteOrStaffFeedback"];
				$instructorFeedback = $row["InstructorFeedback"];

				// display the current student's data
				echo "<div class='text-center col-12 col-md-5 mt-3'>
						<ul class='list-group text-start'> 
							<li class='list-group-item'>Site Attended: ${siteAttended}</li>
							<li class='list-group-item'>Enjoy site: ${enjoySite}</li>
							<li class='list-group-item'>Staff Supportive: ${staffSupportive}</li>
							<li class='list-group-item'>Site learning objective: ${siteLearningObjectives}</li>
							<li class='list-group-item'>Preceptor Learning Objective : ${preceptorLearningObjective}</li>
							<li class='list-group-item'>Recommend Site : ${recommendSite}</li>
							<li class='list-group-item'>Site or Staff Feedback: ${siteOrStaffFeedback}</li>
							<li class='list-group-item'>Instructor Feedback: ${instructorFeedback}</li>
						</ul>
					</div>";
			}
        ?>
    </div>
</div>
</body>
</html>