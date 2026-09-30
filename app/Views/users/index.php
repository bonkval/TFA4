<?= $this->extend('layout') ?>
<?= $this->section('content') ?>
<section class="page-intro"><div><div class="eyebrow">User records</div><h1><?= esc($heading) ?></h1></div><p>Create user accounts and manage profile pictures.</p><a class="button" href="<?= site_url('users/new') ?>">New user</a></section>
<?php if (session('success')): ?><div class="notice" role="status"><?= esc(session('success')) ?></div><?php endif; ?>
<div class="table-wrap">
    <table>
        <thead><tr><th>Avatar</th><th>Username</th><th>Full name</th><th>Created at</th><th>Action</th></tr></thead>
        <tbody>
        <?php foreach ($users as $user): ?>
            <tr><td><img class="avatar" src="<?= base_url(! empty($user['avatar']) ? 'uploads/avatars/' . rawurlencode($user['avatar']) : 'images/avatar-placeholder.svg') ?>" alt="" width="48" height="48"></td><td><?= esc($user['username']) ?></td><td><?= esc($user['full_name']) ?></td><td><?= esc($user['created_at']) ?></td><td><a class="text-link" href="<?= site_url('users/' . $user['id'] . '/edit') ?>">Edit</a></td></tr>
        <?php endforeach; ?>
        <?php if ($users === []): ?>
            <tr><td colspan="5">No user records found.</td></tr>
        <?php endif; ?>
        </tbody>
    </table>
</div>
<?= $this->endSection() ?>
