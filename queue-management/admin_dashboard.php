<?php
session_start();
include('config.php'); // Ensure this points to your correct database connection file

// Fetch the number of bookings based on the status
$query = "SELECT status, COUNT(*) as count FROM bookings GROUP BY status";
$result = $conn->query($query);

$pending = 0;
$completed = 0;

while ($row = $result->fetch_assoc()) {
    if ($row['status'] == 'Pending') {
        $pending = $row['count'];
    } elseif ($row['status'] == 'Completed') {
        $completed = $row['count'];
    }
}

// Fetch all bookings (excluding cancelled bookings)
$bookingQuery = "SELECT id, user_name, service_name, status, created_at FROM bookings WHERE status != 'Cancelled'";
$bookingsResult = $conn->query($bookingQuery);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f4f4f4;
        }
        .container {
            margin-top: 30px;
        }
        h3 {
            color: #333;
        }
        .card {
            margin-bottom: 20px;
        }
        .table th, .table td {
            vertical-align: middle;
        }
        .status-label {
            font-weight: bold;
        }
    </style>
</head>
<body>

    <div class="container">
        <h3 class="text-center">Admin Dashboard</h3>
        
        <!-- Booking Statistics Summary -->
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Booking Status Overview</h4>
                    </div>
                    <div class="card-body">
                        <p><strong>Pending Bookings:</strong> <?php echo $pending; ?></p>
                        <p><strong>Completed Bookings:</strong> <?php echo $completed; ?></p>
                    </div>
                </div>
            </div>
        </div>

        <!-- View All Bookings -->
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4>All Bookings</h4>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>User Name</th>
                                    <th>Service</th>
                                    <th>Status</th>
                                    <th>Created At</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($row = $bookingsResult->fetch_assoc()): ?>
                                    <tr>
                                        <td><?php echo $row['id']; ?></td>
                                        <td><?php echo empty($row['user_name']) ? 'Unknown' : $row['user_name']; ?></td>
                                        <td><?php echo $row['service_name']; ?></td>
                                        <td class="status-label"><?php echo $row['status']; ?></td>
                                        <td><?php echo $row['created_at']; ?></td>
                                        <td>
                                            <?php if ($row['status'] != 'Cancelled'): ?>
                                                <a href="cancel_booking.php?id=<?php echo $row['id']; ?>" class="btn btn-danger">Cancel</a>
                                            <?php else: ?>
                                                <span class="text-muted">Cancelled</span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>