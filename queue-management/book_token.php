<?php
session_start();
include('config.php');

if (!isset($_SESSION['user_id'])) {
    header("Location: user_login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$user_name = $_SESSION['user_name'] ?? '';

// Check if user already booked an active token
$checkQuery = "SELECT * FROM bookings WHERE user_id = ? AND status != 'Cancelled'";
$stmt = $conn->prepare($checkQuery);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    echo "<script>alert('You have already booked a token.');window.location.href='user_dashboard.php';</script>";
    exit();
}

// Fetch services
$services = ["Mobile Repair", "Software Update", "Health Checkup", "License", "General Inquiry"];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $service_name = $_POST['service_name'];

    $insert = $conn->prepare("INSERT INTO bookings (user_id, user_name, service_name, status, created_at) VALUES (?, ?, ?, 'Pending', NOW())");
    $insert->bind_param("iss", $user_id, $user_name, $service_name);
    if ($insert->execute()) {
        echo "<script>alert('Token booked successfully!');window.location.href='user_dashboard.php';</script>";
    } else {
        echo "<script>alert('Error booking token.');window.location.href='user_dashboard.php';</script>";
    }
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Book Token</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <h2 class="text-center mb-4">Book a Token</h2>
    <form method="POST">
        <div class="mb-3">
            <label for="service_name" class="form-label">Select Service</label>
            <select class="form-control" name="service_name" required>
                <?php foreach ($services as $service): ?>
                    <option value="<?= $service ?>"><?= $service ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <button class="btn btn-primary">Book Token</button>
    </form>
</div>
</body>
</html>