<?php
session_start();
include("../include/template.php");
require __DIR__ . '/../config/categorie.php';

$message = "";
$messageClass = "info"; // Pour couleur Bootstrap

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = $_POST['nom'] ?? '';

    $editCtg = new Categorie();
    $nomCtg = $editCtg->categorieByNom($nom);

    $message = $editUser->editUser($id, $nom);

    if (strpos($message, '✅') !== false) {
            $messageClass = "success";
    } elseif (strpos($message, '⛔') !== false || strpos($message, '❌') !== false) {
            $messageClass = "danger";
    }
}

if(isset($_SESSION['connectedUser'])){

  if(isset($_GET['id'])){
    $id = $_GET['id'];
    $ctg = new Categorie();
    $infoCtg = $ctg->categorieById($id);

    if($infoCtg){ ?>
      <div class="content">
        <div class="container-fluid">

        <div class="tab-bord">
          <h1 class="mb-0">Espace Utilisateur</h1>
        </div>
        <div class="container mt-5">
          <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Modifier une Categorie</h2>
                <a href="espaceCategorie.php" class="btn btn-dark">🔙 Retour</a>
          </div>
        </div>

          <form action="" method="POST" class="p-4 shadow rounded bg-white" style="max-width: 500px; margin: auto; margin-top: 20px">

              <!-- Message d'information -->
              <?php if (!empty($message)): ?>
                  <div class="alert alert-<?= $messageClass ?> text-center">
                      <?= $message ?>
                  </div>
              <?php endif; ?>
              
              <input type="hidden" name="id" value="$id ">
              <!-- Champ Nom -->
              <div class="mb-3">
                  <label for="nom" class="form-label">Nom</label>
                  <input type="text" id="nom" name="nom" class="form-control" placeholder="Entrez le Libellé"
                        value="<?= htmlspecialchars($infoCtg['nom']) ?>" required>
              </div>

              <!-- Bouton -->
              <button type="submit" class="btn btn-dark w-100">Modifier</button>
          </form>
        </div>
      </div>
  <?php }
    else {
      header("location:espaceCategorie.php");
      exit();
    }
  }

    include '../include//footer.php';

  } else {
    header('Location:/GestionStock_FBL/authentification/login.php?auth=0');
    exit();
  }