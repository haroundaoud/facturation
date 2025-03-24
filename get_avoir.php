<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include "db.php";
$db = new Dbt();

if (isset($_GET['id_ticket'])) {
    $id_ticket = htmlspecialchars($_GET['id_ticket']);

    try {
        // Vérifier si l'ID du ticket est numérique
        if (!is_numeric($id_ticket)) {
            echo json_encode(["success" => false, "message" => "ID ticket invalide"]);
            exit;
        }

        // Préparer la requête SQL
        $stmt = $db->prepare("SELECT prix_total FROM avoirs WHERE id = ?");
        $stmt->execute([$id_ticket]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result) {
            $total_avoir = $result['prix_total'];
            echo json_encode(["success" => true, "total_avoir" => $total_avoir]);
        } else {
            echo json_encode(["success" => false, "message" => "Ticket non trouvé"]);
        }
    } catch (PDOException $e) {
        echo json_encode(["success" => false, "message" => "Erreur SQL: " . $e->getMessage()]);
    }
} else {
    echo json_encode(["success" => false, "message" => "ID ticket manquant"]);
}
?>
