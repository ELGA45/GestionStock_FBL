<?php
session_start();
include("../include/template.php");
require_once __DIR__ . '/../config/produit.php';
require_once __DIR__ . '/../config/categorie.php';

$message = "";
$messageClass = "info"; // Pour couleur Bootstrap

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'] ?? '';
    $nom = $_POST['nom'] ?? '';
    $prix = $_POST['prix'] ?? '';
    $stock = $_POST['stock'] ?? '';
    $ctg = $_POST['categorie'] ?? '';


    $editProduit = new Produit();
    $message = $editProduit->editProduit($id, $nom, $prix, $stock, $ctg);

    if (strpos($message, '✅') !== false) {
            $messageClass = "success";
    } elseif (strpos($message, '⛔') !== false || strpos($message, '❌') !== false) {
            $messageClass = "danger";
    }
}

if(isset($_SESSION['connectedUser'])){

  $categorie = new Categorie;
  $allCtg = $categorie->AllCategorie();

  if(isset($_GET['id'])){
    $id = htmlspecialchars($_GET['id']);
    $prdt = new Produit();
    $infoPrdt = $prdt->ProduitById($id);

    if($infoPrdt){ ?>
      <div class="content">
        <div class="container-fluid">

        <div class="tab-bord">
          <h1 class="mb-0">Espace Produit</h1>
        </div>
        <div class="container mt-5">
          <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Modifier un Produit</h2>
            <a href="espaceProduit.php" class="btn btn-dark">🔙 Retour</a>
          </div>
        </div>

          <form action="" method="POST" class="p-4 shadow rounded bg-white" style="max-width: 500px; margin: auto; margin-top: 20px">

              <!-- Message d'information -->
              <?php if (!empty($message)): ?>
                  <div class="alert alert-<?= $messageClass ?> text-center">
                      <?= $message ?>
                  </div>
              <?php endif; ?>
              
              <input type="hidden" name="id" value="<?= htmlspecialchars($infoPrdt['id']) ?>">
              <!-- Champ Nom -->
              <div class="mb-3">
                  <label for="nom" class="form-label">Nom</label>
                  <input type="text" id="nom" name="nom" class="form-control" placeholder="Entrez le Libellé"
                        value="<?= htmlspecialchars($infoPrdt['nom']) ?>" required>
              </div>

              <!-- Champ prix -->
        <div class="mb-3">
            <label for="prix" class="form-label">Prix</label>
            <input type="number" id="prix" name="prix" class="form-control" placeholder="Entrez le prix unitair"
                    value="<?= htmlspecialchars($infoPrdt['prix']) ?>" required>
        </div>

        <!-- Champ stock -->
        <div class="mb-3">
            <label for="stock" class="form-label">Stock</label>
            <input type="number" id="stock" name="stock" class="form-control" placeholder="Entrez le stock" 
                    value="<?= htmlspecialchars($infoPrdt['stock']) ?>" required>
        </div>
        
        <!-- Champ categorie -->
        <div class="mb-3">
            <label for="categorie" class="form-label">Catégorie</label>
            <select id="categorie" name="categorie" class="form-select" required>
          <?php foreach($allCtg as $ctg){ ?>
                  <option <?= $ctg['id'] ===  $infoPrdt['idCategorie']?'selected':''?>
                    value="<?= htmlspecialchars($ctg['id']) ?>"><?= htmlspecialchars($ctg['nom']) ?>
                  </option>
          <?php  } ?>
            </select>
        </div>


              <!-- Bouton -->
              <button type="submit" class="btn btn-dark w-100">Modifier</button>
          </form>
        </div>
      </div>
  <?php }
    else {
      header("location:espaceProduit.php");
      exit();
    }
  }

    include '../include//footer.php';

  } else {
    header('Location:/GestionStock_FBL/authentification/login.php?auth=0');
    exit();
  }