<?php
// Expects $siteKey ('nathan'|'tidbits') and $siteHome (that site's home page) to be passed in.
$isNathan   = $siteKey === 'nathan';
$otherHome  = $isNathan ? $site->page('tidbits') : $site->page('nathan');
$swapLabel  = $isNathan ? 'View Tidbits' : 'View Nathan';
$aboutPage  = $siteHome->find('about');
$listPage   = $isNathan ? $siteHome->find('blog') : $siteHome->find('projects');
$listLabel  = $isNathan ? 'Blog' : 'Portfolio';
$contactPage = $siteHome->find('contact');
?>
<nav id="sitenav">
  <a class="swap-link" href="<?= $otherHome->url() ?>"><?= $swapLabel ?></a>
  <ul class="nav-menu">
    <li><a href="<?= $aboutPage->url() ?>">About</a></li>
    <li><a href="<?= $listPage->url() ?>"><?= $listLabel ?></a></li>
    <li><a href="<?= $contactPage->url() ?>">Contact</a></li>
  </ul>
</nav>
