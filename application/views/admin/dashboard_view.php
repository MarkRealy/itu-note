<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
    <title>Admin Dashboard</title>
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #e9ecef;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            text-align: center;
            color: #343a40;
        }
        .dashboard-content {
            background: #ffffff;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            width: 100%;
        }
        h2 {
            color: #212529;
            margin-bottom: 20px;
            font-size: 2em;
        }
        .dashboard-links {
            margin-top: 30px;
        }
        .dashboard-links a {
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
        .dashboard-links a:hover {
            background-color: #0056b3;
            transform: scale(1.05);
        }
    </style>
</head>
<body>
    <div class="dashboard-content">
        <h2>Welcome to the Admin Dashboard</h2>
        <p>This is the admin dashboard.</p>

        <div class="dashboard-links">
            <a href="<?php echo site_url('admins/login'); ?>">Login</a>
            <a href="<?php echo site_url('welcome/index'); ?>">RETOUR</a>
        </div>
    </div>
</body>
</html>
