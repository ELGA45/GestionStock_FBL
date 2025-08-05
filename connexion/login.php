<form action="" method="POST">
  <label for="email">Votre email</label>
  <input type="email" name="email">
  <label for="passwd">Votre Mot de passe</label>
  <input type="password" name="passwd">
  <input type="submit" value="Se connecter">
  <?php
    if(isset($_GET['error'])){
      if($_GET['error'] == 0){ ?>
        <div class="error">les champs sont obligatoires</div>
      <?php }
      if($_GET['error'] == 1){ ?>
        <div class="error">Mot de passe ou Email incorrect</div>
      <?php }
    }
    if(isset($_GET['auth']) && $_GET['auth'] == 0){ ?>
      <div class="error">Merci de vous connecter</div>
    <?php } ?>
</form>

<?php
  require  'config/utilisateur.php';
  
  if($_SERVER['REQUEST_METHOD'] === 'POST'){
    extract($_POST);
    if($email == null || $passwd == null){
      header('Location:login.php?error=0');
    }

    $user = New Utilisateur();
    $emailUser = $user->UtilisateurByEamil($email);

    if($emailUser && password_verify($passwd, $emailUser['mot_de_passe'])){
      session_start();
      $_SESSION['connectedUser'] = $eamilUser;
      header('Location:dashbord.php');
    }
    else{
      header('Location:login.php?error=1');
    }
  }
