<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil</title>
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
        .menu-container {
            background: #ffffff;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            max-width: 500px;
            width: 100%;
        }
        .menu-link {
            display: block;
            margin: 15px 0;
            font-size: 1.2em;
            text-decoration: none;
            color: #007bff;
            padding: 15px;
            border: 1px solid #007bff;
            border-radius: 5px;
            transition: background-color 0.3s ease, color 0.3s ease;
        }
        .menu-link:hover {
            background-color: #007bff;
            color: #fff;
        }
    </style>
</head>
<body>
    <div class="menu-container">
        <h1>Welcome, Admin!</h1>

        <a class="menu-link" href="<?php echo site_url('admins/dash'); ?>">Dashboard</a>
        <a class="menu-link" href="<?php echo site_url('admins/saisir_note'); ?>">Saisir note</a>
        <a class="menu-link" href="<?php echo site_url('admins/liste_etudiants'); ?>">Liste Etudiants</a>
        <a class="menu-link" href="<?php echo site_url('admins/redirect_import_config'); ?>">Upload</a>
        <a class="menu-link" href="<?php echo site_url('admins/choisir_semestre_promotion'); ?>">Rang par semestre</a>
        <a class="menu-link" href="<?php echo site_url('admins/modifier_config'); ?>">Modifier Configuration</a>
        <a class="menu-link" href="<?php echo site_url('admins/saisir_note_prom'); ?>">Saisir note promotion</a>
        <a class="menu-link" href="<?php echo site_url('admins/drop_data'); ?>">Reinitialize</a>
        <a class="menu-link" href="<?php echo site_url('admins/logout'); ?>">Logout</a>
    </div>
</body>
</html>
