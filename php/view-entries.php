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
			echo "<table class='table'>
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
							<td>${siteAttended}</td>
							<td>${enjoySite}</td>
							<td>${staffSupportive}</td>
							<td>${siteLearningObjectives}</td>
							<td>${preceptorLearningObjective}</td>
							<td>${recommendSite}</td>
							<td>${siteOrStaffFeedback}</td>
							<td>${instructorFeedback}</td>
						</tr>
					</tbody>
				</table>";
		}
	?>
</body>
</html>