<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Dashboard des Étudiants</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            color: #343a40;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            text-align: center;
            color: #007bff;
        }
        .stats {
            display: flex;
            justify-content: space-around;
            margin-top: 20px;
        }
        .stat {
            background-color: #e9ecef;
            padding: 20px;
            border-radius: 8px;
            text-align: center;
            flex: 1;
            margin: 0 10px;
        }
        .stat a {
            text-decoration: none;
            color: inherit;
        }
        .stat h2 {
            color: #495057;
        }
        .stat p {
            font-size: 1.2em;
            margin: 0;
        }
        .students-list {
            margin-top: 20px;
        }
        .students-list h3 {
            color: #007bff;
        }
        .students-list ul {
            list-style: none;
            padding: 0;
        }
        .students-list li {
            padding: 10px;
            margin-bottom: 5px;
            border-radius: 4px;
        }
        .total {
            background-color: #cce5ff;
        }
        .valid {
            background-color: #d4edda;
        }
        .non-valid {
            background-color: #f8d7da;
        }
        .home-link {
            text-align: center;
            margin-top: 30px;
        }
        .home-link a {
            text-decoration: none;
            color: #007bff;
            font-size: 1.2em;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Dashboard des Étudiants</h1>
        <div class="stats">
            <div class="stat">
                <a href="?type=total">
                    <h2>Total des Étudiants</h2>
                    <p><?= isset($nbr_total) ? $nbr_total : 0 ?></p>
                </a>
            </div>
            <div class="stat">
                <a href="?type=valid">
                    <h2>Étudiants Validés</h2>
                    <p><?= isset($nbr_valide) ? $nbr_valide : 0 ?></p>
                </a>
            </div>
            <div class="stat">
                <a href="?type=non-valid">
                    <h2>Étudiants Non Validés</h2>
                    <p><?= isset($nbr_non_valide) ? $nbr_non_valide : 0 ?></p>
                </a>
            </div>
        </div>
        <div class="students-list">
            <?php
                if (isset($_GET['type']) && isset($etudiants))
                {
                    $type = $_GET['type'];
                    $students = [];
                    $title = '';
                    $className = '';

                    if ($type === 'total')
                    {
                        $students = $etudiants;
                        $title = 'Liste des Étudiants';
                        $className = 'total';
                    }
                    elseif ($type === 'valid')
                    {
                        $students = array_filter($etudiants, function($etudiant) use ($semestres)
                        {
                            foreach ($semestres as $v)
                            {
                                $result = $this->Note_model->get_notes_par_semestre($v->id_semestre, $etudiant->num_etu);
                                foreach ($result['notes'] as $r) {
                                    if ($r->deliberation == 'ajournee')
                                    {
                                        return false;
                                    }
                                }
                            }
                            return true;
                        });
                        $title = 'Liste des Étudiants Validés';
                        $className = 'valid';
                    }
                    elseif ($type === 'non-valid')
                    {
                        $students = array_filter($etudiants, function($etudiant) use ($semestres)
                        {
                            foreach ($semestres as $v)
                            {
                                $result = $this->Note_model->get_notes_par_semestre($v->id_semestre, $etudiant->num_etu);
                                foreach ($result['notes'] as $r)
                                {
                                    if ($r->deliberation == 'ajournee')
                                    {
                                        return true;
                                    }
                                }
                            }
                            return false;
                        });
                        $title = 'Liste des Étudiants Non Validés';
                        $className = 'non-valid';
                    }

                    echo '<h3>' . $title . '</h3><ul>';
                    foreach ($students as $student)
                    {
                        echo '<li class="' . $className . '"><a href="' . site_url('admins/details_etudiant/' . $student->num_etu . '/' . $student->unique_etu) . '">' . $student->nom_etudiant . ' ' . $student->prenom_etudiant . '</a></li>';
                    }
                    echo '</ul>';
                }
            ?>
        </div>
        <div class="home-link">
            <a href="<?= site_url('admins/accueil') ?>">Retour à la page d\'accueil</a>
        </div>
    </div>
</body>
</html>
