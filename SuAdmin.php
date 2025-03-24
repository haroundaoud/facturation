<?php

session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit; // Stop the script if the user is not logged in
}
?>
<?php
include 'connect.php'; // Include your Dbf class

$db = new Dbf(); // Instantiate the class


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="apple-touch-icon" sizes="76x76" href="assets/img/apple-icon.png">
    <link rel="icon" type="image/png" href="logo.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.5/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <!-- Buttons Extension CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" rel="stylesheet">
    <script src="js/bootstrap.bundle.min.js"></script>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/bootstrap-icon-1.11.3" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/bootstrap-icons.min.css">
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <link rel="stylesheet" href="fontawesome-free-6.7.2-web/css/all.min.css">
    <link rel="stylesheet" href="assets/css/bootstrap-icons.min.css">
    <link rel="stylesheet" href="assets/css/bootstrap-icons.css">
    <link rel="stylesheet" href="assets/datatables.min.css">




    <style>
        .toast-success {
            background-color: #28a745 !important;
            /* Green background */
            color: #ffffff !important;
            /* White text */
            border-radius: 10px !important;
            /* Rounded corners */
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1) !important;
            /* Subtle shadow */
        }

        .toast-success .toast-title {
            font-weight: bold;
            font-size: 16px;
        }

        .toast-success .toast-message {
            font-size: 14px;
        }

        .toast-close-button {
            color: #ffffff !important;
            /* Close button color */
            opacity: 1 !important;
            /* Full opacity */
        }

        .toast-progress {
            background-color: #ffffff !important;
            /* Progress bar color */
        }



        /* Style the action buttons */
        td.align-middle.text-center button,
        td.align-middle.text-center a {
            font-size: 14px;
            /* Adjust text size */
            padding: 6px 12px;
            /* Adjust padding for buttons */
            border-radius: 8px;
            /* Rounded corners */
            text-align: center;
            /* Center-align text */
        }

        /* Add hover effect for Edit button */
        td.align-middle.text-center .btn-warning:hover {
            background-color: #e0a800;
            /* Darker yellow on hover */
        }

        /* Add hover effect for Delete button */
        td.align-middle.text-center .btn-danger:hover {
            background-color: #c82333;
            /* Darker red on hover */
        }

        /* Additional spacing */
        td.align-middle.text-center {
            padding-top: 15px;
            padding-bottom: 15px;
        }

        /* Styling for DataTable */
        /* Table Wrapper */
        .table.dataTable {
            width: 100%;
            margin: 0;
            border-collapse: collapse;
            /* Collapse borders for a cleaner look */
            background-color: #ffffff;
            border-radius: 10px;
            /* Subtle rounded corners */
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
            /* Elevated shadow for a professional look */
            overflow: hidden;
            /* Rounded corners effect */
            font-family: 'Roboto', sans-serif;
            /* Modern font */
        }

        /* No Footer Styling */
        .table.dataTable.no-footer {
            border-bottom: none;
        }



        /* Table Header Styling */
        .table thead {
            background-color: #5f5f5f;
            /* Corporate blue for header */
            color: white;
            /* White text for contrast */
            text-align: center;
            font-weight: 600;
            text-transform: uppercase;
        }

        .table thead th {
            padding: 14px 20px;
            /* Larger padding for a cleaner layout */
            font-size: 3rem;
            /* Standardized font size */
            letter-spacing: 0.5px;
            /* Slightly spaced letters for clarity */
            border-bottom: 2px solid #dee2e6;
            /* Define header and body separation */
            color: white;
        }

        /* Table Row Styling */
        .table tbody tr {
            background-color: #f8f9fa;
            /* Neutral background */
            border-bottom: 1px solid #e9ecef;
            /* Subtle borders for rows */
            transition: background-color 0.2s ease;
            /* Smooth hover effect */
        }

        /* Alternate Row Coloring */
        .table tbody tr:nth-child(even) {
            background-color: #f1f3f5;
            /* Slightly darker shade for striping */
        }

        /* Hover Effect for Rows */
        .table tbody tr:hover {
            background-color: #e9ecef;
            /* Light gray on hover */
        }

        /* Table Cell Styling */
        .table tbody td {
            padding: 12px 20px;
            /* Adequate spacing for content */
            text-align: center;
            /* Center-align text */
            font-size: 0.875rem;
            /* Standard font size */
            color: #495057;
            /* Dark text for readability */
            vertical-align: middle;
            /* Vertically align content */
            word-wrap: break-word;
            /* Handle long text */
        }

        /* Action Buttons (e.g., Edit/Delete) */
        .table tbody td button,
        .table tbody td a {
            padding: 8px 12px;
            font-size: 0.8rem;
            border-radius: 4px;
            text-transform: uppercase;
            transition: all 0.3s ease;
        }

        .table tbody td button.btn-primary {
            background-color: #007bff;
            color: white;
            border: none;
        }

        .table tbody td button.btn-primary:hover {
            background-color: #0056b3;
            /* Darker blue on hover */
        }

        .table tbody td a.text-danger {
            color: #dc3545;
        }

        .table tbody td a.text-danger:hover {
            color: #a71d2a;
        }

        /* Responsive Table */
        @media (max-width: 768px) {
            .table.dataTable {
                font-size: 0.8rem;
                /* Smaller text on mobile */
            }

            .table tbody td,
            .table thead th {
                padding: 10px 12px;
                /* Reduce padding for mobile */
            }
        }


        /* Responsive table design */
        @media (max-width: 768px) {
            .table thead {
                font-size: 0.8rem;
                /* Smaller header text on small screens */
            }

            .table tbody td {
                font-size: 0.75rem;
                /* Smaller text for table cells on small screens */
                padding: 8px 12px;
                /* Reduced padding for smaller screens */
            }

            .table tbody tr {
                display: block;
                margin-bottom: 10px;
                /* Space between rows on smaller screens */
            }

            .table tbody td {
                display: block;
                text-align: left;
                /* Align text to the left for smaller screens */
                padding: 6px 0;
                /* Reduced padding for mobile view */
            }
        }


        .dt-button.btn-print {
            padding: 8px 16px;
            border-radius: 5px;
            font-size: 0.9rem;
            font-weight: 600;
            color: #67748e;
            background-color: #ffff;
            /* Light blue for print button */
            transition: background-color 0.3s ease;
        }

        .dt-button.btn-print:hover {
            background-color: #c2c2c2;
        }

        .dt-button.btn-pdf {
            padding: 8px 16px;
            border-radius: 5px;
            font-size: 0.9rem;
            font-weight: 600;
            color: #67748e;
            background-color: #ffff;
            /* Red for PDF button */
            transition: background-color 0.3s ease;
        }

        .dt-button.btn-pdf:hover {
            background-color: #c2c2c2;
        }

        .btn-dropdown {
            padding: 8px 16px;
            border-radius: 5px;
            font-size: 0.9rem;
            font-weight: 600;
            color: #67748e;
            background-color: #ffff;
            /* Yellow for Excel button */
            transition: background-color 0.3s ease;
        }

        .dt-button.btn-excel {
            padding: 8px 16px;
            border-radius: 5px;
            font-size: 0.9rem;
            font-weight: 600;
            color: #67748e;
            background-color: #ffff;
            /* Yellow for Excel button */
            transition: background-color 0.3s ease;
        }

        .dt-button.btn-excel:hover {
            background-color: #c2c2c2;
        }

        .dt-button.btn-csv {
            padding: 8px 16px;
            border-radius: 5px;
            font-size: 0.9rem;
            font-weight: 600;
            color: #67748e;
            background-color: #ffff;
            /* Green for CSV button */
            transition: background-color 0.3s ease;
        }

        .dt-button.btn-csv:hover {
            background-color: #c2c2c2;
        }

        .dt-button.btn-copy {
            padding: 8px 16px;
            border-radius: 5px;
            font-size: 0.9rem;
            font-weight: 600;
            color: #67748e;
            background-color: #ffff;
            /* Blue for Copy button */
            transition: background-color 0.3s ease;
        }

        .dt-button.btn-copy:hover {
            background-color: #c2c2c2;
        }

        .card-body {
            max-width: 100%;
            overflow-x: auto;
        }

        /* Styling for Hide/Show Button */
        .dropdown-button {
            display: inline-block;
            padding: 8px 16px;
            border-radius: 5px;
            font-size: 0.9rem;
            font-weight: 600;
            color: #fff;
            background-color: #ff6f61;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .dropdown-button:hover {
            background-color: #e63e50;
        }

        .dropdown-content {
            display: none;
            position: absolute;
            right: 850px;
            top: 0px;
            background-color: #fff;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            border: 1px solid #ddd;
            border-radius: 5px;
            z-index: 1;
            width: 200px;
            padding: 10px 0;
            text-align: left;
        }

        .dropdown-content a {
            display: block;
            color: #495057;
            padding: 8px 12px;
            text-decoration: none;
            transition: background-color 0.2s ease;
        }

        .dropdown-content a:hover {
            background-color: #f8f9fa;
            /* Light gray background on hover */
        }


        .dropdown-button {
            background-color: #4CAF50;
            /* Green background for the button */
            color: white;
            padding: 10px 20px;
            font-size: 16px;
            border: none;
            cursor: pointer;
        }

        .dropdown-button:hover {
            background-color: #3e8e41;
        }

        .dropdown-content.show {
            display: block;
            /* Show the dropdown when toggled */
        }

        /* Styling for DataTables search input */
        .dataTables_filter {
            float: right;
            /* Position it to the right of the table */
            margin-bottom: 20px;
        }

        .dataTables_filter input {
            padding: 8px 16px;
            font-size: 0.9rem;
            font-weight: 600;
            border-radius: 5px;
            border: 1px solid #ddd;
            background-color: #f8f9fa;
            color: #495057;
            width: 200px;
            /* Adjust the width of the input */
            transition: all 0.3s ease;
        }

        .dataTables_filter input:focus {
            outline: none;
            border-color: #007bff;
            /* Highlight the border on focus */
            background-color: #fff;
        }

        .dataTables_filter label {
            margin-right: 10px;
            /* Space between the label and input */
            font-weight: 600;
            color: #495057;
        }

        /* Responsive design for smaller screens */
        @media (max-width: 768px) {
            .dataTables_filter input {
                width: 100%;
                /* Make the search input field full width on smaller screens */
                font-size: 0.8rem;
            }
        }

        /* Date Filter Styling */
        /* General styling for date input fields */
        /* Adjust spacing and alignments for the layout */
        .d-flex {
            display: flex;
            align-items: center;
            gap: 10px;
            /* Adjust spacing between input and button */
        }

        .d-flex gap-4 {
            gap: 20px;
        }

        /* Input fields styling */
        .form-control {
            border-radius: 15px;
            background-color: #f7f7f7;
            border: 2px solid #007bff;
            font-size: 16px;
        }

        /* Add shadow and highlight focus state for the inputs */
        .form-control:focus {
            border-color: #f39c12;
            box-shadow: 0 0 8px rgba(243, 156, 18, 0.6);
        }

        /* Customize the icon color */
        .input-group-text i {
            font-size: 18px;
            color: #f39c12;
        }

        /* Button style */
        /* Button style adjustments for smaller size */
        /* Button style adjustments for smaller size */
        .btn-primary {
            position: relative;
            /* top: 25px; */

            background-color: #1048e3;
            border: none;
            color: #fff;
            font-weight: 600;
            font-size: 14px;
            /* Smaller font size */
            padding: 6px 12px;
            /* Reduced padding for smaller size */
        }

        .haroun {
            position: relative;
            top: 25px;

            background-color: #1048e3;
            border: none;
            color: #fff;
            font-weight: 600;
            font-size: 14px;
            /* Smaller font size */
            padding: 6px 12px;
            /* Reduced padding for smaller size */
        }


        .btn-primary:hover {
            background-color: #c0392b;
        }

        .btn-primary i {
            font-size: 16px;
            /* Smaller icon size */
        }

        /* Adjust spacing between the icon and text */
        .btn span {
            font-size: 14px;
            /* Smaller text size */
            margin-left: 5px;


        }

        input[type="date"] {
            padding-left: 12px;
            padding-right: 12px;
        }

        /* Label for a more professional look */
        .form-label {
            margin-bottom: 8px;
        }


        /* General Pagination Styling */
        .dataTables_wrapper .dataTables_paginate {
            display: flex;
            justify-content: center;
            /* Center-align pagination */
            align-items: center;
            gap: 8px;
            /* Space between pagination buttons */
            margin-top: 20px;
            /* Space above pagination */
            font-family: 'Roboto', sans-serif;
            /* Clean modern font */
        }

        /* Pagination Buttons Styling */
        .dataTables_wrapper .dataTables_paginate .paginate_button {
            padding: 8px 12px;
            /* Button padding */
            margin: 0 2px;
            /* Small margin between buttons */
            font-size: 14px;
            /* Font size */
            color: #007bff;
            /* Blue text for buttons */
            border: 1px solid #ced4da;
            /* Light border */
            background-color: #ffffff;
            /* White background */
            border-radius: 4px;
            /* Rounded corners */
            cursor: pointer;
            transition: all 0.3s ease;
            /* Smooth hover effects */
            text-decoration: none;
            /* Remove underline */
        }

        /* Hover Effect */
        .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
            color: #0056b3;
            /* Darker blue on hover */
            border-color: #0056b3;
            /* Blue border on hover */
            background-color: #f8f9fa;
            /* Light gray background on hover */
        }

        /* Active Pagination Button */
        .dataTables_wrapper .dataTables_paginate .paginate_button.current {
            background-color: #007bff;
            /* Blue background */
            color: #ffffff !important;
            /* White text */
            border-color: #007bff;
            /* Blue border */
            font-weight: bold;
            /* Highlight active button */
            cursor: default;
            /* No pointer on active button */
        }

        /* Disabled Pagination Buttons */
        .dataTables_wrapper .dataTables_paginate .paginate_button.disabled {
            color: #adb5bd;
            /* Gray text for disabled */
            border-color: #dee2e6;
            /* Neutral border */
            background-color: #e9ecef;
            /* Light gray background */
            cursor: not-allowed;
            /* No pointer for disabled */
        }

        /* << and >> Buttons */
        .dataTables_wrapper .dataTables_paginate .paginate_button.first,
        .dataTables_wrapper .dataTables_paginate .paginate_button.last {
            font-weight: bold;
            /* Make << and >> prominent */
        }

        /* Mobile Responsiveness */
        @media (max-width: 768px) {
            .dataTables_wrapper .dataTables_paginate {
                flex-wrap: wrap;
                /* Wrap buttons on smaller screens */
                gap: 4px;
                /* Smaller gap */
            }
        }
    </style>
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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <link rel="icon" type="image/png" href="logo.png">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">
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
                <a class="nav-link" href="historique_ticket.php">
                    <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">

                        <i class="bi bi-list-ul text-dark text-sm opacity-10 me-2"></i>                    </div>

                    historique de ticket
                </a>
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
                    <li class="breadcrumb-item text-sm text-white active" aria-current="page">Gestion des produits</li>
                </ol>
                <h6 class="font-weight-bolder text-white mb-0">produits</h6>
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

    </nav>



    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <!-- End Navbar -->


    <!-- Include DataTables CSS and JS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>


    <?php if (isset($_GET['updated'])): ?>

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
            toastr.success("Le produit a été modifier avec succès !");
        </script>


    <?php endif; ?>






    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-md-12">
                <div class="card shadow-lg rounded-lg">
                    <div class="card-header text-white px-4 py-3">
                        <h6 class="mb-0">Liste des Produits</h6>
                    </div>
                    <div class="card-body p-4">
                        <table id="clientTable" class="table align-items-center mb-0">
                            <thead>
                            <tr>
                                <th class="text-uppercase text-xs font-weight-bold ps-2">Réf Article</th>
                                <th class="text-uppercase text-xs font-weight-bold ps-2">Code Barre</th>
                                <th class="text-uppercase text-xs font-weight-bold ps-2">Title</th>
                                <th class="text-uppercase text-xs font-weight-bold ps-2">Marque</th>
                                <th class="text-uppercase text-xs font-weight-bold ps-2">Catégorie</th>
                                <th class="text-uppercase text-xs font-weight-bold ps-2">Gamme</th>
                                <th class="text-uppercase text-xs font-weight-bold ps-2">Quantité</th>
                                <th class="text-uppercase text-xs font-weight-bold ps-2">Prix d'Achat (HT)</th>
                                <th class="text-uppercase text-xs font-weight-bold ps-2">Marge (%)</th>
                                <th class="text-uppercase text-xs font-weight-bold ps-2">Prix Unitaire HT</th>
                                <th class="text-uppercase text-xs font-weight-bold ps-2">Prix Unitaire TTC</th>
                                <th class="text-uppercase text-xs font-weight-bold ps-2">Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $produits = $db->select("SELECT * FROM produits");
                            foreach ($produits as $produit) {
                                echo "<tr id='row-" . htmlspecialchars($produit['id']) . "'>
                                        <td>" . htmlspecialchars($produit['reference']) . "</td>
                                        <td>" . htmlspecialchars($produit['code_barre']) . "</td>
                                        <td>" . htmlspecialchars($produit['title']) . "</td>
                                        <td>" . htmlspecialchars($produit['brand']) . "</td>
                                        <td>" . htmlspecialchars($produit['categorie']) . "</td>
                                        <td>" . htmlspecialchars($produit['gamme']) . "</td>
                                        <td>" . htmlspecialchars($produit['quantity']) . "</td>
                                        <td>" . htmlspecialchars($produit['prix_dachat']) . "</td>
                                        <td>" . htmlspecialchars('30%') . "</td>
                                        <td>" . htmlspecialchars($produit['prix_unitaire_ht']) . "</td>
                                        <td>" . htmlspecialchars($produit['prix_unitaire_ttc']) . "</td>
                                         <td>
                                            <button class='btn btn-success btn-sm' onclick='showEditCard(" . htmlspecialchars($produit['id']) . ")'><i class='bi bi-pencil-fill'></i></button>
                                            <a href='deleteProduit.php?id=" . htmlspecialchars($produit['id']) . "' 
                                               class='btn btn-danger btn-sm' 
                                               onclick='return confirm(\"Voulez-vous supprimer ce produit ?\")'>


                            <i class='bi bi-trash-fill'></i>

                                            </a>
                                        </td>
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

    <!-- Modal for Editing Product -->
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="editModalLabel">Modifier Produit</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="editProduit.php">
                        <input type="hidden" name="id" id="editId" value="">
                        <div class="mb-3">
                            <label class="form-label">Réf Article</label>
                            <input type="text" class="form-control" name="reference" id="editReference">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Code Barre</label>
                            <input type="text" class="form-control" name="code_barre" id="editCodeBarre" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Titre</label>
                            <input type="text" class="form-control" name="title" id="editTitle">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Prix d'Achat (HT)</label>
                            <input type="decimal" class="form-control" name="prix_dachat" id="editPrixDachat">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Marque</label>
                            <select class="form-control" name="brand" id="editBrand">
                                <?php
                                $brands = $db->select("SELECT DISTINCT brand FROM product"); // Assuming brands are stored in a 'brands' table
                                foreach ($brands as $brands) {
                                    echo "<option value='" . htmlspecialchars($brands['brand']) . "'>" . htmlspecialchars($brands['brand']) . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Catégorie</label>
                            <select class="form-control" name="categorie" id="editCategorie">
                                <?php
                                $categories = $db->select("SELECT DISTINCT categorie FROM product"); // Assuming categories are stored in a 'categories' table
                                foreach ($categories as $categories) {
                                    echo "<option value='" . htmlspecialchars($categories['categorie']) . "'>" . htmlspecialchars($categories['categorie']) . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Gamme</label>
                            <select class="form-control" name="gamme" id="editGamme">
                                <?php
                                $ranges = $db->select("SELECT DISTINCT gamme FROM product"); // Assuming ranges are stored in a 'ranges' table
                                foreach ($ranges as $range) {
                                    echo "<option value='" . htmlspecialchars($range['gamme']) . "'>" . htmlspecialchars($range['gamme']) . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Quantité</label>
                            <input type="number" class="form-control" name="quantity" id="editQuantity" required oninput="calculatePrices()">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Marge (%)</label>
                            <input type="number" class="form-control" name="marge_beneficier" id="editMargeBeneficier" required oninput="calculatePrices()">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Prix Unitaire HT</label>
                            <input type="number" class="form-control" name="prix_unitaire_ht" id="editPrixUnitaireHT" readonly>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Prix Unitaire TTC</label>
                            <input type="number" class="form-control" name="prix_unitaire_ttc" id="editPrixUnitaireTTC" readonly>
                        </div>
                        <button type="submit" class="btn btn-success">Mettre à jour</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Function to show the modal and populate the form with existing data
        function showEditCard(id) {
            var row = document.getElementById('row-' + id);
            document.getElementById('editId').value = id;
            document.getElementById('editReference').value = row.cells[0].innerText;
            document.getElementById('editCodeBarre').value = row.cells[1].innerText;
            document.getElementById('editTitle').value = row.cells[2].innerText;
            document.getElementById('editPrixDachat').value = row.cells[7].innerText;
            document.getElementById('editBrand').value = row.cells[3].innerText;
            document.getElementById('editCategorie').value = row.cells[4].innerText;
            document.getElementById('editGamme').value = row.cells[5].innerText;
            document.getElementById('editQuantity').value = row.cells[6].innerText;
            document.getElementById('editMargeBeneficier').value = row.cells[8].innerText;

            // Calculate initial prices
            calculatePrices();

            // Show the modal
            var myModal = new bootstrap.Modal(document.getElementById('editModal'));
            myModal.show();
        }

        // Function to calculate Prix Unitaire HT and TTC
        function calculatePrices() {
            var prixDachat = parseFloat(document.getElementById('editPrixDachat').value) || 0;
            var marge = parseFloat(document.getElementById('editMargeBeneficier').value) || 0;
            var quantity = parseFloat(document.getElementById('editQuantity').value) || 0;

            // Calculate Prix Unitaire HT
            var prixUnitaireHT = prixDachat * (1 + (marge / 100));
            document.getElementById('editPrixUnitaireHT').value = prixUnitaireHT.toFixed(2);

            // Calculate Prix Unitaire TTC (assuming VAT is 20%)
            var prixUnitaireTTC = prixUnitaireHT * 1.19; // 20% VAT
            document.getElementById('editPrixUnitaireTTC').value = prixUnitaireTTC.toFixed(2);
        }
    </script>
</main>
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
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

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
            },
            "buttons": [{
                extend: 'copy',
                className: 'btn btn-copy'
            },
                {
                    extend: 'csv',
                    className: 'btn btn-csv'
                },
                {
                    extend: 'excel',
                    className: 'btn btn-excel'
                },
                {
                    extend: 'pdf',
                    className: 'btn btn-pdf'
                },
                {
                    extend: 'print',
                    className: 'btn btn-print'
                },
                {
                    text: 'Afficher/Masquer Colonnes &nbsp;<i class="fa-solid fa-caret-down"></i>',
                    className: 'dropdown-button btn btn-copy',
                    action: function(e, dt, node, config) {
                        $('.dropdown-content').toggle();
                    }
                }
            ],




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


<script>
    $(document).ready(function() {
        // Initialize DataTable
        var table = $('#clientTable').DataTable();

        // Custom filtering function
        $.fn.dataTable.ext.search.push(function(settings, data, dataIndex) {
            var startDate = $('#startDate').val();
            var endDate = $('#endDate').val();
            var dateDecla = data[4]; // Replace with the correct column index for `date_decla`

            // If no date filter is applied, show all rows
            if (!startDate && !endDate) {
                return true;
            }

            // Convert dates to comparable format
            var declarationDate = new Date(dateDecla);
            var start = startDate ? new Date(startDate) : null;
            var end = endDate ? new Date(endDate) : null;

            // Check if declarationDate is within the range
            if (
                (!start || declarationDate >= start) &&
                (!end || declarationDate <= end)
            ) {
                return true;
            }

            return false;
        });

        // Event listener for date inputs
        $('#startDate, #endDate').on('change', function() {
            table.draw();
        });

        // Optional: Dropdown logic for showing/hiding columns
        $('.toggle-vis').on('change', function() {
            var column = table.column($(this).attr('data-column'));
            column.visible($(this).is(':checked'));
        });
    });
</script>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.7.2/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.2.2/jszip.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.7.2/js/buttons.html5.min.js"></script>


<script type="text/javascript" src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.js"></script>

<!-- DataTables Buttons extension JS -->

<script src="https://cdn.datatables.net/buttons/2.3.4/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.3.4/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.3.4/js/buttons.print.min.js"></script>

<!-- jEditable -->
<script src="https://cdn.jsdelivr.net/npm/jquery-jeditable@2.0.17/dist/jquery.jeditable.min.js"></script>

<!-- Additional CSS -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz4fnFO9gybB9OBQTxk+d6jaIV0SDbzl4gipFb38B8ANaK8nyE5DAurrTi" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-qN6AoGP6nhCCTAVTtXkCHykaOxd+WjJCFq0t/sXUuFtF0h7x1zwE0H8up2zWbiA/" crossorigin="anonymous"></script>



<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
