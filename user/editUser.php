<?php
session_start();
include("../include/template.php");
require __DIR__ . '/../config/utilisateur.php';

$message = "";
$messageClass = "info"; // Pour couleur Bootstrap

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'] ?? '';
    $nom = $_POST['nom'] ?? '';
    $email = $_POST['email'] ?? '';
    $mot_de_passe = $_POST['mot_de_passe'] ?? '';
    $role = $_POST['role'] ?? '';
    $statut = $_POST['statut'] ?? '';

    $editUser = new Utilisateur();
    $emailUser = $editUser->UtilisateurByEmail($email);

    $roleActuel = $_SESSION['connectedUser']['rôle'] ?? '';
    $message = $editUser->editUser($id, $nom, $email, $mot_de_passe, $role, $statut,);

    if (strpos($message, '✅') !== false) {
            $messageClass = "success";
    } elseif (strpos($message, '⛔') !== false || strpos($message, '❌') !== false) {
            $messageClass = "danger";
    }
}

if(isset($_SESSION['connectedUser'])){
  //Formulaire pour modifier un utilisateur
  if(isset($_GET['id'])){
    $id = $_GET['id'];
    $user = new Utilisateur();
    $infoUser = $user->UtilisateurById($id);

    if($infoUser){ ?>
      <div class="content">
        <div class="container-fluid">

        <div class="tab-bord">
          <h1 class="mb-0">Espace Utilisateur</h1>
        </div>
        <div class="container mt-5">
          <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Modifier un utilisateur</h2>
                <a href="espaceUser.php" class="btn btn-dark">🔙 Retour</a>
          </div>

          <form action="" method="POST" class="p-4 shadow rounded bg-white" style="max-width: 500px; margin: auto; margin-top: 20px">

              <!-- Message d'information -->
              <?php if (!empty($message)): ?>
                  <div class="alert alert-<?= $messageClass ?> text-center">
                      <?= $message ?>
                  </div>
              <?php endif; ?>
              
              <input type="hidden" name="id" value="$id ">
              <!-- Champ Nom -->
              <div class="mb-3">
                  <label for="nom" class="form-label">Nom</label>
                  <input type="text" id="nom" name="nom" class="form-control" placeholder="Entrez le nom"
                        value="<?= htmlspecialchars($infoUser['nom']) ?>" required>
              </div>

              <!-- Champ Email -->
              <div class="mb-3">
                  <label for="email" class="form-label">E-mail</label>
                  <input type="email" id="email" name="email" class="form-control" placeholder="Entrez l'e-mail"
                        value="<?= htmlspecialchars($infoUser['email']) ?>" required>
              </div>

              <!-- Champ Mot de passe -->
              <div class="mb-3">
                  <label for="mot_de_passe" class="form-label">Mot de passe</label>
                  <input type="password" id="mot_de_passe" name="mot_de_passe" class="form-control" placeholder="Entrez le mot de passe" required>
              </div>

              <!-- Champ Rôle -->
              <div class="mb-3">
                  <label for="role" class="form-label">Rôle</label>
                  <select id="role" name="role" class="form-select" required>
                    <?php 
                          $libelleActu = $infoUser['rôle'] == "admin"?"Administrateur":"Employé";
                          $role = $infoUser['rôle'] == "admin"?"employé":"admin";
                          $libelleRole = $role == "admin"?"Administrateur":"Employé"
                    ?>
                      <option value="<?= $infoUser['rôle'] ?>"><?= htmlspecialchars($libelleActu) ?></option>
                      <option value="<?= $role ?>"><?= $libelleRole ?></option>
                  </select>
              </div>

              <!-- Champ Statut -->
              <div class="mb-4">
                  <label for="statut" class="form-label">Statut</label>
                  <select id="statut" name="statut" class="form-select" required>
                    <?php $statut = $infoUser['statut'] == "actif"?"inactif":"actif";
                    ?>
                      <option value="<?= $infoUser['statut'] ?>"><?= htmlspecialchars($infoUser['statut']) ?></option>
                      <option value="<?= $statut ?>"><?= htmlspecialchars($statut) ?></option>
                  </select>
                  </select>
              </div>

              <!-- Bouton -->
              <button type="submit" class="btn btn-dark w-100">Modifier</button>
          </form>
        </div>
      </div>
  <?php }
    else {
      header("location:espaceUser.php");
      exit();
    }
  }


  //Formulaire pour modifier le statut
  if(isset($_GET['statut'])){
    $id = $_GET['statut'];
    $user = new Utilisateur();
    $infoUser = $user->UtilisateurById($id);

    if($infoUser){
      $statut = $infoUser['statut'] == "actif"?"inactif":"actif";
      $user->statutUser($id, $statut);
      header("location:espaceUser.php");
      exit();
    }
  }


    include '../include//footer.php';

  } else {
    header('Location:/GestionStock_FBL/authentification/login.php?auth=0');
    exit();
  }