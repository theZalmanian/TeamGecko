<?php
//Start a session function
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

	/**
     * An array containing the Names of all Clinical Sites that have submission stored in DB
     */
    $allClinicalSiteNames = array();

	/**
     * An array containing a Bootstrap Card for each Clinical Site that has a submission in the DB
     * Each card contains a table with a row for each submission, along with a calculation of 
	 * average ratings for the site at the bottom
     */
	$allClinicalSiteCards = array();

	// get all experience form submissions from DB, ordered by clinical site, 
	// with newest submissions at the top
	$allSubmissions = executeQuery("SELECT * 
									FROM ExperienceFormSubmissions 
									ORDER BY SiteAttended, Seen");

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
			// save the name of the current clinical site to be used for scrollspy
			$allClinicalSiteNames[] = $currClinicalSite;

			//  save the data for the previous clinical site in a generated display card
			$allClinicalSiteCards[] = generateClinicalSiteDisplay($formattedSubmissionRows
																	, $currClinicalSite
																	, $currSubmissionCount);

			// track the new site
			$currClinicalSite = $siteAttended;

			// reset other trackers
			$formattedSubmissionRows = array(); 
			$currSubmissionCount = 0;
			resetRatingTotals();
		}

		// update the rating totals with the current submissions ratings
		updateRatingTotals($submissionRatings);

		// a new submission has been tracked
		$currSubmissionCount++;
		$totalSubmissionCount++;

		// update the current submission to be "seen" in the DB, as it is about to be displayed
        executeQuery("UPDATE ExperienceFormSubmissions 
						SET Seen = 1
						WHERE SubmissionID = {$currSubmission['SubmissionID']}");

		// format the data of the current submission row, 
		// and track with other rows belonging to the current clinical site
		$formattedSubmissionRows[] = generateFormattedSubmissionRow($currSubmission);
	}

	// save the name of the current clinical site to be used for scrollspy
	$allClinicalSiteNames[] = $currClinicalSite;

	// save the data for the previous clinical site in a generated display card
	$allClinicalSiteCards[] = generateClinicalSiteDisplay($formattedSubmissionRows
															, $currClinicalSite
															, $currSubmissionCount);
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<?php 
        // include standard nursing header metadata
        require_once(LAYOUTS_PATH . "/nursing-metadata.php");
    ?>
</head>
<body data-bs-spy='scroll' data-bs-target='#scrollspy' data-bs-smooth-scroll='true'>
	<main class="container mt-3">
		<div class="row">
			<div class="col-md-3 col-lg-3">
                <!--Button only accessible on mobile layout, used to toggle scrollspy-->
                <div class="card col-12 d-md-none mb-3 p-3">
                    <button id="scrollspy-toggler" class="btn btn-success w-100 py-2 border">
                        Go to Clinical Site
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chevron-expand" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M3.646 9.146a.5.5 0 0 1 .708 0L8 12.793l3.646-3.647a.5.5 0 0 1 .708.708l-4 4a.5.5 0 0 1-.708 0l-4-4a.5.5 0 0 1 0-.708zm0-2.292a.5.5 0 0 0 .708 0L8 3.207l3.646 3.647a.5.5 0 0 0 .708-.708l-4-4a.5.5 0 0 0-.708 0l-4 4a.5.5 0 0 0 0 .708z"/>
                        </svg>
                    </button>
                </div>
                <?php 
                    // generate scrollspy to track and link clinical sites
                    echo generateBootstrapScrollspy($allClinicalSiteNames, "/sprint-4/experience.php");
                ?>
            </div>
            <div class="col-12 col-md-9 col-lg-9">
				<?php
					/**
					 * Global counter of # of HTML elements tracked by scrollspy
					 */
					$scrollspyElementsCount = 0;

					// run through and display all generated clinical site cards
					foreach ($allClinicalSiteCards as $currClinicalSiteCard) {
						echo $currClinicalSiteCard;
					}
				?>
			</div>
		</div>
	</main>

	<!--Include dynamic scrollspy for mobile-->
	<script src="/js/responsive-scrollspy-toggle.js"></script>
</body>
</html>

<?php
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
		// format and store the remaining given data in array
		$formattedData = array(
			generateStars($currSubmission["EnjoyedSite"]),
			generateStars($currSubmission["StaffSupportive"]),
			generateStars($currSubmission["SiteLearningObjectives"]),
			generateStars($currSubmission["PreceptorLearningObjectives"]),
			generateStars($currSubmission["RecommendSite"]),
			displayFeedback($currSubmission["SiteOrStaffFeedback"], $currSubmission["InstructorFeedback"])
		);

		// wrap each formatted column in a <td>, and add to row
		$formattedSubmissionRows = "";
		for( $i = 0; $i < count($formattedData); $i++ ) {
			$formattedSubmissionRows .= "<td>{$formattedData[$i]}</td>";
		}

		// if the current row has not been displayed to an admin user before, setup notifiers
		$seenStatusDisplay = displaySeenStatus($currSubmission["Seen"]);
		$newSubmissionClass = $currSubmission["Seen"] ? "" : "bg-warning";

		// return all <td>'s wrapped in a <tr>
		return "<tr class='text-center {$newSubmissionClass}'>{$seenStatusDisplay}" . $formattedSubmissionRows . "</tr>";
	}

	/**
	 * Generates and returns an HTML td containing a Bootstrap badge if the current submission row has 
	 * not been seen, otherwise an empty td 
	 * @param boolean $seen Whether the current submission has been displayed and seen by an admin before
	 * @return string an HTML td containing a Bootstrap badge if not seen, otherwise an empty td
	 */
    function displaySeenStatus($seen) {
		if(!$seen) {
			return "<td>
						<span class='badge rounded-pill bg-success border'>
							NEW
						</span>
					</td>";
		}

		return "<td></td>";
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
	 * Generates and returns a Bootstrap card containing the following content, generated using the given data:
	 * A header displaying the site name, a table containing the given submission rows, and a section of average ratings for the current clinical site at the bottom
	 * @param array $formattedSubmissionRows The submission rows pulled from the DB belonging to the current clinical site, formatted appropriately within HTML table rows
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

		/**
         * Global counter of # of HTML elements tracked by scrollspy
         */
        global $scrollspyElementsCount; 

		// add all formatted submission rows together
		$tableContent = implode("", $formattedSubmissionRows);
        
        // another element is tracked by scrollspy
        $scrollspyElementsCount++;

		// generate clinical site averages using given data
		$averageRatings = generateRatingAverages($ratingTotals, $submissionCount);

		// generate and return table using given data
		return "<div class='card mb-3 p-3 table-responsive' id='spy-{$scrollspyElementsCount}'>
					<h1 class='text-center mb-3'>
						<strong>{$clinicalSiteName}</strong>
					</h1>
					<table class='table table-bordered table-striped-columns align-middle m-0'>
						<thead>
							<tr class='text-center'>
								<th>Status</th>
								<th>Enjoyed Site</th>
								<th>Staff Supportive</th>
								<th>Site Learning <br> Objectives</th>
								<th>Preceptor Learning <br> Objectives</th>
								<th>Recommend Site</th>
								<th>Feedback</th>
							</tr>
						</thead>
						<tbody>
							{$tableContent}
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