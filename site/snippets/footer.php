<footer id="sitefooter">
  <?php if ($site->footer_text()->isNotEmpty()): ?>
    <p><?= $site->footer_text()->html() ?></p>
  <?php endif ?>
  <?php if ($site->copyright_text()->isNotEmpty()): ?>
    <p><?= $site->copyright_text()->html() ?></p>
  <?php endif ?>
  <?php $links = $site->footer_links()->toStructure(); ?>
  <?php if ($links->count()): ?>
    <ul class="footer-links">
      <?php foreach ($links as $link): ?>
        <li><a href="<?= $link->url() ?>"><?= $link->label()->html() ?></a></li>
      <?php endforeach ?>
    </ul>
  <?php endif ?>
</footer>
