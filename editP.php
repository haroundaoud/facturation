<?php
include "connect.php";
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password']; // Mot de passe brut
    $id =$_SESSION["user_id"]; // ID caché transmis depuis le formulaire
    $job=$_SESSION['user_job'];

    // Hachage du mot de passe
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);


    $d = new Dbf();
    $sql = "UPDATE locallocalusers SET username = :username, email = :email, password = :hashedPassword WHERE id = :id";
    $stmt = $d->conF->prepare($sql);
    $stmt->bindParam(':username', $username, PDO::PARAM_STR);
    $stmt->bindParam(':email', $email, PDO::PARAM_STR);
    $stmt->bindParam(':hashedPassword', $hashedPassword, PDO::PARAM_STR); // Utilisation du mot de passe haché
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);

    if ($stmt->execute()) {
        if($job=="admin"){
        header("Location: profile.php");
        exit();}else{
            header("Location: ProfileClient.php");
        }

    } else {
        echo "Erreur lors de la mise à jour.";
    }
}
?>
