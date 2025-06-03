<?php
session_start();
require '../config.php';


if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    header('Location: ../login.php');
    exit();
}

$success = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'] ?? '';
    $title = $_POST['title'] ?? '';
    $bio = $_POST['bio'] ?? '';
    $experience = $_POST['experience'] ?? '';
    $specialized_in = $_POST['specialized_in'] ?? '';

    
    if (!$name || !$title || !$bio || !$experience || !$specialized_in) {
        $error = 'Please fill in all fields.';
    } else {
        
        $imageName = 'default.jpg';
        if (!empty($_FILES['image']['name'])) {
            $targetDir = "../assets/img/";
            $imageName = time() . '_' . basename($_FILES["image"]["name"]);
            $targetFile = $targetDir . $imageName;
            move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile);
        }

       
        try {
            $stmt = $conn->prepare("INSERT INTO doctors (name, title, bio, experience, specialized_in, image) 
                                    VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->execute([$name, $title, $bio, $experience, $specialized_in, $imageName]);
            $success = "Doctor added successfully!";
        } catch (PDOException $e) {
            $error = "Error: " . $e->getMessage();
        }
    }
}
?>


<div class="container mt-5">
    <h2 class="mb-4">Add New Doctor</h2>

    <?php if ($success): ?>
        <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
    <?php elseif ($error): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="post" enctype="multipart/form-data">
        <div class="mb-3">
            <label class="form-label">Full Name</label>
            <input type="text" name="name" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Title (e.g. Pulmonologist)</label>
            <input type="text" name="title" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Bio</label>
            <textarea name="bio" class="form-control" rows="3" required></textarea>
        </div>
        <div class="mb-3">
            <label class="form-label">Experience (e.g. 10 years)</label>
            <input type="text" name="experience" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Specialized In</label>
            <input type="text" name="specialized_in" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Doctor Image (optional)</label>
            <input type="file" name="image" class="form-control">
        </div>
        <button type="submit" class="btn btn-success">Add Doctor</button>
    </form>
</div>

