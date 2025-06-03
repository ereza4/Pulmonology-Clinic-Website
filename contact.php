<?php
include("includes/header.php");
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';
$config = include('config_mail.php');

$success = '';
$error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name    = htmlspecialchars(trim($_POST['name']));
    $email   = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
    $subject = htmlspecialchars(trim($_POST['subject']));
    $message = htmlspecialchars(trim($_POST['message']));

    if (!$name || !$email || !$subject || !$message) {
        $error = "Please fill all fields.";
    } else {
        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host       = $config['smtp_host'];
            $mail->SMTPAuth   = true;
            $mail->Username   = $config['smtp_user'];
            $mail->Password   = $config['smtp_pass'];
            $mail->Port       = $config['smtp_port'];

            $mail->setFrom($email, $name);
            $mail->addAddress('info@pulmonology-clinic.com', 'Pulmonology Clinic');

            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->Body    = "<strong>From:</strong> $name<br><strong>Email:</strong> $email<br><br>$message";

            $mail->send();
            $success = "Your message has been sent successfully!";
        } catch (Exception $e) {
            $error = "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }
}
?>

<section class="py-5">
  <div class="container">
    <h2 class="text-orange text-center mb-4">Contact Us</h2>

    <?php if ($success): ?>
      <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
    <?php elseif ($error): ?>
      <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="post" class="mx-auto" style="max-width: 700px;">
      <div class="mb-3">
        <label>Your Name</label>
        <input type="text" name="name" class="form-control" required>
      </div>
      <div class="mb-3">
        <label>Your Email</label>
        <input type="email" name="email" class="form-control" required>
      </div>
      <div class="mb-3">
        <label>Subject</label>
        <input type="text" name="subject" class="form-control" required>
      </div>
      <div class="mb-3">
        <label>Your Message</label>
        <textarea name="message" rows="5" class="form-control" required></textarea>
      </div>
      <button type="submit" class="btn btn-orange">Send Message</button>
    </form>
  </div>
</section>

<?php include("includes/footer.php"); ?>
