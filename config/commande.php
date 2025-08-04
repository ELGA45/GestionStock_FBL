<?php
include "dataBase.php";

class Commande {
    private $conn;

    public function __construct() {
        $db = new Database();
        $this->conn = $db->connect();
    }

    // Ajouter une commande
    public function AddCommande($idClient, $produits) {
    try {
        $this->conn->beginTransaction();

        // 1. Insérer la commande
        $sql = "INSERT INTO commande(idClient, dateCommande, etat) VALUES (?, NOW(), 'en attente')";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$idClient]);
        $idCommande = $this->conn->lastInsertId();

        // 2. Ajouter les produits dans commande_produit
        $sqlProd = "INSERT INTO commande_produit(idCommande, idProduit, quantite) VALUES (?, ?, ?)";
        $stmtProd = $this->conn->prepare($sqlProd);

        // 3. Préparer la requête de mise à jour du stock
        $sqlUpdateStock = "UPDATE produit SET stock = stock - ? WHERE id = ?";
        $stmtStock = $this->conn->prepare($sqlUpdateStock);

        foreach ($produits as $p) {
            // Ajouter à commande_produit
            $stmtProd->execute([$idCommande, $p['idProduit'], $p['quantite']]);

            // Diminuer le stock
            $stmtStock->execute([$p['quantite'], $p['idProduit']]);
        }

        $this->conn->commit();
        echo "Commande ajoutée et stock mis à jour avec succès";
    } catch (PDOException $e) {
        $this->conn->rollBack();
        echo "Erreur lors de l'ajout : " . $e->getMessage();
    }
}


    // Liste des commandes
    public function AllCommandes() {
        $sql = "SELECT c.id, cl.nom AS client, c.dateCommande, c.etat
                FROM commande c
                JOIN client cl ON cl.id = c.idClient";
        $stmt = $this->conn->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Détails d'une commande
    public function DetailsCommande($idCommande) {
        $sql = "SELECT p.nom, cp.quantite, p.prix, (cp.quantite * p.prix) AS total
                FROM commande_produit cp
                JOIN produit p ON p.id = cp.idProduit
                WHERE cp.idCommande = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$idCommande]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Modifier état d'une commande
    public function UpdateEtat($idCommande, $nouvelEtat) {
        $sql = "UPDATE commande SET etat = ? WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$nouvelEtat, $idCommande]);
        echo "État de la commande mis à jour";
    }

    public function DeleteCommande($idCommande) {
    try {
        $sql = "DELETE FROM commande WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$idCommande]);
        echo "Commande supprimée avec succès";
    } catch (PDOException $e) {
        echo "Erreur lors de la suppression : " . $e->getMessage();
    }
}
}
?>
