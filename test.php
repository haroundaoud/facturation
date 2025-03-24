<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Facture</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
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
        }

        .total-facture {
            width: 100%;
            border-collapse: collapse;
        }

        .total-facture td {
            padding: 10px;
            border-bottom: 1px solid #ddd;
        }

        .total-ttc {
            font-weight: bold;
            background: #007bff;
            color: black;
        }
    </style>
</head>
<body>

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

            <td>                                    <input type="text" class="form-control title" readonly>
            </td>
            <td><input type="hidden" class="form-control tva" name="tva[]" >
                <input type="number" class="form-control tva" readonly></td>
            <td>                                    <input type="number" name="quantite[]" class="form-control quantite" min="1" value="1" required>
            </td>
            <td>                                        <input type="number" name="prix_unitaire_ht[]" class="form-control prix_ht" readonly >
            </td>
            <td>                                    <input type="number" name="remise[]" class="form-control remise" min="0" max="100" value="0">
            </td>
            <td>                                    <input type="number" class="form-control prix_total" readonly>
            </td>
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
                <td id="base_7">000</td>
                <td id="tva_7">00</td>
            </tr>
            <tr>
                <td>19.00%</td>
                <td id="base_19">000</td>
                <td id="tva_19">00</td>
            </tr>
        </table>
        <p>Arrêtée la présente facture à la somme de <b id="montant_lettres">cent quatre-vingt-dix dinars six cent cinquante millimes.</b></p>
        <table class="total-facture">
            <tr>
                <td>Sous-total HT</td>
                <td id="total_ht">000 TND</td>
            </tr>
            <tr>
                <td>Remise</td>
                <td id="total_remise">0.000 TND</td>
            </tr>
            <tr>
                <td>Total HT</td>
                <td id="total_ht_final">0 TND</td>
            </tr>
            <tr>
                <td>TVA</td>
                <td id="total_tva">0 TND</td>
            </tr>
            <tr>
                <td>Timbre fiscal</td>
                <td>1.000 TND</td>
            </tr>
            <tr class="total-ttc">
                <td><b>Total TTC</b></td>
                <td id="total_ttc"><b>0 TND</b></td>
            </tr>
        </table>
    </div>
</div>

<script>
    document.querySelector(".ajouterProduit").addEventListener("click", function () {
        let tableBody = document.getElementById("produits");
        let newRow = document.createElement("tr");
        newRow.classList.add("produit");

        newRow.innerHTML = `
            <td><input type="text" class="form-control title" placeholder="Produit"></td>
            <td><input type="number" class="form-control tva" value="7.00" readonly></td>
            <td><input type="number" class="form-control quantite" min="1" value="1"></td>
            <td><input type="number" class="form-control prix_ht" value="155.000" readonly></td>
            <td><input type="number" class="form-control remise" min="0" max="100" value="0"></td>
            <td><input type="number" class="form-control prix_total" value="155.000" readonly></td>
            <td><button type="button" class="btn btn-danger supprimerProduit">-</button></td>
        `;

        tableBody.appendChild(newRow);

        newRow.querySelector(".supprimerProduit").addEventListener("click", function () {
            newRow.remove();
        });
    });

    document.querySelectorAll(".supprimerProduit").forEach(button => {
        button.addEventListener("click", function () {
            this.closest(".produit").remove();
        });
    });
</script>

</body>
</html>
