<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Ordre de Fabrication</title>
    {{-- <meta name="csrf-token" content="{{ csrf_token() }}"> --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <style>
        body {
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
            height: 100vh;
            display: flex;
            flex-direction: column;
        }

        h1 {
            text-align: center;
            font-size: 45px;
            color: #007bff;
            margin-top: 20px;
        }

        .container {
            /* flex-grow: 0;    bax container ikbar b double/ stopped from using */
            width: 90%;
            height: 500px;
            margin-top: 20px;
            overflow-y: auto;
            /* the browser ghadi isaweb lik scrollbar ila fat*/
        }

        .table-container {
            overflow: auto;
        }

        table {
            width: 100%;
            margin-top: 20px;
        }

        th,
        td {
            text-align: center;
            padding: 10px;
        }

        .buttons {
            text-align: center;
            margin-top: 20px;
        }

        .footer {
            background-color: #f8f9fa;
            padding: 10px;
            position: sticky;
            bottom: 0;
            text-align: center;
            z-index: 1000;
        }

        button {
            margin: 5px;
            text-align: center
        }

        /* Set a specific width for the Etat column */
        th.etat-col {
            width: 150px;
        }
    </style>
    {{-- stylies 3ta9 bootstrap --}}
</head>

<body>
    <h1>Ordre de Fabrication</h1>
    <div class="container">
        <table class="table table-bordered" id="myTable">
            <thead class="table-secondary">
                <tr>
                    <th>N°OF</th>
                    <th>Date création</th>
                    <th>Client</th>
                    <th>Désignation</th>
                    <th>Qte</th>
                    <th>Caractéristiques</th>
                    <th class="etat-col">Etat</th>{{-- class bax nwas3oh 3la lbotonat bjoj --}}
                    <th>Action</th>
                </tr>
            </thead>

            <tbody>
                {{-- added by js  --}}
            </tbody>
        </table>
    </div>
    <div class="footer">
        <div class="buttons">
            <button onclick="addRow()" class="btn btn-dark">Ajouter</button>
            <button class="btn btn-primary" onclick="saveData()">Enregistrer</button>
        </div>

        <script>
            var ofCounter = 1;
            //fonction li katzid 
            function addRow() {
                var table = document.getElementById("myTable").getElementsByTagName('tbody')[0];
                /* 5dina 1er row li makinax daba 😂*/
                var newRow = table.insertRow(table.rows
                    .length); //zdna row b insertrow dyal DOM (var duyal row bla makat7adad les cellules)
                var types = ['text', 'date', 'text', 'text', 'number', 'text', 'text']; //xadina les columns b types dyalhom

                // Auto-increment and set "N°OF" as read-only
                var cell = newRow.insertCell(0);
                cell.innerHTML = '<td id="td_of_' + ofCounter + '">' + ofCounter + '</td>';

                //zadna biha wahed row b counter o properties
                ofCounter++;
                //loupina 3la 9yass toul tableau 
                for (var i = 1; i < 7; i++) {
                    cell = newRow.insertCell(i);
                    cell.innerHTML = '<input type="' + types[i] + '" class="form-control">';
                }
                //salat hna
                // Add a cell for buttons and set their style
                cell = newRow.insertCell(7);
                cell.style.display = 'flex';
                cell.style.gap = '5px'; // Adjust the gap between buttons as needed
                cell.innerHTML = `
            <button onclick="clearValues(this)" class="btn btn-warning" style="flex: 1;">Vider</button>
            <button onclick="deleteRow(this)" class="btn btn-danger" style="flex: 1;">Supprimer</button>
        `;

                // Ajouter les options à la colonne "État"
                addOptionsToEtatColumn(newRow);
            }

            // Fonction pour ajouter les options à la colonne "État"
            function addOptionsToEtatColumn(row) {
                var etatCell = row.cells[6]; // Colonne "État"
                etatCell.innerHTML = `
            <select class="form-select">
                <option disabled selected hidden>Choisir état OF</option>
                <option>En cours de fabrication</option>
                <option>En cours de livraison</option>
                <option>Livré</option>
            </select>
        `;
            }

            function deleteRow(btn) {
                var row = btn.parentNode.parentNode;
                row.parentNode.removeChild(row);
            }

            function clearValues(btn) {
                var row = btn.parentNode.parentNode;
                for (var i = 1; i < row.cells.length - 1; i++) {
                    var cell = row.cells[i];
                    if (cell.querySelector('input')) {
                        cell.querySelector('input').value = '';
                    } else if (cell.querySelector('select')) {
                        cell.querySelector('select').selectedIndex = 0;
                    }
                }
            }

            function saveData() {
                // Récupérez le tableau de données
                var table = document.getElementById("myTable");
                var rows = table.getElementsByTagName("tr");
                var data = [];

                for (var i = 1; i < rows.length; i++) { // Skip the first row (header)
                    var rowData = [];
                    var cells = rows[i].getElementsByTagName("td");

                    for (var j = 0; j < cells.length - 1; j++) { // Skip the last cell with buttons
                        var cellValue = cells[j].querySelector("input").value;
                        if (!cellValue) {
                            cellValue = cells[j].querySelector("select").value;
                        }
                        rowData.push(cellValue);
                    }

                    data.push(rowData);
                }

                // Ajoutez le jeton CSRF aux données
                data.push('_token', '{{ csrf_token() }}');

                // Envoyez les données à l'application Laravel
                axios.post("store", data)
                    .then(function(response) {
                        alert("Données enregistrées avec succès!");
                    })
                    .catch(function(error) {
                        alert("Erreur lors de l'enregistrement des données.");
                    });
            }
        </script>
        <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
        </script>
</body>

</html>
