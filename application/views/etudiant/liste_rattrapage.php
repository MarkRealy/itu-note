<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste Rattrapage</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            color: #333;
        }

        h1 {
            text-align: center;
            color: #0056b3;
            margin-top: 20px;
        }

        table {
            width: 80%;
            margin: 20px auto;
            border-collapse: collapse;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #0056b3;
            color: #fff;
        }

        tr:hover {
            background-color: #f1f1f1;
        }

        .align-right {
            text-align: right;
        }

        a {
            display: block;
            width: 100px;
            text-align: center;
            padding: 10px;
            margin: 20px auto;
            color: #fff;
            background-color: #0056b3;
            text-decoration: none;
            border-radius: 5px;
        }

        a:hover {
            background-color: #004494;
        }
    </style>
</head>
<body>
    <h1>Liste Matières à Rattraper</h1>
    <table>
        <thead>
            <tr>
                <th>Code Matière</th>
                <th>Matière</th>
            </tr>
        </thead>
        <tbody>
    <?php if (!empty($rattrapage)): ?>
        <?php foreach ($rattrapage as $note): ?>
            <tr>
                <td><?php echo htmlspecialchars($note->code_matiere); ?></td>
                <td><?php echo htmlspecialchars($note->nom_matiere); ?></td>
            </tr>
        <?php endforeach; ?>
        
        <tr>
            <td colspan="2" class="align-right"><strong>Total à payer:</strong></td>
            <?php if ($vola * $count >= 50000): ?>
                <td style="color:green"><?php echo htmlspecialchars($vola * $count); ?></td>
            <?php elseif ($vola * $count < 50000): ?>
                <td style="color:red"><?php echo htmlspecialchars($vola * $count); ?></td>
            <?php endif; ?>
        </tr>
    <?php else: ?>
        <tr>
            <td colspan="2" class="align-center">Aucune matière à rattraper</td>
        </tr>
    <?php endif; ?>
</tbody>

    </table>
    <a href="<?php echo site_url('etudiants/rattrapage'); ?>">Retour</a>
</body>
</html>