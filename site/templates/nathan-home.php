<?php
$siteKey  = 'nathan';
$siteHome = $page;
$articles = $page->find('blog')->children()->listed()->sortBy('date', 'desc');
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
    <p class="section-heading">Hi, I'm</p>
    <h1><?= $page->headline()->or($page->title())->html() ?></h1>
    <p><?= $page->blurb()->html() ?></p>
  </section>

  <section>
    <p class="section-heading">Featured posts</p>
    <div class="card-grid">
      <?php foreach ($articles->limit(4) as $i => $article): ?>
        <article class="card">
          <?php if ($i === 0 && $thumb = $article->thumbnail()->toFile()): ?>
            <div class="placeholder-box"><img src="<?= $thumb->url() ?>" alt=""></div>
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
