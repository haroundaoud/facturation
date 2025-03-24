
<?php
session_start();

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <script type="text/javascript" >
        function preventBack(){window.history.forward()};
        setTimeout("preventBack()",0);
        window.onunload=function (){null;}   </script>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="style.css">
    <link rel="icon" type="image/png" href="logo.png">

    <title>SEASIDECARE</title>

<style>
    .error-message {
        color: red;
        font-size: 14px;
        position: absolute;
        top: 195px; /* Adjust this value to position the error */
        left: 50%;
        transform: translateX(-50%);
        width: 100%;
        text-align: center;
        margin: 0;
    }
    .form-container {
        position: relative; /* Needed for positioning the error message */
        padding-top: 5px; /* Add space to accommodate the error message */
    }



</style>

</head>

<body>

<div class="container" id="container">




    <div class="form-container sign-in">
        <form method="post" action="login.php">
            <div class="logo-container">
                <img src="logo.png" alt="main_logo" class="img-fluid" style="max-width: 350px; height: auto;">
            </div>

            <!-- Error Message -->
            <?php if (isset($_SESSION['error'])): ?>
                <p class="error-message"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></p>
            <?php endif; ?>

            <!-- Input Fields -->
            <input type="email" placeholder="Adresse e-mail " name="email" required>
            <input type="password" placeholder="Mot de passe" name="password" required>
            <button type="submit">Se connecter</button>
        </form>
    </div>


    <div class="toggle-container">
        <div class="toggle">

            <div class="toggle-panel toggle-right">
                <h1>SEASIDE CARE  </h1>
                <p> Stockage Parapharmacie </p>

            </div>
        </div>
    </div>
</div>

<script src="/script.js"></script>
</body>

</html>
