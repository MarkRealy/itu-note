<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Relevé de Notes</title>
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #e9ecef;
            text-align: center;
            padding: 50px;
            margin: 0;
        }
        h1 {
            color: #212529;
            margin-bottom: 40px;
            font-size: 2.5em;
        }
        .report-container {
            background: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            max-width: 800px;
            margin: 0 auto;
            text-align: left;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            background: #fff;
            border-radius: 5px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        th, td {
            padding: 12px;
            border: 1px solid #ddd;
            text-align: center;
        }
        th {
            background-color: #0056b3;
            color: white;
        }
        td {
            background-color: #f9f9f9;
        }
        tr:hover td {
            background-color: #f1f1f1;
        }
        a {
            text-decoration: none;
            color: #007bff;
            transition: color 0.3s ease;
        }
        a:hover {
            color: #0056b3;
        }
        .back-link {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }
        .back-link:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="report-container">
        <h1>Relevé de Notes pour le Semestre</h1>

        <table>
            <thead>
                <tr>
                    <th>Code Matiere</th>
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
                            <td><?php echo $note->valeur; ?></td>
                            <td><?php echo $note->deliberation; ?></td>
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
                    <td><?php echo bcadd($average, '0', 8); ?></td>
                    <td></td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>

        <a class="back-link" href="<?php echo site_url('admins/releve_notes_categorie/'. $semestre->id_semestre . '/' . $etudiant->num_etu); ?>">Relevé par categorie</a>

        <a class="back-link" href="<?php echo site_url('admins/details_etudiant/' . $note->num_etu . '/' . $note->unique_etu); ?>">Retour aux détails de l'étudiant</a>
    </div>
</body>
</html>
