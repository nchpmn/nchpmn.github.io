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

<main id="content">
  <section>
    <p class="section-heading"><?= $page->date()->toDate('F Y') ?></p>
    <h1><?= $page->headline()->or($page->title())->html() ?></h1>
    <p><?= $page->blurb()->html() ?></p>
  </section>
  <section>
    <?= $page->main_content()->toBlocks() ?>
  </section>
</main>

<?php snippet('footer') ?>
</body>
</html>
