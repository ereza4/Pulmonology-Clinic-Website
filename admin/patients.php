<?php
session_start();
require '../config.php';

if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}


if (isset($_GET['toggle'])) {
    $id = intval($_GET['toggle']);
    $stmt = $conn->prepare("UPDATE users SET is_active = NOT is_active WHERE id = ? AND role = 'patient'");
    $stmt->execute([$id]);
    header("Location: patients.php");
    exit();
}


$stmt = $conn->prepare("SELECT id, name, email, created_at, is_active FROM users WHERE role = 'patient' ORDER BY created_at DESC");
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
            <th>Status</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($patients as $index => $patient): ?>
            <tr>
              <td class="text-center"><?= $index + 1 ?></td>
              <td><?= htmlspecialchars($patient['name']) ?></td>
              <td><?= htmlspecialchars($patient['email']) ?></td>
              <td><?= date('d M Y, H:i', strtotime($patient['created_at'])) ?></td>
              <td class="text-center">
                <span class="badge <?= $patient['is_active'] ? 'bg-success' : 'bg-danger' ?>">
                  <?= $patient['is_active'] ? 'Active' : 'Inactive' ?>
                </span>
              </td>
              <td class="text-center">
                <a href="patients.php?toggle=<?= $patient['id'] ?>" 
                   class="btn btn-sm <?= $patient['is_active'] ? 'btn-danger' : 'btn-success' ?>"
                   onclick="return confirm('Are you sure you want to <?= $patient['is_active'] ? 'deactivate' : 'activate' ?> this account?')">
                  <?= $patient['is_active'] ? 'Deactivate' : 'Activate' ?>
                </a>
              </td>
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
