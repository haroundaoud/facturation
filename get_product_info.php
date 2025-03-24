<?php
require 'db.php'; // Vérifie que ce fichier contient bien la connexion

// Vérifier si la classe `Dbf` existe bien
if (!class_exists('Dbt')) {
    echo json_encode(["success" => false, "message" => "Erreur de connexion : classe Dbf non trouvée"]);
    exit;
}

// Création de l'objet connexion
$pdo = new Dbt(); // Assure-toi que `Dbf` est bien définie dans `connect.php`

header("Content-Type: application/json"); // Spécifie le format JSON

if (!isset($_GET['code_barre']) || empty($_GET['code_barre'])) {
    echo json_encode(["success" => false, "message" => "Code-barres manquant"]);
    exit;
}

$codeBarre = $_GET['code_barre'];

try {
    // Préparer et exécuter la requête
    $stmt = $pdo->prepare("SELECT title, prix_unitaire_ht,tva FROM produits WHERE code_barre = ?");
    $stmt->execute([$codeBarre]);
    $produit = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($produit) {
        echo json_encode([
            "success" => true,
            "titre" => $produit["title"],
            "prix_unitaire_ht" => $produit["prix_unitaire_ht"],
            "tva" => $produit["tva"]
        ]);
    } else {
        echo json_encode(["success" => false, "message" => "Produit non trouvé"]);
    }
} catch (Exception $e) {
    echo json_encode(["success" => false, "message" => "Erreur SQL: " . $e->getMessage()]);
}
?>
