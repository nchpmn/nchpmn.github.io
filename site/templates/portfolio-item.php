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
    <p class="section-heading"><?= $page->date()->toDate('F Y') ?></p>
    <h1><?= $page->headline()->or($page->title())->html() ?></h1>
    <p><?= $page->blurb()->html() ?></p>
  </section>

  <section>
    <?php if ($page->featured_media_type()->value() === 'video' && $page->featured_video_url()->isNotEmpty()): ?>
      <div class="placeholder-box" style="aspect-ratio:16/9;">
        <iframe src="<?= embedUrl($page->featured_video_url()->value()) ?>"
          frameborder="0" allow="autoplay; fullscreen" allowfullscreen style="width:100%;height:100%;"></iframe>
      </div>
    <?php elseif ($photo = $page->featured_photo()->toFile()): ?>
      <div class="placeholder-box"><img src="<?= $photo->url() ?>" alt=""></div>
    <?php else: ?>
      <div class="placeholder-box"><span>Featured media</span></div>
    <?php endif ?>
  </section>

  <section>
    <?= $page->main_content()->toBlocks() ?>
  </section>
</main>

<?php snippet('footer') ?>
</body>
</html>
