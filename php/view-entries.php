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

				$scoreCounters = array(0, 0, 0, 0, 0);
				$nameToCheck = "";
				$siteCounter = 0;
				$count = 0;

				$rowsInSite = array(); 

				// run through all returned submissions
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
						$scoreCounters[0] +=  $currSubmission["EnjoyedSite"];
						$scoreCounters[1] +=  $currSubmission["StaffSupportive"];
						$scoreCounters[2] +=  $currSubmission["SiteLearningObjectives"];
						$scoreCounters[3] +=  $currSubmission["PreceptorLearningObjectives"];
						$scoreCounters[4] +=  $currSubmission["RecommendSite"];
						$count++;

						// generate and add row to array keeping track of all rows for this clinical site
						$rowsInSite[] = generateRow($currSubmission, $siteCounter, $siteOrStaffFeedback, $instructorFeedback);
					}

					// if the site of the current row is a different site
					elseif($nameToCheck != $siteAttended) {
						// add all rows belonging to the previous clinical site to table
						$allRowsForTable = "";
						for ($i = 0; $i < count($rowsInSite); $i++) { 
							$allRowsForTable .= $rowsInSite[$i];
						}

						// display the table 
						echo generateTable($allRowsForTable);

						// calculate and display averages
						echo calculateAndGenerateSiteAverages($scoreCounters, $count, $nameToCheck);

						// track the new site
						$nameToCheck = $siteAttended;

						// reset the counters to that of the new site
						$scoreCounters[0] =  $currSubmission["EnjoyedSite"];
						$scoreCounters[1] =  $currSubmission["StaffSupportive"];
						$scoreCounters[2] =  $currSubmission["SiteLearningObjectives"];
						$scoreCounters[3] =  $currSubmission["PreceptorLearningObjectives"];
						$scoreCounters[4] =  $currSubmission["RecommendSite"];
						$count = 1;

						// empty the rows array
						$rowsInSite = array(); 

						// generate and add row to array keeping track of all rows for this clinical site
						$rowsInSite[] = generateRow($currSubmission, $siteCounter, $siteOrStaffFeedback, $instructorFeedback);

						// display clinical site name in header
						echo "<div class='card'><h1 class='text-center'>{$siteAttended}</h1></div>";
					}

					$siteCounter++;
				}

				// display the last table of submissions
				$allRowsForTable = "";
				for ($i = 0; $i < count($rowsInSite); $i++) { 
					$allRowsForTable .= $rowsInSite[$i];
				}

				// display the table 
				echo generateTable($allRowsForTable);


				// display the average for the last group of submissions
                echo calculateAndGenerateSiteAverages($scoreCounters, $count, $nameToCheck);
			?>
		</div>
	</main>
</body>
</html>

<?php
	/**
	 * @param mixed $currSubmission
	 * @param int $siteCounter
	 * @param string $siteOrStaffFeedback
	 * @param string $instructorFeedback
	 * @return string
	 */
	function generateRow($currSubmission, $siteCounter, $siteOrStaffFeedback, $instructorFeedback) {
		// generate the current row
		$row = "<tr class='text-center'>
		<td>" . generateStars($currSubmission["EnjoyedSite"]) . "</td>
		<td>" . generateStars($currSubmission["StaffSupportive"]) . "</td>
		<td>" . generateStars($currSubmission["SiteLearningObjectives"]) . "</td>
		<td>" . generateStars($currSubmission["PreceptorLearningObjectives"]) . "</td>
		<td>" . generateStars($currSubmission["RecommendSite"]) . "</td>";

		// display feedback, if any, and close off <tr>
		return $row . displayFeedback($siteCounter, $siteOrStaffFeedback, $instructorFeedback) . "</tr>";
	}

	/**
	 * 
	 * @param int $siteCounter
	 * @param string $siteOrStaffFeedback
	 * @param string $instructorFeedback
	 * @return string
	 */
	function displayFeedback($siteCounter, $siteOrStaffFeedback, $instructorFeedback) {
		$feedbackDisplay = "";

		// if feedback was given
		if(!empty($siteOrStaffFeedback) || !empty($instructorFeedback)) {
			// display the feedback button and modal in a <td>
			$feedbackDisplay .= "<td><button type='button' class='btn btn-primary' data-bs-toggle='modal' data-bs-target='#feedback-modal-{$siteCounter}'>
									Feedback
								</button>";

			$feedbackDisplay .= generateFeedbackModal($siteCounter, $siteOrStaffFeedback, $instructorFeedback) . "</td>";
		}

		// otherwise, display an empty <td>
		else {
			$feedbackDisplay = "<td>N/A</td>";
		}

		return $feedbackDisplay;
	}

	/**
	 * 
	 * @param string $row
	 * @return string
	 */
	function generateTable($row) {
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
					<tbody>";

		$table .= $row;

		$table .= 	"</tbody>
				</table>
				</div>";

		return $table;
	}

	/**
	 * 
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
				$feedbackModal .= "<h6><strong>Instructor Feedback:</strong></h6>
									<p>{$instructorFeedback}</>";
			}

		// close off and return modal
		return $feedbackModal . "</div></div></div></div>";
	}

	/**
	 * 
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