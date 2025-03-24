<?php
require('db.php');

if (isset($_GET['ticket_id'])) {
    $ticketId = intval($_GET['ticket_id']);
    $db = new Dbt();

    // Récupérer les produits du ticket
    $produits = $db->select("SELECT ticket_id,code_barre, produit, quantite FROM ticket_details WHERE ticket_id = :ticket_id", [
        ':ticket_id' => $ticketId
    ]);

    if ($produits) {
        echo json_encode($produits);
    } else {
        echo json_encode([]);
    }
}
?>
