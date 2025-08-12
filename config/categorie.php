<?php
  require_once "dataBase.php";

  class Categorie {
    private $conn;
    public function __construct(){
      $db = new Database();
      $this->conn = $db->connect(); 
    }

    public function addCategorie($nom){
      try {
        $sql = "INSERT INTO categorie(nom) VALUES(?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$nom]);
        return "✅ Categorie ajouter avec succé";
      } catch (PDOException $e) {
        return "❌ Erreur lors de l'ajout : " . $e->getMessage();
      }
    }

    public function AllCategorie(){
      $stmt = $this->conn->query("SELECT c.id, c.nom, COUNT(p.id) AS nbr_prdt
                                  FROM categorie c
                                  LEFT JOIN produit p ON p.idCategorie = c.id
                                  GROUP BY c.id, c.nom");
      return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function categorieById($id){
      $stmt = $this->conn->prepare("SELECT *
                                  FROM categorie
                                  WHERE id = ?");
      $stmt->execute([$id]);                          
      return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function categorieByNom($nom){
      $stmt = $this->conn->prepare("SELECT *
                                  FROM categorie
                                  WHERE nom = ?");
      $stmt->execute([$nom]);                          
      return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function editCategorie($id, $nom){
      try{
      $stmt = $this->conn->prepare("UPDATE categorie SET 
                                    nom = ?
                                    WHERE id = ?");
      $stmt->execute([$nom, $id]);
        return "✅ Categorie mise a jour avec succée";  
      }
      catch(PDOException $e){
        return "❌ Erreur lors de la mise à jour ". $e->getMessage();
      }
    }

    public function DeleteCategorie($id){
      $stmt = $this->conn->prepare("DELETE FROM categorie WHERE id = ?");
      $stmt->execute([$id]);
    }
  }
