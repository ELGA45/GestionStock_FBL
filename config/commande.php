<?php
require_once "dataBase.php";

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

            // Vérifier si le client existe
            $stmtCheckClient = $this->conn->prepare("SELECT id FROM client WHERE id = ?");
            $stmtCheckClient->execute([$idClient]);
            if (!$stmtCheckClient->fetchColumn()) {
                return "⚠️ Client introuvable";
            }

            // 1. Insérer la commande
            $sql = "INSERT INTO commande(idClient, dateCommande, etat) VALUES (?, NOW(), 'en attente')";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([$idClient]);
            $idCommande = $this->conn->lastInsertId();

            // 2. Ajouter les produits dans commande_produit + mettre à jour le stock
            $sqlProd = "INSERT INTO commande_produit(idCommande, idProduit, quantite) VALUES (?, ?, ?)";
            $stmtProd = $this->conn->prepare($sqlProd);

            $sqlUpdateStock = "UPDATE produit SET stock = stock - ? WHERE id = ? AND stock >= ?";
            $stmtStock = $this->conn->prepare($sqlUpdateStock);

            foreach ($produits as $p) {
                // Vérifier si le produit existe et stock suffisant
                $stmtCheckProd = $this->conn->prepare("SELECT stock FROM produit WHERE id = ?");
                $stmtCheckProd->execute([$p['idProduit']]);
                $stockActuel = $stmtCheckProd->fetchColumn();

                if ($stockActuel === false) {
                    $this->conn->rollBack();
                    return "⚠️ Produit ID {$p['idProduit']} introuvable";
                }

                if ($stockActuel < $p['quantite']) {
                    $this->conn->rollBack();
                    return "⚠️ Stock insuffisant pour le produit ID {$p['idProduit']}";
                }

                // Ajouter à commande_produit
                $stmtProd->execute([$idCommande, $p['idProduit'], $p['quantite']]);

                // Diminuer le stock
                $stmtStock->execute([$p['quantite'], $p['idProduit'], $p['quantite']]);
            }

            $this->conn->commit();
            return "✅ Commande ajoutée et stock mis à jour avec succès";
        } catch (PDOException $e) {
            $this->conn->rollBack();
            return "❌ Erreur lors de l'ajout : " . $e->getMessage();
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

    public function UpdateCommande($idCommande, $idClient, $produits) {
    try {
        $this->conn->beginTransaction();

        // Supprimer les anciens produits de la commande
        $sqlDeleteProd = "DELETE FROM commande_produit WHERE idCommande = ?";
        $stmtDel = $this->conn->prepare($sqlDeleteProd);
        $stmtDel->execute([$idCommande]);

        // Remettre le stock des anciens produits
        $sqlStockRetour = "UPDATE produit p 
                           JOIN commande_produit cp ON p.id = cp.idProduit 
                           SET p.stock = p.stock + cp.quantite 
                           WHERE cp.idCommande = ?";
        $stmtStockRetour = $this->conn->prepare($sqlStockRetour);
        $stmtStockRetour->execute([$idCommande]);

        // Mettre à jour le client
        $sqlUpdateCmd = "UPDATE commande SET idClient = ? WHERE id = ?";
        $stmtUpdateCmd = $this->conn->prepare($sqlUpdateCmd);
        $stmtUpdateCmd->execute([$idClient, $idCommande]);

        // Ajouter les nouveaux produits
        $sqlProd = "INSERT INTO commande_produit(idCommande, idProduit, quantite) VALUES (?, ?, ?)";
        $stmtProd = $this->conn->prepare($sqlProd);

        // Diminuer le stock pour les nouveaux produits
        $sqlUpdateStock = "UPDATE produit SET stock = stock - ? WHERE id = ?";
        $stmtStock = $this->conn->prepare($sqlUpdateStock);

        foreach ($produits as $p) {
            $stmtProd->execute([$idCommande, $p['idProduit'], $p['quantite']]);
            $stmtStock->execute([$p['quantite'], $p['idProduit']]);
        }

        $this->conn->commit();
        return "✅ Commande modifiée avec succès";
    } catch (PDOException $e) {
        $this->conn->rollBack();
        return "❌ Erreur lors de la modification : " . $e->getMessage();
    }
}


    // Modifier état d'une commande
    public function UpdateEtat($idCommande, $nouvelEtat) {
        // Vérifier l'état actuel
        $sqlCheck = "SELECT etat FROM commande WHERE id = ?";
        $stmtCheck = $this->conn->prepare($sqlCheck);
        $stmtCheck->execute([$idCommande]);
        $etatActuel = $stmtCheck->fetchColumn();

        if (!$etatActuel) {
            return "⚠️ Commande introuvable";
        }

        if ($etatActuel === 'livrée') {
            return "⚠️ Impossible de modifier une commande déjà livrée";
        }

        $etatsValides = ['en attente', 'en cours', 'livrée'];
        if (!in_array($nouvelEtat, $etatsValides)) {
            return "❌ État invalide";
        }

        $sql = "UPDATE commande SET etat = ? WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$nouvelEtat, $idCommande]);
        return "✅ État de la commande mis à jour";
    }

    // Supprimer une commande
    public function DeleteCommande($idCommande) {
        try {
            // Vérifier l'état de la commande
            $sqlEtat = "SELECT etat FROM commande WHERE id = ?";
            $stmtEtat = $this->conn->prepare($sqlEtat);
            $stmtEtat->execute([$idCommande]);
            $etat = $stmtEtat->fetchColumn();

            if (!$etat) {
                return "⚠️ Commande introuvable";
            }

            $this->conn->beginTransaction();

            // Si état = livrée → on remet le stock
            if ($etat === 'livrée') {
                $sqlSelect = "SELECT idProduit, quantite FROM commande_produit WHERE idCommande = ?";
                $stmtSelect = $this->conn->prepare($sqlSelect);
                $stmtSelect->execute([$idCommande]);
                $produits = $stmtSelect->fetchAll(PDO::FETCH_ASSOC);

                $sqlUpdateStock = "UPDATE produit SET stock = stock + ? WHERE id = ?";
                $stmtStock = $this->conn->prepare($sqlUpdateStock);
                foreach ($produits as $p) {
                    $stmtStock->execute([$p['quantite'], $p['idProduit']]);
                }
            }

            // Supprimer dans commande_produit
            $sqlDeleteProd = "DELETE FROM commande_produit WHERE idCommande = ?";
            $stmtDelProd = $this->conn->prepare($sqlDeleteProd);
            $stmtDelProd->execute([$idCommande]);

            // Supprimer la commande
            $sqlDeleteCmd = "DELETE FROM commande WHERE id = ?";
            $stmtDelCmd = $this->conn->prepare($sqlDeleteCmd);
            $stmtDelCmd->execute([$idCommande]);

            $this->conn->commit();
            return "✅ Commande supprimée avec succès";
        } catch (PDOException $e) {
            $this->conn->rollBack();
            return "❌ Erreur lors de la suppression : " . $e->getMessage();
        }
    }
}
?>
