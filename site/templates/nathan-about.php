<?php
$siteKey  = 'nathan';
$siteHome = $site->page('nathan');
?>
<!doctype html>
<html lang="en">
<head>
<?php snippet('head') ?>
</head>
<body data-theme="nathan">
<?php snippet('nav', compact('siteKey', 'siteHome')) ?>
<?php snippet('about-body') ?>
<?php snippet('footer') ?>
</body>
</html>
