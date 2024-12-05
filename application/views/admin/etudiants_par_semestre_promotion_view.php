<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Étudiants par Semestre et Promotion</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            color: #343a40;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            text-align: center;
            color: #007bff;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #007bff;
            color: #fff;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        .home-link {
            text-align: center;
            margin-top: 20px;
        }
        .home-link a {
            text-decoration: none;
            color: #007bff;
            font-size: 1.2em;
        }
    </style>
</head>
<body>
<div class="container">
        <h1>Étudiants de <?= $semestre->numero_semestre ?></h1>
        <table>
            <tr>
                <th>Rang</th>
                <th>ID Étudiant</th>
                <th>Numero ETU</th>
                <th>Nom</th>
                <th>Prénom</th>
                <th>Moyenne</th>
            </tr>
            <?php foreach ($etudiants as $etudiant): ?>
                <tr>
                    <td><?= $etudiant->rang ?></td>
                    <td><?= $etudiant->num_etu ?></td>
                    <td><?= $etudiant->unique_etu ?></td>
                    <td><?= $etudiant->nom_etudiant ?></td>
                    <td><?= $etudiant->prenom_etudiant ?></td>
                    <td><?= bcadd($etudiant->moyenne, '0', 8) ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
        <div class="home-link">
            <a href="<?= site_url('admins/choisir_semestre_promotion') ?>">Retour à la sélection</a>
        </div>
    </div>

</body>
</html>
