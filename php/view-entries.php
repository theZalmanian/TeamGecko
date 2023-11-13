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
	<?php
	
		// get all experience form submissions from DB, ordered by clinical site
		$allSubmissions = executeQuery("SELECT * 
										FROM ExperienceFormSubmissions 
										ORDER BY SiteAttended");

		// run through all returned submissions
		while ($currSubmission = mysqli_fetch_assoc($allSubmissions)) {
			// get all relevant columns of current row
			$siteAttended = $currSubmission["SiteAttended"];
			$starQuestions = array(
				$currSubmission["EnjoyedSite"],
				$currSubmission["StaffSupportive"],
				$currSubmission["SiteLearningObjectives"],
				$currSubmission["PreceptorLearningObjectives"],
				$currSubmission["RecommendSite"]
			);
			$siteOrStaffFeedback = $currSubmission["SiteOrStaffFeedback"];
			$instructorFeedback = $currSubmission["InstructorFeedback"];

			// display the current submission in a table format
			$table = "<table class='table'>
					<thead>
						<tr>
							<th>Site Attended</th>
							<th>Enjoyed Site</th>
							<th>Staff Supportive</th>
							<th>Site Learning Objective</th>
							<th>Preceptor Learning Objective</th>
							<th>Recommend Site</th>
							<th>Site or Staff Feedback</th>
							<th>Instructor Feedback</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>${siteAttended}</td>";

							for($i = 0; $i < count($starQuestions); $i++) {
								$table .= "<td>" . generateStars($starQuestions[$i]) . "</td>";
							}
							
				$table .= "<td>" . generateStars($siteOrStaffFeedback) . "</td>
							<td>" . generateStars($instructorFeedback) . "</td>
						</tr>
					</tbody>
				</table>";

			echo $table;
		}
	?>
</body>
</html>