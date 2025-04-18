<?php
session_start();
include('config.php');

if (!isset($_SESSION['user_id'])) {
    header("Location: user_login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION['user_id'];
    $user_name = $_SESSION['user_name'];  // Make sure user_name is set during login
    $token_id = $_POST['token_id'];

    // Update the selected token
    $sql = "UPDATE booking 
            SET user_id = ?, user_name = ?, is_free = 0, status = 'Booked'
            WHERE id = ? AND is_free = 1";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("isi", $user_id, $user_name, $token_id);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        header("Location: user_dashboard.php?success=1");
    } else {
        echo "Failed to book token or token already booked.";
    }
}
?>