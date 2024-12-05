<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Saisir note pour prom</title>
</head>
<body>
    <div class="form-container">
        <h1>Saisir la note pour une promotion selon la matière</h1>
        
        <form method="post" action="<?php echo site_url('admins/inserer_note_prom'); ?>">
            <label for="id_promotion">Promotion:</label>
            <select name="id_promotion">
                <option value="">--Sélectionner une promotion--</option>
                <?php foreach ($promotions as $promo): ?>
                    <option value="<?php echo $promo->id_promotion; ?>" <?php echo ($promo->id_promotion == $this->input->post('id_promotion')) ? 'selected' : ''; ?>>
                        <?php echo $promo->nom_promotion; ?>
                    </option>
                <?php endforeach; ?>
            </select>
            
            <label for="id_matiere">Matière:</label>
            <select name="id_matiere">
                <?php foreach ($matieres as $matiere): ?>
                    <option value="<?php echo $matiere->id_matiere; ?>">
                        <?php echo $matiere->code_matiere; ?>
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