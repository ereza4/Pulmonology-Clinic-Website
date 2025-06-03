<?php
session_start();
require '../config.php';

if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}

$totalDoctors = $conn->query("SELECT COUNT(*) FROM doctors")->fetchColumn();
$totalUsers = $conn->query("SELECT COUNT(*) FROM users WHERE role = 'patient'")->fetchColumn();
$totalAppointments = $conn->query("SELECT COUNT(*) FROM appointments")->fetchColumn();
?>
<?php include 'inc/admin_header.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin Dashboard</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    html, body {
      margin: 0;
      padding: 0;
      height: 100%;
      background: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.6)),
                  url('../assets/img/admin.png') no-repeat center center fixed;
      background-size: cover;
      color: white;
    }

    .dashboard-wrapper {
      padding: 100px 0 50px;
      text-align: center;
    }

    .stat-cards {
      margin-top: 40px;
    }

    .card {
      border-left: 5px solid orange;
      border-radius: 10px;
      padding: 20px;
      background-color: rgba(255, 255, 255, 0.9);
      color: #333;
    }
    .text1{
      margin: 60px;
    }
  </style>
</head>
<body>

<div class="container dashboard-wrapper">
  <h1 class="display-4 fw-bold">Welcome to the Admin Dashboard</h1>

  <div class="row stat-cards">
    <div class="col-md-4">
      <div class="card shadow-sm text-center">
        <h4>Total Doctors</h4>
        <p class="display-6"><?= $totalDoctors ?></p>
      </div>
    </div>
    <div class="col-md-4">
      <div class="card shadow-sm text-center">
        <h4>Total Patients</h4>
        <p class="display-6"><?= $totalUsers ?></p>
      </div>
    </div>
    <div class="col-md-4">
      <div class="card shadow-sm text-center">
        <h4>Total Appointments</h4>
        <p class="display-6"><?= $totalAppointments ?></p>
      </div>
    </div>
  </div>
  <div class="text1">
    <p class="lead">Manage doctors, appointments and patients efficiently.</p>
  </div>
</div>

</body>
</html>

