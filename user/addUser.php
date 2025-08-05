<form action="" method="POST">
        <h2>Ajouter un Utilisateur</h2>

        <!-- Champ Nom -->
        <label for="nom">Nom</label>
        <input type="text" id="nom" name="nom" placeholder="Entrez le nom" required>

        <!-- Champ Email -->
        <label for="email">Email</label>
        <input type="email" id="email" name="email" placeholder="Entrez l'email" required>

        <!-- Champ Mot de passe -->
        <label for="mot_de_passe">Mot de passe</label>
        <input type="password" id="mot_de_passe" name="mot_de_passe" placeholder="Entrez le mot de passe" required>

        <!-- Champ Rôle -->
        <label for="role">Rôle</label>
        <select id="role" name="role" required>
            <option value="">-- Sélectionner --</option>
            <option value="admin">Administrateur</option>
            <option value="employé">emloyé</option>
        </select>

        <!-- Champ Statut -->
        <label for="statut">Statut</label>
        <select id="statut" name="statut" required>
            <option value="">-- Sélectionner --</option>
            <option value="actif">Actif</option>
            <option value="inactif">Inactif</option>
        </select>

        <button type="submit">Enregistrer</button>
    </form>

<?php
  require 'config/utilisateur.php';
  
  if($_SERVER['REQUEST_METHOD'] === 'POST'){
    extract($_POST);
    $newUser = New Utilisateur();
    $newUser->AddUtilisateur($nom, $email, $mot_de_passe, $role, $statut, $roleActuel);
  }