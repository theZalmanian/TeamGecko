<?php 
    // get access to all PHP helpers
    require_once("/home/geckosgr/public_html/initial.php");

    // store the current page's title for dynamic HTML generation
    $currPageTitle = "Edit Requirements";
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
            <div class="col-md-2 col-lg-3">
                <div class="card col-12 h-100 rounded-0">
                    <nav class="navbar p-3 sticky-top" id="scroll-spy">
                        <div class="navbar-nav">
                            <a class="nav-link" href="#spy-1">
                                How it works
                            </a>
                            <a class="nav-link" href="#spy-2">
                                How it works
                            </a>
                            <a class="nav-link" href="#spy-3">
                                How it works
                            </a>
                            <a class="nav-link" href="#spy-4">
                                How it works
                            </a>
                            <a class="nav-link" href="#spy-5">
                                How it works
                            </a>
                            <a class="nav-link" href="#spy-6">
                                How it works
                            </a>
                        </div>
                    </nav>     
                </div>
            </div>
            <div class="col-12 col-md-10 col-lg-9">
                <form class="container" data-bs-spy='scroll' data-bs-target='#scroll-spy' 
                    action="/php/save-requirements.php" method="post" target="_blank">
                    <input type="hidden" value="confirmed" name="confirm-edits">
                    <div class="row justify-content-center">
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
        
                                // display the current requirement in editable inputs
                                echo displayRequirement($title, $notes, $option1, $option2, $requirementID);
                            }                
                        ?>
                        <div class="card col-12 col-md-10 p-3 sticky-bottom  rounded-0">
                            <div class="row d-flex justify-content-center">
                                <button class="col-5 btn btn-success py-2 mx-2 border" id="save-requirements">Save All Changes</button>
                                <a class="col-5 btn btn-danger py-2 mx-2 border" href="/sprint-4/requirements.php">Cancel</a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </main>
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
                        <textarea class='form-control' id='{$inputID}' name='{$inputID}' required>{$value}</textarea>
                        <label for='{$inputID}'>
                            {$inputLabelText}" . displayRequired() . "
                        </label>
                    </div>";
        }

        else {
            return "<div class='contact form-floating my-2'>
                    <textarea class='form-control' id='{$inputID}' name='{$inputID}'>{$value}</textarea>
                    <label for='{$inputID}'>
                        {$inputLabelText}
                    </label>
                </div>";
        }
    }
?>