<?= $this->extend('layout') ?>
<?= $this->section('content') ?>
<section class="page-intro"><div><div class="eyebrow">Customer records</div><h1><?= esc($heading) ?></h1></div><p>Create and maintain customer accounts.</p><a class="button" href="<?= site_url('customers/new') ?>">New customer</a></section>
<?php if (session('success')): ?><div class="notice" role="status"><?= esc(session('success')) ?></div><?php endif; ?>
<div class="table-wrap">
    <table>
        <thead><tr><th>Full name</th><th>Email</th><th>Phone</th><th>Action</th></tr></thead>
        <tbody>
        <?php foreach ($customers as $customer): ?>
            <tr><td><?= esc($customer['full_name']) ?></td><td><?= esc($customer['email']) ?></td><td><?= esc($customer['phone']) ?></td><td><a class="text-link" href="<?= site_url('customers/' . $customer['id'] . '/edit') ?>">Edit</a></td></tr>
        <?php endforeach; ?>
        <?php if ($customers === []): ?>
            <tr><td colspan="4">No customer records found.</td></tr>
        <?php endif; ?>
        </tbody>
    </table>
</div>
<?= $this->endSection() ?>
