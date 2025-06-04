<?php
session_start();
require '../config.php';

if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}

if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $stmt = $conn->prepare("DELETE FROM doctors WHERE id = ?");
    $stmt->execute([$id]);
    header("Location: doctors.php");
    exit();
}


$doctors = $conn->query("SELECT * FROM doctors ORDER BY id DESC")->fetchAll(PDO::FETCH_ASSOC);
?>
<?php include 'inc/admin_header.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Manage Doctors</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    .btn-orange {
      background-color: #ff7a00;
      color: white;
    }
    .btn-orange:hover {
      background-color: #e96c00;
    }
    .table img {
      width: 60px;
      height: 60px;
      object-fit: cover;
      border-radius: 50%;
    }
  </style>
</head>
<body>
<div class="container mt-5">
  <h2 class="mb-4 text-orange">Manage Doctors</h2>

  <a href="add-doctors.php" class="btn btn-orange mb-3">Add New Doctor</a>

  <table class="table table-bordered table-striped">
    <thead>
      <tr>
        <th>Image</th>
        <th>Name</th>
        <th>Title</th>
        <th>Experience</th>
        <th>Specialization</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($doctors as $doc): ?>
        <tr>
          <td><img src="../assets/img/<?= htmlspecialchars($doc['image']) ?>" alt="Doctor"></td>
          <td><?= htmlspecialchars($doc['name']) ?></td>
          <td><?= htmlspecialchars($doc['title']) ?></td>
          <td><?= htmlspecialchars($doc['experience']) ?></td>
          <td><?= htmlspecialchars($doc['specialized_in']) ?></td>
          <td>
            <a href="edit_doctors.php?id=<?= $doc['id'] ?>" class="btn btn-sm btn-warning">Edit</a>
            <a href="?delete=<?= $doc['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?');">Delete</a>
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>


</div>
</body>
</html>
