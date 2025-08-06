<?php
  include 'include/template.php';
?>

<!-- Contenu principal -->

<div class="content">
  <div class="container-fluid">

    <!-- Barre fixe avec titre -->
    <div class="tab-bord">
      <h1 class="mb-0">Tableau de bord</h1>
    </div>

    <!-- Contenu qui défile -->
    <div class="main-dashboard">

      <!-- Cartes statistiques -->
      <div class="row mb-4">
        <div class="col-md-4">
          <div class="card text-center shadow-sm">
            <div class="card-body">
              <h5 class="card-title">Nombre de produits</h5>
              <p class="display-6 fw-bold text-primary">150</p>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="card text-center shadow-sm">
            <div class="card-body">
              <h5 class="card-title">Stock total</h5>
              <p class="display-6 fw-bold text-success">5,000</p>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="card text-center shadow-sm">
            <div class="card-body">
              <h5 class="card-title">Valeur totale</h5>
              <p class="display-6 fw-bold text-danger">€75,000</p>
            </div>
          </div>
        </div>
      </div>

      <!-- Tableau des mouvements récents -->
      <div class="card shadow-sm">
        <div class="card-header bg-dark text-white">
          Mouvements récents
        </div>
        <div class="card-body p-0">
          <table class="table table-striped table-hover mb-0">
            <thead>
              <tr>
                <th>Date</th>
                <th>Produit</th>
                <th>Quantité</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>18/04/2024</td>
                <td>Produit D</td>
                <td class="text-danger">-2</td>
              </tr>
              <tr>
                <td>16/04/2024</td>
                <td>Produit A</td>
                <td class="text-success">+10</td>
              </tr>
              <tr>
                <td>15/04/2024</td>
                <td>Produit C</td>
                <td class="text-danger">-5</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>

    </div><!-- Fin main-dashboard -->
  </div>
</div>

  <?php
  include 'include/footer.php';
?>