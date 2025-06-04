<?php
session_start();
require '../config.php';

if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    header('Location: ../login.php');
    exit();
}

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
if (!$id) {
    header('Location: doctors.php');
    exit();
}

$success = '';
$error = '';

$stmt = $conn->prepare("SELECT * FROM doctors WHERE id = ?");
$stmt->execute([$id]);
$doctor = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$doctor) {
    die("Doctor not found.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'] ?? '';
    $title = $_POST['title'] ?? '';
    $bio = $_POST['bio'] ?? '';
    $experience = $_POST['experience'] ?? '';
    $specialized_in = $_POST['specialized_in'] ?? '';

    if (!$name || !$title || !$bio || !$experience || !$specialized_in) {
        $error = 'Please fill in all fields.';
    } else {
        $imageName = $doctor['image']; 

        if (!empty($_FILES['image']['name'])) {
            $targetDir = "../assets/img/";
            $imageName = time() . '_' . basename($_FILES["image"]["name"]);
            $targetFile = $targetDir . $imageName;
            move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile);
        }

        try {
            $stmt = $conn->prepare("UPDATE doctors 
                SET name = ?, title = ?, bio = ?, experience = ?, specialized_in = ?, image = ? 
                WHERE id = ?");
            $stmt->execute([$name, $title, $bio, $experience, $specialized_in, $imageName, $id]);
            $success = "Doctor updated successfully!";
            $stmt = $conn->prepare("SELECT * FROM doctors WHERE id = ?");
            $stmt->execute([$id]);
            $doctor = $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            $error = "Error: " . $e->getMessage();
        }
    }
}
?>

<?php include 'inc/admin_header.php'; ?>
<style>
.text-orange {
  color: #ff7a00;
}

.btn-orange {
  background-color: #ff7a00;
  color: white;
  border: none;
}
.btn-orange:hover {
  background-color: #e96c00;
  color: white;
}

.card {
  border: 1px solid #f0f0f0;
  border-radius: 15px;
  background-color: #ffffff;
}

.form-label {
  font-weight: 500;
  color: #333;
}

.form-control {
  border-radius: 8px;
}

.alert {
  font-size: 0.95rem;
}

.btn-secondary {
  border-radius: 25px;
  padding: 8px 20px;
}

.btn-secondary:hover {
  background-color: #6c757d;
  color: white;
}
</style>

<section class="py-5 bg-light">
  <div class="container">
    <div class="card mx-auto shadow rounded" style="max-width: 700px;">
      <div class="card-body p-4">
        <h2 class="mb-4 text-orange text-center fw-bold">Edit Doctor</h2>

        <?php if ($success): ?>
            <div class="alert alert-success text-center"><?= htmlspecialchars($success) ?></div>
        <?php elseif ($error): ?>
            <div class="alert alert-danger text-center"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <form method="post" enctype="multipart/form-data">
          <div class="mb-3 text-center">
            <img src="../assets/img/<?= htmlspecialchars($doctor['image']) ?>" alt="Current image" class="img-fluid rounded shadow" style="max-height: 150px;">
          </div>
          <div class="mb-3">
            <label class="form-label">Full Name</label>
            <input type="text" name="name" class="form-control" value="<?= htmlspecialchars($doctor['name']) ?>" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Title</label>
            <input type="text" name="title" class="form-control" value="<?= htmlspecialchars($doctor['title']) ?>" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Bio</label>
            <textarea name="bio" class="form-control" rows="3" required><?= htmlspecialchars($doctor['bio']) ?></textarea>
          </div>
          <div class="mb-3">
            <label class="form-label">Experience</label>
            <input type="text" name="experience" class="form-control" value="<?= htmlspecialchars($doctor['experience']) ?>" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Specialized In</label>
            <input type="text" name="specialized_in" class="form-control" value="<?= htmlspecialchars($doctor['specialized_in']) ?>" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Change Image (optional)</label>
            <input type="file" name="image" class="form-control">
          </div>
          <div class="text-center">
            <button type="submit" class="btn btn-orange px-5 py-2 fw-semibold rounded-pill shadow-sm">
            <i class="fas fa-save me-2"></i> Update Doctor</button>
            <a href="doctors.php" class="btn btn-secondary ms-2">Back</a>
          </div>
        </form>
      </div>
    </div>
  </div>
</section>

