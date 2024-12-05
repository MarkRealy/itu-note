<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Résultats des Semestres</title>
    <style>
        body {
            font-family: 'Roboto', Arial, sans-serif;
            background-color: #e9ecef;
            color: #495057;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 900px;
            margin: 50px auto;
            background-color: #ffffff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            transition: box-shadow 0.3s ease-in-out;
        }
        .container:hover {
            box-shadow: 0 0 25px rgba(0, 0, 0, 0.15);
        }
        h1, h2, h3 {
            margin-bottom: 20px;
            color: #343a40;
            text-align: center;
        }
        h2 {
            color: #007bff;
            border-bottom: 2px solid #007bff;
            padding-bottom: 10px;
            margin-top: 40px;
        }
        h3 {
            color: #28a745;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            background-color: #f8f9fa;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.05);
        }
        table th, table td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #dee2e6;
        }
        table th {
            background-color: #007bff;
            color: #ffffff;
            text-transform: uppercase;
            font-size: 14px;
            letter-spacing: 0.05em;
        }
        table tr:nth-child(even) {
            background-color: #f1f3f5;
        }
        table td {
            font-size: 16px;
        }
        .align-right {
            text-align: right;
        }
        /* .result-valid {
            background-color: #d4edda;
            color: #155724;
            font-weight: bold;
            padding: 5px 10px;
            border-radius: 4px;
            text-align: center;
        }
        .result-ajournee {
            background-color: #f8d7da;
            color: #721c24;
            font-weight: bold;
            padding: 5px 10px;
            border-radius: 4px;
            text-align: center;
        } */
        a {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #007bff;
            color: #ffffff;
            text-decoration: none;
            border-radius: 4px;
            font-weight: bold;
            text-align: center;
            transition: background-color 0.3s ease-in-out;
        }
        a:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Résultats de l'Étudiant: <?= $etudiant->nom_etudiant . ' ' . $etudiant->prenom_etudiant ?></h1>

        <!-- Dynamic Semester Heading -->
        <h2>Semestre </h2>
        <table>
            <thead>
                <tr>
                    <th>Code Matiere</th>
                    <th>Matière</th>
                    <th>Crédit</th>
                    <th>Note</th>
                    <th>Résultat</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($semestre1['notes'])): ?>
                    <?php foreach ($semestre1['notes'] as $note): ?>
                        <tr>
                            <td><?= $note->code_matiere; ?></td>
                            <td><?= $note->nom_matiere; ?></td>
                            <td><?= ($note->valeur >= 10) ? $note->credit : ''; ?></td>
                            <td><?= $note->valeur; ?></td>
                            <td class="<?= $note->deliberation == 'valide' ? 'result-valid' : 'result-ajournee' ?>">
                                <?= $note->deliberation; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    <tr>
                        <td colspan="2" class="align-right"><strong>Total Crédit Acquis:</strong></td>
                        <td><?= $semestre1['total_credits']; ?></td>
                        <td colspan="2"></td>
                    </tr>
                    <tr>
                        <td colspan="3" class="align-right"><strong>Moyenne des Notes:</strong></td>
                        <td><?= bcadd($semestre1['average'], '0', 2); ?></td>
                        <td></td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>

        <h2>Semestre </h2>
        <table>
            <thead>
                <tr>
                    <th>Code Matiere</th>
                    <th>Matière</th>
                    <th>Crédit</th>
                    <th>Note</th>
                    <th>Résultat</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($semestre2['notes'])): ?>
                    <?php foreach ($semestre2['notes'] as $note): ?>
                        <tr>
                            <td><?= $note->code_matiere; ?></td>
                            <td><?= $note->nom_matiere; ?></td>
                            <td><?= ($note->valeur >= 10) ? $note->credit : ''; ?></td>
                            <td><?= $note->valeur; ?></td>
                            <td class="<?= $note->deliberation == 'valide' ? 'result-valid' : 'result-ajournee' ?>">
                                <?= $note->deliberation; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    <tr>
                        <td colspan="2" class="align-right"><strong>Total Crédit Acquis:</strong></td>
                        <td><?= $semestre2['total_credits']; ?></td>
                        <td colspan="2"></td>
                    </tr>
                    <tr>
                        <td colspan="3" class="align-right"><strong>Moyenne des Notes:</strong></td>
                        <td><?= bcadd($semestre2['average'], '0', 2); ?></td>
                        <td></td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>

        <h3>Moyenne Générale de l'Année: <?= bcadd($moyenne_generale_annee, '0', 2); ?></h3>
        
        <a href="<?php echo site_url('admins/liste_annee/' .  $etudiant->num_etu) ;?>">RETOUR</a>
    </div>
</body>
</html>
