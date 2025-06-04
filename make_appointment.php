<?php
require 'config.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$success = '';
$error = '';

$selected_doctor_id = isset($_GET['doctor']) ? intval($_GET['doctor']) : 0;
$doctor_name = '';
$doctors = [];

try {
    $stmt = $conn->query("SELECT id, name FROM doctors ORDER BY name ASC");
    $doctors = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $error = "Failed to load doctors list: " . $e->getMessage();
}

if ($selected_doctor_id) {
    $stmt = $conn->prepare("SELECT name FROM doctors WHERE id = ?");
    $stmt->execute([$selected_doctor_id]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($row) {
        $doctor_name = $row['name'];
    } else {
        $selected_doctor_id = 0;
    }
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['user_id'];
    $date = $_POST['date'] ?? '';
    $time = $_POST['time'] ?? '';
    $doctor_id = $_POST['doctor'] ?? '';
    $message = $_POST['message'] ?? '';

  if ($date && $time && $doctor_id) {
    $dayOfWeek = date('w', strtotime($date)); 

    if ($dayOfWeek == 0) {
        $error = "Appointments cannot be scheduled on Sundays. The clinic is closed.";
    } elseif ($time < '07:00' || $time > '20:00') {
        $error = "Appointments can only be scheduled between 07:00 and 20:00.";
    } else {
        try {
            $stmt = $conn->prepare("INSERT INTO appointments 
                (patient_id, appointment_date, appointment_time, doctor_id, message)
                VALUES (?, ?, ?, ?, ?)");

            $stmt->execute([$user_id, $date, $time, $doctor_id, $message]);

            $stmt = $conn->prepare("SELECT name FROM doctors WHERE id = ?");
            $stmt->execute([$doctor_id]);
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $doctor_name = $row['name'] ?? 'the doctor';

            $success = "Appointment successfully booked with $doctor_name.";
        } catch (PDOException $e) {
            $error = "Something went wrong: " . $e->getMessage();
        }}
        
      }
      else {
    $error = "Please fill in all required fields.";}
      }

?>

<?php include 'includes/header.php'; ?>

<section class="appointment-section py-5">
  <div class="container">
    <h2 class="text-center text-orange fw-bold mb-4">
      Make an Appointment<?= $doctor_name ? " with <span class='text-dark'>$doctor_name</span>" : '' ?>
    </h2>

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
        <select name="time" class="form-select" required>
  <option value="">-- Select time --</option>
  <?php
  $start = strtotime("07:00");
  $end = strtotime("20:00");

  for ($time = $start; $time <= $end; $time += 30 * 60) {
      $formatted = date("H:i", $time);
      echo "<option value=\"$formatted\">$formatted</option>";
  }
  ?>
</select>

      </div>

      <div class="mb-3">
        <label class="form-label">Doctor *</label>
        <?php if ($selected_doctor_id): ?>
          <input type="hidden" name="doctor" value="<?= $selected_doctor_id ?>">
          <input type="text" class="form-control" value="<?= htmlspecialchars($doctor_name) ?>" readonly>
        <?php else: ?>
          <select name="doctor" class="form-select" required>
            <option value="">-- Select a doctor --</option>
            <?php foreach ($doctors as $doc): ?>
              <option value="<?= $doc['id'] ?>"><?= htmlspecialchars($doc['name']) ?></option>
            <?php endforeach; ?>
          </select>
        <?php endif; ?>
      </div>

      <div class="mb-3">
        <label class="form-label">Message</label>
        <textarea name="message" class="form-control" rows="4"></textarea>
      </div>

      <div class="text-center">
        <button type="submit" class="btn btn-orange px-4">Book Appointment</button>
      </div>
      <?php if (isset($_SESSION['user_id'])): ?>
  <div class="text-center mt-3">
    <a href="my_appointments.php" class="btn btn-orange px-4">My Appointments</a>
  </div>
<?php endif; ?>

    </form>
  </div>
</section>

<?php include 'includes/footer.php'; ?>
