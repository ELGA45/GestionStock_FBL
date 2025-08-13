<?php
session_start();
include("../include/template.php");
require_once __DIR__ . '/../config/commande.php';
require_once __DIR__ . '/../config/client.php';
require_once __DIR__ . '/../config/produit.php';

if (!isset($_SESSION['connectedUser'])) {
    header('Location:/GestionStock_FBL/authentification/login.php?auth=0');
    exit();
}

$commandeObj = new Commande();
$clientObj = new Client();
$produitObj = new Produit();

$idCommande = $_GET['id'] ?? null;
if (!$idCommande) {
    echo "<div class='alert alert-danger m-3'>❌ ID commande manquant</div>";
    include '../include/footer.php';
    exit();
}

$message = "";
$messageClass = "info";

// Charger données existantes
$details = $commandeObj->DetailsCommande($idCommande);
$allClients = $clientObj->AllClient();
$allProduits = $produitObj->AllProduit();

// Traitement formulaire
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $idClient = $_POST['idClient'];
    $produits = [];

    if (!empty($_POST['produit']) && !empty($_POST['quantite'])) {
        foreach ($_POST['produit'] as $index => $idProd) {
            if (!empty($idProd) && !empty($_POST['quantite'][$index])) {
                $produits[] = [
                    'idProduit' => $idProd,
                    'quantite' => $_POST['quantite'][$index]
                ];
            }
        }
    }

    $message = $commandeObj->UpdateCommande($idCommande, $idClient, $produits);

    if (strpos($message, '✅') !== false) {
        $messageClass = "success";
    } else {
        $messageClass = "danger";
    }
}
?>

<div class="content">
  <div class="container-fluid">
    <div class="tab-bord">
      <h1 class="mb-0">Modifier la commande #<?= htmlspecialchars($idCommande) ?></h1>
    </div>

    <div class="container mt-5">
      <a href="espaceCommande.php" class="btn btn-dark mb-4">🔙 Retour</a>

      <?php if (!empty($message)): ?>
        <div class="alert alert-<?= $messageClass ?>"><?= $message ?></div>
      <?php endif; ?>

      <form action="" method="POST" class="p-4 shadow rounded bg-white" style="max-width: 600px; margin: auto;">

        <!-- Client -->
        <div class="mb-3">
          <label for="idClient" class="form-label">Client</label>
          <select name="idClient" id="idClient" class="form-select" required>
            <option value="">-- Sélectionner --</option>
            <?php foreach ($allClients as $client) { ?>
              <option value="<?= $client['id'] ?>" <?= ($details && $client['nom'] === $details[0]['client']) ? 'selected' : '' ?>>
                <?= htmlspecialchars($client['nom']) ?>
              </option>
            <?php } ?>
          </select>
        </div>

        <!-- Produits -->
        <div id="produitsContainer">
          <?php foreach ($details as $index => $prod) { ?>
            <div class="row mb-3">
              <div class="col-md-6">
                <select name="produit[]" class="form-select" required>
                  <option value="">-- Produit --</option>
                  <?php foreach ($allProduits as $p) { ?>
                    <option value="<?= $p['id'] ?>" <?= ($p['nom'] === $prod['nom']) ? 'selected' : '' ?>>
                      <?= htmlspecialchars($p['nom']) ?>
                    </option>
                  <?php } ?>
                </select>
              </div>
              <div class="col-md-4">
                <input type="number" name="quantite[]" class="form-control" value="<?= $prod['quantite'] ?>" min="1" required>
              </div>
            </div>
          <?php } ?>
        </div>

        <!-- Bouton -->
        <button type="submit" class="btn btn-dark w-100">💾 Enregistrer</button>
      </form>
    </div>
  </div>
</div>

<?php include '../include/footer.php'; ?>
