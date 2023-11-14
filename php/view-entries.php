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
		<div class="row">
			<?php
				// get all experience form submissions from DB, ordered by clinical site
				$allSubmissions = executeQuery("SELECT * 
												FROM ExperienceFormSubmissions 
												ORDER BY SiteAttended");

				// run through all returned submissions

				$nameScore = array(0, 0, 0, 0, 0);
				$nameToCheck = "";
				$siteCounter = 0;
				$count = 0;
				while ($currSubmission = mysqli_fetch_assoc($allSubmissions)) {
					// get all relevant columns of current row
					$siteAttended = $currSubmission["SiteAttended"];
					$siteOrStaffFeedback = $currSubmission["SiteOrStaffFeedback"];
					$instructorFeedback = $currSubmission["InstructorFeedback"];

					if($siteCounter == 0) {
						$nameToCheck = $siteAttended;
						echo "<div class='card'><h1 class='text-center'>{$siteAttended}</h1></div>";
					}

					// if the site is the same as the previous site
					if($nameToCheck == $siteAttended) {
						// increase counters
						$nameScore[0] +=  $currSubmission["EnjoyedSite"];
						$nameScore[1] +=  $currSubmission["StaffSupportive"];
						$nameScore[2] +=  $currSubmission["SiteLearningObjectives"];
						$nameScore[3] +=  $currSubmission["PreceptorLearningObjectives"];
						$nameScore[4] +=  $currSubmission["RecommendSite"];
						$count++;
					}

					// if the site of the current row is a different site
					elseif($nameToCheck != $siteAttended) {
						// calculate and display averages
						echo calculateAndGenerateSiteAverages($nameScore, $count, $nameToCheck);;

						// track the new site
						$nameToCheck = $siteAttended;

						// reset the counters to that of the new site
						$nameScore[0] =  $currSubmission["EnjoyedSite"];
						$nameScore[1] =  $currSubmission["StaffSupportive"];
						$nameScore[2] =  $currSubmission["SiteLearningObjectives"];
						$nameScore[3] =  $currSubmission["PreceptorLearningObjectives"];
						$nameScore[4] =  $currSubmission["RecommendSite"];
						$count = 1;

						// display new site header
						echo "<div class='card'><h1 class='text-center'>{$siteAttended}</h1></div>";
					}

					// display the current submission in a table format
					$table = "<div class='card mb-3'>
								<table class='table'>
								<thead>
									<tr class='text-center'>
										<th>Enjoyed Site</th>
										<th>Staff Supportive</th>
										<th>Site Learning Objectives</th>
										<th>Preceptor Learning Objectives</th>
										<th>Recommend Site</th>
										<th>Feedback</th>
									</tr>
								</thead>
								<tbody>
									<tr class='text-center'>
										<td>" . generateStars($currSubmission["EnjoyedSite"]) . "</td>
										<td>" . generateStars($currSubmission["StaffSupportive"]) . "</td>
										<td>" . generateStars($currSubmission["SiteLearningObjectives"]) . "</td>
										<td>" . generateStars($currSubmission["PreceptorLearningObjectives"]) . "</td>
										<td>" . generateStars($currSubmission["RecommendSite"]) . "</td>
										<td>";

							// if feedback was given
							if(!empty($siteOrStaffFeedback) || !empty($instructorFeedback)) {
								// display the feedback button and modal in <td>
								$table .= "<button type='button' class='btn btn-primary' data-bs-toggle='modal' data-bs-target='#feedback-modal-{$siteCounter}'>
												Feedback
											</button>";

								$table .= generateFeedbackModal($siteCounter, $siteOrStaffFeedback, $instructorFeedback);
							}

							// otherwise, display empty
							else {
								$table .= "N/A";
							}

							$table .= 	"</td>
									</tr>
								</tbody>
							</table>
							</div>";

					echo $table;

					$siteCounter++;
				}

				// Display the average for the last group of submissions
                echo calculateAndGenerateSiteAverages($nameScore, $count, $nameToCheck);
			?>
		</div>
	</main>
</body>
</html>

<?php 
	/**
	 * @param int $siteCounter 
	 * @param string $siteOrStaffFeedback
	 * @param string $instructorFeedback
	 * @return string
	 */
	function generateFeedbackModal($siteCounter, $siteOrStaffFeedback, $instructorFeedback) {
		// setup feedback modal
		$feedbackModal = "<div class='modal fade text-start' id='feedback-modal-{$siteCounter}' tabindex='-1' aria-labelledby='feedback-modal-label-{$siteCounter}' aria-hidden='true'>
		<div class='modal-dialog modal-dialog-centered modal-dialog-scrollable'>
		  <div class='modal-content'>
			<div class='modal-header'>
			  <h1 class='modal-title fs-5' id='feedback-modal-label-{$siteCounter}'>Feedback</h1>
			  <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
			</div>
			<div class='modal-body'>";

			// only display feedback if given
			if(!empty($siteOrStaffFeedback)) {
				$feedbackModal .= "<h6><strong>Site or Staff Feedback:</strong></h6>
									<p>{$siteOrStaffFeedback}</p>";
			}
			if(!empty($instructorFeedback)) {
				$feedbackModal .= "<h6><strong>InstructorFeedback:</strong></h6>
									<p>{$instructorFeedback}</>";
			}

		// close off and return modal
		return $feedbackModal . "</div></div></div></div>";
	}

	/**
	 * @param array $nameScore
	 * @param int $count
	 * @param string $nameToCheck
	 * @return string
	 */
	function calculateAndGenerateSiteAverages($nameScore, $count, $nameToCheck) {
		// calculate averages
		$enjoySiteAverage = round($nameScore[0] / $count);
		$staffSupportiveAverage = round($nameScore[1] / $count);
		$siteLearningAverage = round($nameScore[2] / $count);
		$preceptorLearningObjectiveAverage = round($nameScore[3] / $count);
		$recommendSiteAverage = round($nameScore[4] / $count);

		// generate and return averages
		return "<div class='card mb-3'>
						<h1 class='text-center'>Average for {$nameToCheck}</h1>
						<table class='table'>
							<thead>
								<tr class='text-center'>
									<th>Enjoyed Site</th>
									<th>Staff Supportive</th>
									<th>Site Learning Objectives</th>
									<th>Preceptor Learning Objectives</th>
									<th>Recommend Site</th>
								</tr>
							</thead>
							<tbody>
								<tr class='text-center'>
									<td>" . generateStars($enjoySiteAverage) . "</td>
									<td>" . generateStars($staffSupportiveAverage) . "</td>
									<td>" . generateStars($siteLearningAverage) . "</td>
									<td>" . generateStars($preceptorLearningObjectiveAverage) . "</td>
									<td>" . generateStars($recommendSiteAverage) . "</td>
								</tr>
							</tbody>
						</table>
						</div>";
	}
?>