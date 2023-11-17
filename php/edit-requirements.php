<?php 
    // get access to all helper methods
    require_once("../php/helpers.php");

    // save the current pages name to session
    setCurrentPage("Edit Requirements");
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
            <form class="my-1" action="/" method="post">
                <?php 
                    // setup and execute SELECT Query
                    $allRequirements = executeQuery("SELECT * FROM ClinicalRequirements");

                    $targetCount = 0;
                    // run through rows returned from query
                    while ($currRow = mysqli_fetch_assoc($allRequirements)) {
                        // get each column from current row
                        $title = $currRow["RequirementTitle"];
                        $notes = $currRow["RequirementNotes"];
                        $option1 = $currRow["Option1"];
                        $option2 = $currRow["Option2"];

                        // generate an accordion item for the row
                        $targetID = "requirement-{$targetCount}";
                        $targetCount++;

                        echo displayRequirement($title, $notes, $option1, $option2, $targetID);
                    }                
                ?>
                <div class="card container p-2 my-1">
                    <div class="row justify-content-center">
                        <button class="col-5 btn btn-success py-2 m-2 border" id="submit-save-requirements">Save All Changes</button>
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
                    " . generateBootstrapFloatingLabelTextbox("title-{$targetID}", "Title", $title, true) . "
                    " . generateBootstrapFloatingLabelTextbox("notes-{$targetID}", "Notes", $notes, false) . "
                    " . displayOptionTextarea("option1-{$targetID}", "Option 1", $option1, true) . "
                    " . displayOptionTextarea("option2-{$targetID}", "Option 2", $option2, false) . "
                </div>";
    }

    function generateOptionInputs($optionInputLabel, $option) {
        // split the given option into individual lines
        $optionLines = explode("\n", $option);

        // start off option content
        $optionContent = "<ul class='list-group list-group-flush'>";
    
        // run through all lines in the given option
        foreach ($optionLines as $currLine) {
            // remove leading and trailing whitespace
            $currLine = trim($currLine);
    
            // if the current line starts with "-", its considered an option
            if (!empty($currLine) && $currLine[0] === '-') {
                // remove the leading "-" and add to display as option
                $optionContent .= "<li class='list-group-item'>" . substr($currLine, 1) . "</li>";
            } 
            
            // if there is content, but not starting with a "-", its considered a title
            elseif(!empty($currLine)) {
                // add to display as title
                $optionContent .= "<li class='list-group-item h5 mb-0'>{$currLine}</li>";
            }
        }
    
        // close off and return option content
        return $optionContent . "</ul>";
    }

    /**
     * @param string $inputID
     * @param string $inputLabelText
     * @return string
     */
    function generateBootstrapFloatingLabelTextbox($inputID, $inputLabelText, $value, $isRequired) {
        if($isRequired) {
            return "<div class='contact form-floating'>
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