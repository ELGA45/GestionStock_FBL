<?php
  include "dataBase.php";

  class Utilisateur {
    private $conn;
    public function __construct(){
      $db = new Database();
      $this->conn = $db->connect(); 
    }

    public function AddUtilisateur($nom, $email, $mot_de_passe, $role, $statut, $roleActuel) {
      if ($roleActuel !== 'admin') {
          return "⛔ Accès refusé : seuls les admins peuvent ajouter un utilisateur.";
        return;
      }
      else {
        $motDePasseHache = password_hash($mot_de_passe, PASSWORD_DEFAULT);
        try {
          $sql = "INSERT INTO utilisateur(nom, email, mot_de_passe, rôle, statut) VALUES(?,?,?,?,?)";
          $stmt = $this->conn->prepare($sql);
          $stmt->execute([$nom, $email, $motDePasseHache, $role, $statut]);
          return "✅ Utilisateur ajouté avec succès";
        } catch (PDOException $e) {
          return "❌ Erreur lors de l'ajout : " . $e->getMessage();
        }
      }
    }

    public function AllUtilisateur(){
      $stmt = $this->conn->query("SELECT nom, email, rôle, statut
                                  FROM utilisateur");
      return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function UtilisateurByEmail($email){
      $sql = "SELECT * FROM utilisateur WHERE email = ?";
      $stmt = $this->conn->prepare($sql); 
      $stmt->execute([$email]); 
      return $stmt->fetch(PDO::FETCH_ASSOC);
    }


    public function DeleteUtilisateur($id, $roleActuel){
      if ($roleActuel !== 'admin') {
        echo "⛔ Accès refusé : seuls les admins peuvent ajouter un utilisateur.";
        return;
      }
      else{
        $stmt = $this->conn->prepare("DELETE FROM utilisateur WHERE id = ?");
        $stmt->execute([$id]);
      }
    }
  }
