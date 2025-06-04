<?php
require 'config.php';

$isLoggedIn = isset($_SESSION['user_id']) && (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin');
$userName = $isLoggedIn ? $_SESSION['user_name'] : '';
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Pulmonology Clinic</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

<header class="bg-white shadow-sm sticky-top">
  <nav class="navbar navbar-expand-lg navbar-light custom-navbar">
    <div class="container">
    
      <a class="navbar-brand d-flex align-items-center brand-orange" href="index.php">
        <i class="fa-solid fa-lungs me-2 fs-2"></i>
        <span class="fs-4 fw-bold">Pulmonology Clinic</span>
      </a>

      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
        <ul class="navbar-nav align-items-center gap-4 fs-5">
          <li class="nav-item">
            <a class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'index.php' ? 'active' : '' ?>" href="index.php">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'about.php' ? 'active' : '' ?>" href="about.php">About</a>
          </li>
          <li class="nav-item">
            <a class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'staff.php' ? 'active' : '' ?>" href="staff.php">Staff</a>
          </li>
          <li class="nav-item">
            <a class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'contact.php' ? 'active' : '' ?>" href="contact.php">Contact</a>
          </li>
          
          <?php if ($isLoggedIn): ?>
            <li class="nav-item">
              <a class="btn btn-outline-danger" href="logout.php">Logout</a>
            </li>
          <?php else: ?>
            <li class="nav-item">
              <a class="btn btn-orange" href="login.php">Login</a>
            </li>
          <?php endif; ?>
        </ul>
      </div>
    </div>
  </nav>
</header>
