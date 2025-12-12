<?php
session_start();
require_once __DIR__ . '/../model/connection.php';
$pdo = connection();

// Vérifie si l'utilisateur est connecté et doit changer son mot de passe
if (!isset($_SESSION['ID_user'])) {
    header('Location: ../login');
    exit;
}

$error = '';
$success = '';

$stmt = $pdo->prepare("SELECT must_change_password FROM user WHERE ID_user = ?");
$stmt->execute([$_SESSION['ID_user']]);
$userData = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$userData || $userData['must_change_password'] != 1) {
    header('Location: ../dashboard');
    exit;
}

// Traitement du formulaire
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $pwd = trim($_POST['newPwd'] ?? '');
    $confirm = trim($_POST['confirmPwd'] ?? '');

    if (strlen($pwd) < 6) {
        $error = "Le mot de passe doit contenir au moins 6 caractères.";
    } elseif ($pwd !== $confirm) {
        $error = "Les mots de passe ne correspondent pas.";
    } else {
        $hash = password_hash($pwd, PASSWORD_DEFAULT);
        $update = $pdo->prepare("UPDATE user SET password = ?, must_change_password = 0 WHERE ID_user = ?");
        $update->execute([$hash, $_SESSION['ID_user']]);

        unset($_SESSION['force_change']); // supprime le flag
        $success = "Mot de passe mis à jour avec succès ! Redirection...";
        header("refresh:2;url=../dashboard"); // redirection après 2 secondes
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Changement de mot de passe | Fondation Salama</title>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
<style>
body {
    background: linear-gradient(135deg, #7c4a2f 0%, #4a2c1d 100%);
    height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    font-family: "Poppins", sans-serif;
}
.login-box {
    background: #fff;
    border-radius: 15px;
    overflow: hidden;
    box-shadow: 0 8px 20px rgba(0,0,0,0.2);
    width: 100%;
    max-width: 400px;
}
.card-body { padding: 30px; }
.logo { max-height: 80px; margin-bottom: 15px; transition: transform 0.3s ease; }
.logo:hover { transform: scale(1.05); }
.btn { border-radius: 8px; font-weight: 600; transition: all 0.3s; }
.btn:hover { transform: translateY(-2px); box-shadow: 0 4px 8px rgba(0,0,0,0.1); }
.form-control { border-radius: 8px; padding: 12px 15px; transition: all 0.3s; }
.form-control:focus { border-color: #7c4a2f; box-shadow: 0 0 0 0.2rem rgba(124,74,47,0.25); }
.text-muted small { display:block; margin-top:15px; }
</style>
</head>
<body>

<section class="login-register">
  <div class="login-box card shadow-lg">
    <div class="card-body">
      <div class="text-center mb-4">
        <img src="../printing/fiches/logoSpdernet.png" alt="Logo" class="logo">
        <h3 class="text-primary">Changement de mot de passe</h3>
      </div>

      <?php if ($error): ?>
        <div class="alert alert-danger"><?= $error ?></div>
      <?php elseif ($success): ?>
        <div class="alert alert-success"><?= $success ?></div>
      <?php endif; ?>

      <form method="POST">
        <p class="text-center text-muted mb-4">
          🔒 Par mesure de sécurité, vous devez modifier votre mot de passe avant d’accéder à votre compte.
        </p>

        <div class="form-group mb-3">
          <div class="input-group">
            <div class="input-group-prepend">
              <span class="input-group-text bg-light border-end-0">
                <i class="fas fa-lock text-muted"></i>
              </span>
            </div>
            <input type="password" class="form-control border-start-0 ps-2" name="newPwd" placeholder="Nouveau mot de passe" required>
          </div>
        </div>

        <div class="form-group mb-4">
          <div class="input-group">
            <div class="input-group-prepend">
              <span class="input-group-text bg-light border-end-0">
                <i class="fas fa-lock text-muted"></i>
              </span>
            </div>
            <input type="password" class="form-control border-start-0 ps-2" name="confirmPwd" placeholder="Confirmer le mot de passe" required>
          </div>
        </div>

        <div class="form-group text-center">
          <button type="submit" class="btn btn-block text-white btn-lg" style="background: linear-gradient(to right, #7c4a2f, #a56a46); border: none;">
            <i class="fas fa-save me-2"></i>Enregistrer
          </button>
        </div>
      </form>

      <div class="text-center text-muted">
        <small>Un bon mot de passe, c’est comme un bon café : fort, unique, et difficile à deviner ☕</small>
      </div>
    </div>
  </div>
</section>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
