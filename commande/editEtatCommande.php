<?php
session_start();
include("../include/template.php");
require __DIR__ . '/../config/commande.php';

if (!isset($_SESSION['connectedUser'])) {
    header('Location:/GestionStock_FBL/authentification/login.php?auth=0');
    exit();
}

$commandeObj = new Commande();
$idCommande = $_GET['id'] ?? null;

if (!$idCommande) {
    echo "<div class='alert alert-danger m-3'>❌ ID commande manquant</div>";
    include '../include/footer.php';
    exit();
}

$message = "";
$messageClass = "info";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nouvelEtat = $_POST['etat'] ?? '';
    $message = $commandeObj->UpdateEtat($idCommande, $nouvelEtat);

    if (strpos($message, '✅') !== false) {
        $messageClass = "success";
    } elseif (strpos($message, '⚠️') !== false) {
        $messageClass = "warning";
    } else {
        $messageClass = "danger";
    }
}

?>
<div class="content">
  <div class="container-fluid">
    <div class="tab-bord">
      <h1 class="mb-0">Modifier l'état de la commande #<?= htmlspecialchars($idCommande) ?></h1>
    </div>

    <div class="container mt-5">
      <a href="espaceCommande.php" class="btn btn-dark mb-4">🔙 Retour</a>

      <?php if (!empty($message)): ?>
        <div class="alert alert-<?= $messageClass ?>"><?= $message ?></div>
      <?php endif; ?>

      <form action="" method="POST" class="p-4 shadow rounded bg-white" style="max-width: 500px; margin: auto;">
        <div class="mb-3">
          <label for="etat" class="form-label">État de la commande</label>
          <select id="etat" name="etat" class="form-select" required>
            <option value="">-- Sélectionner --</option>
            <option value="en attente">En attente</option>
            <option value="en cours">En cours</option>
            <option value="livrée">Livrée</option>
          </select>
        </div>

        <button type="submit" class="btn btn-dark w-100">Mettre à jour</button>
      </form>
    </div>
  </div>
</div>

<?php include '../include/footer.php'; ?>
