<?php 
    // error_reporting(E_ALL);
    // ini_set('display_errors', 1);
    
    // get access to all helper methods
    require_once("../php/helpers.php");

    // save the current pages name to session
    setCurrentPage("Save Requirements");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php 
        // include standard nursing header metadata
        require_once("../php/layouts/nursing-metadata.php");
    ?>
</head>
<body>
	<main class="container mt-3">
		<div class="row">
           <div>
                <pre><?php echo var_dump($_POST) ?></pre>

                <?php
                    // if page was accessed from edit-requirements.php
                    if(isset($_POST["confirm-edits"]) && $_POST["confirm-edits"] === "confirmed") {
                        // loop through the post data
                        foreach ($_POST as $key => $value) {
                            if($key != "confirm-edits") {
                                $data = explode("-", $key);

                                $requirementID = $data[0];
                                $column = $data[1];

                                echo "<h1>{$requirementID}</h1>";
                                echo "<h1>{$column}</h1>";

                                // connect to database
                                require_once('/home/geckosgr/db-connect-nursing.php');
                                
                                // perform the update query
                                $updateQuery = "UPDATE ClinicalRequirements SET $column = '$value' WHERE RequirementID = $requirementID";

                                echo $updateQuery;
                                echo "<br><br>";

                                // execute the query
                                $result = mysqli_query($dbConnection, $updateQuery);

                                if ($result) {
                                    echo "<p>Update successful!</p>";
                                } else {
                                    echo "<p>Update failed: " . mysqli_error($dbConnection) . "</p>";
                                }
                            }
                        }
                    }

                    function updateRequirement($requirementID, $column, $value) {
                        // connect to database
                        require_once('/home/geckosgr/db-connect-nursing.php');
                        
                        // perform the update query
                        $updateQuery = "UPDATE ClinicalRequirements SET $column = '$value' WHERE RequirementID = $requirementID";

                        echo $updateQuery;
                        echo "<br><br>";

                        // execute the query
                        $result = mysqli_query($dbConnection, $updateQuery);

                        if ($result) {
                            echo "<p>Update successful!</p>";
                        } else {
                            echo "<p>Update failed: " . mysqli_error($dbConnection) . "</p>";
                        }
                    }
                ?>
           </div>
        </div>
    </main>
</body>
</html>