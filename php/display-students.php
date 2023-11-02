<?php
    // connect to DB 
    require '/home/geckosgr/db-connect.php';

    // setup SELECT Query
    $selectAllStudents = "SELECT * FROM student";

    // execute SELECT Query
    $allStudents = @mysqli_query($dbConnection, $selectAllStudents);

    // run through given rows
    while ($currRow = mysqli_fetch_assoc($allStudents)) {
        // get data in each column
        $sid = $currRow["sid"];
        $firstName = $currRow["first"];
        $lastName = $currRow["last"];
        $birthdate = $currRow["birthdate"];

        // display the current student's data
        echo "<p>({$sid}) {$firstName} {$lastName} - {$birthdate}</p>";
    }
