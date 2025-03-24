<?php

session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit; // Stop the script if the user is not logged in
}
?>
<?php
include "connect.php";
$db= new Dbf();




// Récupérer les produits

// Récupérer les clients
$brand = $db->select("SELECT DISTINCT brand FROM product");


?>
<!DOCTYPE html>
<html lang="en">

<head>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<link rel="stylesheet" href="fontawesome-free-6.7.2-web/css/all.min.css">
<link rel="stylesheet" href="css/toastr.min.css">


<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<link rel="apple-touch-icon" sizes="76x76" href="assets/img/apple-icon.png">
<link rel="icon" type="image/png" href="logo.png">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">

<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">
<title>
SEASIDECARE
</title>
<!--     Fonts and icons     -->
<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
<!-- Nucleo Icons -->
<link href="https://demos.creative-tim.com/argon-dashboard-pro/assets/css/nucleo-icons.css" rel="stylesheet" />
<link href="https://demos.creative-tim.com/argon-dashboard-pro/assets/css/nucleo-svg.css" rel="stylesheet" />
<!-- Font Awesome Icons -->
<script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
<!-- CSS Files -->
<link id="pagestyle" href="assets/css/argon-dashboard.css?v=2.1.0" rel="stylesheet" />


<style>
    /* Centrer la notification en haut */
    .toast-top-center {
        top: 20px;
        /* Distance par rapport au haut de la fenêtre */
        left: 50%;
        transform: translateX(-50%);
    }

    /* Personnalisation supplémentaire (optionnel) */
    .toast-success {
        background-color: #28a745 !important;
        /* Couleur de fond */
        color: #fff !important;
        /* Couleur du texte */
        font-size: 16px;
        /* Taille de la police */
        border-radius: 8px;
        /* Coins arrondis */
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        /* Ombre */
    }

    .toast-error {
        background-color: #f44336 !important;
        /* Rouge vif */
        color: #fff !important;
        /* Texte blanc */
    }

    .toast-error .toast-title {
        font-weight: bold;
        color: #fff !important;
    }

    .toast-error .toast-message {
        color: #fff !important;
    }
</style>

</head>

<body class="g-sidenav-show   bg-gray-100">
<div class="min-height-300 bg-dark position-absolute w-100"></div>



<aside fragment="navbar" class="sidenav bg-white navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-4 " id="sidenav-main">
    <div class="sidenav-header">
        <i class="fas fa-times p-3 cursor-pointer text-secondary opacity-5 position-absolute end-0 top-0 d-none d-xl-none" aria-hidden="true" id="iconSidenav"></i>
        <div class="d-flex justify-content-center align-items-center" style="height: 150px;">
            <a class="navbar-brand" href="#" target="_blank">
                <img src="logo.png" alt="main_logo" class="img-fluid" style="max-width: 200px; height: auto;">
            </a>
        </div>
    </div>
    </br></br>
    <hr class="horizontal dark mt-0">
    <div class="collapse navbar-collapse  w-auto " id="sidenav-collapse-main">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" href="dashboard.php">
                    <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="fa-solid fa-house" style="font-size: 16px; color: #4f4f4f;"></i>
                    </div>
                    <span class="nav-link-text ms-1">Acceuil</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link active dropdown-toggle bg-gradient-success" data-bs-toggle="collapse" href="#submenuUtilisateur" role="button" aria-expanded="false" aria-controls="submenuUtilisateur">
                    <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="fa-solid fa-box" style="font-size: 14px; color: #4f4f4f;"></i>
                    </div>
                    <span class="nav-link-text ms-1">Gestion des produits</span>
                </a>

                <div class="collapse" id="submenuUtilisateur">
                    <ul class="nav flex-column ms-4">
                        <li class="nav-item">
                            <a class="nav-link" href="formProduit.php">
                                <i class="bi bi-person-plus text-dark text-sm opacity-10 me-2"></i>
                                Ajouter un produit
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="listeProducts.php">
                                <i class="bi bi-list-ul text-dark text-sm opacity-10 me-2"></i>
                                Liste des produits
                            </a>
                        </li>

                    </ul>
                </div>
            </li>


            <li class="nav-item">
                <a class="nav-link dropdown-toggle" data-bs-toggle="collapse" href="#submenuClients" role="button" aria-expanded="false" aria-controls="submenuClients">
                    <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="fa-solid fa-users-line" style="font-size: 14px; color: #4f4f4f;"></i>
                    </div>
                    <span class="nav-link-text ms-1">Gestion des clients</span>
                </a>

                <div class="collapse" id="submenuClients">
                    <ul class="nav flex-column ms-4">
                        <li class="nav-item">
                            <a class="nav-link" href="formClient.php">
                                <i class="bi bi-person-plus text-dark text-sm opacity-10 me-2"></i>
                                Ajouter Client
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="listeClient.php">
                                <i class="bi bi-list-ul text-dark text-sm opacity-10 me-2"></i>
                                Liste des Clients
                            </a>
                        </li>

                    </ul>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link dropdown-toggle" data-bs-toggle="collapse" href="#submenuFacture" role="button" aria-expanded="false" aria-controls="submenuUtilisateur">
                    <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="fa-solid fa-file-invoice-dollar" style="font-size: 14px; color: #4f4f4f;"></i>
                    </div>
                    <span class="nav-link-text ms-1">gestion des factures</span>
                </a>

                <div class="collapse" id="submenuFacture">
                    <ul class="nav flex-column ms-4">
                        <li class="nav-item">
                            <a class="nav-link active" href="formFacture.php">
                                <i class="bi bi-person-plus text-dark text-sm opacity-10 me-2"></i>
                                Ajouter facture
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="listeFacture.php">
                                <i class="bi bi-list-ul text-dark text-sm opacity-10 me-2"></i>
                                Liste des des factures
                            </a>
                        </li>

                    </ul>
                </div>
            </li>

            <li class="nav-item">
                <a class="nav-link " href="scanner_produit.php">
                    <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="fa-solid fa-money-bill" style="font-size: 16px; color: #4f4f4f;"></i>
                    </div>
                    <span class="nav-link-text ms-1">Vente au comptoire</span>
                </a>

            </li>
            <li class="nav-item ">
                <a class="nav-link " href="historique_ticket.php">
                    <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">

                        <i class="bi bi-list-ul text-dark text-sm opacity-10 me-2"></i>                    </div>

                    historique de ticket
                </a>

            <li class="nav-item active">
                <a class="nav-link" href="avoire.php">
                    <i class="bi bi-list-ul text-dark text-sm opacity-10 me-2"></i>
                    avoirs de ticket
                </a>
            </li>

            </li>

            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <li class="nav-item mt-3">
                <h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder opacity-6">gestion de compte</h6>
            </li>
            <li class="nav-item">
                <a class="nav-link " href="profile.php">
                    <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="fa-solid fa-gear" style="font-size: 14px; color: #4f4f4f;"></i>
                    </div>
                    <span class="nav-link-text ms-1">Espace Comptes</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link " href="logout.php">
                    <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="fa-solid fa-arrow-right-from-bracket" style="font-size: 14px; color: #4f4f4f;"></i>
                    </div>
                    <span class="nav-link-text ms-1">Se déconnecter</span>
                </a>
            </li>

        </ul>
    </div>

</aside>
<main class="main-content position-relative border-radius-lg ">
    <!-- Navbar -->
    <nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl " id="navbarBlur" data-scroll="false">
        <div class="container-fluid py-1 px-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
                    <li class="breadcrumb-item text-sm"><a class="opacity-5 text-white" href="javascript:;">Pages</a></li>
                    <li class="breadcrumb-item text-sm text-white active" aria-current="page">Produit</li>
                </ol>
                <h6 class="font-weight-bolder text-white mb-0">Ajouter un produit</h6>
            </nav>

            <li class="nav-item d-xl-none ps-3 d-flex align-items-center">
                <a href="javascript:;" class="nav-link text-white p-0" id="iconNavbarSidenav">
                    <div class="sidenav-toggler-inner">
                        <i class="sidenav-toggler-line bg-white"></i>
                        <i class="sidenav-toggler-line bg-white"></i>
                        <i class="sidenav-toggler-line bg-white"></i>
                    </div>
                </a>
                           
            </li>



        </div>
    </nav>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <?php if (isset($_GET['addP'])): ?>

        <script>
            toastr.options = {
                "closeButton": true, // Ajoute un bouton de fermeture
                "progressBar": true, // Barre de progression pour le temps d'affichage
                "positionClass": "toast-top-center", // Centré en haut
                "showDuration": "300", // Durée d'apparition (ms)
                "hideDuration": "1000", // Durée de disparition (ms)
                "timeOut": "5000", // Temps d'affichage (ms)
                "extendedTimeOut": "1000", // Temps après interaction utilisateur
                "showEasing": "swing", // Animation d'apparition
                "hideEasing": "linear", // Animation de disparition
                "showMethod": "fadeIn", // Effet d'apparition
                "hideMethod": "fadeOut" // Effet de disparition
            };

            // Exemple de notification
            toastr.success("Le client a été ajouté avec succès !");
        </script>


    <?php endif; ?>


    <?php if (isset($_GET['error'])): ?>

        <script>
            toastr.options = {
                "closeButton": true, // Ajoute un bouton de fermeture
                "progressBar": true, // Barre de progression pour le temps d'affichage
                "positionClass": "toast-top-center", // Centré en haut
                "showDuration": "300", // Durée d'apparition (ms)
                "hideDuration": "1000", // Durée de disparition (ms)
                "timeOut": "5000", // Temps d'affichage (ms)
                "extendedTimeOut": "1000", // Temps après interaction utilisateur
                "showEasing": "swing", // Animation d'apparition
                "hideEasing": "linear", // Animation de disparition
                "showMethod": "fadeIn", // Effet d'apparition
                "hideMethod": "fadeOut" // Effet de disparition
            };

            // Exemple de notification
            toastr.error("mail deja exist !");
        </script>
    <?php endif; ?>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-md-11 mt-4">
                <div class="card shadow-lg rounded-lg">
                    <div class="card-header text-white px-4 py-3">
                        <h6 class="mb-0">Ajouter un produit :</h6>
                    </div>
                    <div class="card-body p-4">
                        <form method="POST" action="ajoutProduit.php" class="needs-validation" novalidate>
                            <div class="row">
                                <!-- First Column (Product Information) -->
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="title" class="form-label">Ref article :</label>
                                        <input type="text" class="form-control" id="title" name="reference" required>
                                        <div class="invalid-feedback">
                                            Veuillez fournir la référence de l'article.
                                        </div>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="title" class="form-label">code barre :</label>
                                        <input type="text" class="form-control" id="title" name="code_barre" required>
                                        <div class="invalid-feedback">
                                            Veuillez fournir la code a barre.
                                        </div>
                                    </div>


                                    <div class="form-group mb-3">
                                        <label for="title" class="form-label">Title :</label>
                                        <input type="text" class="form-control" id="title" name="title">
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="prix_dachat" class="form-label">Prix d'Achat (HT) :</label>
                                        <input type="number" class="form-control" id="prix_dachat" name="prix_dachat" required>
                                        <div class="invalid-feedback">
                                            Veuillez fournir le prix d'achat.
                                        </div>
                                    </div>

                                    <div class="form-group mb-3">
                                        <label for="marge_beneficier" class="form-label">Marge bénéficiaire (%) :</label>
                                        <input type="number" class="form-control" id="marge_beneficier" name="marge_beneficier" placeholder="30">
                                        <div class="invalid-feedback">
                                            Veuillez fournir la marge bénéficiaire.
                                        </div>
                                    </div>

                                    <div class="form-group mb-3">
                                        <label for="discount" class="form-label">Remise (%) :</label>
                                        <input type="number" class="form-control" id="discount" name="discount" value="0">
                                    </div>

                                </div>

                                <!-- Second Column (Additional Information) -->
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="tva" class="form-label">TVA (%) :</label>
                                        <input type="number" class="form-control" id="tva" name="tva" required value="19.00">
                                        <div class="invalid-feedback">
                                            Veuillez fournir le pourcentage de TVA.
                                        </div>
                                    </div>

                                    <div class="form-group mb-3">
                                        <label for="quantity" class="form-label">Quantité :</label>
                                        <input type="number" class="form-control" id="quantity" name="quantity" required>
                                        <div class="invalid-feedback">
                                            Veuillez fournir la quantité.
                                        </div>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="categorie" class="form-label">Marque :</label>
                                        <select class="form-control" id="brand" name="brand" >
                                            <option value="">Sélectionnez une marque</option>
                                            <?php
                                            $brand = $db->select("SELECT DISTINCT brand FROM product");
                                            foreach ($brand as $cat) {
                                                echo '<option value="' . htmlspecialchars($cat['brand']) . '">' . htmlspecialchars($cat['brand']) . '</option>';
                                            }
                                            ?>
                                        </select>
                                        <div class="invalid-feedback">
                                            Veuillez sélectionner une marque.
                                        </div>
                                    </div>

                                    <div class="form-group mb-3">
                                        <label for="categorie" class="form-label">Catégorie :</label>
                                        <select class="form-control" id="categorie" name="categorie" >
                                            <option value="">Sélectionnez une catégorie</option>
                                            <?php
                                            $categorie = $db->select("SELECT DISTINCT categorie FROM product");
                                            foreach ($categorie as $cat) {
                                                echo '<option value="' . htmlspecialchars($cat['categorie']) . '">' . htmlspecialchars($cat['categorie']) . '</option>';
                                            }
                                            ?>
                                        </select>
                                        <div class="invalid-feedback">
                                            Veuillez sélectionner une catégorie.
                                        </div>
                                    </div>




                                    <div class="form-group mb-3">
                                        <label for="categorie" class="form-label">gamme :</label>
                                        <select class="form-control" id="categorie" name="gamme">
                                            <option value="">Sélectionnez une gamme</option>
                                            <?php
                                            $gamme = $db->select("SELECT DISTINCT gamme FROM product");
                                            foreach ($gamme as $cat) {
                                                echo '<option value="' . htmlspecialchars($cat['gamme']) . '">' . htmlspecialchars($cat['gamme']) . '</option>';
                                            }
                                            ?>
                                        </select>
                                        <div class="invalid-feedback">
                                            Veuillez sélectionner une gamme.
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex justify-content-center mt-3">
                                <button type="submit" class="btn btn-primary px-5 py-2">Ajouter</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>




    <footer class="footer pt-3  ">
        <div class="container-fluid">
            <div class="row align-items-center justify-content-lg-between">
                <div class="col-lg-6 mb-lg-0 mb-4">
                    <div class="copyright text-center text-sm text-muted text-lg-start">
                        © <script>
                            document.write(new Date().getFullYear())
                        </script>,
                        made with <i class="fa fa-heart"></i> by
                        <a href="https://www.creative-tim.com" class="font-weight-bold" target="_blank">Dasinformatique</a>
                        for a better web.
                    </div>
                </div>
                <div class="col-lg-6">
                    <ul class="nav nav-footer justify-content-center justify-content-lg-end">
                        <li class="nav-item">
                            <a href="https://www.creative-tim.com" class="nav-link text-muted" target="_blank">Dasinformatique</a>
                        </li>

                    </ul>
                </div>
            </div>
        </div>
    </footer>
    </div>
</main>
<div class="fixed-plugin">
    <a class="fixed-plugin-button text-dark position-fixed px-3 py-2">
        <i class="fa fa-cog py-2"> </i>
    </a>
    <div class="card shadow-lg">
        <div class="card-header pb-0 pt-3 ">
            <div class="float-start">
                <h5 class="mt-3 mb-0">Argon Configurator</h5>
                <p>See our dashboard options.</p>
            </div>
            <div class="float-end mt-4">
                <button class="btn btn-link text-dark p-0 fixed-plugin-close-button">
                    <i class="fa fa-close"></i>
                </button>
            </div>
            <!-- End Toggle Button -->
        </div>
        <hr class="horizontal dark my-1">
        <div class="card-body pt-sm-3 pt-0 overflow-auto">
            <!-- Sidebar Backgrounds -->
            <div>
                <h6 class="mb-0">Sidebar Colors</h6>
            </div>
            <a href="javascript:void(0)" class="switch-trigger background-color">
                <div class="badge-colors my-2 text-start">
                    <span class="badge filter bg-gradient-primary active" data-color="primary" onclick="sidebarColor(this)"></span>
                    <span class="badge filter bg-gradient-dark" data-color="dark" onclick="sidebarColor(this)"></span>
                    <span class="badge filter bg-gradient-info" data-color="info" onclick="sidebarColor(this)"></span>
                    <span class="badge filter bg-gradient-success" data-color="success" onclick="sidebarColor(this)"></span>
                    <span class="badge filter bg-gradient-warning" data-color="warning" onclick="sidebarColor(this)"></span>
                    <span class="badge filter bg-gradient-danger" data-color="danger" onclick="sidebarColor(this)"></span>
                </div>
            </a>
            <!-- Sidenav Type -->
            <div class="mt-3">
                <h6 class="mb-0">Sidenav Type</h6>
                <p class="text-sm">Choose between 2 different sidenav types.</p>
            </div>
            <div class="d-flex">
                <button class="btn bg-gradient-primary w-100 px-3 mb-2 active me-2" data-class="bg-white" onclick="sidebarType(this)">White</button>
                <button class="btn bg-gradient-primary w-100 px-3 mb-2" data-class="bg-default" onclick="sidebarType(this)">Dark</button>
            </div>
            <p class="text-sm d-xl-none d-block mt-2">You can change the sidenav type just on desktop view.</p>
            <!-- Navbar Fixed -->
            <div class="d-flex my-3">
                <h6 class="mb-0">Navbar Fixed</h6>
                <div class="form-check form-switch ps-0 ms-auto my-auto">
                    <input class="form-check-input mt-1 ms-auto" type="checkbox" id="navbarFixed" onclick="navbarFixed(this)">
                </div>
            </div>
            <hr class="horizontal dark my-sm-4">
            <div class="mt-2 mb-5 d-flex">
                <h6 class="mb-0">Light / Dark</h6>
                <div class="form-check form-switch ps-0 ms-auto my-auto">
                    <input class="form-check-input mt-1 ms-auto" type="checkbox" id="dark-version" onclick="darkMode(this)">
                </div>
            </div>
            <a class="btn bg-gradient-dark w-100" href="https://www.creative-tim.com/product/argon-dashboard">Free Download</a>
            <a class="btn btn-outline-dark w-100" href="https://www.creative-tim.com/learning-lab/bootstrap/license/argon-dashboard">View documentation</a>
            <div class="w-100 text-center">
                <a class="github-button" href="https://github.com/creativetimofficial/argon-dashboard" data-icon="octicon-star" data-size="large" data-show-count="true" aria-label="Star creativetimofficial/argon-dashboard on GitHub">Star</a>
                <h6 class="mt-3">Thank you for sharing!</h6>
                <a href="https://twitter.com/intent/tweet?text=Check%20Argon%20Dashboard%20made%20by%20%40CreativeTim%20%23webdesign%20%23dashboard%20%23bootstrap5&amp;url=https%3A%2F%2Fwww.creative-tim.com%2Fproduct%2Fargon-dashboard" class="btn btn-dark mb-0 me-2" target="_blank">
                    <i class="fab fa-twitter me-1" aria-hidden="true"></i> Tweet
                </a>
                <a href="https://www.facebook.com/sharer/sharer.php?u=https://www.creative-tim.com/product/argon-dashboard" class="btn btn-dark mb-0 me-2" target="_blank">
                    <i class="fab fa-facebook-square me-1" aria-hidden="true"></i> Share
                </a>
            </div>
        </div>
    </div>
</div>
<!--   Core JS Files   -->
<script src="assets/js/core/popper.min.js"></script>
<script src="assets/js/plugins/perfect-scrollbar.min.js"></script>
<script src="assets/js/plugins/smooth-scrollbar.min.js"></script>
<script>
    var win = navigator.platform.indexOf('Win') > -1;
    if (win && document.querySelector('#sidenav-scrollbar')) {
        var options = {
            damping: '0.5'
        }
        Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
    }
</script>
<!-- Github buttons -->
<script async defer src="https://buttons.github.io/buttons.js"></script>
<!-- Control Center for Soft Dashboard: parallax effects, scripts for the example pages etc -->
<script src="assets/js/argon-dashboard.min.js?v=2.1.0"></script>
</body>

</html>
<script>
    // Remove this script as it interferes with Bootstrap's functionality
    document.querySelectorAll('[data-bs-toggle="collapse"]').forEach(toggle => {
        toggle.addEventListener('click', function(e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            const isShown = target.classList.contains('show');
            target.classList.toggle('show', !isShown);
        });
    });
</script>
<script>
    // JavaScript for form validation
    (function() {
        'use strict';
        window.addEventListener('load', function() {
            var forms = document.getElementsByClassName('needs-validation');
            Array.prototype.filter.call(forms, function(form) {
                form.addEventListener('submit', function(event) {
                    if (form.checkValidity() === false) {
                        event.preventDefault();
                        event.stopPropagation();
                    }
                    form.classList.add('was-validated');
                }, false);
            });
        }, false);
    })();
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script src="js/toastr.min.js"></script>
