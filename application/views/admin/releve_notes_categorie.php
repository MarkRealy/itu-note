<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Relevé de Notes par Catégorie</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }

        h1 {
            text-align: center;
            color: #333;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background-color: #fff;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        th, td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #4CAF50;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        .align-right {
            text-align: right;
        }

        strong {
            color: #333;
        }

        .category-row {
            background-color: #f9f9f9;
            font-weight: bold;
        }

        .highlight {
            background-color: #fffae6;
        }

        .credit-column {
            text-align: center;
        }

        .average-row {
            background-color: #e9f5e9;
            font-weight: bold;
        }

        .total-row {
            background-color: #dff0d8;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <h1>Notes par Catégorie</h1>

    <table>
        <thead>
            <tr>
                <th>Code Matière</th>
                <th>Matière</th>
                <th class="credit-column">Crédit</th>
                <th>Note</th>
                <th>Résultat</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($categories as $category => $notes): ?>
                <tr class="category-row">
                    <td colspan="5"><?php echo $category; ?></td>
                </tr>
                <?php foreach ($notes as $note): ?>
                    <tr>
                        <td><?php echo $note->code_matiere; ?></td>
                        <td><?php echo $note->nom_matiere; ?></td>
                        <td class="credit-column"><?php echo ($note->valeur >= 10) ? $note->credit : ''; ?></td>
                        <td><?php echo $note->valeur; ?></td>
                        <td><?php echo $note->deliberation; ?></td>
                    </tr>
                <?php endforeach; ?>
                <tr class="average-row">
                    <td colspan="2" class="align-right"><strong>Moyenne <?php echo $category; ?>:</strong></td>
                    <td colspan="3"><?php echo bcadd($averages[$category], '0', 8); ?></td>
                </tr>
            <?php endforeach; ?>
            <tr class="total-row">
                <td colspan="2" class="align-right"><strong>Total Crédit Acquis:</strong></td>
                <td><?php echo $total_credits; ?></td>
                <td></td>
                <td></td>
            </tr>
            <tr class="total-row">
                <td colspan="3" class="align-right"><strong>Moyenne Générale:</strong></td>
                <td><?php echo bcadd($average, '0', 8); ?></td>
                <td></td>
            </tr>
        </tbody>
    </table>

    <a href="<?php echo site_url('admins/accueil') ; ?>"> ACCUEIL </a>
</body>
</html>
