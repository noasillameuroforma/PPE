<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title><?= htmlspecialchars($title ?? 'Fiches frais') ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        body{font-family:system-ui,-apple-system,Segoe UI,Roboto,Ubuntu,Arial,sans-serif;margin:24px;}
        table{border-collapse:collapse;width:100%;max-width:1100px;}
        th,td{border:1px solid #ddd;padding:8px;text-align:left;}
        th{background:#f6f6f6;}
        .topbar{margin-bottom:16px;display:flex;gap:12px;align-items:center;}
        .flash{color:#b30000;margin:8px 0;}
        a.button{display:inline-block;padding:6px 10px;border:1px solid #ccc;border-radius:6px;text-decoration:none;}
        .actions a{margin-right:6px;}
        .actions form { display:inline; margin:0; }
        .actions button { border:1px solid #ccc; border-radius:6px; padding:4px 8px; background:#fff; cursor:pointer; }
    </style>
</head>
<body>
    <div class="topbar">
        <h1 style="margin:0;">Liste des fiches frais</h1>
        <a class="button" href="./dashboard">Dashboard</a>
        <a class="button" href="./logout">Se déconnecter</a>
    </div>

    <a class="button" href="ficheFrais/create">➕ Ajouter une fiche</a>

    <?php if (!empty($message)): ?>
        <div class="flash"><?= htmlspecialchars($message) ?></div>
    <?php endif; ?>

    <?php if (empty($fiches)): ?>
        <p>Aucune fiche trouvée.</p>
    <?php else: ?>
        <table>
            <thead>
                <tr>
                    <th>Visiteur</th>
                    <th>Mois</th>
                    <th>État</th>
                    <th>Hors forfait</th>
                    <th>Justifs</th>
                    <th>Montant</th>
                    <th>Date modif</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($fiches as $f): ?>
                <tr>
                    <td><?= htmlspecialchars($f['visiteur_nom'] . ' ' . $f['visiteur_prenom']) ?></td>
                    <td><?= htmlspecialchars((string)$f['mois']) ?></td>
                    <td><?= htmlspecialchars((string)$f['etat_libelle']) ?></td>
                    <td><?= htmlspecialchars((string)($f['lhf_libelle'] ?? '—')) ?></td>
                    <td><?= htmlspecialchars((string)$f['nbrJustificatifs']) ?></td>
                    <td><?= htmlspecialchars((string)$f['montantValide']) ?></td>
                    <td><?= htmlspecialchars((string)$f['dateModif']) ?></td>
                    <td class="actions">
                        <a href="./<?= urlencode($f['IDvisiteur']) ?>/<?= urlencode($f['mois']) ?>">Voir</a>
                        <a href="./<?= urlencode($f['IDvisiteur']) ?>/<?= urlencode($f['mois']) ?>/edit">Modifier</a>
                        <form action="./<?= urlencode($f['IDvisiteur']) ?>/<?= urlencode($f['mois']) ?>/delete"
                              method="post"
                              onsubmit="return confirm('Supprimer cette fiche ?');">
                            <button type="submit">Supprimer</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</body>
</html>
