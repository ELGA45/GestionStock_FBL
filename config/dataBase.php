<?php
  class database{   
    private $host = "localhost"; 
    private $dbname = "gestionstockfld"; 
    private $username = "root"; 
    private $password = "";     
    private $conn;

    public function connect(){
      if($this->conn == null){
        try { 
          $this->conn = new PDO("mysql:host=$this->host;dbname=$this->dbname;",$this->username, $this->password); 
          $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
        } catch (PDOException $e) { 
          die("Erreur de connexion : " . $e->getMessage()); 
        } 
      }
      return $this->conn;
    }
  }