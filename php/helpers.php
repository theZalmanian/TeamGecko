<?php 
    /******************
    ***** DISPLAY *****
    ******************/

    /**
     * Returns a Bootstrap Alert to be displayed containing the given title and message, 
     * along with the given link styled as a button at the bottom
     * @param string $linkHref The links destination path
     * @param string $linkText The text to be displayed in the "button" link
     * @param string $message The message itself
     * @param string $title (Optional) The title of the message block, may be unnecessary if only a message is needed
     * @return string a Bootstrap Alert containing the given HTML content
     */
    function displayMessageWithLink($linkHref, $linkText, $message, $title = "") {
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
        return displayBootstrapAlert($messageContent);
    }

    /**
     * Returns a Bootstrap Alert to be displayed containing the given title and message
     * @param string $message The message itself
     * @param string $title (Optional) The title of the message block, may be unnecessary if only a message is needed
     * @return string a Bootstrap Alert containing the given HTML content
     */
    function displayMessage($message, $title = "") {
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
    ****** MySQL ******
    ******************/

    /**
     * Opens a connection to the DB, executes the given query, closes the DB connection, and returns the result
     *
     * @param string $query The SQL query to be executed
     * @return mixed Returns a mysqli_result object for successful SELECT queries, and true/false for CREATE, UPDATE, and DELETE queries
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
     * @return mixed Returns a mysqli_result object for successful SELECT queries, and true/false for CREATE, UPDATE, and DELETE queries
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
            echo "<p>Query failed" . mysqli_error($dbConnection)  . "</p>";
        }

        // close connection to DB
        disconnectDB($dbConnection);

        return $result;
    }
?>