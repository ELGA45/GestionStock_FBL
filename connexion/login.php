<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Connexion</title>
  <link rel="stylesheet" href="/GestionStock_FBL/asset/css/bootstrap.min.css">

  <style>
    body {
      background-color: #f8f9fa;
    }
    .login-container {
      max-width: 400px;
      margin: 80px auto;
      background: white;
      padding: 30px;
      border-radius: 8px;
      box-shadow: 0 0 15px rgba(0,0,0,0.1);
    }
    .btn-dark {
      background-color: #212529;
    }
  </style>
</head>
<body>

  <div class="login-container">
    <h3 class="text-center mb-4">BOUTIQUE FLD</h3>
    <form action="login.php" method="POST">
      <div class="mb-3">
        <label for="email" class="form-label">Adresse e-mail</label>
        <input type="email" class="form-control" id="email" name="email" required placeholder="Votre email">
      </div>
      <div class="mb-3">
        <label for="password" class="form-label">Mot de passe</label>
        <input type="password" class="form-control" id="password" name="password" required placeholder="Votre mot de passe">
      </div>
      <button type="submit" class="btn btn-dark w-100">Se connecter</button>
      <?php
        if (isset($_GET['error'])) {
            if ($_GET['error'] == 0) { ?>
                <div class="alert alert-danger text-center" role="alert">
                    ⚠️ Les champs sont obligatoires
                </div>
            <?php }
            if ($_GET['error'] == 1) { ?>
                <div class="alert alert-danger text-center" role="alert">
                    ❌ Mot de passe ou e-mail incorrect
                </div>
            <?php }
        }
        if (isset($_GET['auth']) && $_GET['auth'] == 0) { ?>
            <div class="alert alert-warning text-center" role="alert">
                🔒 Merci de vous connecter
            </div>
      <?php } ?>
    </form>
  </div>
</body>
</html>

<?php
  require __DIR__ . '/../config/utilisateur.php';

  if($_SERVER['REQUEST_METHOD'] === 'POST'){
    extract($_POST);

    $user = New Utilisateur();
    $emailUser = $user->UtilisateurByEmail($email);

    if($emailUser && password_verify($password, $emailUser['mot_de_passe'])){
      session_start();
      $_SESSION['connectedUser'] = $emailUser;
      header('Location:/GestionStock_FBL/dashbord.php');
    }
    else{
      header('Location:login.php?error=1');
    }
  }
