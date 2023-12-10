<?php
// updatePoints.php

// Include the database connection file
include "connect.php";

// Read JSON data sent from the client-side
$data = json_decode(file_get_contents("php://input"));

if ($data) {
    // Sanitize and validate input data
    $userId = mysqli_real_escape_string($connection, $data->userId);
    $points = mysqli_real_escape_string($connection, $data->points);

    // Update user points in the database
    $updatePointsQuery = "UPDATE users SET points = $points WHERE id = $userId";
    $result = mysqli_query($connection, $updatePointsQuery);

    if ($result) {
        // Return a success message or additional data if needed
        echo json_encode(array("success" => true, "message" => "Points updated successfully"));
    } else {
        // Return an error message
        echo json_encode(array("success" => false, "message" => "Error updating points"));
    }
} else {
    // Return an error message if no valid JSON data is received
    echo json_encode(array("success" => false, "message" => "Invalid JSON data"));
}

// Close the database connection
mysqli_close($connection);
?>
