<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            text-align: center;
            padding: 20px;
        }
        h2 {
            color: #333;
        }
        form {
            max-width: 300px;
            margin: 0 auto;
            background: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        label {
            display: block;
            text-align: left;
            margin-bottom: 10px;
        }
        input[type="text"],
        input[type="password"] {
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
        .error-message {
            color: red;
            margin-top: 10px;
        }
        .return-link {
            display: block;
            margin-top: 20px;
            text-decoration: none;
            color: #007bff;
        }
        .return-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

    <h2>Login</h2>

    <?php echo validation_errors('<div class="error-message">', '</div>'); ?>

    <?php echo form_open('admins/do_login'); ?>

        <label for="login">Login:</label>
        <input type="text" name="login" /><br />

        <label for="mdp">Mot de passe:</label>
        <input type="password" name="mdp" /><br />

        <input type="submit" value="Login" />

    <?php echo form_close(); ?>

    <?php if ($this->session->flashdata('error')): ?>
        <p class="error-message"><?php echo $this->session->flashdata('error'); ?></p>
    <?php endif; ?>

    <a class="return-link" href="<?php echo site_url('welcome/index'); ?>">RETOUR</a>
</body>
</html>
