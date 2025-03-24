<?php
include 'connect.php';
$db = new Dbf();

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $produit = $db->select("SELECT * FROM produits WHERE id = ?", [$id])[0];
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $title = $_POST['title'];
    $code_barre = $_POST['code_barre'];
    $reference = $_POST['reference'];
    $discount = $_POST['discount'];
    $brand = $_POST['brand'];
    $categorie = $_POST['categorie'];
    $gamme = $_POST['gamme'];
    $quantity = $_POST['quantity'];
    $prix_unitaire_ht = $_POST['prix_unitaire_ht'];
    $prix_unitaire_ttc = $_POST['prix_unitaire_ttc'];
    $tva = $_POST['tva'];
    $prix_dachat = $_POST['prix_dachat'];

    $sql = "UPDATE produitsa SET title=?, code_barre=?, reference=?, discount=?, brand=?, categorie=?, gamme=?, quantity=?,prix_unitaire_ht=?,prix_unitaire_ttc=? , tva=?, prix_dachat=? WHERE id=?";

    try {
        $stmt = $db->conF->prepare($sql);
        $stmt->execute([$title, $code_barre, $reference, $discount, $brand, $categorie, $gamme, $quantity,$prix_unitaire_ht,$prix_unitaire_ttc, $tva, $prix_dachat, $id]);
        header("Location: listeProducts.php?updated");
        exit();
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        }
}
?>