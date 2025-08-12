<?php
session_start();
include("../include/template.php");
require __DIR__ . '/../config/utilisateur.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $id = $_POST['id'];
  $val = $_POST['val'];
  $roleActuel = $_SESSION['connectedUser']['rôle'];
  if ($val === "oui") {
      $user = new Utilisateur();
      $user->deleteUtilisateur($id, $roleActuel);
      header('Location:espaceUser.php');
      exit();
  } 
  else {
      header('Location:espaceUser.php');
      exit();
  }
}
if(isset($_SESSION['connectedUser'])){
  if(isset($_GET['id'])){
    $idUser = htmlspecialchars($_GET['id']);
    $user = new Utilisateur();
    $infoUser = $user->UtilisateurById($idUser);

    if($infoUser) { ?>
    <div class="content">
      <div class="container-fluid">
        <div class="container vh-100 d-flex justify-content-center align-items-center">
            <div class="card shadow p-4" style="max-width: 400px; width: 100%;">
                <h4 class="text-center mb-3">Voulez-vous vous supprimer l'utilisateur ?</h4>
                <form method="POST" class="text-center">
                    <input type="hidden" name="id" value="<?= $idUser ?>">
                    <button type="submit" name="val" value="oui" class="btn btn-danger w-100 mb-2">Oui</button>
                    <button type="submit" name="val" value="non" class="btn btn-secondary w-100">Non</button>
                </form>
            </div>
        </div>
      </div>
    </div>
<?php
    }
    else{
      header("location:espaceUser.php");
      exit();
    }
  }
  else {
    header("location:espaceUser.php");
    exit();
  }

include '../include//footer.php';
} 
else {
    header('Location:/GestionStock_FBL/authentification/login.php?auth=0');
    exit();
}
