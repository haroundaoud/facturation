<?php
// Include database connection
include('connect.php');
$db = new Dbf();

// Get facture ID from the URL
$facture_id = $_GET['id'];

$stmt_articles = $db->prepare("DELETE FROM facture_articles WHERE facture_id = ?");
$stmt_articles->execute([$facture_id]);
// Delete the facture from facture table
$stmt = $db->prepare("DELETE FROM facture  WHERE id = ?");
$stmt->execute([$facture_id]);

// Delete associated facture_articles (products) for the facture


// Redirect to facture list or another page after deletion
header('Location: listeFacture.php');
exit();
?>
