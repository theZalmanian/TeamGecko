<?php 
    // get access to all helper methods
    require_once("../php/helpers.php");

    // save the current pages name to session
    setCurrentPage("Clinical Requirements");
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
    <?php 
        // display site navigation
        require_once("../php/layouts/navigation.php");
    ?>
    <main class="container" id="requirements">
        <div class="row">
            <div class="col-md-1 col-lg-2">
            </div>
            <div class="col-12 col-md-10 col-lg-8 mb-3">
                <h1 class="card col-12 py-3 mb-1 text-center">
                    Green River College
                    <br>
                    Nursing Program Clinical Requirements
                </h1>
                <div class="card my-2 notes">
                    <ul class="list-group list-group-flush text-center">
                        <li class="list-group-item text-break px-2">
                            <strong>2660*All vaccination proof must include full name, date of birth, and date of vaccine, titer (blood draw), or test</strong>
                        </li>
                    </ul>
                </div>

                <div class="accordion mb-2 my-2" id="requirements-accordion">
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

                            $targetID = "item-{$targetCount}";
                            $targetCount++; // update the target count for next row

                            // generate an accordion item for the row
                            echo generateAccordionItem($title, $targetID, $notes, $option1, $option2);
                        }
                    ?>
                </div>

                <div class="card notes">
                    <ul class="list-group list-group-flush text-center">
                        <li class="list-group-item text-break px-2">
                            <b>If you have any questions about the requirements, you can email me at csavage@greenriver.edu</b>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-md-1 col-lg-2">
            </div>
        </div>
    </main>
</body>
</html>

<?php 
    /**
     * Generates and returns a Bootstrap Accordion item using the given data
     * @param string $title The title of the Accordion item, to be displayed in the header
     * @param string $targetID The ID for the Accordion item, used to control its open/collapse
     * @param string $note Additional note to be displayed at the top of the body (Optional: null)
     * @param string $option1 The first option to be displayed in the body
     * @param string $option2 The second option to be displayed in the (Optional: null)
     * @return string The generated Bootstrap Accordion item containing the given data displayed in its corresponding areas
     */
    function generateAccordionItem($title, $targetID, $note, $option1, $option2) {
        // start off Accordion item
        $accordionItem = "<div class='accordion-item'>";

        // generate and add header containing given title to item 
        $accordionItem .= generateAccordionHeader($title, $targetID);

        // generate and add body to item containing given note (if any), 
        // and given options (second is optional, if given as empty or null: will not be displayed)
        $accordionItem .= "<div class='accordion-collapse collapse' id='{$targetID}'>" 
                            . generateAccordionBody($note, $option1, $option2) 
                            . "</div>" ;
       
        // close off and return Accordion item
        return $accordionItem .= "</div>";
    }

    /**
     * Generates and returns the header of a Bootstrap Accordion item using the given data
     * @param string $title The title of the Accordion item, to be displayed in the "toggle" button
     * @param string $targetID The ID for the Accordion item, used to control its open/collapse when header is clicked
     * @return string The header generated for a Bootstrap Accordion item using the given data
     */
    function generateAccordionHeader($title, $targetID) {
        return "<h2 class='accordion-header'>
                    <button class='accordion-button collapsed' type='button'
                            data-bs-toggle='collapse' data-bs-target='#{$targetID}'
                            aria-expanded='false' aria-controls='{$targetID}'>
                        {$title}
                    </button>
                </h2>";
    }

    /**
     * Generates and returns the body of a Bootstrap Accordion item using the given data
     * @param string $note Additional note to be displayed at the top of body, if given (Optional: null)
     * @param string $option1 The first option to be displayed in the body
     * @param string $option2 The second option to be displayed in the body (Optional: null)
     * @return string The body generated for a Bootstrap Accordion item using the given data
     */
    function generateAccordionBody($note, $option1, $option2) {
        // start off body content
        $accordionBody = "<div class='accordion-body p-0'>";
        
        // if a note was given
        if(!empty($note)) {
            // generate and add it to the body at the top
            $accordionBody .= generateRequirementNotes($note);
        }

        // generate and add all given options to body, then close off and return it
        return $accordionBody . generateRequirementData($option1, $option2) . "</div>";
    }

    /** 
     * Generates and returns an HTML <ul> containing the given note
     * @param string $note A general note regarding the requirement
     * @return string an HTML div containing the given note
     */
    function generateRequirementNotes($note) {
        return "<ul class='list-group list-group-flush text-center requirement-note'>
                    <li class='list-group-item'>
                        {$note}
                    </li>
                </ul>";
    }

    /** 
     * Generates and returns an HTML <div> containing the given option/s
     * @param string $option1 The first or only requirement option
     * @param string $option2 The second requirement option (Optional: null)
     * @return string an HTML <div> containing the given option/s
     */
    function generateRequirementData($option1, $option2 = "") {
        // start off data content
        $dataContent = "<div class='px-3 m-0 requirement-data'>";

        // generate and add the first option to display (required)
        $dataContent .= generateRequirementOption($option1);

        // if a second option was given (optional)
        if(!empty($option2)) {
            // generate and add an "OR" separator between options to display
            $dataContent .= "<h3 class='or-row text-center py-2 m-0'>
                                <b>OR</b>
                            </h3>";

            // generate and add the second option to display
            $dataContent .= generateRequirementOption($option2);
        }

        // close off and return data content
        return $dataContent . "</div>";
    }

    /**
     * Generates and returns an HTML <ul> containing the given requirement option block, separated for display
     * @param string $optionBlock The option to be processed into an optionTitle (if given) and optionText
     * @return string an HTML <ul> containing the given requirement option
     */
    function generateRequirementOption($optionBlock) {
        // split the given option into individual lines
        $optionLines = explode("\n", $optionBlock);
    
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
?>