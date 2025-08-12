<?php
  session_start();
  include("../include/template.php");
  require __DIR__ . '/../config/client.php';


if(isset($_SESSION['connectedUser'])){
    $client = new Client();
    $allClients = $client->Allclient(); 
    
?>
<div class="content">
  <div class="container-fluid">
    <div class="tab-bord">
      <h1 class="mb-0">Espace Client</h1>
    </div>
    <div class="container mt-5">
      <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Liste des clients</h2>
        <a href="addClient.php" class="btn btn-dark">➕ Ajouter un client</a>
      </div>

      <div class="card shadow">
        <div class="card-body p-0">
          <?php if($allClients){ ?>
            <div class="table-responsive">
              <table class="table table-striped table-hover mb-0">
                <thead class="bg-dark text-white thead-custom">
                  <tr class="bg-dark text-white" >
                    <th>Nom</th>
                    <th>Email</th>
                    <th>Téléphone</th>
                    <th>Actions</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach($allClients as $clients) { ?>
                    <tr>
                      <td><?= htmlspecialchars($clients['nom']) ?></td>
                      <td><?= htmlspecialchars($clients['email']) ?></td>
                      <td><?= htmlspecialchars($clients['téléphone']) ?></td>
                      <td>
                        <?php echo "<a href='editClient.php?id=".$clients['id']."' class='btn btn-sm btn-warning'>
                                      ✏️ Modifier
                                    </a>&nbsp";
                              echo "<a href='deleteClient.php?id=".$clients['id']."' class='btn btn-sm btn-danger'>
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
            <div class="alert alert-warning m-3">Aucun client trouvé.</div>
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
