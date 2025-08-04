<?php
  include "dataBase.php";

  class Produit {
    private $conn;
    public function __construct(){
      $db = new Database();
      $this->conn = $db->connect(); 
    }

    public function AddProduit($nom, $prix, $stock, $image, $idCategorie){
      try {
        $sql = "INSERT INTO produit(nom, prix, stock, 'image', idCategorie) VALUES(?,?,?,?,?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$nom, $prix, $stock, $image, $idCategorie]);
        echo "Produit ajouter avec succé";
      } catch (PDOException $e) {
        echo "Erreur lors de l'ajout : " . $e->getMessage();
      }
    }

    public function AllProduit(){
      $stmt = $this->conn->query("SELECT nom, prix, stock, image, idCategorie AS categorie
                                  FROM produit p
                                  JOIN categorie c ON c.id = p.idCategorie");
      return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function ProduitById($id){
      $stmt = $this->conn->prepare("SELECT * FROM produit WHERE id = ?");
      $stmt->execute([$id]);
      return $stmt->fetch(PDO::FETCH_ASSOC); // Retourne false si aucune ligne trouvée
    }

    public function editProduit($id, $nom, $prix, $stock, $image, $idCategorie){
      try{
      $stmt = $this->conn->prepare("UPDATE produit SET 
                                    nom = ?,
                                    prix = ?,
                                    stock = ?,
                                    image = ?,
                                    idCategorie = ?
                                    WHERE id = ?");
      $stmt->execute([$nom, $prix, $stock, $image, $idCategorie, $id]);
        echo "Produit mise a jour avec succée";  
      }
      catch(PDOException $e){
        echo "Erreur lors de la mise à jour ". $e->getMessage();
      }
    }

    public function DeleteProduit($id){
      $stmt = $this->conn->prepare("DELETE FROM produit WHERE id = ?");
      $stmt->execute([$id]);
    }
  }
