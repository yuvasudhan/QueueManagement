<?php
session_start();
include('config.php');

if (!isset($_SESSION['user_id'])) {
    header("Location: user_login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$user_name = $_SESSION['user_name'] ?? '';

$query = "SELECT * FROM bookings WHERE user_id = ? AND status != 'Cancelled' ORDER BY created_at DESC";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$tokens = $stmt->get_result();
?>

<!DOCTYPE html>
<html>
<head>
    <title>User Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <h2 class="text-center">Welcome, <?= htmlspecialchars($user_name) ?></h2>
    <div class="text-end mb-3">
        <a href="book_token.php" class="btn btn-success">Book a Token</a>
    </div>

    <h4>Your Booked Tokens</h4>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Token ID</th>
                <th>Service</th>
                <th>Status</th>
                <th>Created At</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($tokens->num_rows > 0): ?>
                <?php while ($row = $tokens->fetch_assoc()): ?>
                    <tr>
                        <td><?= $row['id'] ?></td>
                        <td><?= $row['service_name'] ?></td>
                        <td><?= $row['status'] ?></td>
                        <td><?= $row['created_at'] ?></td>
                        <td>
                            <?php
                            $created_time = strtotime($row['created_at']);
                            $current_time = time();
                            $time_diff = ($created_time + 3600) > $current_time;
                            ?>
                            <?php if ($row['status'] == 'Pending' && $time_diff): ?>
                                <a href="cancel_booking.php?id=<?= $row['id'] ?>" class="btn btn-danger btn-sm">Cancel</a>
                            <?php else: ?>
                                <span class="text-muted">Not cancellable</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr><td colspan="5" class="text-center">No tokens found.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
</body>
</html>