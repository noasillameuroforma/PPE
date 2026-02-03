<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($title ?? 'Créer fiche', ENT_QUOTES, 'UTF-8'); ?></title>
    <style>
        .error { color: red; }
        .flash { background: #eef; padding: .5rem 1rem; margin-bottom: 1rem; border: 1px solid #99c; }
        .field { margin-bottom: 1rem; }
        label { display: block; margin-bottom: .3rem; }
        input, select { padding:.35rem; min-width: 260px; }
    </style>
</head>
<body>

<h1><?= htmlspecialchars($title ?? 'Créer fiche', ENT_QUOTES, 'UTF-8'); ?></h1>

<?php if (!empty($message)): ?>
    <div class="flash"><?= htmlspecialchars($message, ENT_QUOTES, 'UTF-8'); ?></div>
<?php endif; ?>

<form action="./create" method="post">

    <div class="field">
        <label for="IDvisiteur">Visiteur</label>
        <select name="IDvisiteur" id="IDvisiteur" required>
            <option value="">-- choisir --</option>
            <?php foreach ($visiteurs as $v): ?>
                <?php $val = (string)$v['ID']; ?>
                <option value="<?= htmlspecialchars($val) ?>"
                    <?= ($old['IDvisiteur'] ?? '') == $val ? 'selected' : '' ?>>
                    <?= htmlspecialchars($v['NOM'] . ' ' . $v['PRENOM']) ?>
                </option>
            <?php endforeach; ?>
        </select>
        <?php if (!empty($errors['IDvisiteur'])): ?>
            <div class="error"><?= htmlspecialchars($errors['IDvisiteur']); ?></div>
        <?php endif; ?>
    </div>

    <div class="field">
        <label for="mois">Mois (ex: 202508)</label>
        <input type="number" name="mois" id="mois" value="<?= htmlspecialchars($old['mois'] ?? '') ?>" required>
        <?php if (!empty($errors['mois'])): ?>
            <div class="error"><?= htmlspecialchars($errors['mois']); ?></div>
        <?php endif; ?>
    </div>

    <div class="field">
        <label for="idEtat">État</label>
        <select name="idEtat" id="idEtat" required>
            <option value="">-- choisir --</option>
            <?php foreach ($etats as $e): ?>
                <?php $val = (string)$e['id']; ?>
                <option value="<?= htmlspecialchars($val) ?>"
                    <?= ($old['idEtat'] ?? '') == $val ? 'selected' : '' ?>>
                    <?= htmlspecialchars($e['libelle']) ?>
                </option>
            <?php endforeach; ?>
        </select>
        <?php if (!empty($errors['idEtat'])): ?>
            <div class="error"><?= htmlspecialchars($errors['idEtat']); ?></div>
        <?php endif; ?>
    </div>

    <div class="field">
        <label for="idLigneFraisHorsForfait">Ligne frais hors forfait</label>
        <select name="idLigneFraisHorsForfait" id="idLigneFraisHorsForfait" required>
            <option value="">-- choisir --</option>
            <?php foreach ($lhf as $l): ?>
                <?php $val = (string)$l['ID']; ?>
                <option value="<?= htmlspecialchars($val) ?>"
                    <?= ($old['idLigneFraisHorsForfait'] ?? '') == $val ? 'selected' : '' ?>>
                    <?= htmlspecialchars($l['libelle']) ?>
                </option>
            <?php endforeach; ?>
        </select>
        <?php if (!empty($errors['idLigneFraisHorsForfait'])): ?>
            <div class="error"><?= htmlspecialchars($errors['idLigneFraisHorsForfait']); ?></div>
        <?php endif; ?>
    </div>

    <div class="field">
        <label for="nbrJustificatifs">Nbr justificatifs</label>
        <input type="number" name="nbrJustificatifs" id="nbrJustificatifs"
               value="<?= htmlspecialchars($old['nbrJustificatifs'] ?? '0') ?>" required>
    </div>

    <div class="field">
        <label for="montantValide">Montant validé</label>
        <input type="number" name="montantValide" id="montantValide"
               value="<?= htmlspecialchars($old['montantValide'] ?? '0') ?>" required>
    </div>

    <div class="field">
        <label for="dateModif">Date modif</label>
        <input type="date" name="dateModif" id="dateModif"
               value="<?= htmlspecialchars($old['dateModif'] ?? date('Y-m-d')) ?>" required>
        <?php if (!empty($errors['dateModif'])): ?>
            <div class="error"><?= htmlspecialchars($errors['dateModif']); ?></div>
        <?php endif; ?>
    </div>

    <button type="submit">Enregistrer</button>
    <a href="/ficheFrais">Annuler</a>
</form>

</body>
</html>
