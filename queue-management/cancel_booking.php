<?php
include('config.php');
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: user_login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$booking_id = $_GET['id'] ?? 0;

// Fetch booking
$stmt = $conn->prepare("SELECT * FROM bookings WHERE id = ? AND user_id = ?");
$stmt->bind_param("ii", $booking_id, $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo "<script>alert('Invalid token!');window.location.href='user_dashboard.php';</script>";
    exit();
}

$row = $result->fetch_assoc();
$created_time = strtotime($row['created_at']);
$current_time = time();

if (($created_time + 3600) > $current_time) {
    // Allow cancel
    $cancel = $conn->prepare("UPDATE bookings SET status = 'Cancelled' WHERE id = ?");
    $cancel->bind_param("i", $booking_id);
    if ($cancel->execute()) {
        echo "<script>alert('Token cancelled successfully.');window.location.href='user_dashboard.php';</script>";
    } else {
        echo "<script>alert('Error cancelling token.');window.location.href='user_dashboard.php';</script>";
    }
} else {
    echo "<script>alert('Token cannot be cancelled after 1 hour.');window.location.href='user_dashboard.php';</script>";
}
?>