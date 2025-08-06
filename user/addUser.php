<?php
session_start();
include("../include/template.php");
require __DIR__ . '/../config/utilisateur.php';

$message = "";
$messageClass = "info"; // Pour couleur Bootstrap

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = $_POST['nom'] ?? '';
    $email = $_POST['email'] ?? '';
    $mot_de_passe = $_POST['mot_de_passe'] ?? '';
    $role = $_POST['role'] ?? '';
    $statut = $_POST['statut'] ?? '';

    $newUser = new Utilisateur();
    $emailUser = $newUser->UtilisateurByEmail($email);

    if (!$emailUser) {
        $roleActuel = $_SESSION['connectedUser']['rôle'] ?? '';
        $message = $newUser->AddUtilisateur($nom, $email, $mot_de_passe, $role, $statut, $roleActuel);

        // Couleur du message selon contenu
        if (strpos($message, '✅') !== false) {
            $messageClass = "success";
        } elseif (strpos($message, '⛔') !== false || strpos($message, '❌') !== false) {
            $messageClass = "danger";
        }
    } else {
        $message = "⚠️ Cet e-mail est déjà enregistré";
        $messageClass = "warning";
    }
}
?>

<div class="content">
  <div class="container-fluid">

    <!-- Barre fixe avec titre -->
    <div class="tab-bord">
      <h1 class="mb-0">Utilisateur</h1>
    </div>

    <form action="" method="POST" class="p-4 shadow rounded bg-white" style="max-width: 500px; margin: auto; margin-top: 20px">
        <h2 class="text-center mb-4">Ajouter un Utilisateur</h2>

        <!-- Message d'information -->
        <?php if (!empty($message)): ?>
            <div class="alert alert-<?= $messageClass ?> text-center">
                <?= $message ?>
            </div>
        <?php endif; ?>

        <!-- Champ Nom -->
        <div class="mb-3">
            <label for="nom" class="form-label">Nom</label>
            <input type="text" id="nom" name="nom" class="form-control" placeholder="Entrez le nom"
                  value="<?= htmlspecialchars($nom ?? '') ?>" required>
        </div>

        <!-- Champ Email -->
        <div class="mb-3">
            <label for="email" class="form-label">E-mail</label>
            <input type="email" id="email" name="email" class="form-control" placeholder="Entrez l'e-mail"
                  value="<?= htmlspecialchars($email ?? '') ?>" required>
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
                <option value="">-- Sélectionner --</option>
                <option value="admin" <?= (isset($role) && $role === 'admin') ? 'selected' : '' ?>>Administrateur</option>
                <option value="employé" <?= (isset($role) && $role === 'employé') ? 'selected' : '' ?>>Employé</option>
            </select>
        </div>

        <!-- Champ Statut -->
        <div class="mb-4">
            <label for="statut" class="form-label">Statut</label>
            <select id="statut" name="statut" class="form-select" required>
                <option value="">-- Sélectionner --</option>
                <option value="actif" <?= (isset($statut) && $statut === 'actif') ? 'selected' : '' ?>>Actif</option>
                <option value="inactif" <?= (isset($statut) && $statut === 'inactif') ? 'selected' : '' ?>>Inactif</option>
            </select>
        </div>

        <!-- Bouton -->
        <button type="submit" class="btn btn-dark w-100">Enregistrer</button>
    </form>
  </div>
</div>
