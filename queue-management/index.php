<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Queue Management System</title>
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
  <style>
    /* Apply gradient background */
    body {
      background: linear-gradient(45deg, #ff7e5f, #feb47b, #6a11cb, #2575fc);
      background-size: 400% 400%;
      animation: gradientBG 15s ease infinite;
      height: 100vh;
      font-family: 'Arial', sans-serif;
    }

    /* Smooth animation of the background gradient */
    @keyframes gradientBG {
      0% { background-position: 0% 50%; }
      50% { background-position: 100% 50%; }
      100% { background-position: 0% 50%; }
    }

    .container {
      color: white;
      text-align: center;
      padding-top: 100px;
    }

    .btn-custom {
      padding: 15px 30px;
      font-size: 18px;
      border-radius: 25px;
    }

    .card-glass {
      background: rgba(255, 255, 255, 0.4);
      padding: 40px;
      margin: 50px auto;
      border-radius: 10px;
      width: 60%;
    }
    
    h1 {
      font-size: 50px;
      margin-bottom: 20px;
    }

    h4 {
      font-size: 25px;
      margin-bottom: 30px;
    }

  </style>
</head>
<body>

  <!-- Main container -->
  <div class="container">
    <div class="row">
      <!-- User Side -->
      <div class="col-md-6">
        <div class="card-glass">
          <h1>User Portal</h1>
          <h4>Access queue bookings and manage your tokens efficiently!</h4>
          <a href="user_login.php" class="btn btn-light btn-lg btn-custom">User Login</a><br>
          <a href="user_signup.php" class="btn btn-outline-light btn-lg btn-custom">User Signup</a>
        </div>
      </div>

      <!-- Admin Side -->
      <div class="col-md-6">
        <div class="card-glass">
          <h1>Admin Portal</h1>
          <h4>Manage bookings and view reports!</h4>
          <a href="admin_login.php" class="btn btn-light btn-lg btn-custom">Admin Login</a><br>
          <a href="admin_signup.php" class="btn btn-outline-light btn-lg btn-custom">Admin Signup</a>
        </div>
      </div>
    </div>
  </div>

  <!-- Bootstrap JS -->
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>