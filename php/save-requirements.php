<?php 
    // get access to all PHP helpers
    require_once("/home/geckosgr/public_html/initial.php");

    // store the current page's title for dynamic HTML generation
    $currPageTitle = "Save Requirements";

	$lastRequirementID = -1;

    $requirementInDB = array();
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
            <div class="col-md-2 col-lg-4">
            </div>
            <div class="col-12 col-md-8 col-lg-4">
                <?php
                    $updateCount = "";
                    // if page was accessed from edit-requirements.php
                    if(isset($_POST["confirm-edits"]) && $_POST["confirm-edits"] === "confirmed") {
                        // loop through the post data
                        foreach ($_POST as $currKey => $currValue) {
                            if($currKey != "confirm-edits") {
                                // separate the key into ID and column
                                $splitKey = explode("-", $currKey);
                                $currRequirementID = $splitKey[0];
                                $currColumnName = $splitKey[1];

                                if($currRequirementID != $lastRequirementID) {
                                    // get the version of current requirement stored in DB
                                    $selectResult = executeQuery("SELECT *
                                                                  FROM ClinicalRequirements 
                                                                  WHERE RequirementID = '{$currRequirementID}'");

                                    $requirementInDB = mysqli_fetch_assoc($selectResult);

                                    $lastRequirementID = $currRequirementID;
                                }

                                // only update if the current value is not the same as that stored in DB
                                if($requirementInDB[$currColumnName] != $currValue) {
                                    // update the column with the given value
                                    executeQuery("UPDATE ClinicalRequirements 
                                                  SET {$currColumnName} = '{$currValue}' 
                                                  WHERE RequirementID = '{$currRequirementID}'");
                                }
                            }
                        }
                        
                        echo displayMessageWithLink("/sprint-4/requirements.php", "Clinical Requirements",
                                                    "All changes were saved successfully");
                    
                    }
                ?>
            </div>
            <div class="col-md-2 col-lg-4">
            </div>
        </div>
    </main>
</body>
</html>