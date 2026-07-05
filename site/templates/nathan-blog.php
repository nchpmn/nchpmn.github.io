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
    <p class="section-heading">Blog</p>
    <div class="card-grid">
      <?php foreach ($page->children()->listed()->sortBy('date', 'desc') as $article): ?>
        <article class="card">
          <?php if ($thumb = $article->thumbnail()->toFile()): ?>
            <div class="placeholder-box"><img src="<?= $thumb->url() ?>" alt=""></div>
          <?php else: ?>
            <div class="placeholder-box"><span>Post image</span></div>
          <?php endif ?>
          <h3><a href="<?= $article->url() ?>" class="text-link"><?= $article->headline()->or($article->title())->html() ?></a></h3>
          <p><?= $article->blurb()->html() ?></p>
        </article>
      <?php endforeach ?>
    </div>
  </section>
</main>

<?php snippet('footer') ?>
</body>
</html>
