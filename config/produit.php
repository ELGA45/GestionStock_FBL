<?php
  require_once "dataBase.php";

  class Produit {
    private $conn;
    public function __construct(){
      $db = new Database();
      $this->conn = $db->connect(); 
    }

    public function AddProduit($nom, $prix, $stock, $idCategorie){
      try {
        $sql = "INSERT INTO produit(nom, prix, stock, idCategorie) VALUES(?,?,?,?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$nom, $prix, $stock, $idCategorie]);
        return "✅ Produit ajouter avec succé";
      } catch (PDOException $e) {
        return "❌ Erreur lors de l'ajout : " . $e->getMessage();
      }
    }

    public function AllProduit(){
      $stmt = $this->conn->query("SELECT p.id, p.nom, prix, stock, c.nom AS categorie
                                  FROM produit p
                                  JOIN categorie c ON c.id = p.idCategorie");
      return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function produitBycategorie($idCategorie){
      $stmt = $this->conn->prepare("SELECT p.nom, prix, stock, c.nom AS categorie
                                  FROM produit p
                                  JOIN categorie c ON c.id = p.idCategorie
                                  WHERE p.idCategorie = ?");
      $stmt->execute([$idCategorie]);
      return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function ProduitById($id){
      $stmt = $this->conn->prepare("SELECT * FROM produit WHERE id = ?");
      $stmt->execute([$id]);
      return $stmt->fetch(PDO::FETCH_ASSOC); // Retourne false si aucune ligne trouvée
    }

    public function info(){
      $stmt = $this->conn->query("SELECT COUNT(id) AS nbrProduit, SUM(prix) AS valeurTotal,
                                          SUM(stock) AS stockTotal
                                  FROM produit ");
      return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function ProduitByNom($nom){
      $stmt = $this->conn->prepare("SELECT * FROM produit WHERE nom = ?");
      $stmt->execute([$nom]);
      return $stmt->fetch(PDO::FETCH_ASSOC); // Retourne false si aucune ligne trouvée
    }

    public function editProduit($id, $nom, $prix, $stock, $idCategorie){
      try{
      $stmt = $this->conn->prepare("UPDATE produit SET 
                                    nom = ?,
                                    prix = ?,
                                    stock = ?,
                                    idCategorie = ?
                                    WHERE id = ?");
      $stmt->execute([$nom, $prix, $stock, $idCategorie, $id]);
        return "✅ Produit mise a jour avec succée";  
      }
      catch(PDOException $e){
        return "❌ Erreur lors de la mise à jour ". $e->getMessage();
      }
    }

    public function DeleteProduit($id){
      $stmt = $this->conn->prepare("DELETE FROM produit WHERE id = ?");
      $stmt->execute([$id]);
    }
  }
