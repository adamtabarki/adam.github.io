<?php
// redeemPoints.php

// Include the database connection file
include "connect.php";

// Read JSON data sent from the client-side
$data = json_decode(file_get_contents("php://input"));

if ($data) {
    // Sanitize and validate input data
    $userId = mysqli_real_escape_string($connection, $data->userId);
    $pointsToRedeem = mysqli_real_escape_string($connection, $data->pointsToRedeem);

    // Perform the points redemption logic
    $getUserPointsQuery = "SELECT points FROM users WHERE id = $userId";
    $result = mysqli_query($connection, $getUserPointsQuery);

    if ($result) {
        $row = mysqli_fetch_assoc($result);
        $userPoints = $row["points"];

        // Check if the user has enough points to redeem
        if ($userPoints >= $pointsToRedeem) {
            // Deduct redeemed points from the user's total points
            $newPoints = $userPoints - $pointsToRedeem;
            $updatePointsQuery = "UPDATE users SET points = $newPoints WHERE id = $userId";
            $updateResult = mysqli_query($connection, $updatePointsQuery);

            if ($updateResult) {
                // Return a success message or additional data if needed
                echo json_encode(array("success" => true, "message" => "Points redeemed successfully"));
            } else {
                // Return an error message
                echo json_encode(array("success" => false, "message" => "Error updating points"));
            }
        } else {
            // Return an error message if the user has insufficient points
            echo json_encode(array("success" => false, "message" => "Insufficient points"));
        }
    } else {
        // Return an error message if there's an issue retrieving user points
        echo json_encode(array("success" => false, "message" => "Error retrieving user points"));
    }
} else {
    // Return an error message if no valid JSON data is received
    echo json_encode(array("success" => false, "message" => "Invalid JSON data"));
}

// Close the database connection
mysqli_close($connection);
?>