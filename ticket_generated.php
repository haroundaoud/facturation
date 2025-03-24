<?php
require('fpdf.php');
include 'db.php';

// Fetch ticket ID from URL
if (isset($_GET['ticket_id'])) {
    $ticketId = $_GET['ticket_id'];
} else {
    echo "Ticket ID is missing!";
    exit;
}

// Fetch ticket and ticket details from the database
$db = new Dbt();
$ticketQuery = "SELECT * FROM tickets WHERE id = :ticket_id";
$ticket = $db->select($ticketQuery, [':ticket_id' => $ticketId]);

if (!$ticket) {
    echo "Ticket not found!";
    exit;
}

$ticket = $ticket[0]; // We expect only one result
$ticketDetailsQuery = "SELECT * FROM ticket_details WHERE ticket_id = :ticket_id";
$ticketDetails = $db->select($ticketDetailsQuery, [':ticket_id' => $ticketId]);

// Fetch payment details
$paymentQuery = "SELECT * FROM reglement WHERE id_ticket = :ticket_id";
$paymentDetails = $db->select($paymentQuery, [':ticket_id' => $ticketId]);
$paymentDetails = $paymentDetails[0]; // We expect only one result

// Generate PDF for the ticket
class PDF extends FPDF
{
    // Header
    function Header()
    {
        $this->Image('logo.png', 3, 2, 50);
        $this->SetFont('Arial', 'B', 8);
        $this->Ln(8);
    }


    // Footer
    function Footer()
    {
        // Empty footer for the modified design
    }

    // Table Header
    function TableHeader()
    {
        $this->SetFont('Arial', 'B', 6);
        $this->Cell(10, 5, 'Qte', 0, 0, 'C');
        $this->Cell(40, 5, 'Produit', 0, 0, 'L');
        $this->Cell(12, 5, 'PU.TTC', 0, 0, 'C');
        $this->Cell(12, 5, 'PT.TTC', 0, 1, 'C');
    }

    // Table Row
    function TableRow($quantite, $nomProduit, $prixUnitaire, $prixTotal)
    {
        $this->SetFont('Arial', '', 6);
        $this->Cell(10, 5, $quantite, 0, 0, 'C');
        $this->Cell(40, 5, substr(utf8_decode($nomProduit), 0, 38), 0, 0, 'L');
        $this->Cell(12, 5, number_format($prixUnitaire, 3) . ' ', 0, 0, 'R');
        $this->Cell(12, 5, number_format($prixTotal, 3) . ' ', 0, 1, 'R');
    }

    // Total
    function Total($totalPrix)
    {
        $this->SetFont('Arial', 'B', 8);
        $this->Ln(2);
        $this->Cell(37, 5, 'Total :', 0, 0, 'L');
        $this->Cell(36, 5, number_format($totalPrix, 3) . ' TND', 0, 1, 'R');
    }
}

// Initialize PDF
$pdf = new PDF('P', 'mm', array(80, 100));
$pdf->AddPage();
$pdf->SetMargins(3, 0, 0);
$pdf->SetFont('Arial', '', 6);

// Add ticket info
$pdf->Cell(0, 10, 'Ticket de Vente', 0, 1, 'C');
$pdf->TableHeader();

// Add table rows for ticket details
$totalAmount = 0;
foreach ($ticketDetails as $detail) {
    $pdf->TableRow(
        $detail['quantite'],
        $detail['produit'],
        $detail['prix_unitaire'],
        $detail['prix_total']
    );
    $totalAmount += $detail['prix_total'];
}

// Add total price
$pdf->Total($totalAmount);

// Add date and time of transaction
$pdf->Cell(80, 5, 'Date : ' . date('d/m/Y'), 0, 1);
$pdf->Cell(80, 5, 'Heure : ' . date('H:i:s'), 0, 1);

// Thank you message
$pdf->Ln(2);
$pdf->Cell(80, 5, 'Merci de votre achat !', 0, 1);

// Output the PDF
$pdf->Output();
?>
