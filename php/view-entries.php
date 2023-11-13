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
	<main class="container">
		<div class="row">
			<?php
				// get all experience form submissions from DB, ordered by clinical site
				$allSubmissions = executeQuery("SELECT * 
												FROM ExperienceFormSubmissions 
												ORDER BY SiteAttended");

				// run through all returned submissions
				while ($currSubmission = mysqli_fetch_assoc($allSubmissions)) {
					// get all relevant columns of current row
					$siteAttended = $currSubmission["SiteAttended"];
					$siteOrStaffFeedback = $currSubmission["SiteOrStaffFeedback"];
					$instructorFeedback = $currSubmission["InstructorFeedback"];

					// display the current submission in a table format
					$table = "<div class='col-12 col-md-4'>
								<table class='table'>
									<tbody>
										<tr>
											<th>Site Attended</th>
											<td>${siteAttended}</td>
										</tr>
										<tr>
											<th>Enjoyed Site</th>
											<td>" . generateStars($currSubmission["EnjoyedSite"]) . "</td>
										</tr>
										<tr>
											<th>Staff Supportive</th>
											<td>" . generateStars($currSubmission["StaffSupportive"]) . "</td>
										</tr>
										<tr>
											<th>Site Learning Objectives</th>
											<td>" . generateStars($currSubmission["SiteLearningObjectives"]) . "</td>
										</tr>
										<tr>
											<th>Preceptor Learning Objectives</th>
											<td>" . generateStars($currSubmission["PreceptorLearningObjectives"]) . "</td>
										</tr>
										<tr>
											<th>Recommend Site</th>
											<td>" . generateStars($currSubmission["RecommendSite"]) . "</td>
										</tr>
										<tr>
											<th>Site or Staff Feedback</th>
											<td>" . generateStars($siteOrStaffFeedback) . "</td>
										</tr>
										<tr>
											<th>Instructor Feedback</th>
											<td>" . generateStars($instructorFeedback) . "</td>
										</tr>
									</tbody>
								</table>
							</div>";

					echo $table;
				}
			?>
		</div>
	</main>
</body>
</html>