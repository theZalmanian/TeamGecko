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
        require_once("../php/layouts/nursing-metadata.php");
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

				$ratingsTracker = array(0, 0, 0, 0, 0);
				$nameToCheck = "";
				$clinicalSiteCount = 0;
				$rowCount = 0;

				$rowsInSite = array(); 

				// run through all returned submissions
				while ($currSubmission = mysqli_fetch_assoc($allSubmissions)) {
					// get all relevant columns of current row
					$siteAttended = $currSubmission["SiteAttended"];
					$enjoyedSite = $currSubmission["EnjoyedSite"];
					$staffSupportive = $currSubmission["StaffSupportive"];
					$siteLearningObjectives = $currSubmission["SiteLearningObjectives"];
					$preceptorLearningObjectives = $currSubmission["PreceptorLearningObjectives"];
					$recommendSite = $currSubmission["RecommendSite"];
					$siteOrStaffFeedback = $currSubmission["SiteOrStaffFeedback"];
					$instructorFeedback = $currSubmission["InstructorFeedback"];

					if($clinicalSiteCount == 0) {
						$nameToCheck = $siteAttended;
					}

					// if the site is the same as the previous site
					if($nameToCheck == $siteAttended) {
						// increase counters
						$ratingsTracker[0] +=  $enjoyedSite;
						$ratingsTracker[1] +=  $staffSupportive;
						$ratingsTracker[2] +=  $siteLearningObjectives;
						$ratingsTracker[3] +=  $preceptorLearningObjectives;
						$ratingsTracker[4] +=  $recommendSite;
						$rowCount++;

						// generate and add row to array keeping track of all rows for this clinical site
						$rowsInSite[] = generateRow($currSubmission);
					}

					// if the site of the current row is a different site
					elseif($nameToCheck != $siteAttended) {
						// add all rows belonging to the previous clinical site to table
						$allRowsForTable = "";
						for ($i = 0; $i < count($rowsInSite); $i++) { 
							$allRowsForTable .= $rowsInSite[$i];
						}

						// display the table 
						echo generateTable($allRowsForTable, $nameToCheck, $ratingsTracker, $rowCount);

						// track the new site
						$nameToCheck = $siteAttended;

						// reset the counters to that of the new site
						$ratingsTracker[0] =  $enjoyedSite;
						$ratingsTracker[1] =  $staffSupportive;
						$ratingsTracker[2] =  $siteLearningObjectives;
						$ratingsTracker[3] =  $preceptorLearningObjectives;
						$ratingsTracker[4] =  $recommendSite;
						$rowCount = 1;

						// empty the rows array
						$rowsInSite = array(); 

						// generate and add row to array keeping track of all rows for this clinical site
						$rowsInSite[] = generateRow($currSubmission);
					}

					$clinicalSiteCount++;
				}

				// display the last table of submissions
				$allRowsForTable = "";
				for ($i = 0; $i < count($rowsInSite); $i++) { 
					$allRowsForTable .= $rowsInSite[$i];
				}

				echo generateTable($allRowsForTable, $siteAttended, $ratingsTracker, $rowCount);
			?>
		</div>
	</main>
</body>
</html>

<?php
	/**
	 * 
	 * @param array $rowData
	 * @return string
	 */
	function generateRow($rowData) {
		// setup array to hold all <td>'s generated for the <tr> being returned using the given data
		$formattedData = array(
			generateStars($rowData["EnjoyedSite"]),
			generateStars($rowData["StaffSupportive"]),
			generateStars($rowData["SiteLearningObjectives"]),
			generateStars($rowData["PreceptorLearningObjectives"]),
			generateStars($rowData["RecommendSite"]),
			displayFeedback($rowData["SiteOrStaffFeedback"], $rowData["InstructorFeedback"])
		);

		// generate <td>'s for the current <tr> using the formatted data generated using the submission data
		$rowContent = "";
		for( $i = 0; $i < count($formattedData); $i++ ) {
			$rowContent .= "<td>{$formattedData[$i]}</td>";
		}

		// return row content wrapped in a <tr>
		return "<tr class='text-center'>" . $rowContent . "</tr>";
	}

	/**
	 * 
	 * @param int $siteCounter
	 * @param string $siteOrStaffFeedback
	 * @param string $instructorFeedback
	 * @return string
	 */
	function displayFeedback($siteOrStaffFeedback, $instructorFeedback) {
		global $clinicalSiteCount;

		// if feedback was given
		if(!empty($siteOrStaffFeedback) || !empty($instructorFeedback)) {
			// generate feedback modal
			$feedbackModal = generateFeedbackModal($siteOrStaffFeedback, $instructorFeedback);

			// add the feedback button and modal to display
			return "<button type='button' class='btn btn-success border' data-bs-toggle='modal' 
						data-bs-target='#feedback-modal-{$clinicalSiteCount}'>
						View
					</button>
					{$feedbackModal}";
		}

		// otherwise, display as empty
		else {
			return "N/A";
		}
	}

	/**
	 * 
	 * @param string $siteOrStaffFeedback
	 * @param string $instructorFeedback
	 * @return string
	 */
	function generateFeedbackModal($siteOrStaffFeedback, $instructorFeedback) {
		global $clinicalSiteCount;

		// setup feedback modal
		$feedbackModal = "<div class='modal fade text-start' id='feedback-modal-{$clinicalSiteCount}' tabindex='-1' aria-labelledby='feedback-modal-label-{$clinicalSiteCount}' aria-hidden='true'>
							<div class='modal-dialog modal-dialog-centered modal-dialog-scrollable'>
								<div class='modal-content'>
									<div class='modal-header'>
										<h1 class='modal-title fs-5' id='feedback-modal-label-{$clinicalSiteCount}'>
											<strong>Feedback</strong>
										</h1>
										<button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'>
										</button>
									</div>
									<div class='modal-body'>";

		// only display feedback if given
		if(!empty($siteOrStaffFeedback)) {
			$feedbackModal .= "<h6><strong>Site or Staff Feedback:</strong></h6>
								<p>{$siteOrStaffFeedback}</p>";
		}
		if(!empty($instructorFeedback)) {
			$feedbackModal .= "<h6><strong>Instructor Feedback:</strong></h6>
								<p>{$instructorFeedback}</p>";
		}

		// close off and return modal
		return $feedbackModal . "</div></div></div></div>";
	}

	/**
	 * 
	 * @param string $rowContent
	 * @param string $clinicalSiteName
	 * @param array $ratingsTracker
	 * @param int $rowCount
	 * @return string
	 */
	function generateTable($rowContent, $clinicalSiteName, $ratingsTracker, $rowCount) {
		// generate clinical site averages using given data
		$averageRatings = generateSiteAverages($ratingsTracker, $rowCount);

		// generate and return table using given data
		return "<div class='card mb-3 p-3 table-responsive'>
					<h1 class='text-center mb-3'>
						<strong>{$clinicalSiteName}</strong>
					</h1>
					<table class='table table-bordered table-striped-columns align-middle m-0'>
						<thead>
							<tr class='text-center'>
								<th>Enjoyed Site</th>
								<th>Staff Supportive</th>
								<th>Site Learning <br> Objectives</th>
								<th>Preceptor Learning <br> Objectives</th>
								<th>Recommend Site</th>
								<th>Feedback</th>
							</tr>
						</thead>
						<tbody>
							{$rowContent}
						</tbody>
					</table>
					{$averageRatings}
				</div>";
	}

	/**
	 * 
	 * @param array $ratingsTracker
	 * @param int $rowCount
	 * @return string
	 */
	function generateSiteAverages($ratingsTracker, $rowCount) {
		$formattedAverages = array(
			generateStars( round($ratingsTracker[0] / $rowCount) ),
			generateStars( round($ratingsTracker[1] / $rowCount) ),
			generateStars( round($ratingsTracker[2] / $rowCount) ),
			generateStars( round($ratingsTracker[3] / $rowCount) ),
			generateStars( round($ratingsTracker[4] / $rowCount) ),
		);

		$averagesContent = "";
		for($i = 0; $i < count($formattedAverages); $i++) {
			$averagesContent .= "<td>{$formattedAverages[$i]}</td>";
		}

		return "<div>
					<h1 class='text-center my-3'>
						<strong>Average Ratings</strong>
					</h1>
					<table class='table table-bordered table-striped-columns align-middle m-0'>
						<thead>
							<tr class='text-center'>
								<th>Enjoyed Site</th>
								<th>Staff Supportive</th>
								<th>Site Learning <br> Objectives</th>
								<th>Preceptor Learning <br> Objectives</th>
								<th>Recommend Site</th>
							</tr>
						</thead>
						<tbody>
							<tr class='text-center'>
								{$averagesContent}
							</tr>
						</tbody>
					</table>
				</div>";
	}
?>