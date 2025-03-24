<?php
require('fpdf.php');
include 'db.php';

class PDF extends FPDF
{
    function Header()
    {
        $this->Image('logo.png', 3, 2, 50);
        $this->SetFont('Arial', 'B', 8);
        $this->Ln(8);
    }

    function Footer() {}

    function TableHeader()
    {
        $this->SetFont('Arial', 'B', 6);
        $this->Cell(10, 5, 'Qte', 0, 0, 'C');
        $this->Cell(40, 5, 'Produit', 0, 0, 'L');
        $this->Cell(12, 5, 'PU.TTC', 0, 0, 'C');
        $this->Cell(12, 5, 'PT.TTC', 0, 1, 'C');
    }

    function TableRow($quantite, $nomProduit, $prixUnitaire, $prixTotal)
    {
        $this->SetFont('Arial', '', 6);
        $this->Cell(10, 5, $quantite, 0, 0, 'C');
        $this->Cell(40, 5, substr(utf8_decode($nomProduit), 0, 38), 0, 0, 'L');
        $this->Cell(12, 5, number_format($prixUnitaire, 3) . ' ', 0, 0, 'R');
        $this->Cell(12, 5, number_format($prixTotal, 3) . ' ', 0, 1, 'R');
    }

    function Total($totalPrix)
    {
        $this->SetFont('Arial', 'B', 8);
        $this->Ln(2);
        $this->Cell(37, 5, 'Total :', 0, 0, 'L');
        $this->Cell(36, 5, number_format($totalPrix, 3) . ' TND', 0, 1, 'R');
    }
}

$db = new Dbt();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $codesBarres = $_POST['code_barre'];
    $quantites = $_POST['quantite'];
    $remises = $_POST['remise']; // Assurez-vous que les remises sont envoyées avec 'remise[]'
    $remiseGlobale = isset($_POST['remise_totale']) ? floatval($_POST['remise_totale']) : 0;

    $totalPrix = 0;
    $ticketDetails = [];

    foreach ($codesBarres as $i => $codeBarre) {
        $query = "SELECT title, prix_unitaire_ttc, quantity FROM produits WHERE code_barre = :code_barre";
        $produit = $db->select($query, [':code_barre' => $codeBarre])[0] ?? null;

        if ($produit) {
            $nomProduit = $produit['title'];
            $prixUnitaire = $produit['prix_unitaire_ttc'];
            $stock = $produit['quantity'];

            if ($quantites[$i] > $stock) {
                $message = urlencode("Stock insuffisant pour le produit : $nomProduit. Il reste seulement $stock unité(s).");
                header("Location: scanner_produit.php?error=$message");
                exit;
            }

            $prixTotal = ($prixUnitaire * $quantites[$i]) - ($remises[$i] / 100 * $prixUnitaire * $quantites[$i]);
            $totalPrix += $prixTotal;

            $ticketDetails[] = [
                'code_barre' => $codeBarre,
                'produit' => $nomProduit,
                'quantite' => $quantites[$i],
                'prix_unitaire' => $prixUnitaire,
                'remise' => $remises[$i],
                'prix_total' => $prixTotal
            ];

            // Mise à jour du stock
            $db->update("UPDATE produits SET quantity = quantity - :quantite WHERE code_barre = :code_barre", [
                ':quantite' => $quantites[$i],
                ':code_barre' => $codeBarre
            ]);
        }
    }

    $totalPrix -= $remiseGlobale;

    // Enregistrement du ticket
    $db->insert("INSERT INTO tickets (date, total, remise_globale) VALUES (NOW(), :total, :remise_globale)", [
        ':total' => $totalPrix,
        ':remise_globale' => $remiseGlobale
    ]);
    $ticketId = $db->select("SELECT LAST_INSERT_ID() as id")[0]['id'] ?? null;

    // Enregistrement des détails du ticket
    foreach ($ticketDetails as $detail) {
        $db->insert("INSERT INTO ticket_details (ticket_id, code_barre, produit, quantite, prix_unitaire, remise, prix_total) 
                     VALUES (:ticket_id, :code_barre, :produit, :quantite, :prix_unitaire, :remise, :prix_total)", [
            ':ticket_id' => $ticketId,
            ':code_barre' => $detail['code_barre'],
            ':produit' => $detail['produit'],
            ':quantite' => $detail['quantite'],
            ':prix_unitaire' => $detail['prix_unitaire'],
            ':remise' => $detail['remise'],
            ':prix_total' => $detail['prix_total']
        ]);
    }

    // Génération du PDF
    $pdf = new PDF('P', 'mm', array(80, 100));
    $pdf->AddPage();
    $pdf->SetMargins(3, 0, 0);
    $pdf->SetFont('Arial', '', 6);
    $pdf->Header();
    $pdf->Cell(0, 10, 'Ticket de Vente', 0, 1, 'C');
    $pdf->Cell(0, 5, $ticketId, 0, 1, 'C');
    $pdf->TableHeader();

    foreach ($ticketDetails as $detail) {
        $pdf->TableRow($detail['quantite'], $detail['produit'], $detail['prix_unitaire'], $detail['prix_total']);
    }

    $pdf->Total($totalPrix);
    $pdf->Cell(80, 5, 'Date : ' . date('d/m/Y'), 0, 1);
    $pdf->Cell(80, 5, 'Heure : ' . date('H:i:s'), 0, 1);
    $pdf->Cell(80, 5, 'Merci de votre achat !', 0, 1);
    $pdfFilePath = 'ticket.pdf';
    $pdf->Output($pdfFilePath, 'F'); // Enregistre le PDF sur le serveur

// Commande pour Windows (ajuste le nom de l'imprimante)
    //exec("print /d:\\\\Microsoft Print to PDF $pdfFilePath");
    //exec("notepad $pdfFilePath");
    exec("start $pdfFilePath");

}
header('Location: scanner_produit.php');

?>