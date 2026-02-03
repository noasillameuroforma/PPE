<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($title ?? 'Modifier fiche', ENT_QUOTES); ?></title>
    <style>
        .error { color: red; }
        .flash { background: #eef; padding: .5rem 1rem; margin-bottom: 1rem; border: 1px solid #99c; }
        .field { margin-bottom: 1rem; }
        label { display: block; margin-bottom: .3rem; }
        input, select { padding:.35rem; min-width: 260px; }
    </style>
</head>
<body>

<h1><?= htmlspecialchars($title ?? 'Modifier fiche'); ?></h1>

<?php if (!empty($message)): ?>
    <div class="flash"><?= htmlspecialchars($message); ?></div>
<?php endif; ?>

<p><strong>Visiteur :</strong> <?= htmlspecialchars($fiche['visiteur_nom'].' '.$fiche['visiteur_prenom']) ?></p>
<p><strong>Mois :</strong> <?= htmlspecialchars((string)$fiche['mois']) ?></p>

<form action="../../<?= urlencode($fiche['IDvisiteur']) ?>/<?= urlencode($fiche['mois']) ?>/edit" method="post">

    <div class="field">
        <label for="idEtat">État</label>
        <select name="idEtat" id="idEtat" required>
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
    <a href="/ficheFrais/<?= urlencode($fiche['IDvisiteur']) ?>/<?= urlencode($fiche['mois']) ?>">Annuler</a>
</form>

</body>
</html>
