<!doctype html>
<html lang="en">
<head>
<?php snippet('head') ?>
</head>
<body>
<header id="splash">
  <a href="<?= $site->page('nathan')->url() ?>" class="splash-half splash-nathan"><span>Nathan Chapman</span></a>
  <a href="<?= $site->page('tidbits')->url() ?>" class="splash-half splash-tidbits"><span>Tidbits</span></a>
</header>

<nav id="sitenav"></nav>
<main id="content"></main>
<footer id="sitefooter"></footer>

<script src="<?= url('assets/js/router.js') ?>"></script>
</body>
</html>
