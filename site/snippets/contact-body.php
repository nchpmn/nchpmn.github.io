<main id="content">
  <section>
    <p class="section-heading">Contact</p>
    <h1><?= $page->headline()->html() ?></h1>
    <?php if ($page->intro()->isNotEmpty()): ?>
      <p><?= $page->intro()->html() ?></p>
    <?php endif ?>
    <form class="contact-form">
      <input type="text" placeholder="Name">
      <input type="email" placeholder="Email">
      <textarea rows="5" placeholder="Message"></textarea>
      <button type="submit">Send</button>
    </form>
  </section>
</main>
