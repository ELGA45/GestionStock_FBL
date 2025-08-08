<?php
session_start();
include("../include/template.php");
require __DIR__ . '/../config/categorie.php';

$message = "";
$messageClass = "info"; // Pour couleur Bootstrap

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = $_POST['nom'] ?? '';

    $newCtg = new Categorie();
    $nomCtg = $newCtg->categorieByNom($nom);

    if (!$nomCtg) {
        $message = $newCtg->addCategorie($nom);

        // Couleur du message selon contenu
        if (strpos($message, '✅') !== false) {
            $messageClass = "success";
        } elseif (strpos($message, '❌') !== false) {
            $messageClass = "danger";
        }
    } else {
        $message = "⚠️ Cet Libellé est déjà enregistré";
        $messageClass = "warning";
    }
}

if(isset($_SESSION['connectedUser'])){
?>

<div class="content">
  <div class="container-fluid">

  <div class="tab-bord">
      <h1 class="mb-0">Categorie</h1>
    </div>
    <div class="container mt-5">
      <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Ajouter un Categorie</h2>
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

        <!-- Champ Nom -->
        <div class="mb-3">
            <label for="nom" class="form-label">Libellé</label>
            <input type="text" id="nom" name="nom" class="form-control" placeholder="Entrez le libellé"
                  value="<?= htmlspecialchars($nom ?? '') ?>" required>
        </div>

        <button type="submit" class="btn btn-dark w-100">Ajouter</button>
    </form>
  </div>
</div>

<?php

    include '../include//footer.php';

  } else {
    header('Location:/GestionStock_FBL/authentification/login.php?auth=0');
    exit();
  }
