<?php
require 'config.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user_id'];
$appointments = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cancel_id'])) {
    $cancel_id = intval($_POST['cancel_id']);

    $checkStmt = $conn->prepare("SELECT id FROM appointments WHERE id = ? AND patient_id = ?");
    $checkStmt->execute([$cancel_id, $user_id]);

    if ($checkStmt->fetch()) {
        $cancelStmt = $conn->prepare("UPDATE appointments SET status = 'cancelled' WHERE id = ?");
        $cancelStmt->execute([$cancel_id]);
        header("Location: my_appointments.php");
        exit();
    }
}

try {
    $stmt = $conn->prepare("
        SELECT 
            a.id,
            a.appointment_date,
            a.appointment_time,
            a.status,
            a.message,
            d.name AS doctor_name
        FROM 
            appointments a
        JOIN 
            doctors d ON a.doctor_id = d.id
        WHERE 
            a.patient_id = ?
        ORDER BY 
            a.appointment_date DESC, a.appointment_time DESC
    ");
    $stmt->execute([$user_id]);
    $appointments = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error fetching appointments: " . $e->getMessage());
}
?>

<?php include 'includes/header.php'; ?>

<section class="py-5">
  <div class="container">
    <h2 class="text-center text-orange fw-bold mb-4">My Appointments</h2>

    <?php if (count($appointments) === 0): ?>
      <div class="alert alert-info text-center">You have no appointments yet.</div>
    <?php else: ?>
      <div class="table-responsive">
        <table class="table table-bordered table-striped align-middle">
          <thead class="table-warning text-center">
            <tr>
              <th>Date</th>
              <th>Time</th>
              <th>Doctor</th>
              <th>Status</th>
              <th>Message</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($appointments as $app): ?>
              <tr>
                <td><?= htmlspecialchars($app['appointment_date']) ?></td>
                <td><?= htmlspecialchars($app['appointment_time']) ?></td>
                <td><?= htmlspecialchars($app['doctor_name']) ?></td>
                <td class="text-center">
                  <span class="badge 
                    <?= $app['status'] === 'confirmed' ? 'bg-success' : ($app['status'] === 'cancelled' ? 'bg-danger' : 'bg-secondary') ?>">
                    <?= ucfirst($app['status']) ?>
                  </span>
                </td>
                <td><?= nl2br(htmlspecialchars($app['message'])) ?></td>
                <td class="text-center">
                  <?php if ($app['status'] === 'pending'): ?>
                    <form method="post" onsubmit="return confirm('Are you sure you want to cancel this appointment?');">
                      <input type="hidden" name="cancel_id" value="<?= $app['id'] ?>">
                      <button type="submit" class="btn btn-sm btn-danger">Cancel</button>
                    </form>
                  <?php else: ?>
                    <span class="text-muted">N/A</span>
                  <?php endif; ?>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    <?php endif; ?>
  </div>
</section>

<?php include 'includes/footer.php'; ?>
