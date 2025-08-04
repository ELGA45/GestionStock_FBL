<?php
  include "dataBase.php";

  class Categorie {
    private $conn;
    public function __construct(){
      $db = new Database();
      $this->conn = $db->connect(); 
    }

    public function AddCategorie($nom){
      try {
        $sql = "INSERT INTO categorie(nom) VALUES(?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$nom]);
        echo "Categorie ajouter avec succé";
      } catch (PDOException $e) {
        echo "Erreur lors de l'ajout : " . $e->getMessage();
      }
    }

    public function AllCategorie(){
      $stmt = $this->conn->query("SELECT * FROM categorie");
      return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function editCategorie($id, $nom){
      try{
      $stmt = $this->conn->prepare("UPDATE categorie SET 
                                    nom = ?
                                    WHERE id = ?");
      $stmt->execute([$nom, $id]);
        echo "Categorie mise a jour avec succée";  
      }
      catch(PDOException $e){
        echo "Erreur lors de la mise à jour ". $e->getMessage();
      }
    }

    public function DeleteCategorie($id){
      $stmt = $this->conn->prepare("DELETE FROM categorie WHERE id = ?");
      $stmt->execute([$id]);
    }
  }
