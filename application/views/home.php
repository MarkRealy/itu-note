<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
    <title>HOME</title>
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #e9ecef;
            padding: 0;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            text-align: center;
            color: #343a40;
        }
        h1 {
            color: #212529;
            margin-bottom: 40px;
            font-size: 2.5em;
        }
        .container {
            background-color: #ffffff;
            padding: 50px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .link-container {
            margin-top: 20px;
        }
        .link-container a {
            display: inline-block;
            margin: 10px;
            padding: 15px 30px;
            text-decoration: none;
            color: #ffffff;
            background-color: #007bff;
            border-radius: 5px;
            transition: background-color 0.3s ease, transform 0.3s ease;
            font-size: 1.2em;
        }
        .link-container a:hover {
            background-color: #0056b3;
            transform: scale(1.05);
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>TONGASOA</h1>
        <div class="link-container">
            <a href="<?php echo site_url('admins/index'); ?>">Accès Admin</a>
            <a href="<?php echo site_url('etudiants/index'); ?>">Accès Etudiant</a>
        </div>
    </div>
</body>
</html>
