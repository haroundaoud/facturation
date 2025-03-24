<?php
include 'connect.php';
$db = new Dbf();

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    try {
        $stmt = $db->conF->prepare("DELETE FROM client WHERE id = ?");
        $stmt->execute([$id]);
        header("Location: listeClient.php?deleted");
        exit();
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
} else {
    echo "ID invalide.";
}
?>
