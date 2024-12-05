<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste année</title>
    <style>
        body {
            font-family: 'Roboto', Arial, sans-serif;
            background-color: #f8f9fa;
            color: #343a40;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .container {
            background-color: #ffffff;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            max-width: 500px;
            width: 100%;
            text-align: center;
        }
        h1 {
            margin-bottom: 30px;
            font-size: 24px;
            color: #007bff;
        }
        .semestre-link {
            display: flex;
            flex-direction: column;
            gap: 15px;
            margin-bottom: 20px;
        }
        .semestre-link a {
            display: block;
            padding: 12px 20px;
            background-color: #007bff;
            color: #ffffff;
            text-decoration: none;
            border-radius: 5px;
            font-size: 18px;
            transition: background-color 0.3s ease-in-out;
        }
        .semestre-link a:hover {
            background-color: #0056b3;
        }
        .retour-link {
            margin-top: 20px;
        }
        .retour-link a {
            display: inline-block;
            padding: 10px 20px;
            background-color: #6c757d;
            color: #ffffff;
            text-decoration: none;
            border-radius: 5px;
            font-size: 16px;
            transition: background-color 0.3s ease-in-out;
        }
        .retour-link a:hover {
            background-color: #5a6268;
        }
    </style>
</head>
<body>

    <div class="container">
        <h1>Détails de l'Étudiant: <?= $etudiant->nom_etudiant . ' ' . $etudiant->prenom_etudiant ?></h1>
        <div class="semestre-link">
            <a href="<?= site_url('admins/annee_detail/' . $etudiant->num_etu . '/1') ?>">L1 (S1 et S2)</a>
            <a href="<?= site_url('admins/annee_detail/' . $etudiant->num_etu . '/2') ?>">L2 (S3 et S4)</a>
            <a href="<?= site_url('admins/annee_detail/' . $etudiant->num_etu . '/3') ?>">L3 (S5 et S6)</a>
        </div>

        <div class="retour-link">
            <a href="<?php echo site_url('admins/liste_etudiants/' .  $etudiant->num_etu) ;?>">RETOUR</a>
        </div>
    </div>

</body>
</html>
