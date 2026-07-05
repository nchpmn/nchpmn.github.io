<main id="content">
  <section>
    <p class="section-heading">About</p>
    <h1><?= $page->headline()->or($page->title())->html() ?></h1>
    <p><?= $page->summary()->html() ?></p>
  </section>

  <?php if ($photo = $page->featured_photo()->toFile()): ?>
    <section>
      <div class="placeholder-box"><img src="<?= $photo->url() ?>" alt=""></div>
    </section>
  <?php endif ?>

  <section>
    <?= $page->main_content()->toBlocks() ?>
  </section>
</main>
