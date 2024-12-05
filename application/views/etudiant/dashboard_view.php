<!DOCTYPE html>
<html>
<head>
    <title>Dashboard Étudiant</title>
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
        h2 {
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
        <h2>Welcome to the Étudiant Dashboard</h2>
        <p>This is the étudiant dashboard.</p>

        <div class="dashboard-links">
            <a href="<?php echo site_url('etudiants/login'); ?>">Login</a>
            <a href="<?php echo site_url('welcome/index'); ?>">RETOUR</a>
        </div>
    </div>
</body>
</html>
