<?php
  include "dataBase.php";

  class Client {
    private $conn;
    public function __construct(){
      $db = new Database();
      $this->conn = $db->connect(); 
    }

    public function AddClient($nom, $email, $téléphone, $photo){
      try {
        $sql = "INSERT INTO client(nom, email, téléphone, photo) VALUES(?, ?, ?, ?,)";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$nom, $email, $téléphone, $photo]);
        echo "Client ajouter avec succé";
      } catch (PDOException $e) {
        echo "Erreur lors de l'ajout : " . $e->getMessage();
      }
    }

    public function AllClient(){
      $stmt = $this->conn->query("SELECT * FROM client");
      return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function clientByEmail($email){
      $stmt = $this->conn->prepare("SELECT * FROM client WHERE email = ?");
      $stmt->execute([$email]);
      return $stmt->fetch(PDO::FETCH_ASSOC); // Retourne false si aucune ligne trouvée
    }

    public function editClient($id, $nom, $email, $téléphone, $photo){
      try{
      $stmt = $this->conn->prepare("UPDATE client SET 
                                    nom = ?,
                                    email = ?,
                                    téléphone = ?, 
                                    photo = ?
                                    WHERE id = ?");
      $stmt->execute([$nom, $email, $téléphone, $photo, $id]);
        echo "Client mise a jour avec succée";  
      }
      catch(PDOException $e){
        echo "Erreur lors de la mise à jour ". $e->getMessage();
      }
    }

    public function DeleteClient($id){
      $stmt = $this->conn->prepare("DELETE FROM client WHERE id = ?");
      $stmt->execute([$id]);
    }
  }
