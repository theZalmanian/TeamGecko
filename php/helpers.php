<?php 
    // only start a session if one does not exist yet
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    /**
     * Gets and returns the page that is currently open from Session Storage, if any
     * @return string the page that is currently open from Session Storage, if present; otherwise empty string
     */
    function getCurrentPage() {
        // return the page that is currently open from Session Storage, 
        // if one is not present, return an empty string
        return isset($_SESSION["currentPage"]) ? $_SESSION["currentPage"] : ""; 
    }

    /**
     * Sets the current page in Session Storage to be the given page
     * @param string $pageTitle The page being saved as the current page in Session Storage
     */
    function setCurrentPage($pageTitle) {
        // save the given pages name to session as the current page
        $_SESSION["currentPage"] = $pageTitle;
    }

    /******************
    ***** DISPLAY *****
    ******************/

    /**
     * Returns a Bootstrap Alert to be displayed containing the given title and message, 
     * along with the given link styled as a button at the bottom
     * @param string $linkHref The links destination path
     * @param string $linkText The text to be displayed in the "button" link
     * @param string $title The title of the message block
     * @param string $message (Optional) The message itself, may be unnecessary if only a title is needed
     * @return string a Bootstrap Alert containing the given HTML content
     */
    function displayMessageWithLink($linkHref, $linkText, $title, $message = "") {
        // setup message content
        $messageContent = "<h2>{$title}</h2>
                           <hr>
                           <h4>{$message}</h4>
                           <hr>
                           <a class='btn btn-success py-2 m-2 border' href='{$linkHref}'>{$linkText}</a>";

        // place and return message content inside Bootstrap Alert
        return displayBootstrapAlert($messageContent);
    }

    /**
     * Returns a Bootstrap Alert to be displayed containing the given title and message
     * @param string $title The title of the message block
     * @param string $message (Optional) The message itself, may be unnecessary if only a title is needed
     * @return string a Bootstrap Alert containing the given HTML content
     */
    function displayMessage($title, $message = "") {
        // setup message content
        $messageContent = "<h2>{$title}</h2>
                           <hr>
                           <h4>{$message}</h4>";

        // place and return message content inside Bootstrap Alert
        return displayBootstrapAlert($messageContent);
    }

    /**
     * Returns a Bootstrap Alert to be displayed containing the given HTML content
     * @param string $content The HTML content being displayed in the Bootstrap Alert
     * @return string a Bootstrap Alert containing the given HTML content
     */
    function displayBootstrapAlert($content) {
        return "<div class='alert alert-light text-center my-3 border' role='alert'>
                    {$content}
                </div>";
    }

    /**
     * Returns an HTML span signifying that an input is required
     * @return string an HTML span signifying that an input is required
     */
    function displayRequired() {
        return " " . "<span class='text-danger'>*</span>";
    }

    /**
     * Returns the given message inside of an HTML strong element
     * @param string $message The message being displayed inside an HTML strong element
     * @return string the given message inside of an HTML strong element
     */
    function displayStrong($message) {
        return "<strong>{$message}</strong>" . " ";
    }

    /**
     * Constructs and returns a string made up of the given # of stars: ★
     * @param int $numStars The # of stars to be generated and displayed
     * @return string A string containing the given # of stars: ★
     */
    function generateStars($numStars) {
        // add the given number of # stars to the display
        $stars = "";
        for ($currStar = 0; $currStar < $numStars; $currStar++) {
            $stars .= "★";
        }

        return $stars;
    }

    /******************
    ******* SQL *******
    ******************/

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
?>