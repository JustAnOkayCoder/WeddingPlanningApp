<?php

// Database configuration
$servername = ; 
$username = ; 
$password = ; 
$dbname = ; 

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Prepare and bind
$stmt = $conn->prepare("INSERT INTO user_commutes (destination_name, travel_mode, distance, duration, destination_url, ts) VALUES (?, ?, ?, ?, ?, NOW())");
$stmt->bind_param("sssss", $destination_name, $travel_mode, $distance, $duration, $destination_url);

// Collect form data
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $destination_name = $_POST["destination_address"] ?? null;
    $travel_mode = $_POST["travel-mode"] ?? null;
    $distance = $_POST["distance"] ?? ''; 
    $duration = $_POST["duration"] ?? ''; 
    $destination_url = $_POST["destination_url"] ?? ''; 

    // gets the feilds
    if ($destination_name && $travel_mode) {
        
        if ($stmt->execute()) {
            echo "New record created successfully";
        } else {
            echo "Error: " . $stmt->error;
        }
    } else {
        echo "Error: Destination name and travel mode are required.";
    }

   
    $stmt->close();
    $conn->close();
}


?>
<script type="text/javascript">
    window.location = "confirmation.php"; // to prove it works
</script>
