<?php
$siteKey  = 'tidbits';
$siteHome = $site->page('tidbits');
?>
<!doctype html>
<html lang="en">
<head>
<?php snippet('head') ?>
</head>
<body data-theme="tidbits">
<?php snippet('nav', compact('siteKey', 'siteHome')) ?>
<?php snippet('contact-body') ?>
<?php snippet('footer') ?>
</body>
</html>
