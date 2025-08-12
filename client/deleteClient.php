<?php
session_start();
include("../include/template.php");
require __DIR__ . '/../config/client.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $id = $_POST['id'];
  $val = $_POST['val'];
  if ($val === "oui") {
      $client = new Client();
      $client->DeleteClient($id);
      header('Location:espaceClient.php');
      exit();
  } 
  else {
      header('Location:espaceClient.php');
      exit();
  }
}
if(isset($_SESSION['connectedUser'])){
  if(isset($_GET['id'])){
    $idClient = htmlspecialchars($_GET['id']);
    $client = new Client();
    $infoClient = $client->clientById($idClient);

    if($infoClient) { ?>
      <div class="content">
        <div class="container-fluid">
          <div class="container vh-100 d-flex justify-content-center align-items-center">
              <div class="card shadow p-4" style="max-width: 400px; width: 100%;">
                  <h4 class="text-center mb-3">Voulez-vous vous supprimer la catégorie ?</h4>
                  <form method="POST" class="text-center">
                      <input type="hidden" name="id" value="<?= $idClient?>">
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
      header("location:espaceClient.php");
      exit();
    }
  }
  else {
    header("location:espaceClient.php");
    exit();
  }

include '../include//footer.php';
} 
else {
    header('Location:/GestionStock_FBL/authentification/login.php?auth=0');
    exit();
}
