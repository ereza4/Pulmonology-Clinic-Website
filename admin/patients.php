<?php
session_start();
require '../config.php';

if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}

$stmt = $conn->prepare("SELECT id, name, email, created_at FROM users WHERE role = 'patient' ORDER BY created_at DESC");
$stmt->execute();
$patients = $stmt->fetchAll(PDO::FETCH_ASSOC);

include 'inc/admin_header.php';
?>

<div class="container my-5">
  <h2 class="mb-4 text-center text-orange">Registered Patients</h2>

  <?php if (count($patients) > 0): ?>
    <div class="table-responsive">
      <table class="table table-striped table-bordered align-middle">
        <thead class="table-warning text-center">
          <tr>
            <th>#</th>
            <th>Full Name</th>
            <th>Email</th>
            <th>Registered At</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($patients as $index => $patient): ?>
            <tr>
              <td class="text-center"><?= $index + 1 ?></td>
              <td><?= htmlspecialchars($patient['name']) ?></td>
              <td><?= htmlspecialchars($patient['email']) ?></td>
              <td><?= date('d M Y, H:i', strtotime($patient['created_at'])) ?></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  <?php else: ?>
    <div class="alert alert-info text-center">
      No patients found.
    </div>
  <?php endif; ?>
</div>

