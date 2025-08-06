<form action="" method="POST">
  <p>Voulez vous vous deconnecter</p>
  <button type="submit" name="val" value="oui">OUI</button>
  <button type="submit" name="val" value="non">NON</button>
</form>

<?php
  if($_SERVER['REQUEST_METHOD'] === 'POST'){
    extract($_POST);
    if($val == "oui"){
      header('Location:login.php');
      session_start();
      if(isset($_SESSION['connectedUser'])){
        unset($_SESSION['connectedUser']);
        header('Location:login.php');
        exit();
      }
    }
    else{
        header('Location:/GestionStock_FBL/dashbord.php');
        exit();
    }
  }