<?php
  session_start();
  include("../include/template.php");
  require __DIR__ . '/../config/produit.php';


if(isset($_SESSION['connectedUser'])){
    $prdt = new Produit();
    $allPrdts = $prdt->AllProduit(); 
    
?>
<div class="content">
  <div class="container-fluid">
    <div class="tab-bord">
      <h1 class="mb-0">Espace Produit</h1>
    </div>
    <div class="container mt-5">
      <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Liste des produits</h2>
        <a href="addProduit.php" class="btn btn-dark">➕ Ajouter un produit</a>
      </div>

      <div class="card shadow">
        <div class="card-body p-0">
          <?php if($allPrdts){ 
            $nmr = 0;
          ?>
            <div class="table-responsive">
              <table class="table table-striped table-hover mb-0">
                <thead class="bg-dark text-white thead-custom">
                  <tr class="bg-dark text-white" >
                    <th>Numéro</th>
                    <th>Libellé</th>
                    <th>Prix (FCFA)</th>
                    <th>Stock</th>
                    <th>Categorie</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach($allPrdts as $prdt) { 
                    $nmr++;
                  ?>
                    
                    <tr>
                      <td><?= $nmr ?></td>
                      <td><?= htmlspecialchars($prdt['nom']) ?></td>
                      <td><?= htmlspecialchars($prdt['prix']) ?></td>
                      <td><?= htmlspecialchars($prdt['stock']) ?></td>
                      <td><?= htmlspecialchars($prdt['categorie']) ?></td>
                      <td>
                        <?php echo "<a href='editProduit.php?id=".$prdt['id']."' class='btn btn-sm btn-warning'>
                                      ✏️ Modifier
                                    </a>&nbsp";
                              echo "<a href='deleteProduit.php?id=".$prdt['id']."' class='btn btn-sm btn-danger'>
                                      🗑️ Supprimer
                                    </a>";
                        ?>
                      </td>
                    </tr>
                  <?php } ?>
                </tbody>
              </table>
            </div>
          <?php } else { ?>
            <div class="alert alert-warning m-3">Aucun produit trouvé.</div>
          <?php } ?>
        </div>
      </div>
    </div>
  </div>
</div>

<?php

    include '../include//footer.php';

  } else {
    header('Location:/GestionStock_FBL/authentification/login.php?auth=0');
    exit();
  }

?>
