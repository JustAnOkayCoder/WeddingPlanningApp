<?php

// Create a connection
$DBConnect = mysqli_connect();

// Check connection
if ($DBConnect->connect_error) {
    die("Connection failed: " . $DBConnect->connect_error);
} else {
    $TableName = "contact";
    $fields = "Name, Email, Event, Message";  

    // Get form data
    $Name = $_POST['Name'];
    $Email = $_POST['Email'];
    $Event = $_POST['Event'];
    $Message = $_POST['Message'];

    // Prepare SQL query
    $SQLstring = "INSERT INTO `$TableName` (`Name`, `Email`, `Event`, `Message`) 
                  VALUES ('$Name', '$Email', '$Event', '$Message')";

    // Execute the query
    if (mysqli_query($DBConnect, $SQLstring)) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $SQLstring . "<br>" . mysqli_error($DBConnect);
    }

    // Close the connection
    $DBConnect->close();
}
?>
