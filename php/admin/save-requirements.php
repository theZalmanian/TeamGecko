<?php 
    // get access to all PHP helpers
    require_once("/home/geckosgr/public_html/initial.php");

    // store the current page's title for dynamic HTML generation
    $currPageTitle = "Save Requirements";

    /**
     * The RequirementID of the last requirement retrieved from DB
     */
	$lastRequirementID = 0; 

    /**
     * The last Clinical Requirement retrieved from the DB
     */
    $lastRequirement = array();
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
            <div class="col-md-2">
            </div>
            <div class="col-12 col-md-8">
                <?php
                    // if page was accessed from edit-requirements.php
                    if(isset($_POST["confirm-edits"]) && $_POST["confirm-edits"] === "confirmed") {
                        // loop through the data stored in _$POST
                        foreach ($_POST as $postKey => $postValue) {
                            // ignore confirmation flag stored in _$POST
                            if($postKey != "confirm-edits") {
                                // separate the key into ID and column name
                                $splitKey = explode("-", $postKey);
                                $currRequirementID = $splitKey[0];
                                $currColumnName = $splitKey[1];

                                // if the requirement received from _$POST has not been retrieved from DB
                                if($currRequirementID != $lastRequirementID) {
                                    // get the version of current requirement stored in DB
                                    $selectResult = executeQuery("SELECT *
                                                                  FROM ClinicalRequirements 
                                                                  WHERE RequirementID = '{$currRequirementID}'");

                                    // save it externally, and update ID tracker
                                    $lastRequirement = mysqli_fetch_assoc($selectResult);
                                    $lastRequirementID = $currRequirementID;
                                }

                                // only update if the value given for the current column 
                                // is not the same as the one stored in DB
                                if($lastRequirement[$currColumnName] != $postValue) {
                                    $result = executeQuery("UPDATE ClinicalRequirements 
                                                            SET {$currColumnName} = '{$postValue}' 
                                                            WHERE RequirementID = '{$currRequirementID}'");

                                    // if update failed, display which column failed to update, for which requirement
                                    if(!$result) { 
                                        echo generateMessage("Failed to update {$currColumnName} for " . $lastRequirement["RequirementTitle"],
                                                             "ERROR: Update Failed");
                                    }
                                }
                            }
                        }
                        
                        // display success, and link to Clinical Requirements page
                        echo generateMessageWithLink("/sprint-5/requirements.php", "Clinical Requirements",
                                                     "Changes were saved successfully");
                    }
                    else {
                        echo generateMessageWithLink("/php/admin/edit-requirements.php", "Edit Clinical Requirements",
                                                     "Please edit Clinical Requirements there and try again",
                                                     "ERROR: No changes received from Edit Requirements");
                    }
                ?>
            </div>
            <div class="col-md-2">
            </div>
        </div>
    </main>
</body>
</html>