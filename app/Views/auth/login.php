<?= $this->extend('layout') ?>
<?= $this->section('content') ?>
<section class="page-intro"><div><div class="eyebrow">Staff access</div><h1>Log in</h1></div><p>Sign in with your staff username and password to manage customer and user accounts.</p></section>
<?php if ($error !== null): ?><div class="notice" role="alert"><?= esc($error) ?></div><?php endif; ?>
<?php if ($message = session()->getFlashdata('logout_message')): ?><div class="notice" role="status"><?= esc($message) ?></div><?php endif; ?>
<form class="record-form card" action="<?= site_url('login') ?>" method="post">
    <?= csrf_field() ?>
    <div class="field"><label for="username">Username</label><input id="username" name="username" type="text" maxlength="50" autocomplete="username" required value="<?= esc(old('username', ''), 'attr') ?>"></div>
    <div class="field"><label for="password">Password</label><input id="password" name="password" type="password" autocomplete="current-password" required></div>
    <div class="form-actions"><button class="button" type="submit">Log in</button></div>
</form>
<?= $this->endSection() ?>
