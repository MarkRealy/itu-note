<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier Valeur Config</title>
    <style>
        body {
            font-family: 'Roboto', Arial, sans-serif;
            background-color: #f8f9fa;
            color: #343a40;
            margin: 0;
            padding: 0;
            display: flex;
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
        h2 {
            margin-bottom: 30px;
            font-size: 24px;
            color: #007bff;
        }
        form {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }
        label {
            font-size: 16px;
            text-align: left;
            color: #495057;
        }
        select, input[type="text"] {
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ced4da;
            border-radius: 5px;
            width: 100%;
        }
        button {
            padding: 12px 20px;
            background-color: #007bff;
            color: #ffffff;
            text-decoration: none;
            border-radius: 5px;
            font-size: 18px;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s ease-in-out;
        }
        button:hover {
            background-color: #0056b3;
        }
        .flash-message {
            margin-bottom: 20px;
            padding: 15px;
            border-radius: 5px;
            font-size: 16px;
        }
        .flash-message.success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        .flash-message.error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        .back-link {
            margin-top: 20px;
            display: inline-block;
            padding: 10px 20px;
            background-color: #6c757d;
            color: #ffffff;
            text-decoration: none;
            border-radius: 5px;
            font-size: 16px;
            transition: background-color 0.3s ease-in-out;
        }
        .back-link:hover {
            background-color: #5a6268;
        }
    </style>
</head>
<body>

    <div class="container">
        <!-- Flash Messages -->
        <?php if($this->session->flashdata('success')): ?>
            <div class="flash-message success"><?php echo $this->session->flashdata('success'); ?></div>
        <?php endif; ?>

        <?php if($this->session->flashdata('error')): ?>
            <div class="flash-message error"><?php echo $this->session->flashdata('error'); ?></div>
        <?php endif; ?>

        <h2>Modifier la valeur d'une configuration</h2>

        <form method="post" action="<?php echo site_url('admins/modifier_valeur_config'); ?>">
            <label for="code">Configuration:</label>
            <select name="code" id="code" required>
                <option value="">-- Sélectionnez une configuration --</option>
                <?php foreach($configurations as $configuration): ?>
                    <option value="<?php echo $configuration->code; ?>">
                        <?php echo $configuration->config; ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <label for="valeur">Valeur:</label>
            <input type="text" name="valeur" id="valeur" required />

            <button type="submit">Enregistrer</button>
        </form>

        <a href="<?= site_url('admins/accueil') ?>" class="back-link">Retour à la page d'accueil</a>
    </div>

</body>
</html>
