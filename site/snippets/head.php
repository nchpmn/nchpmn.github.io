<?php $siteKey = $siteKey ?? null; ?>
<meta charset="utf-8">
<title><?= $page->title()->html() ?><?= $siteKey === 'tidbits' ? ' — Tidbits' : ($siteKey === 'nathan' ? ' — Nathan Chapman' : '') ?></title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="<?= url('assets/css/base.css') ?>">
<link rel="stylesheet" href="<?= url('assets/css/theme-nathan.css') ?>">
<link rel="stylesheet" href="<?= url('assets/css/theme-tidbits.css') ?>">
