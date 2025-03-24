<?php
require('db.php');
require('fpdf.php');

$db = new Dbt();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $ticketId = intval($_POST['ticket_id']);
    $codeBarres = $_POST['code_barre']; // Tableau des codes-barres
    $quantitesRetour = $_POST['quantite']; // Tableau des quantités

    if (count($codeBarres) !== count($quantitesRetour)) {
        echo json_encode(["status" => "error", "message" => "Données invalides."]);
        exit;

    }

    $totalAvoir = 0;
    $detailsAvoir = [];

    foreach ($codeBarres as $index => $codeBarre) {
        $quantiteRetour = intval($quantitesRetour[$index]);

        // Vérifier si le produit fait partie du ticket
        $produit = $db->select("SELECT * FROM ticket_details WHERE ticket_id = :ticket_id AND code_barre = :code_barre", [
            ':ticket_id' => $ticketId,
            ':code_barre' => $codeBarre
        ])[0] ?? null;

        if (!$produit) {
            die("Erreur : Le produit ($codeBarre) n'existe pas dans le ticket.");
        }

        if ($quantiteRetour > $produit['quantite']) {
            die("Erreur : La quantité retournée dépasse celle du ticket.");
        }

        // Calcul du montant de l’avoir pour cet article
        $prixTotalAvoir = ($produit['prix_unitaire'] * $quantiteRetour) - ($produit['remise'] / 100 * $produit['prix_unitaire'] * $quantiteRetour);
        $totalAvoir += $prixTotalAvoir;

        // Enregistrer l'avoir
        $db->insert("INSERT INTO avoirs (ticket_id, code_barre, produit, quantite, prix_unitaire, remise, prix_total)
                     VALUES (:ticket_id, :code_barre, :produit, :quantite, :prix_unitaire, :remise, :prix_total)", [
            ':ticket_id' => $ticketId,
            ':code_barre' => $produit['code_barre'],
            ':produit' => $produit['produit'],
            ':quantite' => $quantiteRetour,
            ':prix_unitaire' => $produit['prix_unitaire'],
            ':remise' => $produit['remise'],
            ':prix_total' => $prixTotalAvoir
        ]);

        // Remettre les produits retournés en stock
        $db->update("UPDATE produits SET quantity = quantity + :quantite WHERE code_barre = :code_barre", [
            ':quantite' => $quantiteRetour,
            ':code_barre' => $codeBarre
        ]);

        // Stocker les détails pour le PDF
        $detailsAvoir[] = [
            'produit' => $produit['produit'],
            'quantite' => $quantiteRetour,
            'prix' => number_format($prixTotalAvoir, 2)
        ];
    }

    echo "Retour validé ! Un avoir de " . number_format($totalAvoir, 2) . " TND a été généré.";

    // Génération du PDF avec plusieurs lignes
    $pdf = new FPDF('P', 'mm', array(80, 100 + count($detailsAvoir) * 5));
    $pdf->AddPage();
    $pdf->SetMargins(3, 0, 0);
    $pdf->SetFont('Arial', '', 6);

    // Affichage du logo
    $pdf->Image('logo.png', 3, 2, 50);
    $pdf->SetFont('Arial', 'B', 8);
    $pdf->Ln(8);

    $pdf->Cell(0, 10, utf8_decode('Ticket d\'Avoir'), 0, 1, 'C');
    $pdf->Cell(0, 5, utf8_decode('Numéro de Ticket : ') . $ticketId, 0, 1, 'C');

    // Ajouter chaque produit retourné
    foreach ($detailsAvoir as $detail) {
        $pdf->Cell(0, 5, utf8_decode('Produit : ') . utf8_decode(substr($detail['produit'], 0, 38)), 0, 1, 'L');
        $pdf->Cell(0, 5, utf8_decode('Quantité : ') . $detail['quantite'], 0, 1, 'C');
        $pdf->Cell(0, 5, utf8_decode('Montant : ') . $detail['prix'] . ' TND', 0, 1, 'C');
    }

    $pdf->Cell(0, 5, utf8_decode('Total Avoir : ') . number_format($totalAvoir, 2) . ' TND', 0, 1, 'C');
    $pdf->Cell(0, 5, utf8_decode('Date : ') . date('d/m/Y'), 0, 1);
    $pdf->Cell(0, 5, utf8_decode('Merci pour votre retour !'), 0, 1);

    // Sauvegarde du fichier PDF
    $pdfFilePath = 'avoir.pdf';
    $pdf->Output($pdfFilePath, 'F');
    exec("start $pdfFilePath");

    // Redirection vers la page de scan après impression
}
header("Location: avoire.php");
exit;
?>
