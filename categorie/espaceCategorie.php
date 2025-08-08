<?php
  session_start();
  include("../include/template.php");
  require __DIR__ . '/../config/categorie.php';

if(isset($_SESSION['connectedUser'])){
    $categorie = new Categorie();
    $allCategorie = $categorie->AllCategorie(); 
    
?>
<div class="content">
  <div class="container-fluid">
    <div class="tab-bord">
      <h1 class="mb-0">Catégorie</h1>
    </div>
    <div class="container mt-5">
      <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Liste des Catégorie</h2>
        <a href="addCategorie.php" class="btn btn-dark">➕ Ajouter une Catégorie</a>
      </div>

      <div class="card shadow">
        <div class="card-body p-0">
          <?php if($allCategorie){ ?>
            <div class="table-responsive">
              <table class="table table-striped table-hover mb-0">
                <thead class="bg-dark text-white thead-custom">
                  <tr class="bg-dark text-white" >
                    <th>Libellé</th>
                    <th>Nombre de produits</th>
                    <th>Produits</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach($allCategorie as $ctg) { ?>
                    <tr>
                      <td><?= htmlspecialchars($ctg['nom']) ?></td>
                      <td><?= htmlspecialchars($ctg['nbr_prdt']) ?></td>
                      <td><a href="" class='btn btn-sm btn-info'>
                            Voir Produit
                          </a>
                      </td>
                      <td>
                        <?php echo "<a href='editCategorie.php?id=".$ctg['id']."' class='btn btn-sm btn-warning'>
                                      ✏️ Modifier
                                    </a>&nbsp";
                              echo "<a href='deleteCategorie.php?id=".$ctg['id']."' class='btn btn-sm btn-danger'>
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
            <div class="alert alert-warning m-3">Aucun catégorie trouvé.</div>
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
