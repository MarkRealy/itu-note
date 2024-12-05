<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détails de l'Étudiant</title>
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
        .details-container {
            background: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            margin: 0 auto;
            text-align: left;
        }
        p {
            font-size: 1.1em;
            margin: 10px 0;
        }
        p strong {
            color: #0056b3;
        }
        h2 {
            margin-top: 30px;
            font-size: 1.5em;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            background: #fff;
            border-radius: 5px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }
        th, td {
            padding: 12px;
            border: 1px solid #ddd;
        }
        th {
            background-color: #0056b3;
            color: white;
            text-align: left;
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
    <div class="details-container">
        <h1>Détails de l'Étudiant</h1>

        <p><strong>numETU:</strong><?php echo $etudiant->num_etu; ?></p>
        <p><strong>Unique_ETU:</strong> <?php echo $etudiant->unique_etu; ?></p>
        <p><strong>Nom:</strong> <?php echo $etudiant->nom_etudiant; ?></p>
        <p><strong>Prénom:</strong> <?php echo $etudiant->prenom_etudiant; ?></p>

        <h2>Semestres Inscrits</h2>
        <table>
            <thead>
                <tr>
                    <th>Numéro Semestre</th>
                    <th>Moyenne</th>
                    <th>Resultat</th>
                    <th>Rang / semestre</th>
                    <th>Rang / etudiant</th>
                    <th>Détails</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($semestres)): ?>
                    <?php foreach ($semestres as $semestre): ?>
                        <tr>
                            <td><?php echo $semestre->numero_semestre; ?></td>

                            <?php if ($semestre->moyenne < 6){?>
                                <td style = "color:red"><?php echo bcadd($semestre->moyenne, '0', 8); ?></td>
                            <?php } else if($semestre->moyenne >= 6 && $semestre->moyenne < 10) {?>
                                <td style = "color:blue"><?php echo bcadd($semestre->moyenne,'0', 8); ?></td>
                            <?php }else{?>
                                <td style = "color:green"><?php echo bcadd($semestre->moyenne,'0', 8); ?></td>
                            <?php }?>
                            <td><?= $semestre->deliberation?></td>
<?php if (isset($semestre->rang_dense)) : ?>
    <td><?= $semestre->rang_dense ?></td>
<?php else : ?>
    <td>-</td> <!-- Ou une autre valeur par défaut -->
<?php endif; ?>
                            <td><?= $semestre->rang?></td>
                            <td><a href="<?php echo site_url('admins/releve_notes/' . $etudiant->num_etu . '/' . $etudiant->unique_etu . '/' . $semestre->id_semestre); ?>">Détails</a></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="2">Aucun semestre trouvé.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>

        <a class="back-link" href="<?php echo site_url('admins/liste_etudiants'); ?>">Retour à la liste des étudiants</a>
    </div>
</body>
</html>
