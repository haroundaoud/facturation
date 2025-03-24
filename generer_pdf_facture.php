<?php
require 'connect.php'; // Inclusion de la classe de connexion
require 'fpdf.php'; // Inclusion de la bibliothèque FPDF

$db = new Dbf(); // Connexion à la base de données

// Vérifier si un ID de document est fourni
if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("ID du document non fourni !");
}

$document_id = $_GET['id'];

// Récupérer les informations du document
$docQuery = "SELECT d.*, c.prenom, c.nom FROM documents d 
             JOIN clients c ON d.client_id = c.id 
             WHERE d.id = ?";
$document = $db->select($docQuery, [$document_id]);

if (!$document) {
    die("Document introuvable !");
}
$document = $document[0]; // Prendre le premier résultat

// Récupérer les produits associés
$prodQuery = "SELECT * FROM document_produits WHERE document_id = ?";
$produits = $db->select($prodQuery, [$document_id]);

// Création du PDF
$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 16);

// En-tête du document
$pdf->Cell(190, 10, strtoupper($document['type']), 0, 1, 'C');
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(190, 10, "Client : " . $document['prenom'] . " " . $document['nom'], 0, 1, 'C');
$pdf->Ln(10);

// Tableau des produits
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(40, 10, 'Code-barres', 1);
$pdf->Cell(40, 10, 'Quantité', 1);
$pdf->Cell(40, 10, 'Prix Unitaire', 1);
$pdf->Cell(30, 10, 'Remise (%)', 1);
$pdf->Cell(40, 10, 'Total', 1);
$pdf->Ln();

$pdf->SetFont('Arial', '', 10);
foreach ($produits as $produit) {
    $pdf->Cell(40, 10, $produit['code_barre'], 1);
    $pdf->Cell(40, 10, $produit['quantite'], 1);
    $pdf->Cell(40, 10, number_format($produit['prix_unitaire'], 2) . " TND", 1);
    $pdf->Cell(30, 10, $produit['remise'] . "%", 1);
    $pdf->Cell(40, 10, number_format($produit['prix_total'], 2) . " TND", 1);
    $pdf->Ln();
}

// Total général
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(150, 10, "Total général :", 1);
$pdf->Cell(40, 10, number_format($document['total'], 2) . " TND", 1);
$pdf->Ln();

// Générer le fichier PDF
$pdf->Output("Facture_" . $document['id'] . ".pdf", "I");
?>
