<?php
session_start();
include('config.php');

if (!isset($_POST['token_id']) || !isset($_SESSION['user_id'])) {
    header("Location: user_dashboard.php");
    exit();
}

$token_id = $_POST['token_id'];
$user_id = $_SESSION['user_id'];

// Make sure the token belongs to the logged-in user
$query = "SELECT * FROM booking WHERE id = ? AND user_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("ii", $token_id, $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 1) {
    // Update status to Cancelled and set is_free to 1 (so others can book it)
    $update = "UPDATE booking SET status = 'Cancelled', is_free = 1 WHERE id = ?";
    $stmt_update = $conn->prepare($update);
    $stmt_update->bind_param("i", $token_id);
    $stmt_update->execute();
}

header("Location: user_dashboard.php");
exit();
?>