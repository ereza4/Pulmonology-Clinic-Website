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
      background: linear-gradient(rgb(241, 189, 92, 0.6), rgba(255, 145, 145, 0.85)),
                  url('../assets/img/admin.png') no-repeat center center fixed;
      background-size: cover;
      font-family: 'Segoe UI', sans-serif;
    }

    .dashboard-wrapper {
      padding: 80px 0 50px;
      text-align: center;
    }

    .stat-cards {
      margin-top: 40px;
    }

    .card {
      border-left: 6px solid #f05a28;
      border-radius: 12px;
      padding: 25px;
      background-color: #fff;
      color: #333;
      box-shadow: 0 4px 12px rgba(0,0,0,0.08);
      transition: transform 0.2s ease;
    }

    .card:hover {
      transform: translateY(-5px);
    }

    .text1 {
      margin-top: 40px;
    }

    .quick-links {
      margin-top: 40px;
    }

    .quick-links a {
      margin: 10px;
      min-width: 180px;
    }

    .btn-orange {
      background-color: #f05a28;
      color: white;
      border: none;
    }

    .btn-orange:hover {
      background-color: #d94e1f;
    }
  </style>
</head>
<body>

<div class="container dashboard-wrapper">
  <h1 class="display-5 fw-bold text-dark">Welcome to the Admin Dashboard</h1>

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
    <p class="lead text-dark">Manage doctors, appointments, and patients efficiently from this control panel.</p>
  </div>

  <div class="quick-links">
    <a href="doctors.php" class="btn btn-orange btn-lg">Manage Doctors</a>
    <a href="appointments.php" class="btn btn-orange btn-lg">Manage Appointments</a>
    <a href="patients.php" class="btn btn-orange btn-lg">View Patients</a>
    <a href="../logout.php" class="btn btn-orange btn-lg">Logout</a>
  </div>
</div>

</body>
</html>
