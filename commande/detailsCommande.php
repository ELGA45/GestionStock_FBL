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

$details = $commandeObj->DetailsCommande($idCommande);

?>
<div class="content">
  <div class="container-fluid">
    <div class="tab-bord">
      <h1 class="mb-0">Détails de la commande #<?= htmlspecialchars($idCommande) ?></h1>
    </div>

    <div class="container mt-5">
      <a href="espaceCommande.php" class="btn btn-dark mb-4">🔙 Retour</a>

      <?php if ($details) { ?>
        <div class="card shadow">
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-striped table-hover">
                <thead class="bg-dark text-white">
                  <tr>
                    <th>Produit</th>
                    <th>Quantité</th>
                    <th>Prix unitaire</th>
                    <th>Total</th>
                  </tr>
                </thead>
                <tbody>
                  <?php 
                  $totalGeneral = 0;
                  foreach ($details as $item) { 
                      $totalGeneral += $item['total'];
                  ?>
                    <tr>
                      <td><?= htmlspecialchars($item['nom']) ?></td>
                      <td><?= htmlspecialchars($item['quantite']) ?></td>
                      <td><?= number_format($item['prix'], 2, ',', ' ') ?> F</td>
                      <td><?= number_format($item['total'], 2, ',', ' ') ?> F</td>
                    </tr>
                  <?php } ?>
                </tbody>
                <tfoot>
                  <tr class="fw-bold">
                    <td colspan="3" class="text-end">Total général</td>
                    <td><?= number_format($totalGeneral, 2, ',', ' ') ?> F</td>
                  </tr>
                </tfoot>
              </table>
            </div>
          </div>
        </div>
      <?php } else { ?>
        <div class="alert alert-warning">⚠️ Aucun produit trouvé pour cette commande.</div>
      <?php } ?>
    </div>
  </div>
</div>

<?php include '../include/footer.php'; ?>
