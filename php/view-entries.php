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
	<main class="container mt-3">
		<div class="row row-cols-1 row-cols-md-2 g-4">
			<?php
				// get all experience form submissions from DB, ordered by clinical site
				$allSubmissions = executeQuery("SELECT * 
												FROM ExperienceFormSubmissions 
												ORDER BY SiteAttended");

				// run through all returned submissions

				$nameScore = array();
				while ($currSubmission = mysqli_fetch_assoc($allSubmissions)) {
					// get all relevant columns of current row
					$siteAttended = $currSubmission["SiteAttended"];
					$siteOrStaffFeedback = $currSubmission["SiteOrStaffFeedback"];
					$instructorFeedback = $currSubmission["InstructorFeedback"];

					$siteCounter = 0;
					$nameToCheck = "SiteAttended";

					$nameScore[$siteAttended]["enjoy site"] +=  $currSubmission["EnjoyedSite"];
					$nameScore[$siteAttended]["staff supporting"] +=  $currSubmission["StaffSupportive"];
					$nameScore[$siteAttended]["Site Learning Obs"] +=  $currSubmission["SiteLearningObjectives"];
					$nameScore[$siteAttended]["Preceptor Learning Obs"] +=  $currSubmission["PreceptorLearningObjectives"];
					$nameScore[$siteAttended]["Recommend Site"] +=  $currSubmission["RecommendSite"];
					$nameScore[$siteAttended]['count']++;
					// display the current submission in a table format
					$table = "<div class='col-12 col-md-3'>
								<div class='card'>
									<table class='table m-0'>
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
								</div>
							</div>";

					echo $table;
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
													Enjoyed Site: " . generateStars($enjoySiteAverage) . "
												</li>
												<li>
													Staff Supporting: " . generateStars($staffSupportiveAverage) . "
												</li>
												<li>
													Site Learning Obs: " . generateStars($siteLearningAverage) . "
												</li>
												<li>
												 	Preceptor Learning Obs: " . generateStars($preceptorLearningObjectiveAverage) . "
												</li>
												<li>
													Recommend Site: " . generateStars($recommendSiteAverage) . "
												</li>
											</ul>
									 </div>";
					echo $averageHtml;
				}
			?>
		</div>
	</main>
</body>
</html>