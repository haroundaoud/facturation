<?php

session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit; // Stop the script if the user is not logged in
}
?>

<?php
include "db.php";
$db= new Dbt();



?>

<!DOCTYPE html>
<html lang="en">

<head>
</head>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>


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
                <a class="nav-link active dropdown-toggle bg-gradient-success" href="dashboard.php">
                    <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="fa-solid fa-house" style="font-size: 16px; color: #4f4f4f;"></i>
                    </div>
                    <span class="nav-link-text ms-1">Acceuil</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link dropdown-toggle" data-bs-toggle="collapse" href="#submenuUtilisateur" role="button" aria-expanded="false" aria-controls="submenuUtilisateur">
                    <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="fa-solid fa-users-gear" style="font-size: 14px; color: #4f4f4f;"></i>
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
                <a class="nav-link" data-bs-toggle="collapse" href="#submenuFacture" role="button" aria-expanded="false" aria-controls="submenuUtilisateur">
                    <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="fa-solid fa-users-gear" style="font-size: 14px; color: #4f4f4f;"></i>
                    </div>
                    <span class="nav-link-text ms-1">gestion des factures</span>
                </a>

                <div class="collapse" id="submenuFacture">
                    <ul class="nav flex-column ms-4">
                        <li class="nav-item">
                            <a class="nav-link" href="formFacture.php">
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
                <a class="nav-link" href="scanner_produit.php">
                    <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="fa-solid fa-house" style="font-size: 16px; color: #4f4f4f;"></i>
                    </div>
                    <span class="nav-link-text ms-1">Vente au comptoire</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="historique_ticket.php">
                    <i class="bi bi-list-ul text-dark text-sm opacity-10 me-2"></i>
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

    <?php if (isset($_GET['addC'])): ?>

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




    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

    <style>
        toastr.options = {
        "closeButton": true,
        "debug": false,
        "newestOnTop": true,
        "progressBar": true,
        "positionClass": "toast-top-right", // ou une autre position selon ton besoin
        "preventDuplicates": true,
        "onclick": null,
        "showDuration": "300",
        "hideDuration": "1000",
        "timeOut": "5000", // Durée avant disparition
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
        };

    </style>



    <main class="main-content position-relative border-radius-lg ">
        <!-- Navbar -->
     
        <!-- End Navbar -->
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                    <div class="card">
                        <div class="card-body p-3">
                            <div class="row">
                                <div class="col-8">
                                    <div class="numbers">
                                        <p class="text-sm mb-0 text-uppercase font-weight-bold">Today's Money</p>
                                        <h5 class="font-weight-bolder">
                                            $53,000
                                        </h5>
                                        <p class="mb-0">
                                            <span class="text-success text-sm font-weight-bolder">+55%</span>
                                            since yesterday
                                        </p>
                                    </div>
                                </div>
                                <div class="col-4 text-end">
                                    <div class="icon icon-shape bg-gradient-primary shadow-primary text-center rounded-circle">
                                        <i class="ni ni-money-coins text-lg opacity-10" aria-hidden="true"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                    <div class="card">
                        <div class="card-body p-3">
                            <div class="row">
                                <div class="col-8">
                                    <div class="numbers">
                                        <p class="text-sm mb-0 text-uppercase font-weight-bold">Today's Users</p>
                                        <h5 class="font-weight-bolder">
                                            2,300
                                        </h5>
                                        <p class="mb-0">
                                            <span class="text-success text-sm font-weight-bolder">+3%</span>
                                            since last week
                                        </p>
                                    </div>
                                </div>
                                <div class="col-4 text-end">
                                    <div class="icon icon-shape bg-gradient-danger shadow-danger text-center rounded-circle">
                                        <i class="ni ni-world text-lg opacity-10" aria-hidden="true"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                    <div class="card">
                        <div class="card-body p-3">
                            <div class="row">
                                <div class="col-8">
                                    <div class="numbers">
                                        <p class="text-sm mb-0 text-uppercase font-weight-bold">New Clients</p>
                                        <h5 class="font-weight-bolder">
                                            +3,462
                                        </h5>
                                        <p class="mb-0">
                                            <span class="text-danger text-sm font-weight-bolder">-2%</span>
                                            since last quarter
                                        </p>
                                    </div>
                                </div>
                                <div class="col-4 text-end">
                                    <div class="icon icon-shape bg-gradient-success shadow-success text-center rounded-circle">
                                        <i class="ni ni-paper-diploma text-lg opacity-10" aria-hidden="true"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-sm-6">
                    <div class="card">
                        <div class="card-body p-3">
                            <div class="row">
                                <div class="col-8">
                                    <div class="numbers">
                                        <p class="text-sm mb-0 text-uppercase font-weight-bold">Sales</p>
                                        <h5 class="font-weight-bolder">
                                            $103,430
                                        </h5>
                                        <p class="mb-0">
                                            <span class="text-success text-sm font-weight-bolder">+5%</span> than last month
                                        </p>
                                    </div>
                                </div>
                                <div class="col-4 text-end">
                                    <div class="icon icon-shape bg-gradient-warning shadow-warning text-center rounded-circle">
                                        <i class="ni ni-cart text-lg opacity-10" aria-hidden="true"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mt-4">
                <div class="col-lg-7 mb-lg-0 mb-4">
                    <div class="card z-index-2 h-100">
                        <div class="card-header pb-0 pt-3 bg-transparent">
                            <h6 class="text-capitalize">Sales overview</h6>
                            <p class="text-sm mb-0">
                                <i class="fa fa-arrow-up text-success"></i>
                                <span class="font-weight-bold">4% more</span> in 2021
                            </p>
                        </div>
                        <div class="card-body p-3">
                            <div class="chart">
                                <canvas id="chart-line" class="chart-canvas" height="300"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-5">
                    <div class="card card-carousel overflow-hidden h-100 p-0">
                        <div id="carouselExampleCaptions" class="carousel slide h-100" data-bs-ride="carousel">
                            <div class="carousel-inner border-radius-lg h-100">
                                <div class="carousel-item h-100 active" style="background-image: url('..');
      background-size: cover;">
                                    <div class="carousel-caption d-none d-md-block bottom-0 text-start start-0 ms-5">
                                        <div class="icon icon-shape icon-sm bg-white text-center border-radius-md mb-3">
                                            <i class="ni ni-camera-compact text-dark opacity-10"></i>
                                        </div>
                                        <h5 class="text-white mb-1">Get started with Argon</h5>
                                        <p>There’s nothing I really wanted to do in life that I wasn’t able to get good at.</p>
                                    </div>
                                </div>
                                <div class="carousel-item h-100" style="background-image: url('..');
      background-size: cover;">
                                    <div class="carousel-caption d-none d-md-block bottom-0 text-start start-0 ms-5">
                                        <div class="icon icon-shape icon-sm bg-white text-center border-radius-md mb-3">
                                            <i class="ni ni-bulb-61 text-dark opacity-10"></i>
                                        </div>
                                        <h5 class="text-white mb-1">Faster way to create web pages</h5>
                                        <p>That’s my skill. I’m not really specifically talented at anything except for the ability to learn.</p>
                                    </div>
                                </div>
                                <div class="carousel-item h-100" style="background-image: url('..');
      background-size: cover;">
                                    <div class="carousel-caption d-none d-md-block bottom-0 text-start start-0 ms-5">
                                        <div class="icon icon-shape icon-sm bg-white text-center border-radius-md mb-3">
                                            <i class="ni ni-trophy text-dark opacity-10"></i>
                                        </div>
                                        <h5 class="text-white mb-1">Share with us your design tips!</h5>
                                        <p>Don’t be afraid to be wrong because you can’t learn anything from a compliment.</p>
                                    </div>
                                </div>
                            </div>
                            <button class="carousel-control-prev w-5 me-3" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Previous</span>
                            </button>
                            <button class="carousel-control-next w-5 me-3" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Next</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mt-4">
                <div class="col-lg-7 mb-lg-0 mb-4">
                    <div class="card ">
                        <div class="card-header pb-0 p-3">
                            <div class="d-flex justify-content-between">
                                <h6 class="mb-2">Sales by Country</h6>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table align-items-center ">
                                <tbody>
                                <tr>
                                    <td class="w-30">
                                        <div class="d-flex px-2 py-1 align-items-center">
                                            <div>
                                                <img src="../assets/img/icons/flags/US.png" alt="Country flag">
                                            </div>
                                            <div class="ms-4">
                                                <p class="text-xs font-weight-bold mb-0">Country:</p>
                                                <h6 class="text-sm mb-0">United States</h6>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="text-center">
                                            <p class="text-xs font-weight-bold mb-0">Sales:</p>
                                            <h6 class="text-sm mb-0">2500</h6>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="text-center">
                                            <p class="text-xs font-weight-bold mb-0">Value:</p>
                                            <h6 class="text-sm mb-0">$230,900</h6>
                                        </div>
                                    </td>
                                    <td class="align-middle text-sm">
                                        <div class="col text-center">
                                            <p class="text-xs font-weight-bold mb-0">Bounce:</p>
                                            <h6 class="text-sm mb-0">29.9%</h6>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="w-30">
                                        <div class="d-flex px-2 py-1 align-items-center">
                                            <div>
                                                <img src="../assets/img/icons/flags/DE.png" alt="Country flag">
                                            </div>
                                            <div class="ms-4">
                                                <p class="text-xs font-weight-bold mb-0">Country:</p>
                                                <h6 class="text-sm mb-0">Germany</h6>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="text-center">
                                            <p class="text-xs font-weight-bold mb-0">Sales:</p>
                                            <h6 class="text-sm mb-0">3.900</h6>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="text-center">
                                            <p class="text-xs font-weight-bold mb-0">Value:</p>
                                            <h6 class="text-sm mb-0">$440,000</h6>
                                        </div>
                                    </td>
                                    <td class="align-middle text-sm">
                                        <div class="col text-center">
                                            <p class="text-xs font-weight-bold mb-0">Bounce:</p>
                                            <h6 class="text-sm mb-0">40.22%</h6>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="w-30">
                                        <div class="d-flex px-2 py-1 align-items-center">
                                            <div>
                                                <img src="../assets/img/icons/flags/GB.png" alt="Country flag">
                                            </div>
                                            <div class="ms-4">
                                                <p class="text-xs font-weight-bold mb-0">Country:</p>
                                                <h6 class="text-sm mb-0">Great Britain</h6>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="text-center">
                                            <p class="text-xs font-weight-bold mb-0">Sales:</p>
                                            <h6 class="text-sm mb-0">1.400</h6>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="text-center">
                                            <p class="text-xs font-weight-bold mb-0">Value:</p>
                                            <h6 class="text-sm mb-0">$190,700</h6>
                                        </div>
                                    </td>
                                    <td class="align-middle text-sm">
                                        <div class="col text-center">
                                            <p class="text-xs font-weight-bold mb-0">Bounce:</p>
                                            <h6 class="text-sm mb-0">23.44%</h6>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="w-30">
                                        <div class="d-flex px-2 py-1 align-items-center">
                                            <div>
                                                <img src="../assets/img/icons/flags/BR.png" alt="Country flag">
                                            </div>
                                            <div class="ms-4">
                                                <p class="text-xs font-weight-bold mb-0">Country:</p>
                                                <h6 class="text-sm mb-0">Brasil</h6>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="text-center">
                                            <p class="text-xs font-weight-bold mb-0">Sales:</p>
                                            <h6 class="text-sm mb-0">562</h6>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="text-center">
                                            <p class="text-xs font-weight-bold mb-0">Value:</p>
                                            <h6 class="text-sm mb-0">$143,960</h6>
                                        </div>
                                    </td>
                                    <td class="align-middle text-sm">
                                        <div class="col text-center">
                                            <p class="text-xs font-weight-bold mb-0">Bounce:</p>
                                            <h6 class="text-sm mb-0">32.14%</h6>
                                        </div>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-lg-5">
                    <div class="card">
                        <div class="card-header pb-0 p-3">
                            <h6 class="mb-0">Categories</h6>
                        </div>
                        <div class="card-body p-3">
                            <ul class="list-group">
                                <li class="list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg">
                                    <div class="d-flex align-items-center">
                                        <div class="icon icon-shape icon-sm me-3 bg-gradient-dark shadow text-center">
                                            <i class="ni ni-mobile-button text-white opacity-10"></i>
                                        </div>
                                        <div class="d-flex flex-column">
                                            <h6 class="mb-1 text-dark text-sm">Devices</h6>
                                            <span class="text-xs">250 in stock, <span class="font-weight-bold">346+ sold</span></span>
                                        </div>
                                    </div>
                                    <div class="d-flex">
                                        <button class="btn btn-link btn-icon-only btn-rounded btn-sm text-dark icon-move-right my-auto"><i class="ni ni-bold-right" aria-hidden="true"></i></button>
                                    </div>
                                </li>
                                <li class="list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg">
                                    <div class="d-flex align-items-center">
                                        <div class="icon icon-shape icon-sm me-3 bg-gradient-dark shadow text-center">
                                            <i class="ni ni-tag text-white opacity-10"></i>
                                        </div>
                                        <div class="d-flex flex-column">
                                            <h6 class="mb-1 text-dark text-sm">Tickets</h6>
                                            <span class="text-xs">123 closed, <span class="font-weight-bold">15 open</span></span>
                                        </div>
                                    </div>
                                    <div class="d-flex">
                                        <button class="btn btn-link btn-icon-only btn-rounded btn-sm text-dark icon-move-right my-auto"><i class="ni ni-bold-right" aria-hidden="true"></i></button>
                                    </div>
                                </li>
                                <li class="list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg">
                                    <div class="d-flex align-items-center">
                                        <div class="icon icon-shape icon-sm me-3 bg-gradient-dark shadow text-center">
                                            <i class="ni ni-box-2 text-white opacity-10"></i>
                                        </div>
                                        <div class="d-flex flex-column">
                                            <h6 class="mb-1 text-dark text-sm">Error logs</h6>
                                            <span class="text-xs">1 is active, <span class="font-weight-bold">40 closed</span></span>
                                        </div>
                                    </div>
                                    <div class="d-flex">
                                        <button class="btn btn-link btn-icon-only btn-rounded btn-sm text-dark icon-move-right my-auto"><i class="ni ni-bold-right" aria-hidden="true"></i></button>
                                    </div>
                                </li>
                                <li class="list-group-item border-0 d-flex justify-content-between ps-0 border-radius-lg">
                                    <div class="d-flex align-items-center">
                                        <div class="icon icon-shape icon-sm me-3 bg-gradient-dark shadow text-center">
                                            <i class="ni ni-satisfied text-white opacity-10"></i>
                                        </div>
                                        <div class="d-flex flex-column">
                                            <h6 class="mb-1 text-dark text-sm">Happy users</h6>
                                            <span class="text-xs font-weight-bold">+ 430</span>
                                        </div>
                                    </div>
                                    <div class="d-flex">
                                        <button class="btn btn-link btn-icon-only btn-rounded btn-sm text-dark icon-move-right my-auto"><i class="ni ni-bold-right" aria-hidden="true"></i></button>
                                    </div>
                                </li>
                            </ul>
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
                                made with <i class="fa fa-heart"></i> by DAS informatique
                                for a better web.
                            </div>
                        </div>

                    </div>
                </div>
            </footer>
        </div>
    </main>
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