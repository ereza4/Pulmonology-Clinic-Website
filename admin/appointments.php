<?php
session_start();
require '../config.php';

if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}


if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $stmt = $conn->prepare("DELETE FROM appointments WHERE id = ?");
    $stmt->execute([$id]);
    header("Location: appointments.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_status'])) {
    $id = intval($_POST['appointment_id']);
    $newStatus = $_POST['status'];

    if (in_array($newStatus, ['pending', 'confirmed', 'cancelled'])) {
        $stmt = $conn->prepare("UPDATE appointments SET status = ? WHERE id = ?");
        $stmt->execute([$newStatus, $id]);
        $_SESSION['success'] = "Appointment status updated successfully.";
        header("Location: appointments.php");
        exit();
    }
}


$stmt = $conn->prepare("SELECT 
    a.id, a.appointment_date, a.appointment_time, a.message, a.status, a.created_at,
    u.name AS patient_name,
    d.name AS doctor_name
    FROM appointments a
    JOIN users u ON a.patient_id = u.id
    JOIN doctors d ON a.doctor_id = d.id
    ORDER BY a.appointment_date, a.appointment_time
");
$stmt->execute();
$appointments = $stmt->fetchAll(PDO::FETCH_ASSOC);

$success = '';
if (isset($_SESSION['success'])) {
    $success = $_SESSION['success'];
    unset($_SESSION['success']);
}
?>

<?php include 'inc/admin_header.php'; ?>

<style>
    .badge {
        font-size: 0.85rem;
        padding: 0.4em 0.6em;
    }
    select.form-select-sm {
        font-size: 0.85rem;
        padding: 2px 8px;
    }
    .btn-sm {
        font-size: 0.8rem;
        padding: 2px 8px;
    }
</style>

<div class="container mt-5">
    <h2 class="text-center mb-4 text-orange fw-bold">Manage Appointments</h2>

    <?php if ($success): ?>
        <div id="successMessage" class="alert alert-success text-center"><?= htmlspecialchars($success) ?></div>
    <?php endif; ?>

    <div class="table-responsive">
        <table class="table table-bordered table-striped align-middle">
            <thead class="table-warning text-center">
                <tr>
                    <th>#</th>
                    <th>Patient</th>
                    <th>Doctor</th>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Message</th>
                    <th>Status</th>
                    <th>Created</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($appointments): ?>
                    <?php foreach ($appointments as $index => $appt): ?>
                        <tr>
                            <td class="text-center"><?= $index + 1 ?></td>
                            <td><?= htmlspecialchars($appt['patient_name']) ?></td>
                            <td><?= htmlspecialchars($appt['doctor_name']) ?></td>
                            <td class="text-center"><?= htmlspecialchars($appt['appointment_date']) ?></td>
                            <td class="text-center"><?= htmlspecialchars($appt['appointment_time']) ?></td>
                            <td><?= htmlspecialchars($appt['message']) ?></td>
                            <td>
                                <form method="post" class="d-flex align-items-center" style="gap: 6px;">
                                    <input type="hidden" name="appointment_id" value="<?= $appt['id'] ?>">
                                    <input type="hidden" name="update_status" value="1">
                                    <select name="status" class="form-select form-select-sm">
                                        <option value="pending" <?= $appt['status'] === 'pending' ? 'selected' : '' ?>>Pending</option>
                                        <option value="confirmed" <?= $appt['status'] === 'confirmed' ? 'selected' : '' ?>>Confirmed</option>
                                        <option value="cancelled" <?= $appt['status'] === 'cancelled' ? 'selected' : '' ?>>Cancelled</option>
                                    </select>
                                    <button class="btn btn-sm btn-outline-primary">Save</button>
                                </form>
                            </td>
                            <td class="text-center"><?= htmlspecialchars($appt['created_at']) ?></td>
                            <td class="text-center">
                                <a href="appointments.php?delete=<?= $appt['id'] ?>" class="btn btn-sm btn-danger"
                                   onclick="return confirm('Are you sure you want to delete this appointment?')">
                                   Delete
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td colspan="9" class="text-center">No appointments found.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<script>
  setTimeout(() => {
    const msg = document.getElementById('successMessage');
    if (msg) {
      msg.style.transition = 'opacity 0.5s ease';
      msg.style.opacity = '0';
      setTimeout(() => msg.remove(), 500);
    }
  }, 3000);
</script>

