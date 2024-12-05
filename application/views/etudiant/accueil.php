<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil Étudiant</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            text-align: center;
            padding: 20px;
        }
        .dashboard-content {
            max-width: 600px;
            margin: 0 auto;
            background: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        h1 {
            color: #333;
        }
        .dashboard-links {
            margin-top: 20px;
        }
        .dashboard-links a {
            display: block;
            margin-bottom: 10px;
            padding: 10px;
            background-color: #007bff;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }
        .dashboard-links a:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="dashboard-content">
        <h1>Welcome, Étudiant!</h1>

        <div class="dashboard-links">
            <a href="<?php echo site_url('etudiants/liste_semestre'); ?>">Liste Semestres</a>
            <a href="<?php echo site_url('etudiants/rattrapage'); ?>">Liste Rattrapages</a>
            <a href="<?php echo site_url('etudiants/logout'); ?>">Logout</a>
        </div>
    </div>
</body>
</html>
