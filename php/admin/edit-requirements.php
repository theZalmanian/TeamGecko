<?php 
    // get access to all PHP helpers
    require_once("/home/geckosgr/public_html/initial.php");

    // store the current page's title for dynamic HTML generation
    $currPageTitle = "Edit Requirements";

    /**
     * Global counter of # of HTML elements tracked by scrollspy
     */
    $scrollspyElementsCount = 0;
    
    /**
     * An array containing the Titles of all Requirements stored in DB
     */
    $allRequirementTitles = array();

    /**
     * An array containing a Bootstrap Card for each Clinical Requirement in the DB
     * Each card has four inputs, one for each field a Clinical Requirement contains
     */
    $allRequirementCards = array();

    // setup and execute SELECT Query
    $allRequirements = executeQuery("SELECT * 
                                     FROM ClinicalRequirements");

    // run through rows returned from query
    while ($currRow = mysqli_fetch_assoc($allRequirements)) {
        // get each column from current row
        $requirementID = $currRow["RequirementID"];
        $title = $currRow["RequirementTitle"];
        $notes = $currRow["RequirementNotes"];
        $option1 = $currRow["Option1"];
        $option2 = $currRow["Option2"];

        // save the current requirement's title 
        $allRequirementTitles[] = $title;

        // display the current requirement's data in editable inputs
        $allRequirementCards[] = generateRequirementInputs($requirementID, $title, $notes, $option1, $option2);
    }
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
            <?php if($_SESSION["Admin"]) { ?>
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
                        // generate scrollspy to track and link requirements
                        echo generateBootstrapScrollspy($allRequirementTitles, "/sprint-5/requirements.php");
                    ?>
                </div>
                <div class="col-12 col-md-9 col-lg-9">
                    <?php echo generateAddRequirementModal(); ?>
                    <form class="container" action="/php/admin/update-database.php?operation=edit-requirements" method="post">
                        <input type="hidden" value="confirmed" name="confirm-edits">
                        <div class="row justify-content-center">
                            <?php
                                // run through and display all generated requirement cards
                                foreach ($allRequirementCards as $currRequirementCard) {
                                    echo $currRequirementCard;
                                }
                            ?>
                            <div class="card col-12 col-md-10 p-3 border-bottom-0 rounded-0 sticky-bottom">
                                <button type="submit" class="col-12 btn btn-success py-2 border" id="save-requirements">
                                    Save All Changes
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            <?php 
				} 
			
				else {
					echo "<div class='col-md-3 col-lg-3'>
						</div>
						<div class='col-12 col-md-6 col-lg-6'>" 
							. displayAccessDenied("login.php", "Login") .
						"</div>
						<div class='col-md-3 col-lg-3'>
						</div>";
				}
			?>
        </div>
    </main>

    <!--Include dynamic scrollspy for mobile-->
    <script src="/js/responsive-scrollspy-toggle.js"></script>
</body>
</html>

<?php
    function generateAddRequirementModal() {
        $addRequirementForm = "<form action='/php/admin/update-database.php?operation=add-requirement' method='post'>
                                    " . generateBootstrapFloatingTextBox("RequirementTitle", "Title", true) . "
                                    " . generateBootstrapFloatingTextBox("RequirementNotes", "Notes", false) . "
                                    " . generateBootstrapFloatingTextArea("Option1", "Option 1", true) . "
                                    " . generateBootstrapFloatingTextArea("Option2", "Option 2", false) . "
                                    <button type='submit' class='col-12 btn btn-success py-2 border' id='add-requirement'>
                                        Add Requirement
                                    </button>
                                </form>";

        $requirementModalButton = "<div class='card col-12 col-md-10 mx-md-1 mb-3 p-3'>
                                        <button type='button' class='btn btn-success w-100 py-2 border'
                                            data-bs-toggle='modal' data-bs-target='#add-requirement'>
                                            New Requirement
                                            <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-plus-circle' viewBox='0 0 16 16'>
                                                <path d='M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16'/>
                                                <path d='M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4'/>
                                            </svg>
                                        </button>
                                    </div>";

        return generateBootstrapModal("add-requirement"
                                        , displayStrong("Add Clinical Requirement")
                                        , $addRequirementForm
                                        , $requirementModalButton);
    }

    /**
     * Generates and returns a Bootstrap Card containing a Bootstrap Floating Label input for each of 
     * the given parameters (except ID). If a value was provided, it will be stored within the generated input
     * @param int $requirementID The requirement's ID, used in the generated inputs ID attributes
     * @param string $title The title value stored for the requirement in DB, placed within textbox
     * @param string $notes (Optional) The notes value stored for the requirement in DB, placed within textbox if given
     * @param string $option1 The first option value stored for the requirement in DB, placed within textarea
     * @param string $option2 (Optional) The second option value stored for the requirement in DB, placed within textarea if given
     * @return string a Bootstrap Card containing the given values placed within individual Bootstrap Floating Label inputs so they may be edited
     */
    function generateRequirementInputs($requirementID, $title, $notes, $option1, $option2) {
        /**
         * Global counter of # of HTML elements tracked by scrollspy
         */
        global $scrollspyElementsCount; 
        
        // another element is tracked by scrollspy
        $scrollspyElementsCount++;

        // generate requirement inputs using given data and place within Card
        return "<div class='card col-12 col-md-10 mx-md-1 mb-3 p-3' id='spy-{$scrollspyElementsCount}'>
                    " . generateBootstrapFloatingTextBox("{$requirementID}-RequirementTitle", "Title", true, $title) . "
                    " . generateBootstrapFloatingTextBox("{$requirementID}-RequirementNotes", "Notes", false, $notes) . "
                    " . generateBootstrapFloatingTextArea("{$requirementID}-Option1", "Option 1", true, $option1) . "
                    " . generateBootstrapFloatingTextArea("{$requirementID}-Option2", "Option 2", false, $option2) . "
                </div>";
    }
?>