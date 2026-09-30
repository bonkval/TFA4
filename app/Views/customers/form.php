<?= $this->extend('layout') ?>
<?= $this->section('content') ?>
<?php $editing = $customer !== null; ?>
<section class="page-intro"><div><div class="eyebrow">Customer accounts</div><h1><?= $editing ? 'Edit customer' : 'New customer' ?></h1></div><p>Fields marked with an asterisk are required.</p></section>
<form class="record-form card" action="<?= site_url($editing ? 'customers/' . $customer['id'] : 'customers') ?>" method="post" novalidate>
    <?= csrf_field() ?>
    <div class="field"><label for="full_name">Full name <span aria-hidden="true">*</span></label><input id="full_name" name="full_name" type="text" maxlength="100" required value="<?= esc($values['full_name'], 'attr') ?>" <?= isset($errors['full_name']) ? 'aria-invalid="true" aria-describedby="full_name-error"' : '' ?>><?php if (isset($errors['full_name'])): ?><span class="field-error" id="full_name-error"><?= esc($errors['full_name']) ?></span><?php endif; ?></div>
    <div class="field"><label for="email">Email <span aria-hidden="true">*</span></label><input id="email" name="email" type="email" maxlength="100" required value="<?= esc($values['email'], 'attr') ?>" <?= isset($errors['email']) ? 'aria-invalid="true" aria-describedby="email-error"' : '' ?>><?php if (isset($errors['email'])): ?><span class="field-error" id="email-error"><?= esc($errors['email']) ?></span><?php endif; ?></div>
    <div class="field"><label for="phone">Phone</label><input id="phone" name="phone" type="tel" maxlength="20" value="<?= esc($values['phone'], 'attr') ?>" <?= isset($errors['phone']) ? 'aria-invalid="true" aria-describedby="phone-error"' : '' ?>><?php if (isset($errors['phone'])): ?><span class="field-error" id="phone-error"><?= esc($errors['phone']) ?></span><?php endif; ?></div>
    <div class="form-actions"><button class="button" type="submit"><?= $editing ? 'Save changes' : 'Create customer' ?></button><a class="text-link" href="<?= site_url('customers') ?>">Cancel</a></div>
</form>
<?= $this->endSection() ?>
