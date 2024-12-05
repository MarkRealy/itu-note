<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Relevé de Notes</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            color: #333;
            text-align: center;
            padding: 20px;
        }
        h1 {
            color: #0056b3;
            margin-bottom: 20px;
        }
        table {
            width: 80%;
            margin: 0 auto;
            border-collapse: collapse;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        th, td {
            padding: 12px;
            border: 1px solid #ddd;
            text-align: left;
        }
        th {
            background-color: #0056b3;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        tr:hover {
            background-color: #f1f1f1;
        }
        a {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            text-decoration: none;
            background-color: #0056b3;
            color: white;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }
        a:hover {
            background-color: #004494;
        }
        .align-right {
            text-align: right;
        }
    </style>
</head>
<body>
    <h1>Relevé de Notes pour le Semestre</h1>

    <table>
        <thead>
            <tr>
                <th>UE</th>
                <th>Matière</th>
                <th>Crédit</th>
                <th>Note</th>
                <th>Resultat</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($notes)): ?>
                <?php foreach ($notes as $note): ?>
                    <tr>
                        <td><?php echo $note->code_matiere; ?></td>
                        <td><?php echo $note->nom_matiere; ?></td>
                        <td><?php echo ($note->valeur >= 10) ? $note->credit : ''; ?></td>
                        <td><?php echo (!empty($note->valeur) || $note->valeur == '0') ? $note->valeur : '0'; ?></td>
                        <td><?php echo $note->resultat; ?></td>
                    </tr>
                <?php endforeach; ?>
                <tr>
                    <td colspan="2" class="align-right"><strong>Total Crédit Acquis:</strong></td>
                    <td><?php echo $total_credits; ?></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td colspan="3" class="align-right"><strong>Moyenne des Notes:</strong></td>
                    <td><?php echo number_format($average, 2); ?></td>
                    <td></td>
                </tr>
            <?php else: ?>
                <tr>
                    <td colspan="5">Aucune note trouvée pour ce semestre.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <a href="<?php echo site_url('etudiants/liste_semestre/' . $etudiant->num_etu); ?>">Retour à la liste Semestre</a>
</body>
</html>
