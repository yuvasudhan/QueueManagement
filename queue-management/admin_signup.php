<?php
session_start();
include('config.php'); // Database connection

// Predefined admin emails (only these emails can sign up as admins)
$allowed_emails = [
    "admin1@example.com",
    "admin2@example.com",
    "admin3@example.com",
    "admin4@example.com",
    "admin5@example.com"
];

if (isset($_POST['signup'])) {
    // Get input values
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Check if the email is allowed
    if (in_array($email, $allowed_emails)) {
        // Check if the admin already exists in the database
        $query = "SELECT * FROM admins WHERE email = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            echo "<script>alert('Admin with this email already exists!');</script>";
        } else {
            // Insert the new admin into the database
            $query = "INSERT INTO admins (email, password) VALUES (?, ?)";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("ss", $email, $password);
            $stmt->execute();

            echo "<script>alert('Admin successfully registered. Please login!');</script>";
            header("Location: admin_login.php");
            exit();
        }
    } else {
        echo "<script>alert('This email is not allowed for admin registration!');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Signup</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h2 class="text-center mt-5">Admin Signup</h2>
        <form method="post" class="w-50 mx-auto mt-4">
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <button type="submit" name="signup" class="btn btn-primary w-100">Signup</button>
        </form>
    </div>
</body>
</html>