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

<main id="content">
  <section>
    <p class="section-heading">Portfolio</p>
    <div class="card-grid">
      <?php foreach ($page->children()->listed()->sortBy('date', 'desc') as $item): ?>
        <a class="portfolio-thumb" href="<?= $item->url() ?>">
          <?php if ($thumb = $item->thumbnail()->toFile()): ?>
            <img src="<?= $thumb->url() ?>" alt="">
          <?php else: ?>
            <div class="placeholder-box"><span>Project image</span></div>
          <?php endif ?>
          <div class="portfolio-thumb-info">
            <h3><?= $item->headline()->or($item->title())->html() ?></h3>
            <p><?= $item->date()->toDate('F Y') ?></p>
          </div>
        </a>
      <?php endforeach ?>
    </div>
  </section>
</main>

<?php snippet('footer') ?>
</body>
</html>
