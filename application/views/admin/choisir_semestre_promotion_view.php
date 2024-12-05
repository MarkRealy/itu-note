<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Choisir Semestre et Promotion</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            color: #343a40;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 600px;
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
        form {
            display: flex;
            flex-direction: column;
        }
        label {
            margin-top: 10px;
        }
        select {
            padding: 10px;
            margin-top: 5px;
            border-radius: 4px;
            border: 1px solid #ced4da;
        }
        button {
            margin-top: 20px;
            padding: 10px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Choisir Semestre et Promotion</h1>
        <form action="<?= site_url('admins/etudiants_par_semestre_promotion') ?>" method="GET">
            <label for="semestre">Semestre:</label>
            <select name="semestre" id="semestre">
                <?php foreach ($semestres as $semestre): ?>
                    <option value="<?= $semestre->id_semestre ?>"><?= $semestre->numero_semestre ?></option>
                <?php endforeach; ?>
            </select>

            <!-- <label for="promotion">Promotion:</label>
            <select name="promotion" id="promotion">
                <?php foreach ($promotions as $promotion): ?>
                    <option value="<?= $promotion->id_promotion ?>"><?= $promotion->nom_promotion ?></option>
                <?php endforeach; ?>
            </select> -->

            <button type="submit">Voir les étudiants</button>
        </form>

        <a href="<?php echo site_url('admins/accueil') ; ?>"> ACCUEIL </a>
    </div>
</body>
</html>
