<?php 
    // get access to all helper methods
    require_once("../php/helpers.php");

    // save the current pages name to session
    setCurrentPage("Edit Requirements");
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

                    // generate an accordion item for the row
                    echo $title . "<br><br>" . $notes . "<br><br>" . $option1 . "<br><br>" . $option2;
                    echo "<br><br>";
                }
            ?>
        </div>
    </main>
</body>
</html>