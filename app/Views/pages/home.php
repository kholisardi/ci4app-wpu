<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<div class="container">
    <div class="row">
        <div class="col">
            <h1>Hello, Home!</h1>
            <?= $title; ?>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>