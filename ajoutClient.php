<?php
// Inclure la configuration de la base de données (le fichier 'connect.php' contient probablement des informations sur la connexion à la base de données)
include 'connect.php';
$db = new Dbf();

// Vérifier si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer les données du formulaire
    $type = $_POST["typeacount"]; // Set type to the value from the form
    $categorie = $_POST["categorie"];
    $tva_exoneree = isset($_POST["tva_exoneree"]) ? 1 : 0;
    $raison_sociale = $_POST["raison_sociale"];
    $nom = $_POST["nom"];
    $prenom = $_POST["prenom"];
    $matricule_type = $_POST["matricule_type"];
    $matricule = $_POST["matricule"];
    $email = $_POST["email"];
    $adresse = $_POST["adresse"];
    $telephone = $_POST["telephone"];

    // Préparer la requête SQL
    $sql = "INSERT INTO client (type, categorie, tva_exoneree, raison_sociale, nom, prenom, matricule_type, matricule, email, adresse, telephone, typeacount) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    try {
        // Insertion en base de données
        $stmt = $db->conF->prepare($sql);
        $stmt->execute([$type, $categorie, $tva_exoneree, $raison_sociale, $nom, $prenom, $matricule_type, $matricule, $email, $adresse, $telephone, $type]);

        // Rediriger après succès
        header("Location: formClient.php?addC");
        exit();
    } catch (PDOException $e) {
        // Gestion des erreurs de base de données
        $errorMessage = $e->getMessage();
        echo "Error: " . $errorMessage;  // Output error for debugging
        exit();
    } catch (Exception $e) {
        // Gestion des erreurs générales
        $errorMessage = $e->getMessage();
        echo "Error: " . $errorMessage;  // Output error for debugging
        header("Location: formClient.php?error=email");
        exit();
    }
}
?>
