<?php
require 'db.php'; // Inclusion de la classe de connexion
$db = new Dbt(); // Connexion à la base de données

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!isset($_POST['type_fac'], $_POST['client_id'], $_POST['quantite'], $_POST['code_barre'], $_POST['prix_unitaire_ht'],$_POST['tva'])) {
        die("Tous les champs sont obligatoires.");
    }

    $type_fac = $_POST['type_fac'];
    $client_id = $_POST['client_id'];
    $client_id = intval($client_id);

    $nombre_produits = count($_POST['quantite']);

    if (
        count($_POST['code_barre']) !== $nombre_produits ||
        count($_POST['prix_unitaire_ht']) !== $nombre_produits ||
        (isset($_POST['remise']) && count($_POST['remise']) !== $nombre_produits)
    ) {
        die("Erreur : données incohérentes.");
    }

    $total_ht = 0;
    $total_tva = 0;
    $total_ttc = 0;

    for ($i = 0; $i < $nombre_produits; $i++) {
        $quantite = intval($_POST['quantite'][$i]);
        $prix_ht = floatval($_POST['prix_unitaire_ht'][$i]);
        $tva_produit = floatval($_POST['tva'][$i]);
        $c=$_POST['tva'][$i];
        //Afficher le type de la variable $c
        //echo "Type of \$c: " . gettype($c) . " - Value: " . $c;
        //die();  // Arrête le script pour voir la sortie
        $tva = $prix_ht * ($tva_produit/100);
        $prix_ttc = $prix_ht + $tva;
        $remise = isset($_POST['remise'][$i]) ? floatval($_POST['remise'][$i]) : 0;
        $prix_total = $prix_ht * $quantite * (1 - $remise / 100);

        $total_ht += $prix_total;
        $total_tva += $tva * $quantite;
        $total_ttc += $prix_ttc * $quantite * (1 - $remise / 100);
    }
    $total_ht = floatval(number_format($total_ht, 3, '.', ''));
    $total_tva = floatval(number_format($total_tva, 3, '.', ''));
    $total_ttc = floatval(number_format($total_ttc, 3, '.', ''));


    // Insertion de la facture
    try {
        $query = "INSERT INTO devis (client_id, total_ht, total_tva, total_ttc) VALUES (?, ?, ?, ?)";
        var_dump($client_id, $total_ht, $total_tva, $total_ttc); // Vérifie les valeurs avant insertion

        $devis_id = $db->insert($query, [$client_id, $total_ht, $total_tva, $total_ttc]);

        if ($devis_id) {
            echo "Facture créée avec succès, ID: " . $devis_id;
        } else {
            echo "Échec de l'insertion de la facture.";
        }
    } catch (PDOException $e) {
        echo "Erreur SQL : " . $e->getMessage();
    }


    if ($devis_id) {
        $query = "INSERT INTO devis_details (devis_id, produit_id, quantite, prix_unitaire, remise, sous_total,tva) 
                  VALUES (?, ?, ?, ?, ?, ?,?)";
        $stmt = $db->prepare($query);

        for ($i = 0; $i < $nombre_produits; $i++) {
            $code_barre = $_POST['code_barre'][$i];
            $quantite = intval($_POST['quantite'][$i]);
            $prix_ht = floatval($_POST['prix_unitaire_ht'][$i]);
            $remise = isset($_POST['remise'][$i]) ? floatval($_POST['remise'][$i]) : 0;
            $prix_total = $prix_ht * $quantite * (1 - $remise / 100);
            $tva1 =isset($_POST['tva'][$i]) ? floatval($_POST['tva'][$i]):19 ;

            $stmt->execute([$devis_id, $code_barre, $quantite, $prix_ht, $remise, $prix_total,$tva1]);
        }

        echo "Facture et produits insérés avec succès !";
    } else {
        echo "Erreur lors de la création de la facture" . $devis_id;
    }
} else {
    echo "Accès non autorisé.";
}
?>
