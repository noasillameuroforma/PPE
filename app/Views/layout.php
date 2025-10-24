<?php /** @var string $title */ ?>
<!doctype html>
<html lang="fr"><head>
  <meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1">
  <title><?= htmlspecialchars($title ?? 'App', ENT_QUOTES) ?></title>
  <meta http-equiv="X-Content-Type-Options" content="nosniff">
  <meta http-equiv="X-Frame-Options" content="DENY">
  <meta http-equiv="Content-Security-Policy" content="default-src 'self'">
  <style>body{font-family:system-ui;margin:2rem}a{color:inherit}</style>
</head><body>
  <main>
    <?php require $viewFile; ?>
  </main>
</body></html>
