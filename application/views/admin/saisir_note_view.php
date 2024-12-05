<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Saisir note</title>
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #e9ecef;
            text-align: center;
            padding: 50px;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            color: #343a40;
        }
        h1 {
            color: #212529;
            margin-bottom: 40px;
            font-size: 2.5em;
        }
        .form-container {
            background: #ffffff;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            max-width: 500px;
            width: 100%;
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
            margin-bottom: 20px;
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
        .return-link {
            display: inline-block;
            margin-top: 20px;
            text-decoration: none;
            color: #007bff;
            padding: 10px;
            border: 1px solid #007bff;
            border-radius: 5px;
            transition: background-color 0.3s ease, color 0.3s ease;
        }
        .return-link:hover {
            background-color: #007bff;
            color: #fff;
        }
    </style>
</head>
<body>

    <div class="form-container">
        <h1>Saisir la note pour un étudiant selon la matière</h1>

        <?php echo validation_errors('<div class="error-message">', '</div>'); ?>

        <?php echo form_open('admins/inserer_note'); ?>

        <label for="num_etu">Numéro étudiant:</label>
        <input type="text" name="num_etu">

        <label for="id_matiere">Matière:</label>
        <select name="id_matiere">
            <?php foreach ($matieres as $matiere): ?>
                <option value="<?php echo $matiere->id_matiere; ?>">
                    <?php echo $matiere->nom_matiere; ?>
                </option>
            <?php endforeach; ?>
        </select>

        <label for="valeur">Note:</label>
        <input type="text" name="valeur">

        <input type="submit" value="Insérer">

        </form>

        <a class="return-link" href="<?php echo site_url('admins/accueil'); ?>">RETOUR</a>
    </div>

</body>
</html>
