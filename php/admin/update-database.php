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
            <?php 
                if($_SESSION["Admin"]) {
                    if($_GET["operation"] === "edit-requirements") { ?>
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
            <?php 
                    } 

                    elseif($_GET["operation"] === "edit-site-name") {
            ?>
                        <div class="col-12 col-md-8">
                            <?php
                                if( isset($_POST["old-name"]) && isset($_POST["new-name"]) ) {
                                    // get the old and new clinical site names
                                    $oldSiteName = $_POST["old-name"];
                                    $newSiteName = $_POST["new-name"];
            
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
            <?php 
                    }   
            
                    elseif($_GET["operation"] === "add-requirement") { 
            ?>
                        <div class="col-12 col-md-8">
                            <?php
                                $result = executeQuery("INSERT INTO ClinicalRequirements(RequirementTitle, RequirementNotes, Option1, Option2) 
                                                            VALUES ('{$_POST["RequirementTitle"]}', '{$_POST["RequirementNotes"]}'
                                                                        , '{$_POST["Option1"]}', '{$_POST["Option2"]}')");
                                
                            
                                if(!$result) { 
                                    echo generateMessage("Failed to add requirement: {$result}",
                                                        "ERROR: Insert Failed");
                                }
                                
                                // display success, and link to View Entries page
                                echo generateMessageWithLink("edit-requirements.php", "Edit Requirements",
                                                            "Requirement added successfully");
                            ?>
                        </div>
            <?php 
                    }
                } 

                else {
					echo "<div class='col-12 col-md-8'>" 
							. displayAccessDenied("login.php", "Login") .
						"</div>";
				}
            ?>
            <div class="col-md-2">
            </div>
        </div>
    </main>
</body>
</html>