<?php 
    // get access to all PHP helpers
    require_once("/home/geckosgr/public_html/initial.php");

    // store the current page's title for dynamic HTML generation
    $currPageTitle = "Edit Requirements";

    $allRequirementTitles = array();
    $allRequirementsDisplay = array();
?>

<?php 
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

        $allRequirementTitles[] = $title;

        // display the current requirement in editable inputs
        $allRequirementsDisplay[] = displayRequirement($title, $notes, $option1, $option2, $requirementID);
    }     
    
    function displayScrollspy() {
        global $allRequirementTitles;

        $scrollSpy = "<div class='card col-12 mb-3 mb-md-0 h-100 border-bottom-0 rounded-bottom-0' id='scrollspy-container'>
                            <nav class='navbar p-3 rounded-3 sticky-md-top' id='scrollspy'>
                                <div class='navbar-nav'>";

        for ($i = 1; $i <= count($allRequirementTitles); $i++) {
            $scrollSpy .= "<a class='nav-link ps-2 py-0 my-2' href='#spy-{$i}'>
                               {$allRequirementTitles[$i - 1]}
                            </a>";
        }

        return $scrollSpy . "</div></nav></div>";
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
<body>
	<main class="container mt-3">
        <div class="row">
            <div class="col-md-3 col-lg-3">
                <button id="scrollspy-toggler" class="btn btn-success d-md-none w-100 py-2 mb-2 border">
                    Go to Clinical Site
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chevron-expand" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M3.646 9.146a.5.5 0 0 1 .708 0L8 12.793l3.646-3.647a.5.5 0 0 1 .708.708l-4 4a.5.5 0 0 1-.708 0l-4-4a.5.5 0 0 1 0-.708zm0-2.292a.5.5 0 0 0 .708 0L8 3.207l3.646 3.647a.5.5 0 0 0 .708-.708l-4-4a.5.5 0 0 0-.708 0l-4 4a.5.5 0 0 0 0 .708z"/>
                    </svg>
                </button>
                <?php 
                    echo displayScrollspy();
                ?>
            </div>
            <div class="col-12 col-md-9 col-lg-9">
                <form class="container" action="/php/save-requirements.php" method="post"
                    data-bs-spy='scroll' data-bs-target='#scrollspy' data-bs-smooth-scroll='true'>
                    <input type="hidden" value="confirmed" name="confirm-edits">
                    <div class="row justify-content-center">
                        <?php
                            foreach ($allRequirementsDisplay as $requirementDisplay) {
                                echo $requirementDisplay;
                            }
                        ?>
                        <div class="card col-12 col-md-10 p-3 border-bottom-0 rounded-0 sticky-bottom">
                            <div class="row d-flex justify-content-center">
                                <button type="submit" class="col-5 btn btn-success py-2 mx-2 border" id="save-requirements">Save All Changes</button>
                                <a class="col-5 btn btn-danger py-2 mx-2 border" href="/sprint-4/requirements.php">Cancel</a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </main>

    <!--Include dynamic scrollspy for mobile-->
    <script src="/js/responsive-scrollspy-toggle.js"></script>
</body>
</html>

<?php
    $spyCounter = 0;

    /**
     * 
     * @param string $title
     * @param string $notes
     * @param string $option1
     * @param string $option2
     * @return string 
     */
    function displayRequirement($title, $notes, $option1, $option2, $targetID) {
        global $spyCounter;

        $spyCounter++;

        return "<div class='card col-12 col-md-10 mx-md-1 mb-3 p-3' id='spy-{$spyCounter}'>
                    " . generateBootstrapFloatingLabelTextbox("{$targetID}-RequirementTitle", "Title", $title, true) . "
                    " . generateBootstrapFloatingLabelTextbox("{$targetID}-RequirementNotes", "Notes", $notes, false) . "
                    " . displayOptionTextarea("{$targetID}-Option1", "Option 1", $option1, true) . "
                    " . displayOptionTextarea("{$targetID}-Option2", "Option 2", $option2, false) . "
                </div>";
    }

    /**
     * @param string $inputID
     * @param string $inputLabelText
     * @return string
     */
    function generateBootstrapFloatingLabelTextbox($inputID, $inputLabelText, $value, $isRequired) {
        if($isRequired) {
            return "<div class='contact form-floating my-2'>
                        <input type='text' class='form-control' id='{$inputID}' name='{$inputID}'
                            placeholder='' value='{$value}' required>
                        <label for='{$inputID}'>
                            {$inputLabelText}" . displayRequired() . "
                        </label>
                    </div>";
        }
        
        else {
            return "<div class='contact form-floating my-2'>
                        <input type='text' class='form-control' id='{$inputID}' name='{$inputID}'
                            placeholder='' value='{$value}'>
                        <label for='{$inputID}'>
                            {$inputLabelText}
                        </label>
                    </div>";
        }
    }

    /**
     * @param string $inputID
     * @param string $inputLabelText
     * @return string
     */
    function displayOptionTextarea($inputID, $inputLabelText, $value, $isRequired) {
        if($isRequired) {
            return "<div class='contact form-floating my-2'>
                        <textarea class='form-control' id='{$inputID}' name='{$inputID}' placeholder='' required>{$value}</textarea>
                        <label for='{$inputID}'>
                            {$inputLabelText}" . displayRequired() . "
                        </label>
                    </div>";
        }

        else {
            return "<div class='contact form-floating my-2'>
                    <textarea class='form-control' id='{$inputID}' name='{$inputID}' placeholder=''>{$value}</textarea>
                    <label for='{$inputID}'>
                        {$inputLabelText}
                    </label>
                </div>";
        }
    }
?>