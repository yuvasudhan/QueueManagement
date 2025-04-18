<?php
session_start();
include 'config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: user_login.php");
    exit();
}

if (isset($_GET['id'])) {
    $freeTokenId = $_GET['id'];
    $userId = $_SESSION['user_id'];

    // Check if the free token is available for booking (it should have status 'Cancelled')
    $query = "SELECT * FROM bookings WHERE id = ? AND status = 'Cancelled'";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $freeTokenId);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        
        // Book the free token by updating the status to 'Booked' and assigning it to the current user
        $updateQuery = "UPDATE bookings SET status = 'Booked', user_id = ? WHERE id = ?";
        $updateStmt = $conn->prepare($updateQuery);
        $updateStmt->bind_param("ii", $userId, $freeTokenId);
        
        if ($updateStmt->execute()) {
            echo "Free token successfully booked.";
        } else {
            echo "Error in booking the token.";
        }
    } else {
        echo "This token is no longer available for booking.";
    }
} else {
    echo "No token ID provided.";
}
?>