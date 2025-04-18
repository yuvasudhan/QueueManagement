<?php
session_start();
include('config.php'); // Database connection

if (isset($_POST['login'])) {
    // Get input values
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Check the database for admin credentials
    $query = "SELECT * FROM admins WHERE email = ? AND password = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ss", $email, $password);
    $stmt->execute();
    $result = $stmt->get_result();
    $admin = $result->fetch_assoc();

    // If a matching admin record is found
    if ($admin) {
        $_SESSION['admin_id'] = $admin['id'];  // Store admin ID in session
        header("Location: admin_dashboard.php"); // Redirect to the admin dashboard
        exit();
    } else {
        echo "<script>alert('Invalid login credentials');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h2 class="text-center mt-5">Admin Login</h2>
        <form method="post" class="w-50 mx-auto mt-4">
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <button type="submit" name="login" class="btn btn-primary w-100">Login</button>
        </form>
    </div>
</body>
</html>