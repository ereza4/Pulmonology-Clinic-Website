<?php
session_start();
require 'config.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($email && $password) {
        $stmt = $conn->prepare("SELECT id, name, password, role FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            $_SESSION['user_role'] = $user['role'];

            if ($user['role'] === 'admin') {
                header("Location: admin/dashboard.php");
                exit();
            } else {
                header("Location: index.php");
                exit();
            }
        } else {
            $error = "Invalid email or password.";
        }
    } else {
        $error = "Please fill in all fields.";
    }
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login - Pulmonology Clinic</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link rel="stylesheet" href="assets/css/style.css">
  <style>
    html, body {
      height: 100%;
      margin: 0;
    }
    body {
      background: url('/assets/img/login.jpg') no-repeat center center fixed;
      background-size: cover;
      display: flex;
      align-items: center;
    }
    .login-container {
      max-width: 450px;
      padding: 40px;
      background-color: white;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
      border-radius: 10px;
    }
    .btn-orange {
      background-color: #ff7a00;
      color: white;
    }
    .btn-orange:hover {
      background-color: #e96c00;
      color: white;
    }
  </style>
</head>
<body>

  <div class="container py-5">
    <div class="row">
      <div class="col-md-6">
        <div class="login-container">
          <h2 class="mb-4 text-orange text-center">Login to Your Account</h2>

          <?php if ($error): ?>
            <div class="alert alert-danger"> <?= $error ?> </div>
          <?php endif; ?>

          <form action="" method="post">
            <div class="mb-3">
              <label for="email" class="form-label">Email address</label>
              <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="mb-3">
              <label for="password" class="form-label">Password</label>
              <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <div class="d-grid mb-3">
              <button type="submit" class="btn btn-orange">Login</button>
            </div>
            <p class="text-center">Don't have an account? <a href="register.php" class="text-orange">Register here</a></p>
          </form>
        </div>
      </div>
    </div>
  </div>

</body>
</html>
