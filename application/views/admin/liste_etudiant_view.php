<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste Etudiants</title>
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
        form {
            background: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            margin: 0 auto 40px auto;
        }
        label {
            display: block;
            text-align: left;
            margin-bottom: 10px;
            font-weight: bold;
        }
        input[type="text"],
        select {
            width: calc(100% - 22px);
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
        }
        input[type="submit"] {
            background-color: #007bff;
            color: #fff;
            border: none;
            padding: 12px 20px;
            font-size: 16px;
            cursor: pointer;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }
        input[type="submit"]:hover {
            background-color: #0056b3;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 0 auto;
            background: #fff;
            border-radius: 5px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        th, td {
            padding: 12px;
            border: 1px solid #ddd;
        }
        th {
            background-color: #f4f4f4;
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
    <h1>Voici tous les étudiants</h1>

    <form method="get" action="<?php echo site_url('admins/inserer_note_prom'); ?>">
        <label for="promotion">Promotion:</label>
        <select name="promotion">
            <option value="">--Sélectionner une promotion--</option>
            <?php foreach ($promotions as $promo): ?>
                <option value="<?php echo $promo->nom_promotion; ?>" <?php echo ($promo->nom_promotion == $this->input->get('promotion')) ? 'selected' : ''; ?>>
                    <?php echo $promo->nom_promotion; ?>
                </option>
            <?php endforeach; ?>
        </select>

        <label for="nom">Nom:</label>
        <input type="text" name="nom" value="<?php echo $this->input->get('nom'); ?>">

        <input type="submit" value="Filtrer">
    </form>

    <table>
        <thead>
            <tr>
                <th>NumETU</th>
                <th>Numéro Étudiant</th>
                <th>Nom</th>
                <th>Prénom</th>
                <th>Promotion</th>
                <th>Détails</th>
                <th>Lien</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($etudiants)): ?>
                <?php foreach ($etudiants as $etudiant): ?>
                    <tr>
                        <td><?php echo $etudiant->num_etu; ?></td>
                        <td><?php echo $etudiant->unique_etu; ?></td>
                        <td><?php echo $etudiant->nom_etudiant; ?></td>
                        <td><?php echo $etudiant->prenom_etudiant; ?></td>
                        <td><?php echo $etudiant->nom_promotion; ?></td>
                        <td><a href="<?php echo site_url('admins/details_etudiant/' . $etudiant->num_etu . '/' . $etudiant->unique_etu); ?>">Détails</a></td>
                        <td><a href="<?php echo site_url('admins/liste_annee/' .  $etudiant->num_etu) ;?>">Liste année</a></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5">Aucun étudiant trouvé.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <a class="back-link" href="<?php echo site_url('admins/accueil'); ?>">Retour Accueil</a>
</body>
</html>
