<?php
  session_start();
  include("../include/template.php");
  require __DIR__ . '/../config/utilisateur.php';

  function verifieRole($role){
      if($role == 'admin'){
        return true;
      }
      else {
        return false;
      }
    }

if(isset($_SESSION['connectedUser'])){
    $user = new Utilisateur();
    $allUsers = $user->AllUtilisateur(); 
    
    $roleUser = verifieRole($_SESSION['connectedUser']['rôle']);
?>
<div class="content">
  <div class="container-fluid">
    <div class="tab-bord">
      <h1 class="mb-0">Espace Utilisateur</h1>
    </div>
    <div class="container mt-5">
      <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Liste des utilisateurs</h2>
        <?php 
          if($roleUser){ ?>
            <a href="addUser.php" class="btn btn-dark">➕ Ajouter un utilisateur</a>
        <?php } ?>
      </div>

      <div class="card shadow">
        <div class="card-body p-0">
          <?php if($allUsers){ ?>
            <div class="table-responsive">
              <table class="table table-striped table-hover mb-0">
                <thead class="bg-dark text-white thead-custom">
                  <tr class="bg-dark text-white" >
                    <th>Nom</th>
                    <th>Email</th>
                    <th>Rôle</th>
                    <th>Statut</th>
            <?php if($roleUser){ ?>
                    <th>Actions</th>
            <?php } ?>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach($allUsers as $users) { ?>
                    <tr>
                      <td><?= htmlspecialchars($users['nom']) ?></td>
                      <td><?= htmlspecialchars($users['email']) ?></td>
                      <td><?= htmlspecialchars($users['rôle']) ?></td>
              <?php if($roleUser){ ?>
                      <td>
                        <?php echo "<a href='editUser.php?statut=".$users['id']."' class='btn btn-sm btn-info'>
                                      ".$users['statut']."
                                    </a>";
                    }
                    else { ?>
                        <td><?= htmlspecialchars($users['statut']) ?></td>
              <?php }
                    if($roleUser){ ?>
                      <td>
                        <?php echo "<a href='editUser.php?id=".$users['id']."' class='btn btn-sm btn-warning'>
                                      ✏️ Modifier
                                    </a>&nbsp";
                              echo "<a href='deleteUser.php?id=".$users['id']."' class='btn btn-sm btn-danger'>
                                      🗑️ Supprimer
                                    </a>";
                    } ?>
                      </td>
                    </tr>
                  <?php } ?>
                </tbody>
              </table>
            </div>
          <?php } else { ?>
            <div class="alert alert-warning m-3">Aucun utilisateur trouvé.</div>
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
