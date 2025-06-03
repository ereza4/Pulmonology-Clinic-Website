<?php
require 'config.php'; 

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$doctor = isset($_GET['doctor']) ? htmlspecialchars($_GET['doctor']) : '';
$success = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['user_id'];
    $date = $_POST['date'] ?? '';
    $time = $_POST['time'] ?? '';
    $doctor_name = $_POST['doctor'] ?? '';
    $message = $_POST['message'] ?? '';

    if ($date && $time && $doctor_name) {
        try {
            $stmt = $conn->prepare("INSERT INTO appointments 
                (patient_id, appointment_date, appointment_time, doctor_name, message)
                VALUES (?, ?, ?, ?, ?)");

            $stmt->execute([$user_id, $date, $time, $doctor_name, $message]);

            $success = "Appointment successfully booked with $doctor_name.";
        } catch (PDOException $e) {
            $error = "Something went wrong: " . $e->getMessage();
        }
    } else {
        $error = "Please fill in all required fields.";
    }
}
?>

<?php include 'includes/header.php'; ?>

<section class="appointment-section py-5">
  <div class="container">
    <h2 class="text-center text-orange fw-bold mb-4">Make an Appointment<?= $doctor ? " with <span class='text-dark'>$doctor</span>" : '' ?></h2>

    <?php if ($success): ?>
      <div class="alert alert-success text-center"><?= $success ?></div>
    <?php elseif ($error): ?>
      <div class="alert alert-danger text-center"><?= $error ?></div>
    <?php endif; ?>

    <form action="" method="post" class="mx-auto" style="max-width: 600px;">
      <div class="mb-3">
        <label class="form-label">Date *</label>
        <input type="date" name="date" class="form-control" required>
      </div>

      <div class="mb-3">
        <label class="form-label">Time *</label>
        <input type="time" name="time" class="form-control" required>
      </div>

      <div class="mb-3">
        <label class="form-label">Doctor *</label>
        <input type="text" name="doctor" class="form-control" value="<?= $doctor ?>" required readonly>
      </div>

      <div class="mb-3">
        <label class="form-label">Message</label>
        <textarea name="message" class="form-control" rows="4"></textarea>
      </div>

      <div class="text-center">
        <button type="submit" class="btn btn-orange px-4">Book Appointment</button>
      </div>
    </form>
  </div>
</section>

<?php include 'includes/footer.php'; ?>
