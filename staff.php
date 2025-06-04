<?php include 'includes/header.php'; ?>
<?php require 'config.php'; ?>

<section class="staff-section py-5">
  <div class="container">
    <h2 class="text-center text-orange fw-bold mb-5">Our Medical Team</h2>

    <div class="row g-4">
      <?php
      $stmt = $conn->query("SELECT * FROM doctors");
      $doctors = $stmt->fetchAll(PDO::FETCH_ASSOC);

      foreach ($doctors as $index => $doc): ?>
        <div class="col-md-6 col-lg-4">
          <div class="card h-100 shadow-sm border-0">
            <img src="assets/img/<?= htmlspecialchars($doc['image']) ?>" class="card-img-top" alt="<?= htmlspecialchars($doc['name']) ?>">
            <div class="card-body text-center">
              <h5 class="fw-bold"><?= htmlspecialchars($doc['name']) ?></h5>
              <p class="text-muted mb-1"><?= htmlspecialchars($doc['title']) ?></p>
              <button class="btn btn-orange btn-sm mt-2" data-bs-toggle="modal" data-bs-target="#doctorModal<?= $index ?>">More Info</button>
            </div>
          </div>
        </div>

        <div class="modal fade" id="doctorModal<?= $index ?>" tabindex="-1" aria-labelledby="doctorModalLabel<?= $index ?>" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="doctorModalLabel<?= $index ?>"><?= htmlspecialchars($doc['name']) ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
              </div>
              <div class="modal-body text-center">
                <img src="assets/img/<?= htmlspecialchars($doc['image']) ?>" class="img-fluid rounded mb-3" style="max-height: 300px; object-fit: cover;">
                <p><strong><?= htmlspecialchars($doc['title']) ?></strong></p>
                <p><?= nl2br(htmlspecialchars($doc['bio'])) ?></p>
                <p><strong>Experience:</strong> <?= htmlspecialchars($doc['experience']) ?></p>
                <p><strong>Specialized in:</strong> <?= htmlspecialchars($doc['specialized_in']) ?></p>
              </div>
              <div class="modal-footer justify-content-center">
                <a href="make_appointment.php?doctor=<?= $doc['id'] ?>" class="btn btn-orange">Make an Appointment</a>
              </div>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>

    <div class="technical-staff mt-5 pt-5 border-top">
      <h3 class="text-orange mb-4 text-center">Our Technical Team</h3>
      <div class="row justify-content-center">
        <div class="col-md-8 text-center">
          <img src="assets/img/residents.jpg" class="img-fluid rounded shadow mb-3" alt="Technical Team">
          <p class="lead">
            Behind every smooth operation stands our dedicated technical team — lab technicians, coordinators, and support staff — working together to ensure accurate diagnostics and patient comfort.
          </p>
        </div>
      </div>
    </div>

  </div>
</section>

<?php include 'includes/footer.php'; ?>
