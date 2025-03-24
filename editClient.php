<?php
include 'connect.php';
$db = new Dbf();

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $client = $db->select("SELECT * FROM client WHERE id = ?", [$id])[0];
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $typeacount = $_POST['typeacount'];
    $categorie = $_POST['categorie'];
    $tva_exoneree = isset($_POST['tva_exoneree']) ? 1 : 0;
    $raison_sociale = $_POST['raison_sociale'];
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $matricule_type = $_POST['matricule_type'];
    $matricule = $_POST['matricule'];
    $email = $_POST['email'];
    $adresse = $_POST['adresse'];
    $telephone = $_POST['telephone'];

    $sql = "UPDATE client SET typeacount=?, categorie=?, tva_exoneree=?, raison_sociale=?, nom=?, prenom=?, matricule_type=?, matricule=?, email=?, adresse=?, telephone=? WHERE id=?";

    try {
        $stmt = $db->conF->prepare($sql);
        $stmt->execute([$typeacount, $categorie, $tva_exoneree, $raison_sociale, $nom, $prenom, $matricule_type, $matricule, $email, $adresse, $telephone, $id]);
        header("Location: listeClient.php?updated");
        exit();
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>