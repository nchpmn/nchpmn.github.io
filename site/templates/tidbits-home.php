<?php
$siteKey  = 'tidbits';
$siteHome = $page;
$aboutPage = $page->find('about');
$projects  = $page->find('projects')->children()->listed()->sortBy('date', 'desc');
?>
<!doctype html>
<html lang="en">
<head>
<?php snippet('head') ?>
</head>
<body data-theme="tidbits">
<?php snippet('nav', compact('siteKey', 'siteHome')) ?>

<div class="showreel-wrap">
  <?php if ($page->showreel_url()->isNotEmpty()): ?>
    <iframe class="showreel-bg" src="<?= embedBackgroundUrl($page->showreel_url()->value()) ?>"
      frameborder="0" allow="autoplay; fullscreen" allowfullscreen tabindex="-1"></iframe>
  <?php endif ?>
  <div class="showreel-overlay">
    <?php if ($logo = $page->logo()->toFile()): ?>
      <img src="<?= $logo->url() ?>" alt="<?= $site->title()->html() ?>" class="showreel-logo">
    <?php else: ?>
      <span class="showreel-logo-placeholder">[Logo placeholder]</span>
    <?php endif ?>
    <div class="showreel-links">
      <a href="<?= $aboutPage->url() ?>">About</a>
      <a href="#portfolio" class="scroll-link">Scroll for portfolio ↓</a>
    </div>
  </div>
</div>

<main id="content">
  <section id="portfolio">
    <p class="section-heading">Recent work</p>
    <div class="card-grid">
      <?php foreach ($projects->limit(6) as $item): ?>
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
