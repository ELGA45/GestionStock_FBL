<?php
session_start();
include("../include/template.php");
require __DIR__ . '/../config/commande.php';

if (isset($_SESSION['connectedUser'])) {
    $commandeObj = new Commande();
    $allCommandes = $commandeObj->AllCommandes(); 
?>
<div class="content">
  <div class="container-fluid">
    <div class="tab-bord">
      <h1 class="mb-0">Espace Commandes</h1>
    </div>
    <div class="container mt-5">
      <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Liste des commandes</h2>
        <a href="addCommande.php" class="btn btn-dark">➕ Ajouter une commande</a>
      </div>

      <div class="card shadow">
        <div class="card-body p-0">
          <?php if ($allCommandes) { ?>
            <div class="table-responsive">
              <table class="table table-striped table-hover mb-0">
                <thead class="bg-dark text-white thead-custom">
                  <tr>
                    <th>#</th>
                    <th>Client</th>
                    <th>Date</th>
                    <th>État</th>
                    <th>Actions</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($allCommandes as $cmd) { ?>
                    <tr>
                      <td><?= htmlspecialchars($cmd['id']) ?></td>
                      <td><?= htmlspecialchars($cmd['client']) ?></td>
                      <td><?= htmlspecialchars($cmd['dateCommande']) ?></td>
                      <td>
                        <?php if ($cmd['etat'] !== 'livrée') { ?>
                          <a href="EditEtatCommande.php?id=<?= $cmd['id'] ?>" 
                              class="btn btn-sm btn-info">
                              <?= htmlspecialchars($cmd['etat']) ?>
                          </a>
                        <?php } else { ?>
                          <span class="badge bg-success"><?= htmlspecialchars($cmd['etat']) ?></span>
                        <?php } ?>
                      </td>
                      <td>
                        <a href="detailsCommande.php?id=<?= $cmd['id'] ?>" class="btn btn-sm btn-primary">
                          📄 Détails
                        </a>
                        <a href="deleteCommande.php?id=<?= $cmd['id'] ?>" 
                            class="btn btn-sm btn-danger">
                            🗑️ Supprimer
                        </a>
                      </td>
                    </tr>
                  <?php } ?>
                </tbody>
              </table>
            </div>
          <?php } else { ?>
            <div class="alert alert-warning m-3">Aucune commande trouvée.</div>
          <?php } ?>
        </div>
      </div>
    </div>
  </div>
</div>

<?php
    include '../include/footer.php';
} else {
    header('Location:/GestionStock_FBL/authentification/login.php?auth=0');
    exit();
}
?>
