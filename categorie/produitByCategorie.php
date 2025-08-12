<?php
  session_start();
  include("../include/template.php");
  require_once __DIR__ . '/../config/produit.php';
  require_once __DIR__ . '/../config/categorie.php';


if(isset($_SESSION['connectedUser'])){
    $idCategorie = htmlspecialchars($_GET['id']);
    $ctg = new Categorie();
    $infoCtg = $ctg->categorieById($idCategorie);

      $prdt = new Produit();
      $prdtsByCtg = $prdt->produitBycategorie($idCategorie); 
    
    ?>
    <div class="content">
      <div class="container-fluid">
        <div class="tab-bord">
          <h1 class="mb-0">Espace Catégorie</h1>
        </div>
        <div class="container mt-5">
          <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Liste des produits par categorie</h2>
            <a href="espaceCategorie.php" class="btn btn-dark">🔙 Retour</a>
          </div>
          <div class="card shadow">
            <?php if($infoCtg){ ?>
            <div class="card-body p-0">
              <div class="card-header bg-dark text-white">
                <?= htmlspecialchars($infoCtg['nom']) ?>
              </div>
              <?php 
                  if($prdtsByCtg){ ?>
                    <div class="table-responsive">
                      <table class="table table-striped table-hover mb-0">
                        <thead class="bg-dark text-white thead-custom">
                          <tr class="bg-dark text-white" >
                            <th>Libellé</th>
                            <th>Prix (FCFA)</th>
                            <th>Stock</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php foreach($prdtsByCtg as $prdt) { ?>
                            <tr>
                              <td><?= htmlspecialchars($prdt['nom']) ?></td>
                              <td><?= htmlspecialchars($prdt['prix']) ?></td>
                              <td><?= htmlspecialchars($prdt['stock']) ?></td>
                            </tr>
                          <?php } ?>
                        </tbody>
                      </table>
                    </div>
            <?php } 
                  else { ?>
                    <div class="alert alert-warning m-3">Aucun produit trouvé.</div>
                <?php } 
                }
                else { ?>
                  <div class="alert alert-warning m-3">Aucun Categorie trouvé.</div>
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
