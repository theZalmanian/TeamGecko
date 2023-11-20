<?php 
    // get access to all PHP helpers
    require_once("/home/geckosgr/public_html/initial.php");

    // store the current page's title for dynamic HTML generation
    $currPageTitle = "View Entries";

	/**
	 * The name of the current clinical site
	 */
	$currClinicalSite = "";
	
	/**
	 * The number of submissions processed from DB belonging to the current clinical site
	 */
	$currSubmissionCount = 0;

	/**
	 * The total number of submissions processed from DB
	 */
	$totalSubmissionCount = 0;

	/**
	 * An array containing the total ratings for each aspect of the current clinical site:
	 * [Enjoyed Site, Staff Supportive, Site Learning Objectives, Preceptor Learning Objectives, Recommend Site]
	 */
	$ratingTotals = array(0, 0, 0, 0, 0);

	/**
	 * An array containing formatted submission rows belonging to the current clinical site
	 */
	$formattedSubmissionRows = array(); 
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<?php 
        // include standard nursing header metadata
        require_once(LAYOUTS_PATH . "/nursing-metadata.php");
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
				while ($currSubmission = mysqli_fetch_assoc($allSubmissions)) {
					// get the current submission's corresponding clinical site
					$siteAttended = $currSubmission["SiteAttended"];
					
					/**
					 * All ratings containing within the current submission:
					 * 0 -> Enjoyed Site
					 * 1 -> Staff Supportive
					 * 2 -> Site Learning Objectives
					 * 3 -> Preceptor Learning Objectives
					 * 4 -> Recommend Site
					 */
					$submissionRatings = array(
						$currSubmission["EnjoyedSite"],
						$currSubmission["StaffSupportive"],
						$currSubmission["SiteLearningObjectives"],
						$currSubmission["PreceptorLearningObjectives"],
						$currSubmission["RecommendSite"]
					);

					// if the current row is the first one being received from DB
					if($totalSubmissionCount == 0) {
						$currClinicalSite = $siteAttended;
					}

					// if the current row belongs to a different 
					// clinical site than the one tracked
					if($currClinicalSite != $siteAttended) {
						// display the data for the previous clinical site
						displayClinicalSite($currClinicalSite, $formattedSubmissionRows, $currSubmissionCount);

						// track the new site
						$currClinicalSite = $siteAttended;

						// reset other trackers
						$formattedSubmissionRows = array(); 
						$currSubmissionCount = 1;
						resetRatingTotals();
					}

					// update the rating totals with the current submissions ratings
					updateRatingTotals($submissionRatings);

					// a new submission has been tracked
					$currSubmissionCount++;
					$totalSubmissionCount++;

					// format the data of the current submission row, 
					// and track with other rows belonging to the current clinical site
					$formattedSubmissionRows[] = generateFormattedSubmissionRow($currSubmission);
				}

				// display the data of the last clinical site (fencepost)
				displayClinicalSite($currClinicalSite, $formattedSubmissionRows, $currSubmissionCount);
			?>
		</div>
	</main>
</body>
</html>

<?php
	/**
	 * Displays a Bootstrap card containing the following content, generated using the given data:
	 * A header displaying the site name, a table containing the given submission rows, and a section of average ratings for the current clinical site at the bottom	 * @param string $clinicalSiteName The name of the current clinical site
     * @param array $formattedSubmissionRows An array of formatted submission rows belonging to the current clinical site
 	 * @param int $submissionCount The number of submissions belonging to the current clinical site 
	 */
	function displayClinicalSite($clinicalSiteName, $formattedSubmissionRows, $submissionCount) {
		// add all formatted submission rows together
		$tableContent = implode("", $formattedSubmissionRows);

		// display the current clinical site's data on page
		echo generateClinicalSiteDisplay($tableContent, $clinicalSiteName, $submissionCount);
	}

	/**
	 * Adds the values in the given $ratings array to the corresponding rating total in $ratingTotals
	 * @param array $ratings An array containing the rating columns of the current experience form submission
	 * @global array $ratingTotals An array containing the total ratings for each aspect of the current clinical site:
	 * [Enjoyed Site, Staff Supportive, Site Learning Objectives, Preceptor Learning Objectives, Recommend Site]
	 */
	function updateRatingTotals($ratings) {
		/**
		 * An array containing the total ratings for each aspect of the current clinical site:
	 	 * [Enjoyed Site, Staff Supportive, Site Learning Objectives, Preceptor Learning Objectives, Recommend Site]
		 */
		global $ratingTotals;

		for ($i = 0; $i < count($ratings); $i++) {
			$ratingTotals[$i] += $ratings[$i];
		}
	}

	/**
	 * Sets all values in the $ratingTotals array to 0 in preparation to track the totals of a new submission
	 *
	 * @global array $ratingTotals An array containing the total ratings for each aspect of the current clinical site:
	 * [Enjoyed Site, Staff Supportive, Site Learning Objectives, Preceptor Learning Objectives, Recommend Site]
	 */
	function resetRatingTotals() {
		/**
		 * An array containing the total ratings for each aspect of the current clinical site:
	 	 * [Enjoyed Site, Staff Supportive, Site Learning Objectives, Preceptor Learning Objectives, Recommend Site]
		 */
		global $ratingTotals;

		for ($i = 0; $i < count($ratingTotals); $i++) {
			$ratingTotals[$i] = 0;
		}
	}

	/**
	 * Takes in the given array of data and returns an HTML table row containing the data formatted appropriately
	 * @param array $currSubmission the current experience form submission received from the DB
	 * @return string an HTML table row containing the data formatted appropriately
	 */
	function generateFormattedSubmissionRow($currSubmission) {
		// format and store the given data in array
		$formattedData = array(
			generateStars($currSubmission["EnjoyedSite"]),
			generateStars($currSubmission["StaffSupportive"]),
			generateStars($currSubmission["SiteLearningObjectives"]),
			generateStars($currSubmission["PreceptorLearningObjectives"]),
			generateStars($currSubmission["RecommendSite"]),
			displayFeedback($currSubmission["SiteOrStaffFeedback"], $currSubmission["InstructorFeedback"])
		);

		// wrap each formatted column in a <td>, and add to row
		$row = "";
		for( $i = 0; $i < count($formattedData); $i++ ) {
			$row .= "<td>{$formattedData[$i]}</td>";
		}

		// return all <td>'s wrapped in a <tr>
		return "<tr class='text-center'>" . $row . "</tr>";
	}

	/**
	 * Generates a Bootstrap Modal displaying the given feedback (if any). As both fields are optional, only the sections given (not empty) are displayed. If both fields are given as empty, a simple "N/A" is displayed instead
	 * @param string $siteOrStaffFeedback Feedback regarding the clinical site or the staff working there (Optional)
	 * @param string $instructorFeedback Feedback regarding the students instructor at the clinical site (Optional)
	 * @global int $totalSubmissionCount Used for Modal ID
	 * @return string a Bootstrap modal displaying the given feedback (if any), along with a corresponding toggle button; otherwise "N/A"
	 */
	function displayFeedback($siteOrStaffFeedback, $instructorFeedback) {
		// grab the clinical site count for the modal ID
		global $totalSubmissionCount;

		// if feedback was given
		if(!empty($siteOrStaffFeedback) || !empty($instructorFeedback)) {
			// generate feedback Modal
			$feedbackModal = generateFeedbackModal($siteOrStaffFeedback, $instructorFeedback);

			// return the generated Modal and corresponding toggle button
			return "<button type='button' class='btn btn-success border' data-bs-toggle='modal' 
						data-bs-target='#submission-{$totalSubmissionCount}-feedback-modal'>
						View
					</button>
					{$feedbackModal}";
		}

		// otherwise, display a "no feedback" indicator
		else {
			return "N/A";
		}
	}

	/**
	 * Generates a Bootstrap Modal displaying the given feedback. As both fields are optional, only the sections given (not empty) are displayed
	 * @param string $siteOrStaffFeedback Feedback regarding the clinical site or the staff working there (Optional)
	 * @param string $instructorFeedback Feedback regarding the students instructor at the clinical site (Optional)
	 * @global int $totalSubmissionCount Used for Modal ID
	 * @return string a Bootstrap modal displaying the given feedback
	 */
	function generateFeedbackModal($siteOrStaffFeedback, $instructorFeedback) {
		// grab the clinical site count for the modal ID
		global $totalSubmissionCount;

		// setup feedback Modal
		$feedbackModal = "<div class='modal fade text-start' id='submission-{$totalSubmissionCount}-feedback-modal' tabindex='-1' aria-labelledby='feedback-modal-label-{$totalSubmissionCount}' aria-hidden='true'>
							<div class='modal-dialog modal-dialog-centered modal-dialog-scrollable'>
								<div class='modal-content'>
									<div class='modal-header'>
										<h1 class='modal-title fs-5' id='submission-{$totalSubmissionCount}-feedback-modal'>
											" . displayStrong("Feedback") . "
										</h1>
										<button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'>
										</button>
									</div>
									<div class='modal-body'>";

		// only display feedback if given
		if(!empty($siteOrStaffFeedback)) {
			$feedbackModal .= "<h6>". displayStrong("Site or Staff Feedback") . "</h6>
								<p>{$siteOrStaffFeedback}</p>";
		}

		if(!empty($instructorFeedback)) {
			$feedbackModal .= "<h6>". displayStrong("Instructor Feedback") . "</h6>
								<p>{$instructorFeedback}</p>";
		}

		// close off and return feedback Modal
		return $feedbackModal . "</div></div></div></div>";
	}

	/**
	 * Generates a Bootstrap card containing the following content, generated using the given data:
	 * A header displaying the site name, a table containing the given submission rows, and a section of average ratings for the current clinical site at the bottom
	 * @param string $formattedSubmissionRows The submission rows pulled from the DB belonging to the current clinical site, formatted appropriately within HTML table rows
	 * @param string $clinicalSiteName The name of the current clinical site
	 * @param int $submissionCount The number of submissions belonging to the current clinical site 
	 * @return string
	 */
	function generateClinicalSiteDisplay($formattedSubmissionRows, $clinicalSiteName, $submissionCount) {
		/**
		 * An array containing the total ratings for each aspect of the current clinical site:
	     * [Enjoyed Site, Staff Supportive, Site Learning Objectives, Preceptor Learning Objectives, Recommend Site]
		 */
		global $ratingTotals;

		// generate clinical site averages using given data
		$averageRatings = generateRatingAverages($ratingTotals, $submissionCount);

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
							{$formattedSubmissionRows}
						</tbody>
					</table>
					{$averageRatings}
				</div>";
	}

	/**
	 * Takes the total rating values for each aspect of a clinical site, calculates the average for each rating using the calculateRatingAverages function, and formats the result as follows: 
	 * A heading of "Average Ratings", a table with column headers, and a single row containing the average ratings for each aspect of the clinical site
	 * 
	 * @param int $submissionCount The number of submissions belonging to the current clinical site 
	 * @param array $ratingTotals An array containing the total ratings for each aspect of the current clinical site:
	 * [Enjoyed Site, Staff Supportive, Site Learning Objectives, Preceptor Learning Objectives, Recommend Site]
	 * @return string HTML content representing the average ratings for each aspect of the clinical site
	 */
	function generateRatingAverages($ratingTotals, $submissionCount) {
		// calculate and generate the average for each rating, format as a corresponding string of ★'s
		$formattedAverages = calculateRatingAverages($ratingTotals, $submissionCount);

		// place each rating average inside a <td>
		$averagesContent = "";
		for($i = 0; $i < count($formattedAverages); $i++) {
			$averagesContent .= "<td>{$formattedAverages[$i]}</td>";
		}

		// add and return the average ratings in the following HTML structure
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

	/**
	 * Calculates the average rating given to each aspect of the current clinical site based on the total of each rating and the number of submissions
	 * 
	 * Returns an array containing a string made up of ★'s corresponding to each calculated rating average
	 * For example an average rating of 3 would result in "★★★"
	 * @param array $ratingTotals An array containing the total ratings for each aspect of the current clinical site:
	 * [Enjoyed Site, Staff Supportive, Site Learning Objectives, Preceptor Learning Objectives, Recommend Site]
	 * @param int $submissionCount The number of submissions belonging to the current clinical site 
	 * @return array an array containing a string made up of ★'s corresponding to each calculated rating average
	 */
	function calculateRatingAverages($ratingTotals, $submissionCount) {
		return array(
			generateStars( round($ratingTotals[0] / $submissionCount) ),
			generateStars( round($ratingTotals[1] / $submissionCount) ),
			generateStars( round($ratingTotals[2] / $submissionCount) ),
			generateStars( round($ratingTotals[3] / $submissionCount) ),
			generateStars( round($ratingTotals[4] / $submissionCount) ),
		);
	}
?>