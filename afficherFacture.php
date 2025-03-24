
<?php

session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit; // Stop the script if the user is not logged in
}
?>
<?php
// Include database connection
include('connect.php');
$db = new Dbf();

// Get facture_id from URL
$facture_id = $_GET['facture_id'];

// Fetch facture details
$stmt = $db->prepare("SELECT * FROM facture WHERE id = ?");
$stmt->execute([$facture_id]);
$facture = $stmt->fetch();

if (!$facture) {
    echo "Facture not found.";
    exit();
}

// Fetch facture articles (products) associated with this facture
$stmt_articles = $db->prepare("SELECT fa.*, p.* FROM facture_articles fa JOIN produits p ON fa.produit_id = p.id WHERE fa.facture_id = ?");
$stmt_articles->execute([$facture_id]);
$articles = $stmt_articles->fetchAll();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Facture #<?php echo $facture['id']; ?></title>
    <link rel="stylesheet" href="path/to/bootstrap.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .invoice-container {
            margin: 30px auto;
            width: 80%;
            border: 1px solid #ddd;
            padding: 20px;
        }
        .invoice-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 2px solid #ddd;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }
        .invoice-header img {
            max-width: 150px;
        }
        .invoice-header div {
            text-align: right;
        }
        .invoice-header h2 {
            margin: 0;
        }
        .invoice-header p {
            margin: 2px 0;
        }
        .client-info {
            margin-bottom: 20px;
        }
        .facture-info {
            margin-bottom: 20px;
            display: flex;
            justify-content: space-between;
        }
        .facture-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }
        .facture-table th, .facture-table td {
            padding: 12px;
            text-align: left;
            border: 1px solid #ddd;
        }
        .facture-table th {
            background-color: #f7f7f7;
        }
        .totals {
            display: flex;
            justify-content: flex-end;
            font-size: 16px;
        }
        .totals div {
            margin-left: 30px;
        }
        .print-button {
            text-align: center;
        }
        .print-button button {
            padding: 10px 20px;
            font-size: 16px;
            background-color: #007bff;
            color: white;
            border: none;
            cursor: pointer;
        }
        .print-button button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>

<div class="invoice-container">

    <div class="invoice-header">
        <div class="company-info">
            <h2>Seaside Care</h2>
            <p>101 AVENUE HABIB BOURGUIBA RADES PLAGE</p>
            <p>Phone: +216 98 124 878 / 99 912 922</p>
            <p>Email: contact@seasidecare.shop</p>
        </div>
        <img src="s.png" alt="Company Logo">
        <div class="invoice-info">
            <h2>Facture #<?php echo $facture['id']; ?></h2>
            <p>Date: <?php echo $facture['date_facture']; ?></p>
            <p>Due Date: <?php echo date('Y-m-d', strtotime('+30 days')); ?></p> <!-- Assuming a 30-day payment term -->
        </div>
    </div>

    <div class="client-info">
        <strong>Client:</strong>
        <p><?php echo htmlspecialchars($facture['client_id']); ?></p> <!-- Update with actual client info -->
        <!-- Optionally, you can fetch more client details if needed -->
    </div>

    <div class="facture-info">
        <div>
            <strong>Mode de Paiement:</strong>
            <p>Virement Bancaire</p>
        </div>
        <div>
            <strong>Statut:</strong>
            <p><?php echo ucfirst($facture['statut']); ?></p>
        </div>
    </div>

    <table class="facture-table">
        <thead>
        <tr>
            <th>Produit</th>
            <th>Quantité</th>
            <th>Remise (%)</th>
            <th>Prix Unitaire HT</th>
            <th>Prix Total HT</th>
            <th>Prix Total TTC</th>
        </tr>
        </thead>
        <tbody>
        <?php
        $montant_total_ht = 0;
        $montant_total_ttc = 0;
        foreach ($articles as $article):
            $montant_total_ht += $article['prix_total_ht'];
            $montant_total_ttc += $article['prix_total_ttc'];
            ?>
            <tr>
                <td><?php echo htmlspecialchars($article['title']); ?></td>
                <td><?php echo $article['quantite']; ?></td>
                <td><?php echo $article['remiseParFacture']; ?>%</td>
                <td><?php echo number_format($article['prix_unitaire_ht'], 3, ',', ' '); ?> TND</td>
                <td><?php echo number_format($article['prix_total_ht'], 3, ',', ' '); ?> TND</td>
                <td><?php echo number_format($article['prix_total_ttc'], 3, ',', ' '); ?> TND</td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

    <div class="totals">
        <div>
            <strong>Total HT:</strong>
            <p><?php echo number_format($montant_total_ht, 3, ',', ' '); ?> TND</p>
        </div>
        <div>
            <strong>Timbre fidcale</strong>
            <p>1000</p>
        </div>
        <div>
            <strong>Total TTC:</strong>
            <p><?php echo number_format($montant_total_ttc+1, 3, ',', ' ') ?> TND</p>
        </div>
    </div>

    <div class="print-button">
        <button onclick="window.print()">Imprimer la Facture</button>
    </div>
</div>

</body>
</html>
