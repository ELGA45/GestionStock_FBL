<?php
  require_once "dataBase.php";

  class Client {
    private $conn;
    public function __construct(){
      $db = new Database();
      $this->conn = $db->connect(); 
    }

    public function AddClient($nom, $email, $téléphone){
      try {
        $sql = "INSERT INTO client(nom, email, téléphone) VALUES(?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$nom, $email, $téléphone]);
        return "✅ Client ajouter avec succé";
      } catch (PDOException $e) {
        return "❌ Erreur lors de l'ajout : " . $e->getMessage();
      }
    }

    public function AllClient(){
      $stmt = $this->conn->query("SELECT * FROM client");
      return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function clientById($id){
      $stmt = $this->conn->prepare("SELECT * FROM client WHERE id = ?");
      $stmt->execute([$id]);
      return $stmt->fetch(PDO::FETCH_ASSOC); 
    }

    public function clientByEmail($email){
      $stmt = $this->conn->prepare("SELECT * FROM client WHERE email = ?");
      $stmt->execute([$email]);
      return $stmt->fetch(PDO::FETCH_ASSOC); 
    }

    public function editClient($id, $nom, $email, $téléphone){
      try{
      $stmt = $this->conn->prepare("UPDATE client SET 
                                    nom = ?,
                                    email = ?,
                                    téléphone = ?
                                    WHERE id = ?");
      $stmt->execute([$nom, $email, $téléphone, $id]);
        return "✅ Client mise a jour avec succée";  
      }
      catch(PDOException $e){
        return "❌ Erreur lors de la mise à jour ". $e->getMessage();
      }
    }

    public function DeleteClient($id){
      $stmt = $this->conn->prepare("DELETE FROM client WHERE id = ?");
      $stmt->execute([$id]);
    }
  }
