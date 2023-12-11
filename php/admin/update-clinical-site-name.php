<?php 
    // get access to all PHP helpers
    require_once("/home/geckosgr/public_html/initial.php");

    // store the current page's title for dynamic HTML generation
    $currPageTitle = "Update Clinical Site Name";
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
            </div>
            <div class="col-12 col-md-6 col-lg-6">
                <?php
                    if( isset($_POST["old-site-name"]) && isset($_POST["new-site-name"]) ) {
                        // get the old and new clinical site names
                        $oldSiteName = $_POST["old-site-name"];
                        $newSiteName = $_POST["new-site-name"];

                        // get all submissions in DB corresponding to the old clinical site name
                        $oldSiteSubmissionIDs = executeQuery("SELECT SubmissionID
                                                              FROM ExperienceFormSubmissions
                                                              WHERE SiteAttended = '{$oldSiteName}'");

                        // run through all returned submissions
                        while($currSubmission = mysqli_fetch_assoc($oldSiteSubmissionIDs)) {
                            // get the current submissions ID
                            $currSubmissionID = $currSubmission["SubmissionID"];

                            // update the current submission to belong to the new clinical site name
                            $result = executeQuery("UPDATE ExperienceFormSubmissions 
                                                    SET SiteAttended = '{$newSiteName}'
                                                        , Seen = '0' 
                                                    WHERE SubmissionID = '{$currSubmissionID}'");
                        
                            if(!$result) { 
                                echo generateMessage("Failed to update site name: {$result}",
                                                     "ERROR: Update Failed");
                            }
                        }
                        
                        // display success, and link to View Entries page
                        echo generateMessageWithLink("view-entries.php", "View Entries",
                                                     "Name updated successfully");
                    }

                    else {
                        echo generateMessage("Invalid submission");
                    }
                ?>
            </div>
            <div class="col-md-3 col-lg-3">
            </div>
        </div>
    </main>
</body>
</html>