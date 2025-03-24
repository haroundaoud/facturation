<?php
session_start(); // Démarrer la session pour gérer les variables de session
require_once "connect.php"; // Inclure la classe Dbf pour la connexion à la base de données

// Initialiser la connexion à la base de données
$c = new Dbf();

// Vérifier que la méthode HTTP utilisée est POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer et sécuriser les données envoyées par le formulaire
    $email = htmlspecialchars(trim($_POST['email']));
    $password = htmlspecialchars(trim($_POST['password']));

    // Vérifier que les champs ne sont pas vides
    if (!empty($password) && !empty($email)) {
        // Préparer la requête SQL pour vérifier si l'utilisateur existe
        $sql = "SELECT id, job FROM users WHERE password = ? AND email = ?";
        $q = $c->conF->prepare($sql);
        $q->execute([$password, $email]);

        $sql = "SELECT id, job, password FROM users WHERE email = ?";
        $q = $c->conF->prepare($sql);
        $q->execute([$email]);

        if ($q->rowCount() > 0) {
            $data = $q->fetch(PDO::FETCH_ASSOC); // Récupérer les données de l'utilisateur
            $hashedPasswordFromDB = $data['password']; // Le hash stocké en base de données

            // Vérifiez le mot de passe avec password_verify
            if (password_verify($password, $hashedPasswordFromDB)) {
                // Stocker l'ID et le rôle (job) de l'utilisateur dans la session
                $_SESSION['user_id'] = $data['id'];
                $_SESSION['user_job'] = $data['job'];

                // Redirection en fonction du rôle
                if ($_SESSION['user_job'] == 'admin') {
                    header("Location: dashboard.php");
                } else {
                    header("Location: SuAdmin.php");
                }
                exit();
            } else {
                // Mauvais mot de passe
                $_SESSION['error'] = "Mot de passe incorrect.";
                header("Location: index.php");
                exit();
            }
        } else {
            // Email non trouvé
            $_SESSION['error'] = "Utilisateur non trouvé. Veuillez vérifier vos informations.";
            header("Location: index.php");
            exit();
        }

    } else {
        // Redirection si la méthode HTTP n'est pas POST
        $_SESSION['error'] = "Requête invalide.";
        header("Location: index.php");
        exit();
    }
}
?>
