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




// Récupérer les produits
$produits = $db->select("SELECT id, title FROM produits");

// Récupérer les clients


?>

<!DOCTYPE html>
<html lang="en">

<head>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<link rel="stylesheet" href="fontawesome-free-6.7.2-web/css/all.min.css">
<link rel="stylesheet" href="css/toastr.min.css">

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>

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
    .modal-lg {
        max-width: 80%;
        left: 9%;
    }
</style>
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
    ///////////
    /* Styles généraux */
    body {
        font-family: Arial, sans-serif;
        background-color: #f8f9fa;
        padding: 20px;
    }

    .card-header {
        background-color: wheat;
        color: white;
        font-weight: bold;
        border-radius: 8px 8px 0 0;
    }

    /* Conteneur principal */
    form {
        background-color: white;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
        max-width: 800px;
        margin: auto;
    }

    /* Champs de formulaire */
    .form-group {
        margin-bottom: 10px;
    }

    .form-control {
        border-radius: 5px;
    }

    /* Section Produits */
    #produits {
        margin-top: 15px;
        padding: 10px;
        border: 1px solid #ddd;
        border-radius: 5px;
        background-color: #f8f8f8;
    }

    .produit {
        border-bottom: 1px solid #ddd;
        padding-bottom: 10px;
        margin-bottom: 10px;
    }

    .produit:last-child {
        border-bottom: none;
    }

    /* Boutons */
    .btn {
        border-radius: 5px;
    }

    .ajouterProduit {
        margin-top: 10px;
    }

    .supprimerProduit {
        background-color: #dc3545;
        color: white;
        border: none;
        padding: 5px 10px;
        border-radius: 5px;
        cursor: pointer;
    }

    .supprimerProduit:hover {
        background-color: #c82333;
    }

    /* Total général */
    #total_general {
        font-weight: bold;
        font-size: 1.2em;
        color: #007bff;
    }
    .facture {
        font-family: Arial, sans-serif;
        background: white;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
        max-width: 900px;
        margin: auto;
    }

    .table-facture {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 20px;
    }

    .table-facture th, .table-facture td {
        border: 1px solid #ddd;
        padding: 10px;
        text-align: center;
    }

    .table-facture th {
        background: #007bff;
        color: white;
    }

    .form-control {
        width: 100%;
        text-align: center;
    }

    .resume-facture {
        margin-top: 20px;
    }

    .resume-facture table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 10px;
    }

    .resume-facture th, .resume-facture td {
        border: 1px solid #ddd;
        padding: 8px;
        text-align: center;
        color: black;
    }

    .total-facture {
        width: 100%;
        border-collapse: collapse;
    }

    .total-facture td {
        padding: 10px;
        border-bottom: 1px solid #ddd;
        color: black;
    }

    .total-ttc {
        font-weight: bold;
        background: #007bff;
        color: black;
    }
</style>
</head>

<!--
<script>
    $(document).ready(function () {
        // Fonction pour calculer le prix total
        function calculerPrixTotal(ligne) {
            var prixHT = parseFloat(ligne.find(".prix_ht").val()) || 0;
            var quantite = parseInt(ligne.find(".quantite").val()) || 1;
            var remise = parseFloat(ligne.find(".remise").val()) || 0;
            var tva = parseFloat(ligne.find(".tva").val()) || 0;

            var prixTotal = prixHT * quantite * (1 - remise / 100);
            ligne.find(".prix_total").val(prixTotal.toFixed(3));

            // Recalculer le total général chaque fois qu'on met à jour un prix
            calculerTotalGeneral();
        }
        // Fonction pour calculer le total général
        function calculerTotalGeneral() {
            var total = 0;
            $(".prix_total").each(function () {
                total += parseFloat($(this).val()) || 0;
            });
            $("#total_general").text(total.toFixed(3) + " TND"); // Change to .toFixed(3) for three decimal places
        }


        // Lors du scan d'un code-barres, récupérer les infos du produit via AJAX
        $(document).on("keypress", ".scanner", function (e) {
            var input = $(this);
            var codeBarre = input.val();
            var ligne = input.closest(".produit");

            if (e.keyCode === 13) { // Si "Entrée" est pressée
                e.preventDefault(); // Empêche l'envoi du formulaire

                $.ajax({
                    url: "get_product_info.php",
                    type: "GET",
                    data: { code_barre: codeBarre },
                    dataType: "json",
                    success: function (data) {
                        if (data.success) {
                            ligne.find(".title").val(data.titre);
                            ligne.find(".prix_ht").val(data.prix_unitaire_ht);
                            ligne.find(".tva").val(data.tva);
                            calculerPrixTotal(ligne);

                            // Focus sur le champ "remise"
                            ligne.find(".remise").focus();
                        } else {
                            alert("Produit non trouvé !");
                        }
                    },
                    error: function () {
                        alert("Erreur de récupération du produit.");
                    }
                });
            }
        });

        // Fonction pour ajouter un produit
        $(document).on("click", ".ajouterProduit", function addligne () {
            var nouvelleLigne = $(`
            <div class="produit mb-3 d-flex align-items-end">
                <div class="form-group me-2">
                    <input type="number" name="quantite[]" class="form-control quantite" min="1" value="1" required>
                </div>
                <div class="form-group me-2">
                    <input type="text" name="code_barre[]" class="form-control scanner" required>
                </div>
                <div class="form-group me-2">
                    <input type="text" class="form-control title" readonly>
                </div>
                <div class="form-group me-2">
                    <input type="number" name="prix_unitaire_ht[]" class="form-control prix_ht" readonly>
                </div>
                <div class="form-group me-2">
                    <input type="number" name="remise[]" class="form-control remise" min="0" max="100" value="0">
                </div>
                <div class="form-group me-2">
                    <input type="number" class="form-control prix_total" readonly>
                </div>
                <div class="form-group me-2">
                    <input type="hidden" class="form-control tva" name="tva[]" >
                    <input type="number" class="form-control tva" readonly>
                </div>
                <button type="button" class="btn btn-danger supprimerProduit">-</button>
            </div>
        `);

            $("#produits").append(nouvelleLigne);

            // Recalcul du total général après ajout d'une ligne de produit
            calculerTotalGeneral();
        });

        // Calcul du total lorsque la quantité ou la remise change
        $(document).on("input", ".quantite, .remise", function () {
            var ligne = $(this).closest(".produit");
            calculerPrixTotal(ligne);
        });

        // Fonction pour calculer le total général
        function calculerTotalGeneral() {
            var total = 0;
            $(".prix_total").each(function () {
                total += parseFloat($(this).val()) || 0;
            });
            $("#total_general").text(total.toFixed(3) + " TND");
        }

        // Suppression d'un produit
        $(document).on("click", ".supprimerProduit", function () {
            $(this).closest(".produit").remove();
            calculerTotalGeneral();
        });
    });
</script>

<script>
    function addtocodebarre(code) {
        // Sélectionne tous les champs `code_barre[]`
        let inputs = document.querySelectorAll('input[name="code_barre[]"]');

        if (inputs.length > 0) {
            // Récupérer le dernier champ `code_barre`
            let dernierInput = inputs[inputs.length - 1];

            // Désactiver temporairement l'écouteur d'événements
            $(dernierInput).off("keypress");

            // Remplir le champ avec le code-barres
            dernierInput.value = code;

            // Réactiver l'événement après un court délai
            setTimeout(() => {
                $(dernierInput).on("keypress", function (e) {
                    if (e.keyCode === 13) {
                        e.preventDefault();
                        fetchProductInfo($(this));
                    }
                });
            }, 100);
        }
    }
    $(document).on("change", ".scanner", function () {
        var input = $(this);
        var codeBarre = input.val().trim(); // Trim pour éviter les espaces accidentels
        var ligne = input.closest(".produit");

        if (codeBarre !== "") {
            fetchProductInfo(input); // Appeler la fonction AJAX seulement si un code-barres est entré
        }
    });

    // Fonction pour récupérer les infos produit via AJAX
    function fetchProductInfo(input) {
        var codeBarre = input.val().trim();
        var ligne = input.closest(".produit");

        $.ajax({
            url: "get_product_info.php",
            type: "GET",
            data: { code_barre: codeBarre },
            dataType: "json",
            success: function (data) {
                if (data.success) {
                    ligne.find(".title").val(data.titre);
                    ligne.find(".prix_ht").val(data.prix_unitaire_ht);
                    ligne.find(".tva").val(data.tva);
                    calculerPrixTotal(ligne);

                    // Focus sur le champ "remise" après remplissage
                    ligne.find(".remise").focus();
                } else {
                    alert("Produit non trouvé !");
                }
            },
            error: function () {
                alert("Erreur de récupération du produit.");
            }
        });
    }

</script>
-->
<script>
    $(document).ready(function () {
        // Fonction pour calculer le prix total
        function calculerPrixTotal(ligne) {
            var prixHT = parseFloat(ligne.find(".prix_ht").val()) || 0;
            var quantite = parseInt(ligne.find(".quantite").val()) || 1;
            var remise = parseFloat(ligne.find(".remise").val()) || 0;
            var tva = parseFloat(ligne.find(".tva").val()) || 0;

            var prixTotal = prixHT * quantite * (1 - remise / 100);
            ligne.find(".prix_total").val(prixTotal.toFixed(3));

            // Recalculer le total général chaque fois qu'on met à jour un prix
            calculerTotalGeneral();
        }

        // Fonction pour calculer le total général
        function calculerTotalGeneral() {
            var totalHT = 0;
            var totalRemise = 0;
            var totalTVA = 0;

            $(".produit").each(function () {
                var prixHT = parseFloat($(this).find(".prix_ht").val()) || 0;
                var quantite = parseInt($(this).find(".quantite").val()) || 1;
                var remise = parseFloat($(this).find(".remise").val()) || 0;
                var tva = parseFloat($(this).find(".tva").val()) || 0;

                var totalProduitHT = prixHT * quantite;
                totalHT += totalProduitHT * (1 - remise / 100);
                totalRemise += totalProduitHT * remise / 100;

                totalTVA += (totalProduitHT * tva) / 100;
            });

            // Mise à jour du total général
            var totalFinalHT = totalHT - totalRemise;
            var totalTTC = totalFinalHT + totalTVA + 1; // Ajout du timbre fiscal

            $("#total_ht").text(totalFinalHT.toFixed(3) + " TND");
            $("#total_remise").text(totalRemise.toFixed(3) + " TND");
            $("#total_ht_final").text(totalFinalHT.toFixed(3) + " TND");
            $("#total_tva").text(totalTVA.toFixed(3) + " TND");
            $("#total_ttc").text(totalTTC.toFixed(3) + " TND");

            // Mise à jour des sous-totaux par TVA
            $("#base_7").text(totalHT * 0.07);
            $("#tva_7").text(totalTVA * 0.07);
            $("#base_13").text(totalHT * 0.13);
            $("#tva_13").text(totalTVA * 0.13);
            $("#base_19").text(totalHT * 0.19);
            $("#tva_19").text(totalTVA * 0.19);
        }

        // Lors du scan d'un code-barres, récupérer les infos du produit via AJAX
        $(document).on("change", ".scanner", function () {
            fetchProductInfo($(this));
        });

        // Fonction AJAX pour récupérer les infos produit
        function fetchProductInfo(input) {
            var codeBarre = input.val().trim();
            var ligne = input.closest(".produit");

            if (codeBarre !== "") {
                $.ajax({
                    url: "get_product_info.php",
                    type: "GET",
                    data: { code_barre: codeBarre },
                    dataType: "json",
                    success: function (data) {
                        if (data.success) {
                            ligne.find(".title").val(data.titre);
                            ligne.find(".prix_ht").val(data.prix_unitaire_ht);
                            ligne.find(".tva").val(data.tva);
                            calculerPrixTotal(ligne);

                            // Focus sur le champ "remise" après remplissage
                            ligne.find(".remise").focus();
                        } else {
                            alert("Produit non trouvé !");
                        }
                    },
                    error: function () {
                        alert("Erreur de récupération du produit.");
                    }
                });
            }
        }

        // Fonction pour ajouter un produit
        $(document).on("click", ".ajouterProduit", function () {
            var nouvelleLigne = $(`<tr class="produit">
                                    <input type="hidden" name="code_barre[]" class="form-control scanner" required>

                                    <td>
                                        <label for="dataInput">Cliquez pour choisir :</label>
                                        <a  id="openModal" class="btn btn-primary">Sélectionner un Produit</a>
                                        <input type="text" class="form-control title" readonly></td>
                                    <td>
                                        <input type="hidden" class="form-control tva" name="tva[]">
                                        <input type="number" class="form-control tva" readonly>
                                    </td>
                                    <td><input type="number" name="quantite[]" class="form-control quantite" min="1" value="1" required></td>
                                    <td><input type="number" name="prix_unitaire_ht[]" class="form-control prix_ht" readonly></td>
                                    <td><input type="number" name="remise[]" class="form-control remise" min="0" max="100" value="0"></td>
                                    <td><input type="number" class="form-control prix_total" readonly></td>
                                    <td><button type="button" class="btn btn-danger supprimerProduit">-</button></td>
                                </tr>`   );



            $("#produits").append(nouvelleLigne);
            calculerTotalGeneral();
        });

        // Calcul du total lorsque la quantité ou la remise change
        $(document).on("input", ".quantite, .remise", function () {
            var ligne = $(this).closest(".produit");
            calculerPrixTotal(ligne);
        });

        // Suppression d'un produit
        $(document).on("click", ".supprimerProduit", function () {
            $(this).closest(".produit").remove();
            calculerTotalGeneral();
        });
    });

    // Fonction pour ajouter un code-barres automatiquement et déclencher la recherche AJAX
    function addtocodebarre(code) {
        let inputs = document.querySelectorAll('input[name="code_barre[]"]');

        if (inputs.length > 0) {
            let dernierInput = inputs[inputs.length - 1];

            // Remplir le champ avec le code-barres
            dernierInput.value = code;

            // Déclencher l'événement change pour lancer la requête AJAX
            $(dernierInput).trigger("change");
        }
    }
</script>
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
                <a class="nav-link dropdown-toggle" data-bs-toggle="collapse" href="#submenuUtilisateur" role="button" aria-expanded="false" aria-controls="submenuUtilisateur">
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
                <a class="nav-link active dropdown-toggle bg-gradient-success" data-bs-toggle="collapse" href="#submenuFacture" role="button" aria-expanded="false" aria-controls="submenuUtilisateur">
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
                                Liste des factures
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="listedevis.php">
                                <i class="bi bi-list-ul text-dark text-sm opacity-10 me-2"></i>
                                Liste des devis
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="listebc.php">
                                <i class="bi bi-list-ul text-dark text-sm opacity-10 me-2"></i>
                                Liste des commande
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="listebl.php">
                                <i class="bi bi-list-ul text-dark text-sm opacity-10 me-2"></i>
                                Liste des bon liv
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
                <a class="nav-link" href="historique_ticket.php">
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
                    <li class="breadcrumb-item text-sm text-white active" aria-current="page">Facture</li>
                </ol>
                <h6 class="font-weight-bolder text-white mb-0">Ajouter facture</h6>
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


    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-md-11 mt-4">
                <div class="card shadow-lg rounded-lg">
                    <div class="card-header text-white px-4 py-3">
                        <h6 class="mb-0">Ajouter une facture :</h6>



                        <form method="POST" action="ajoutFacture.php" class="needs-validation" novalidate>
                            <!-- Sélection du type de facturation -->
                            <select name="type_fac" id="type_fac" class="form-control">
                                <option value="">Sélectionner un type de facturation</option>
                                <option value="facture">Facture</option>
                                <option value="devis">Devis</option>
                                <option value="bl">Bon de livraison</option>
                                <option value="bc">Bon de commande</option>
                            </select>

                            <!-- Sélection du client -->
                            <select name="client_id" id="client_id" class="form-control" required>
                                <option value="">Sélectionner un client</option>
                                <!-- PHP pour remplir les clients -->

                                <?php
                                $clients = $db->select("SELECT id, nom FROM clients");

                                foreach ($clients as $client): ?>
                                    <option value="<?php echo htmlspecialchars($client['id']); ?>">
                                        <?php echo htmlspecialchars( $client['nom']); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>

                            <!-- Section Produits (dynamiquement ajoutée) -->
                            <div class="facture">
                                <table class="table-facture">
                                    <thead>
                                    <tr>
                                        <th>Désignation</th>
                                        <th>TVA</th>
                                        <th>Quantité</th>
                                        <th>Prix unitaire (TND)</th>
                                        <th>Remise (%)</th>
                                        <th>Prix total (TND)</th>
                                        <th>Actions</th>
                                    </tr>
                                    </thead>
                                    <tbody id="produits">
                                    <tr class="produit">
                                        <input type="hidden" name="code_barre[]" class="form-control scanner" required>

                                        <td>
                                            <label for="dataInput">Cliquez pour choisir :</label>
                                            <a id="openModalBtn" class="btn btn-primary">Sélectionner un Produit</a>
                                            <input type="text" class="form-control title" readonly></td>
                                        <td>
                                            <input type="hidden" class="form-control tva" name="tva[]">
                                            <input type="number" class="form-control tva" readonly>
                                        </td>
                                        <td><input type="number" name="quantite[]" class="form-control quantite" min="1" value="1" required></td>
                                        <td><input type="number" name="prix_unitaire_ht[]" class="form-control prix_ht" readonly></td>
                                        <td><input type="number" name="remise[]" class="form-control remise" min="0" max="100" value="0"></td>
                                        <td><input type="number" class="form-control prix_total" readonly></td>
                                        <td><button type="button" class="btn btn-danger supprimerProduit">-</button></td>
                                    </tr>
                                    </tbody>
                                </table>

                                <button type="button" class="btn btn-success ajouterProduit">+ Ajouter un produit</button>

                                <div class="resume-facture">
                                    <table>
                                        <tr>
                                            <th>TVA</th>
                                            <th>Base</th>
                                            <th>Montant TVA</th>
                                        </tr>
                                        <tr>
                                            <td>7.00%</td>
                                            <td id="base_7">0.000</td>
                                            <td id="tva_7">0.000</td>
                                        </tr>
                                        <tr>
                                            <td>13.00%</td>
                                            <td id="base_13">0.000</td>
                                            <td id="tva_13">0.000</td>
                                        </tr>
                                        <tr>
                                            <td>19.00%</td>
                                            <td id="base_19">0.000</td>
                                            <td id="tva_19">0.000</td>
                                        </tr>
                                    </table>
                                    <table class="total-facture">
                                        <tr>
                                            <td>Sous-total HT</td>
                                            <td id="total_ht">0.000 TND</td>
                                        </tr>
                                        <tr>
                                            <td>Remise</td>
                                            <td id="total_remise">0.000 TND</td>
                                        </tr>
                                        <tr>
                                            <td>Total HT</td>
                                            <td id="total_ht_final">0.000 TND</td>
                                        </tr>
                                        <tr>
                                            <td>TVA</td>
                                            <td id="total_tva">0.000 TND</td>
                                        </tr>
                                        <tr>
                                            <td>Timbre fiscal</td>
                                            <td>1.000 TND</td>
                                        </tr>
                                        <tr class="total-ttc">
                                            <td><b>Total TTC</b></td>
                                            <td id="total_ttc"><b>0.000 TND</b></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary">Créer Facture</button>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            // Ouvrir la popup au clic sur le bouton
            $("#openModalBtn").click(function() {
                $("#dataModal").modal("show");
            });

            // Sélectionner une valeur et mettre à jour le bouton
            $(".selectable").click(function() {
                var value = $(this).data("value");
                $("#openModalBtn").text(value);
                $("#dataModal").modal("hide");
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            // Ouvrir la popup au clic sur le bouton
            $("#openModal").click(function() {
                $("#dataModal").modal("show");
            });

            // Sélectionner une valeur et mettre à jour le bouton
            $(".selectable").click(function() {
                var value = $(this).data("value");
                $("#openModal").text(value);
                $("#dataModal").modal("hide");
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            // Initialiser DataTables
            $('#clientTable').DataTable({
                "language": {
                    "lengthMenu": "Afficher _MENU_ enregistrements par page",
                    "zeroRecords": "Aucun produit trouvé",
                    "info": "Affichage de _PAGE_ sur _PAGES_",
                    "infoEmpty": "Aucun enregistrement disponible",
                    "infoFiltered": "(filtré sur _MAX_ enregistrements au total)",
                    "search": "Rechercher :",
                    "paginate": {
                        "first": "Premier",
                        "last": "Dernier",
                        "next": "Suivant",
                        "previous": "Précédent"
                    }
                }
            });

            // Ouvrir la popup au clic sur le bouton
            $("#openModalBtn").click(function() {
                $("#dataModal").modal("show");
            });
        });
    </script>

    <!-- Modal -->
    <div class="modal fade" id="dataModal" tabindex="-1" aria-labelledby="dataModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="dataModalLabel">Sélectionnez un produit</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table id="clientTable" class="table table-striped table-hover">
                            <thead class="table-dark">
                            <tr>
                                <th>Actions</th>
                                <th>Réf</th>
                                <th>Code Barre</th>
                                <th>Title</th>
                                <th>Quantité</th>
                                <th>Prix d'Achat (HT)</th>
                                <th>Prix Unitaire HT</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $produits = $db->select("SELECT * FROM produits");
                            foreach ($produits as $produit) {
                                echo "<tr><td>
                                            <button class='btn btn-success btn-sm' onclick='addtocodebarre(" . $produit['code_barre'] . ")'>
                                                <i class='bi bi-pencil-fill'></i>
                                            </button>
                                           
                                        </td>
                                     
                                        <td>" . htmlspecialchars($produit['reference']) . "</td>
                                        <td>" . htmlspecialchars($produit['code_barre']) . "</td>
                                        <td>" . htmlspecialchars($produit['title']) . "</td>
                                        <td>" . htmlspecialchars($produit['quantity']) . "</td>
                                      
                                        <td>" . htmlspecialchars($produit['prix_dachat']) . "TND</td>
                                        <td>" . htmlspecialchars($produit['prix_unitaire_ht']) . " TND</td>
                                       </tr>";
                            }
                            ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- scripte to put the
    <script>
        function addtocodebarre(code) {
            let input = document.querySelector('input[name="code_barre[]"]');
            if (input) {
                input.value = code; // Ajoute la valeur du code-barres dans l'input
            }
        }
    </script>
    <script>
        function addtocodebarre(code) {
            // Sélectionne tous les champs `code_barre[]`
            let inputs = document.querySelectorAll('input[name="code_barre[]"]');
            if (inputs.length > 0) {
                // Remplit le champ de la dernière ligne ajoutée
                let dernierInput = inputs[inputs.length - 1];
                dernierInput.value = code;
            }
        }
    </script>-->


    <footer class="footer pt-3  ">
        <div class="container-fluid">
            <div class="row align-items-center justify-content-lg-between">
                <div class="col-lg-6 mb-lg-0 mb-4">
                    <div class="copyright text-center text-sm text-muted text-lg-start">
                        © <script>
                            document.write(new Date().getFullYear())
                        </script>,
                        made with <i class="fa fa-heart"></i> by
                        <a href="https://www.dasinformatique.com" class="font-weight-bold" target="_blank">Dasinformatique</a>
                        for a better web.
                    </div>
                </div>
                <div class="col-lg-6">
                    <ul class="nav nav-footer justify-content-center justify-content-lg-end">
                        <li class="nav-item">
                            <a href="https://www.dasinformatique.com" class="nav-link text-muted" target="_blank">Dasinformatique</a>
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
<script>
    $(document).ready(function() {
        // Check if DataTable already exists and destroy if it does
        if ($.fn.dataTable.isDataTable('#clientTable')) {
            $('#clientTable').DataTable().destroy();
        }

        // Initialize DataTable
        var table = $('#clientTable').DataTable({



            "paging": true,
            "ordering": true,
            "searching": true,
            "lengthChange": false,
            "info": false,
            "autoWidth": false,
            "responsive": true,
            "lengthMenu": [
                [7, 15, 25, 30, -1],
                [7, 15, 25, 30, "All"]
            ],
            "dom": '<"top"Bf>rt<"bottom"ilp><"clear">',
            "language": {
                "paginate": {
                    "first": '<i class="fas fa-angle-double-left"></i>',
                    "last": '<i class="fas fa-angle-double-right"></i>',
                    "next": '<i class="fas fa-angle-right"></i>',
                    "previous": '<i class="fas fa-angle-left"></i>'
                }
            }





        });


        $('.toggle-vis').on('change', function() {
            var column = table.column($(this).data('column'));
            column.visible(this.checked);
            saveCheckboxState();
        });

        // Function to save checkbox states to localStorage
        function saveCheckboxState() {
            $('.toggle-vis').each(function() {
                var columnIndex = $(this).data('column');
                localStorage.setItem('columnVisibility_' + columnIndex, this.checked);
            });
        }

        // Function to load checkbox states from localStorage
        function loadCheckboxState() {
            $('.toggle-vis').each(function() {
                var columnIndex = $(this).data('column');
                var isChecked = localStorage.getItem('columnVisibility_' + columnIndex);

                if (isChecked === null) {
                    isChecked = true;
                } else {
                    isChecked = isChecked === 'true';
                }

                $(this).prop('checked', isChecked);
                var column = table.column(columnIndex);
                column.visible(isChecked);
            });
        }

        loadCheckboxState();
    });
</script>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.7.2/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.2.2/jszip.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.7.2/js/buttons.html5.min.js"></script>


<script type="text/javascript" src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.js"></script>
<!-- jEditable -->
<script src="https://cdn.jsdelivr.net/npm/jquery-jeditable@2.0.17/dist/jquery.jeditable.min.js"></script>

<!-- Additional CSS -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz4fnFO9gybB9OBQTxk+d6jaIV0SDbzl4gipFb38B8ANaK8nyE5DAurrTi" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-qN6AoGP6nhCCTAVTtXkCHykaOxd+WjJCFq0t/sXUuFtF0h7x1zwE0H8up2zWbiA/" crossorigin="anonymous"></script>



<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>