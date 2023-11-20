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
            <form class="my-1" action="/php/save-requirements.php" method="post" target="_blank">
                <input type="hidden" value="confirmed" name="confirm-edits">
                <?php 
                    // setup and execute SELECT Query
                    $allRequirements = executeQuery("SELECT * FROM ClinicalRequirements");

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
                <div class="card container p-2 my-1">
                    <div class="row justify-content-center">
                        <button class="col-5 btn btn-success py-2 m-2 border" id="save-requirements">Save All Changes</button>
                        <a class="col-5 btn btn-danger py-2 m-2 border" href="/sprint-4/requirements.php">Cancel</a>
                    </div>
                </div>
            </form>
        </div>
    </main>
</body>
</html>

<?php
    /**
     * 
     * @param string $title
     * @param string $notes
     * @param string $option1
     * @param string $option2
     * @return string 
     */
    function displayRequirement($title, $notes, $option1, $option2, $targetID) {
        return "<div class='card mb-3 p-3'>
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
            return "<div class='contact form-floating mb-2'>
                        <input type='text' class='form-control' id='{$inputID}' name='{$inputID}'
                            placeholder='' value='{$value}' required>
                        <label for='{$inputID}'>
                            {$inputLabelText}" . displayRequired() . "
                        </label>
                    </div>";
        }
        
        else {
            return "<div class='contact form-floating'>
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
            return "<div>
                        <label class='mb-2' for='{$inputID}'>
                            {$inputLabelText}" . displayRequired() . "
                        </label>
                        <textarea class='form-control' id='{$inputID}' name='{$inputID}' rows='4' required>{$value}</textarea>
                    </div>";
        }

        else {
            return "<div>
                    <label class='mb-2' for='{$inputID}'>
                        {$inputLabelText}
                    </label>
                    <textarea class='form-control' id='{$inputID}' name='{$inputID}' rows='4'>{$value}</textarea>
                </div>";
        }
    }

?>