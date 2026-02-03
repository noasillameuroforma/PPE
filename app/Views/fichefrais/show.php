<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title><?= htmlspecialchars($title ?? 'Fiche frais') ?></title>
    <style>
        body{font-family:system-ui,-apple-system,Segoe UI,Roboto,Ubuntu,Arial,sans-serif;margin:24px;}
        .card{border:1px solid #ddd;padding:16px;border-radius:8px;max-width:520px;}
        .flash{color:#b30000;margin-bottom:10px;}
        a.button{display:inline-block;margin-top:12px;padding:6px 10px;border:1px solid #ccc;border-radius:6px;text-decoration:none;}
    </style>
</head>
<body>
    <h1>Détail fiche frais</h1>

    <?php if (!empty($message)): ?>
        <div class="flash"><?= htmlspecialchars($message) ?></div>
    <?php endif; ?>

    <?php if (!empty($fiche)): ?>
        <div class="card">
            <p><strong>Visiteur :</strong> <?= htmlspecialchars($fiche['visiteur_nom'].' '.$fiche['visiteur_prenom']) ?></p>
            <p><strong>Mois :</strong> <?= htmlspecialchars((string)$fiche['mois']) ?></p>
            <p><strong>État :</strong> <?= htmlspecialchars((string)$fiche['etat_libelle']) ?></p>
            <p><strong>Hors forfait :</strong> <?= htmlspecialchars((string)($fiche['lhf_libelle'] ?? '—')) ?></p>
            <p><strong>Nbr justificatifs :</strong> <?= htmlspecialchars((string)$fiche['nbrJustificatifs']) ?></p>
            <p><strong>Montant validé :</strong> <?= htmlspecialchars((string)$fiche['montantValide']) ?></p>
            <p><strong>Date modif :</strong> <?= htmlspecialchars((string)$fiche['dateModif']) ?></p>
        </div>

        <a class="button" href="/ficheFrais">⬅ Retour</a>
        <a class="button" href="/ficheFrais/<?= urlencode($fiche['IDvisiteur']) ?>/<?= urlencode($fiche['mois']) ?>/edit">✏️ Modifier</a>
    <?php else: ?>
        <p>Fiche introuvable.</p>
        <a class="button" href="/ficheFrais">Retour à la liste</a>
    <?php endif; ?>
</body>
</html>
