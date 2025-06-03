<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$isAdmin = isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin';
$adminName = $isAdmin ? $_SESSION['user_name'] : '';
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin - Pulmonology Clinic</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <style>
    .admin-navbar {
      background-color: #ff7a00 !important; 
    }
    .admin-navbar .nav-link,
    .admin-navbar .navbar-brand,
    .admin-navbar .btn {
      color: white !important; 
    }
    .admin-navbar .nav-link.active {
      font-weight: bold;
      text-decoration: underline;
    }
  </style>
</head>
<body>

<header class="shadow-sm sticky-top">
  <nav class="navbar navbar-expand-lg admin-navbar">
    <div class="container">
      <a class="navbar-brand d-flex align-items-center" href="dashboard.php">
        <i class="fa-solid fa-user-shield me-2 fs-2"></i>
        <span class="fs-4 fw-bold">Admin Panel</span>
      </a>

      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#adminNav">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse justify-content-end" id="adminNav">
        <ul class="navbar-nav align-items-center gap-4 fs-5">
          <li class="nav-item">
            <a class="nav-link <?= basename($_SERVER['PHP_SELF']) === 'dashboard.php' ? 'active' : '' ?>" href="dashboard.php">Dashboard</a>
          </li>
          <li class="nav-item">
            <a class="nav-link <?= basename($_SERVER['PHP_SELF']) === 'doctors.php' ? 'active' : '' ?>" href="doctors.php">Doctors</a>
          </li>
          <li class="nav-item">
            <a class="nav-link <?= basename($_SERVER['PHP_SELF']) === 'appointments.php' ? 'active' : '' ?>" href="appointments.php">Appointments</a>
          </li>
          <li class="nav-item">
            <a class="nav-link <?= basename($_SERVER['PHP_SELF']) === 'patients.php' ? 'active' : '' ?>" href="patients.php">Patients</a>
          </li>
          <li class="nav-item">
            <a class="btn btn-outline-light" href="../logout.php">Logout</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>
</header>
