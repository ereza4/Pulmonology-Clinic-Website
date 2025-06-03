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
?>

<?php include 'inc/admin_header.php'; ?>

<div class="container mt-5">
    <h2 class="text-center mb-4 text-orange">Manage Appointments</h2>

    <table class="table table-bordered table-striped">
        <thead class="table-warning">
            <tr>
                <th>#</th>
                <th>Patient</th>
                <th>Doctor</th>
                <th>Date</th>
                <th>Time</th>
                <th>Message</th>
                <th>Status</th>
                <th>Created At</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($appointments): ?>
                <?php foreach ($appointments as $index => $appt): ?>
                    <tr>
                        <td><?= $index + 1 ?></td>
                        <td><?= htmlspecialchars($appt['patient_name']) ?></td>
                        <td><?= htmlspecialchars($appt['doctor_name']) ?></td>
                        <td><?= htmlspecialchars($appt['appointment_date']) ?></td>
                        <td><?= htmlspecialchars($appt['appointment_time']) ?></td>
                        <td><?= htmlspecialchars($appt['message']) ?></td>
                        <td>
                            <span class="badge 
                                <?= $appt['status'] === 'confirmed' ? 'bg-success' : ($appt['status'] === 'cancelled' ? 'bg-danger' : 'bg-secondary') ?>">
                                <?= ucfirst($appt['status']) ?>
                            </span>
                        </td>
                        <td><?= htmlspecialchars($appt['created_at']) ?></td>
                        <td>
                            <a href="appointments.php?delete=<?= $appt['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this appointment?')">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr><td colspan="9" class="text-center">No appointments found.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

