<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste Semestre</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            text-align: center;
            padding: 20px;
        }
        h1 {
            color: #343a40;
            font-size: 2.5em;
            margin-bottom: 20px;
        }
        table {
            width: 80%;
            margin: 0 auto;
            border-collapse: collapse;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }
        th, td {
            padding: 15px;
            border: 1px solid #dee2e6;
        }
        th {
            background-color: #007bff;
            color: #fff;
        }
        td {
            background-color: #fff;
            color: #343a40;
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
    <h1>Liste des Semestres</h1>

    <table>
        <thead>
            <tr>
                <th>Numéro Semestre</th>
                <th>Détail</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($semestres)): ?>
                <?php foreach ($semestres as $semestre): ?>
                    <tr>
                        <td><?php echo $semestre->numero_semestre; ?></td>
                        <td><a href="<?php echo site_url('etudiants/liste_rattrapage/' . $semestre->id_semestre); ?>">Détail</a></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="2">Aucun semestre trouvé.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <br>

    <a class="back-link" href="<?php echo site_url('etudiants/accueil'); ?>">RETOUR</a>
</body>
</html>
