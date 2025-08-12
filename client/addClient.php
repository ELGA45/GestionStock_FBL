<?php
session_start();
include("../include/template.php");
require __DIR__ . '/../config/client.php';

$message = "";
$messageClass = "info"; // Pour couleur Bootstrap

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = $_POST['nom'] ?? '';
    $email = $_POST['email'] ?? '';
    $tel = $_POST['tel'] ?? '';

    $newClient = new Client();
    $emailClient = $newClient->clientByEmail($email);

    if (!$emailClient) {
        $message = $newClient->AddClient($nom, $email, $tel );

        // Couleur du message selon contenu
        if (strpos($message, '✅') !== false) {
            $messageClass = "success";
        } elseif (strpos($message, '⛔') !== false || strpos($message, '❌') !== false) {
            $messageClass = "danger";
        }
    } else {
        $message = "⚠️ Cet e-mail est déjà enregistré";
        $messageClass = "warning";
    }
}

if(isset($_SESSION['connectedUser'])){
?>

<div class="content">
  <div class="container-fluid">

  <div class="tab-bord">
      <h1 class="mb-0">Espace Client</h1>
    </div>
    <div class="container mt-5">
      <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Ajouter un Client</h2>
        <a href="espaceClient.php" class="btn btn-dark">🔙 Retour</a>
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
            <label for="nom" class="form-label">Nom</label>
            <input type="text" id="nom" name="nom" class="form-control" placeholder="Entrez le nom"
                  value="<?= htmlspecialchars($nom ?? '') ?>" required>
        </div>

        <!-- Champ Email -->
        <div class="mb-3">
            <label for="email" class="form-label">E-mail</label>
            <input type="email" id="email" name="email" class="form-control" placeholder="Entrez l'e-mail"
                  value="<?= htmlspecialchars($email ?? '') ?>" required>
        </div>

        <!-- Champ Téléphone -->
        <div class="mb-3">
            <label for="tel" class="form-label">Téléphone</label>
            <input type="tel" id="text" name="tel" class="form-control" placeholder="Entrez le téléphone" required>
        </div>

        <!-- Bouton -->
        <button type="submit" class="btn btn-dark w-100">Enregistrer</button>
    </form>
  </div>
</div>

<?php

    include '../include//footer.php';

  } else {
    header('Location:/GestionStock_FBL/authentification/login.php?auth=0');
    exit();
  }
