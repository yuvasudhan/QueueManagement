<?php
session_start();
include 'config.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: user_login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch bookings for the logged-in user
$stmt = $conn->prepare("SELECT * FROM bookings WHERE user_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container">
    <h3>Your Bookings</h3>

    <?php if (isset($_GET['status'])): ?>
        <?php if ($_GET['status'] == 'cancelled'): ?>
            <div class="alert alert-success">Your token has been cancelled successfully.</div>
        <?php else: ?>
            <div class="alert alert-danger">There was an error processing your request.</div>
        <?php endif; ?>
    <?php endif; ?>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Service</th>
                <th>Status</th>
                <th>Created At</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($booking = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo $booking['id']; ?></td>
                <td><?php echo $booking['service']; ?></td>
                <td><?php echo $booking['status']; ?></td>
                <td><?php echo $booking['created_at']; ?></td>
                <td>
                    <a href="cancel_token.php?id=<?php echo $booking['id']; ?>" class="btn btn-danger btn-sm">Cancel</a>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

</body>
</html>