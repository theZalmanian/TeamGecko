<?php 
    /******************
    ***** DISPLAY *****
    ******************/

    /**
     * Generates and returns a Bootstrap Floating Label textbox, where the label sits within the textbox, 
     * using the given data and value, if any
     * @param string $inputID The ID attribute being added to the input for use with label
     * @param string $inputLabelText The text being displayed within the input's label
     * @param boolean $isRequired Whether the input is required for submission
     * @param string $value (Optional) The text being preloaded within the input, if any
     * @return string a Bootstrap Floating Label textbox generated using the given data
     */
    function generateBootstrapFloatingTextBox($inputID, $inputLabelText, $isRequired, $value = "") {
        // if the option was given as required
        $requiredAttribute = "";
        if($isRequired) {
            // update the label to display a required *
            $inputLabelText .= displayRequired();

            // add the required attribute to input
            $requiredAttribute = "required";
        }
        
        // generate Bootstrap Floating Label input area using given data
        return "<div class='form-floating my-2'>
                    <input type='text' class='form-control' id='{$inputID}' name='{$inputID}'
                        placeholder='' value='{$value}' {$requiredAttribute}>
                    <label for='{$inputID}'>
                        {$inputLabelText}
                    </label>
                </div>";
    }

    /**
     * Generates and returns a Bootstrap Floating Label textarea, where the label sits within the textarea, 
     * using the given data and value, if any
     * @param string $inputID The ID attribute being added to the input for use with label
     * @param string $inputLabelText The text being displayed within the input's label
     * @param boolean $isRequired Whether the input is required for submission
     * @param string $value (Optional) The text being preloaded within the input, if any
     * @return string a Bootstrap Floating Label input generated using the given data
     */
    function generateBootstrapFloatingTextArea($inputID, $inputLabelText, $isRequired, $value = "") {
        // if the option was given as required
        $requiredAttribute = "";
        if($isRequired) {
            // update the label to display a required *
            $inputLabelText .= displayRequired();

            // add the required attribute to input
            $requiredAttribute = "required";
        }

        // generate Bootstrap Floating Label input area using given data
        return "<div class='contact form-floating my-2'>
                    <textarea class='form-control' id='{$inputID}' name='{$inputID}' 
                        placeholder='' {$requiredAttribute}>{$value}</textarea>
                    <label for='{$inputID}'>
                        {$inputLabelText}
                    </label>
                </div>";
    }

    /**
     * Generates and returns a Bootstrap Alert indicating to user that access was denied, and linking to given page
     * @param string $linkHref The links destination path
     * @param string $linkText The text to be displayed in the "button" link
     * @return string a Bootstrap Alert containing the given HTML content
     */
    function displayAccessDenied($linkHref, $linkText) {
        /**
         * An SVG of a shield with a lock, indicating lack of access
         */
        $lockIcon = "<svg xmlns='http://www.w3.org/2000/svg' width='65' height='65' fill='currentColor' class='bi bi-shield-lock-fill' viewBox='0 0 16 16'>
                        <path fill-rule='evenodd' d='M8 0c-.69 0-1.843.265-2.928.56-1.11.3-2.229.655-2.887.87a1.54 1.54 0 0 0-1.044 1.262c-.596 4.477.787 7.795 2.465 9.99a11.777 11.777 0 0 0 2.517 2.453c.386.273.744.482 1.048.625.28.132.581.24.829.24s.548-.108.829-.24a7.159 7.159 0 0 0 1.048-.625 11.775 11.775 0 0 0 2.517-2.453c1.678-2.195 3.061-5.513 2.465-9.99a1.541 1.541 0 0 0-1.044-1.263 62.467 62.467 0 0 0-2.887-.87C9.843.266 8.69 0 8 0m0 5a1.5 1.5 0 0 1 .5 2.915l.385 1.99a.5.5 0 0 1-.491.595h-.788a.5.5 0 0 1-.49-.595l.384-1.99A1.5 1.5 0 0 1 8 5'/>
                    </svg>";

        // place and return message content within Bootstrap Alert
        return generateMessageWithLink($linkHref, $linkText, $lockIcon, "Access Denied");
    }

    /**
     * Generates and returns a Bootstrap Alert to be displayed containing the given title and message, 
     * along with the given link styled as a button at the bottom
     * @param string $linkHref The links destination path
     * @param string $linkText The text to be displayed in the "button" link
     * @param string $message The message itself
     * @param string $title (Optional) The title of the message block, may be unnecessary if only a message is needed
     * @return string a Bootstrap Alert containing the given HTML content
     */
    function generateMessageWithLink($linkHref, $linkText, $message, $title = "") {
        // setup message content
        $messageContent = "";
        
        // if a title was given
        if(!empty($title)) {
            // display it
            $messageContent .= "<h2>{$title}</h2>
                                <hr>";
        }

        // add message, and setup link using given attributes
        $messageContent .= "<h4>{$message}</h4>
                            <hr>
                            <a class='btn btn-success py-2 m-2 border' href='{$linkHref}'>{$linkText}</a>";

        // place and return message content inside Bootstrap Alert
        return generateBootstrapAlert($messageContent);
    }

    /**
     * Generates and returns a Bootstrap Alert to be displayed containing the given title and message
     * @param string $message The message itself
     * @param string $title (Optional) The title of the message block, may be unnecessary if only a message is needed
     * @return string a Bootstrap Alert containing the given HTML content
     */
    function generateMessage($message, $title = "") {
        // setup message content
        $messageContent = "";

        // if a title was given
        if(!empty($title)) {
            // display it
            $messageContent .= "<h2>{$title}</h2>
                                <hr>";
        }

        // add message to display
        $messageContent .= "<h4>{$message}</h4>";

        // place and return message content inside Bootstrap Alert
        return generateBootstrapAlert($messageContent);
    }

    /**
     * Generates and returns a Bootstrap Alert to be displayed containing the given HTML content
     * @param string $content The HTML content being displayed in the Bootstrap Alert
     * @return string a Bootstrap Alert containing the given HTML content
     */
    function generateBootstrapAlert($content) {
        return "<div class='col-12 w-100 alert alert-light text-center my-3 border' role='alert'>
                    {$content}
                </div>";
    }
    
    /**
     * Generates and returns a Bootstrap Scrollspy tracking and linking to all items in the given array. 
     * Contains a button at the top which contains the text "Exit" and will lead to the given path.
     * The Scrollspy should be generated on the side of a page, and will stick to the top, following the scroll till bottom of page is reached
     * @param array $scrollspyDisplayTitles An array containing titles corresponding to the HTML content being tracked and linked to by Scrollspy
     * @param string $exitHref The destination path of the exit button
     * @param string $otherContent (Optional) any other content you may want displayed after exit button and before links
     * @return string a Bootstrap Scrollspy tracking and linking to the given items
     */
    function generateBootstrapScrollspy($scrollspyDisplayTitles, $exitHref, $otherContent = "") {
        // setup links to all given items
        $scrollspyLinks = "";
        for ($i = 1; $i <= count($scrollspyDisplayTitles); $i++) {
            $scrollspyLinks .= "<a class='nav-link spy-link ps-2 py-0 my-2' href='#spy-{$i}'>
                                    {$scrollspyDisplayTitles[$i - 1]}
                                </a>";
        }

        // return Bootstrap scrollspy containing links leading to each of the given items
        return "<div class='card col-12 mb-3 mb-md-0 border-bottom-0 rounded-bottom-0' id='scrollspy-container'>
                    <nav class='p-3 rounded-3 sticky-md-top' id='scrollspy'>
                        <a class='col-12 btn btn-danger py-2 w-100 border' href='{$exitHref}'>
                            Exit
                        </a>
                        {$otherContent}
                        <hr>
                        {$scrollspyLinks}
                    </nav>
                </div>";
    }

    /**
     * 
     * @param string $modalID
     * @param string $modalTitle
     * @param string $modalBodyContent
     * @param string $modalButton
     * @return string
     */
    function generateBootstrapModal($modalID, $modalTitle, $modalBodyContent, $modalButton = "") {
        if(empty($modalButton)) {
            $modalButton = "<button type='button' class='btn btn-success border' 
                                data-bs-toggle='modal' data-bs-target='#{$modalID}'>
                                View
                            </button>";
        }

        $modal = "<div class='modal fade text-start' id='{$modalID}' tabindex='-1' aria-labelledby='{$modalID}-label' aria-hidden='true'>
                        <div class='modal-dialog modal-dialog-centered modal-dialog-scrollable'>
                            <div class='modal-content'>
                                <div class='modal-header'>
                                    <h1 class='modal-title fs-5' id='{$modalID}-label'>
                                        {$modalTitle}
                                    </h1>
                                    <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'>
                                    </button>
                                </div>
                                <div class='modal-body'>
                                    {$modalBodyContent}
                                </div>
                            </div>
                        </div>
                    </div>";

        // return the modal trigger and modal together
		return "{$modalButton}
                {$modal}";
    }

    /**
     * Generates and returns an HTML span signifying that an input is required
     * @return string an HTML span signifying that an input is required
     */
    function displayRequired() {
        return " " . "<span class='text-danger'>*</span>";
    }

    /**
     * Returns the given text inside of an HTML strong element
     * @param string $text The message being displayed inside an HTML strong element
     * @return string the given message inside of an HTML strong element
     */
    function displayStrong($text) {
        return "<strong>{$text}</strong>" . " ";
    }

    /**
     * Constructs and returns a string made up of the given # of stars: ★
     * @param int $numStars The # of stars to be generated and displayed
     * @return string a string containing the given # of stars: ★
     */
    function generateStars($numStars) {
        // add the given number of # stars to the display
        $stars = "";
        for ($currStar = 0; $currStar < $numStars; $currStar++) {
            $stars .= "★";
        }

        return $stars;
    }

    /**
     * Checks if the given page title matches the current page's title,
     * and returns the corresponding class attributes to be added to a link if so
     * @param string $pageTitle The name of the page being checked
     * @return string a string containing the active and disabled classes if match; otherwise empty string
     */
    function isActive($pageTitle) {
        // include the current page's title
        global $currPageTitle;

        // if the given page name matches that of the current page
        if($pageTitle === $currPageTitle) {
            // return the active and disabled attributes to be
            // added to that link's class list
            return " " . "active disabled";
        }

        // otherwise return empty string
        return "";
    }

    /******************
    ****** MySQL ******
    ******************/

    /**
     * Opens a connection to the DB, executes the given query, closes the DB connection, and returns the result
     *
     * @param string $query The SQL query to be executed
     * @return mixed a mysqli_result object for successful SELECT queries, and true/false for CREATE, UPDATE, and DELETE queries
     */
    function executeQuery($query) {
        // open connection to DB
        $dbConnection = connectDB();

        // execute query and capture result
        $result = mysqli_query($dbConnection, $query);

        // close connection to DB
        disconnectDB($dbConnection);

        return $result;
    }

    /**
     * Opens a connection to the DB, executes the given query, displays success or error message,
     * closes the DB connection, and returns the result
     *
     * @param string $query The SQL query to be executed
     * @return mixed a mysqli_result object for successful SELECT queries, and true/false for CREATE, UPDATE, and DELETE queries
     */
    function executeQueryDebugging($query) {
        // open connection to DB
        $dbConnection = connectDB();

        // execute query and capture result
        $result = mysqli_query($dbConnection, $query);

        // display success or fail
        if ($result) {
            echo "<p>Query successful!</p>";
        } else {
            echo "<p>Query failed: " . mysqli_error($dbConnection)  . "</p>";
        }

        // close connection to DB
        disconnectDB($dbConnection);

        return $result;
    }
?>