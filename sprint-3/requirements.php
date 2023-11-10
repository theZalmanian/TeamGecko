<?php 
    /**
     * Executes the given SQL query and returns the result
     *
     * @param string $query The SQL query to be executed
     * @return mixed Returns a mysqli_result object for successful SELECT queries, or true/false for other types of queries
     */
    function executeQuery($query) {
        // connect to database
        require_once('/home/geckosgr/db-connect-nursing.php');

        // execute and return query
        return mysqli_query($dbConnection, $query);
    }

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

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clinical Requirements</title>
    <link rel="icon" type="image/x-icon" href="/nursing-images/nursing-logo.png">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="/css/nursing-sprint-3.css">

    <!--Implement theme switcher-->
    <script src="/js/theme-switcher.js"></script>
</head>
<body>
    <!--Start of Nav-->
    <nav class="navbar sticky-top navbar-expand-md mb-3 border-bottom">
        <div class="container">
            <div class="navbar-brand">
                <img src="/nursing-images/nursing-logo.png" height="60" alt="GRC Nursing Program founded 1965">
            </div>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar-nav"
                    aria-controls="navbar-nav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse flex-row-reverse" id="navbar-nav">
                <div class="navbar-nav">
                    <a class="nav-link active disabled" href="/sprint-2/requirements.html" aria-current="page">
                        Clinical Requirements
                    </a>
                    <a class="nav-link" href="/sprint-2/experience.html">
                        Experience Survey
                    </a>
                    <a class="nav-link" href="/sprint-2/contact.html">
                        Contact
                    </a>
                    <a class="nav-link" id="theme-switcher">
                        <svg viewBox="0 0 56 56" xmlns="http://www.w3.org/2000/svg">
                            <path id="theme-icon" d="M 27.9999 51.9063 C 41.0546 51.9063 51.9063 41.0781 51.9063 28 C 51.9063 14.9453 41.0312 4.0937 27.9765 4.0937 C 14.8983 4.0937 4.0937 14.9453 4.0937 28 C 4.0937 41.0781 14.9218 51.9063 27.9999 51.9063 Z M 27.9999 47.9219 C 16.9374 47.9219 8.1014 39.0625 8.1014 28 C 8.1014 16.9609 16.9140 8.0781 27.9765 8.0781 C 39.0155 8.0781 47.8983 16.9609 47.9219 28 C 47.9454 39.0625 39.0390 47.9219 27.9999 47.9219 Z M 34.7030 33.2031 C 27.6014 33.2031 23.0546 28.75 23.0546 21.6484 C 23.0546 20.1719 23.4530 18.0859 23.8749 16.9844 C 23.9921 16.6797 24.0155 16.4922 24.0155 16.3750 C 24.0155 16.0234 23.7343 15.6250 23.2421 15.6250 C 23.0780 15.6250 22.7968 15.6484 22.4921 15.7656 C 17.6405 17.6875 14.3827 22.9375 14.3827 28.4453 C 14.3827 36.1563 20.2655 41.6641 27.9765 41.6641 C 33.6014 41.6641 38.4530 38.1953 40.1405 33.9531 C 40.2577 33.6484 40.2812 33.3437 40.2812 33.25 C 40.2812 32.7578 39.8827 32.4297 39.5077 32.4297 C 39.3671 32.4297 39.2030 32.4531 38.9452 32.5234 C 37.9609 32.8750 36.3202 33.2031 34.7030 33.2031 Z">
                            </path>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </nav>
    <!--End of Nav-->
    <main class="container" id="requirements">
        <div class="row">
            <div class="col-md-1 col-lg-2">
            </div>
            <div class="col-12 col-md-10 col-lg-8">
                <h1 class="col-12 mb-3 text-center">
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

                <div class="accordion mb-3 my-2" id="requirements-accordion">
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

                <div class="card my-2 notes">
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