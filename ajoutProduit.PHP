<?php
// Inclure la configuration de la base de données (le fichier 'connect.php' contient probablement des informations sur la connexion à la base de données)
include 'connect.php';
$db = new Dbf();

// Vérifier si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer les données du formulaire
    $title = $_POST["title"];
    $code_barre = $_POST["code_barre"];
    $reference = $_POST["reference"];
    $discount = $_POST["discount"];
    $brand = $_POST["brand"];
    $categorie = $_POST["categorie"];
    $gamme = $_POST["gamme"];
    $quantity = $_POST["quantity"];
    $tva = $_POST["tva"];
    $prix_dachat = $_POST["prix_dachat"];
    $marge_beneficier =30;

    // Préparer la requête SQL
    $sql = "INSERT INTO produits (title, code_barre, reference, discount, brand, categorie,  gamme, quantity, tva, prix_dachat, marge_beneficier, prix_unitaire_ht, prix_unitaire_ttc) VALUES (  ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $prix_unitaire_ht = $prix_dachat * (1 + ($marge_beneficier / 100));
    $prix_unitaire_ttc = $prix_unitaire_ht * (1 + ($tva / 100));
    try {
        // Insertion en base de données
        $stmt = $db->conF->prepare($sql);
        $stmt->execute([$title,  $code_barre, $reference, $discount, $brand, $categorie, $gamme, $quantity, $tva, $prix_dachat, $marge_beneficier, $prix_unitaire_ht, $prix_unitaire_ttc]);

        // Rediriger après succès
        header("Location: formProduit.php?addP");
        exit();
    } catch (PDOException $e) {
        // Gestion des erreurs de base de données
        $errorMessage = $e->getMessage();
        echo "Error: " . $errorMessage;  // Output error for debugging
        exit();
    } catch (Exception $e) {
        // Gestion des erreurs générales
        $errorMessage = $e->getMessage();
        echo "Error: " . $errorMessage;  // Output error for debugging
        header("Location: formProduit.php?error=email");
        exit();
    }
}
?>
