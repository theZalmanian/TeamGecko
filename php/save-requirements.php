<?php 
    // get access to all PHP helpers
    require_once("/home/geckosgr/public_html/initial.php");

    // store the current page's title for dynamic HTML generation
    $currPageTitle = "Save Requirements";
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
           <div>
                <pre>
                    <?php 
                        // echo var_dump($_POST) 
                    ?>
                </pre>

                <?php
                    // if page was accessed from edit-requirements.php
                    if(isset($_POST["confirm-edits"]) && $_POST["confirm-edits"] === "confirmed") {
                        $debugCount = 0;
                        // loop through the post data
                        foreach ($_POST as $currKey => $currValue) {
                            if($currKey != "confirm-edits") {
                                $debugCount++;
                                // separate the key into ID and column
                                $splitKey = explode("-", $currKey);
                                $currRequirementID = $data[0];
                                $currColumnName = $data[1];

                                // get the version of current requirement stored in DB
                                $selectResult = executeQuery("SELECT * 
                                                              FROM ClinicalRequirements 
                                                              WHERE RequirementID = {$currRequirementID}");

                                $requirementInDB = mysqli_fetch_assoc($selectResult);

                                // only update if the current value is not the same as that stored in DB
                                if($requirementInDB[$currColumnName] != $currValue) {
                                    // update the column with the given value
                                    $result = executeQuery("UPDATE ClinicalRequirements 
                                                            SET {$currColumnName} = '{$currValue}' 
                                                            WHERE RequirementID = {$currRequirementID}");

                                    // display result
                                    if ($result) {
                                        echo "<p>({$debugCount}) Update successful!</p>";
                                    } 
                                    
                                    else {
                                        echo "<p>Update failed: " . mysqli_error($dbConnection) . "</p>";
                                    }
                                }
                            }
                        }
                    }
                ?>
           </div>
        </div>
    </main>
</body>
</html>