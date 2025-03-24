<?php
require 'db.php'; // Inclusion de la classe de connexion
$db = new Dbt(); // Connexion à la base de données

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Vérification de la présence des champs nécessaires
    if (!isset($_POST['type_fac'], $_POST['client_id'], $_POST['quantite'], $_POST['code_barre'], $_POST['prix_unitaire_ht'], $_POST['tva'])) {
        die("Tous les champs sont obligatoires.");
    }

    // Récupération des données
    $type_fac = $_POST['type_fac'];
    $client_id = intval($_POST['client_id']); // Conversion en entier

    // Redirection en fonction du type de facture for devis
    if ($type_fac == 'devis') {
        if (!isset($_POST['type_fac'], $_POST['client_id'], $_POST['quantite'], $_POST['code_barre'], $_POST['prix_unitaire_ht'], $_POST['tva'])) {
            die("Tous les champs sont obligatoires.");
        }

        // Vérification de la cohérence des données
        $nombre_produits = count($_POST['quantite']);
        if (
            count($_POST['code_barre']) !== $nombre_produits ||
            count($_POST['prix_unitaire_ht']) !== $nombre_produits ||
            (isset($_POST['remise']) && count($_POST['remise']) !== $nombre_produits)
        ) {
            die("Erreur : données incohérentes.");
        }

        // Initialisation des totaux
        $total_ht = 0;
        $total_tva = 0;
        $total_ttc = 0;

        // Traitement des produits
        for ($i = 0; $i < $nombre_produits; $i++) {
            $quantite = intval($_POST['quantite'][$i]);
            $prix_ht = floatval($_POST['prix_unitaire_ht'][$i]);
            $tva_produit = floatval($_POST['tva'][$i]);
            $remise = isset($_POST['remise'][$i]) ? floatval($_POST['remise'][$i]) : 0;

            $tva = $prix_ht * ($tva_produit / 100);
            $prix_ttc = $prix_ht + $tva;
            $prix_total = $prix_ht * $quantite * (1 - $remise / 100);

            $total_ht += $prix_total;
            $total_tva += $tva * $quantite;
            $total_ttc += $prix_ttc * $quantite * (1 - $remise / 100);
        }

        // Ajout du timbre
        $timbre = 1;
        $total_ht = number_format($total_ht, 3, '.', '');
        $total_tva = number_format($total_tva, 3, '.', '');
        $total_ttc = number_format($total_ttc + $timbre, 3, '.', ''); // Ajout du timbre au total TTC

        // Insertion de la facture dans la base de données
        try {
            $query = "INSERT INTO devis (client_id, total_ht, total_tva, total_ttc) VALUES (?, ?, ?, ?)";
            $facture_id = $db->insert($query, [$client_id, $total_ht, $total_tva, $total_ttc]);

            if ($facture_id) {
                echo "Facture créée avec succès, ID: " . $facture_id;
            } else {
                echo "Échec de l'insertion de la facture.";
            }
        } catch (PDOException $e) {
            echo "Erreur SQL : " . $e->getMessage();
        }

        // Insertion des détails de la facture dans la base de données
        if ($facture_id) {
            $query = "INSERT INTO devis_details (devis_id, produit_id, quantite, prix_unitaire, remise, sous_total, tva) 
                  VALUES (?, ?, ?, ?, ?, ?, ?)";
            $stmt = $db->prepare($query);

            for ($i = 0; $i < $nombre_produits; $i++) {
                $code_barre = $_POST['code_barre'][$i];
                $quantite = intval($_POST['quantite'][$i]);

                $prix_ht = floatval($_POST['prix_unitaire_ht'][$i]);
                $remise = isset($_POST['remise'][$i]) ? floatval($_POST['remise'][$i]) : 0;
                $prix_total = $prix_ht * $quantite * (1 - $remise / 100);
                $tva1 = isset($_POST['tva'][$i]) ? floatval($_POST['tva'][$i]) : 19;

                $stmt->execute([$facture_id, $code_barre, $quantite, $prix_ht, $remise, $prix_total, $tva1]);
            }

            echo "Facture et produits insérés avec succès !";
        } else {
            echo "Erreur lors de la création de la facture.";
        }        exit();
    } elseif ($type_fac == 'bl') {
        if (!isset($_POST['type_fac'], $_POST['client_id'], $_POST['quantite'], $_POST['code_barre'], $_POST['prix_unitaire_ht'], $_POST['tva'])) {
            die("Tous les champs sont obligatoires.");
        }

        // Vérification de la cohérence des données
        $nombre_produits = count($_POST['quantite']);
        if (
            count($_POST['code_barre']) !== $nombre_produits ||
            count($_POST['prix_unitaire_ht']) !== $nombre_produits ||
            (isset($_POST['remise']) && count($_POST['remise']) !== $nombre_produits)
        ) {
            die("Erreur : données incohérentes.");
        }

        // Initialisation des totaux
        $total_ht = 0;
        $total_tva = 0;
        $total_ttc = 0;

        // Traitement des produits
        for ($i = 0; $i < $nombre_produits; $i++) {
            $quantite = intval($_POST['quantite'][$i]);
            $prix_ht = floatval($_POST['prix_unitaire_ht'][$i]);
            $tva_produit = floatval($_POST['tva'][$i]);
            $remise = isset($_POST['remise'][$i]) ? floatval($_POST['remise'][$i]) : 0;

            $tva = $prix_ht * ($tva_produit / 100);
            $prix_ttc = $prix_ht + $tva;
            $prix_total = $prix_ht * $quantite * (1 - $remise / 100);

            $total_ht += $prix_total;
            $total_tva += $tva * $quantite;
            $total_ttc += $prix_ttc * $quantite * (1 - $remise / 100);
        }

        // Ajout du timbre
        $timbre = 1;
        $total_ht = number_format($total_ht, 3, '.', '');
        $total_tva = number_format($total_tva, 3, '.', '');
        $total_ttc = number_format($total_ttc + $timbre, 3, '.', ''); // Ajout du timbre au total TTC

        // Insertion de la facture dans la base de données
        try {
            $query = "INSERT INTO bons_livraison (client_id, total_ht, total_tva, total_ttc) VALUES (?, ?, ?, ?)";
            $facture_id = $db->insert($query, [$client_id, $total_ht, $total_tva, $total_ttc]);

            if ($facture_id) {
                echo "Facture créée avec succès, ID: " . $facture_id;
            } else {
                echo "Échec de l'insertion de la facture.";
            }
        } catch (PDOException $e) {
            echo "Erreur SQL : " . $e->getMessage();
        }

        // Insertion des détails de la facture dans la base de données
        if ($facture_id) {
            $query = "INSERT INTO bons_livraison_details (bon_livraison_id, produit_id, quantite, prix_unitaire, remise, sous_total, tva) 
                  VALUES (?, ?, ?, ?, ?, ?, ?)";
            $stmt = $db->prepare($query);

            for ($i = 0; $i < $nombre_produits; $i++) {
                $code_barre = $_POST['code_barre'][$i];
                $quantite = intval($_POST['quantite'][$i]);

                $prix_ht = floatval($_POST['prix_unitaire_ht'][$i]);
                $remise = isset($_POST['remise'][$i]) ? floatval($_POST['remise'][$i]) : 0;
                $prix_total = $prix_ht * $quantite * (1 - $remise / 100);
                $tva1 = isset($_POST['tva'][$i]) ? floatval($_POST['tva'][$i]) : 19;

                $stmt->execute([$facture_id, $code_barre, $quantite, $prix_ht, $remise, $prix_total, $tva1]);
            }

            echo "Facture et produits insérés avec succès !";
        } else {
            echo "Erreur lors de la création de la facture.";
        }        exit();
    } elseif ($type_fac == 'bc') {

        if (!isset($_POST['type_fac'], $_POST['client_id'], $_POST['quantite'], $_POST['code_barre'], $_POST['prix_unitaire_ht'], $_POST['tva'])) {
            die("Tous les champs sont obligatoires.");
        }

        // Vérification de la cohérence des données
        $nombre_produits = count($_POST['quantite']);
        if (
            count($_POST['code_barre']) !== $nombre_produits ||
            count($_POST['prix_unitaire_ht']) !== $nombre_produits ||
            (isset($_POST['remise']) && count($_POST['remise']) !== $nombre_produits)
        ) {
            die("Erreur : données incohérentes.");
        }

        // Initialisation des totaux
        $total_ht = 0;
        $total_tva = 0;
        $total_ttc = 0;

        // Traitement des produits
        for ($i = 0; $i < $nombre_produits; $i++) {
            $quantite = intval($_POST['quantite'][$i]);
            $prix_ht = floatval($_POST['prix_unitaire_ht'][$i]);
            $tva_produit = floatval($_POST['tva'][$i]);
            $remise = isset($_POST['remise'][$i]) ? floatval($_POST['remise'][$i]) : 0;

            $tva = $prix_ht * ($tva_produit / 100);
            $prix_ttc = $prix_ht + $tva;
            $prix_total = $prix_ht * $quantite * (1 - $remise / 100);

            $total_ht += $prix_total;
            $total_tva += $tva * $quantite;
            $total_ttc += $prix_ttc * $quantite * (1 - $remise / 100);
        }

        // Ajout du timbre
        $timbre = 1;
        $total_ht = number_format($total_ht, 3, '.', '');
        $total_tva = number_format($total_tva, 3, '.', '');
        $total_ttc = number_format($total_ttc + $timbre, 3, '.', ''); // Ajout du timbre au total TTC

        // Insertion de la facture dans la base de données
        try {
            $query = "INSERT INTO bons_commande (fournisseur_id, total_ht, total_tva, total_ttc) VALUES (?, ?, ?, ?)";
            $facture_id = $db->insert($query, [$client_id, $total_ht, $total_tva, $total_ttc]);

            if ($facture_id) {
                echo "Facture créée avec succès, ID: " . $facture_id;
            } else {
                echo "Échec de l'insertion de la facture.";
            }
        } catch (PDOException $e) {
            echo "Erreur SQL : " . $e->getMessage();
        }

        // Insertion des détails de la facture dans la base de données
        if ($facture_id) {
            $query = "INSERT INTO bons_commande_details (bon_commande_id , produit_id, quantite, prix_unitaire, remise, sous_total, tva) 
                  VALUES (?, ?, ?, ?, ?, ?, ?)";
            $stmt = $db->prepare($query);

            for ($i = 0; $i < $nombre_produits; $i++) {
                $code_barre = $_POST['code_barre'][$i];
                $quantite = intval($_POST['quantite'][$i]);

                $prix_ht = floatval($_POST['prix_unitaire_ht'][$i]);
                $remise = isset($_POST['remise'][$i]) ? floatval($_POST['remise'][$i]) : 0;
                $prix_total = $prix_ht * $quantite * (1 - $remise / 100);
                $tva1 = isset($_POST['tva'][$i]) ? floatval($_POST['tva'][$i]) : 19;

                $stmt->execute([$facture_id, $code_barre, $quantite, $prix_ht, $remise, $prix_total, $tva1]);
            }

            echo "Facture et produits insérés avec succès !";
        } else {
            echo "Erreur lors de la création de la facture.";
        }        exit();
    }

    // Vérification de la cohérence des données
    $nombre_produits = count($_POST['quantite']);
    if (
        count($_POST['code_barre']) !== $nombre_produits ||
        count($_POST['prix_unitaire_ht']) !== $nombre_produits ||
        (isset($_POST['remise']) && count($_POST['remise']) !== $nombre_produits)
    ) {
        die("Erreur : données incohérentes.");
    }

    // Initialisation des totaux
    $total_ht = 0;
    $total_tva = 0;
    $total_ttc = 0;

    // Traitement des produits
    for ($i = 0; $i < $nombre_produits; $i++) {
        $quantite = intval($_POST['quantite'][$i]);
        $prix_ht = floatval($_POST['prix_unitaire_ht'][$i]);
        $tva_produit = floatval($_POST['tva'][$i]);
        $remise = isset($_POST['remise'][$i]) ? floatval($_POST['remise'][$i]) : 0;

        $tva = $prix_ht * ($tva_produit / 100);
        $prix_ttc = $prix_ht + $tva;
        $prix_total = $prix_ht * $quantite * (1 - $remise / 100);

        $total_ht += $prix_total;
        $total_tva += $tva * $quantite;
        $total_ttc += $prix_ttc * $quantite * (1 - $remise / 100);
    }

    // Ajout du timbre
    $timbre = 1;
    $total_ht = number_format($total_ht, 3, '.', '');
    $total_tva = number_format($total_tva, 3, '.', '');
    $total_ttc = number_format($total_ttc + $timbre, 3, '.', ''); // Ajout du timbre au total TTC

    // Insertion de la facture dans la base de données
    try {
        $query = "INSERT INTO factures (client_id, total_ht, total_tva, total_ttc) VALUES (?, ?, ?, ?)";
        $facture_id = $db->insert($query, [$client_id, $total_ht, $total_tva, $total_ttc]);

        if ($facture_id) {
            echo "Facture créée avec succès, ID: " . $facture_id;
        } else {
            echo "Échec de l'insertion de la facture.";
        }
    } catch (PDOException $e) {
        echo "Erreur SQL : " . $e->getMessage();
    }

    // Insertion des détails de la facture dans la base de données
    if ($facture_id) {
        $query = "INSERT INTO facture_details (facture_id, produit_id, quantite, prix_unitaire, remise, sous_total, tva) 
                  VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $db->prepare($query);

        for ($i = 0; $i < $nombre_produits; $i++) {
            $code_barre = $_POST['code_barre'][$i];
            $quantite = intval($_POST['quantite'][$i]);

            $prix_ht = floatval($_POST['prix_unitaire_ht'][$i]);
            $remise = isset($_POST['remise'][$i]) ? floatval($_POST['remise'][$i]) : 0;
            $prix_total = $prix_ht * $quantite * (1 - $remise / 100);
            $tva1 = isset($_POST['tva'][$i]) ? floatval($_POST['tva'][$i]) : 19;

            $stmt->execute([$facture_id, $code_barre, $quantite, $prix_ht, $remise, $prix_total, $tva1]);
        }

        echo "Facture et produits insérés avec succès !";
    } else {
        echo "Erreur lors de la création de la facture.";
    }
} else {
    echo "Accès non autorisé.";
}
?>
