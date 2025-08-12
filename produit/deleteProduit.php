<?php
session_start();
include("../include/template.php");
require __DIR__ . '/../config/produit.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $id = $_POST['id'];
  $val = $_POST['val'];
  if ($val === "oui") {
      $prdt = new Produit();
      $prdt->DeleteProduit($id);
      header('Location:espaceProduit.php');
      exit();
  } 
  else {
      header('Location:espaceProduit.php');
      exit();
  }
}
if(isset($_SESSION['connectedUser'])){
  if(isset($_GET['id'])){
    $idPrdt = htmlspecialchars($_GET['id']);
    $prdt = new Produit();
    $infoPrdt = $prdt->ProduitById($idPrdt);

    if($infoPrdt) { ?>
      <div class="content">
        <div class="container-fluid">
          <div class="container vh-100 d-flex justify-content-center align-items-center">
              <div class="card shadow p-4" style="max-width: 400px; width: 100%;">
                  <h4 class="text-center mb-3">Voulez-vous vous supprimer le produit ?</h4>
                  <form method="POST" class="text-center">
                      <input type="hidden" name="id" value="<?= $idPrdt ?>">
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
      header("location:espaceProduit.php");
      exit();
    }
  }
  else {
    header("location:espaceProduit.php");
    exit();
  }

include '../include//footer.php';
} 
else {
    header('Location:/GestionStock_FBL/authentification/login.php?auth=0');
    exit();
}
