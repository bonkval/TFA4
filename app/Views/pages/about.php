<?= $this->extend('layout') ?>
<?= $this->section('content') ?>
<section class="page-intro"><div><div class="eyebrow">About the project</div><h1><?= esc($heading) ?></h1></div><p>This activity extends the TFA2 POS application with forms that validate input and let you create and edit customer and user accounts.</p></section>
<section class="card about-panel"><p>Controllers handle validation and uploads, models manage MySQL records, and views display forms and lists. User avatars are prepared as square thumbnails and served from the public uploads folder.</p></section>
<?= $this->endSection() ?>
