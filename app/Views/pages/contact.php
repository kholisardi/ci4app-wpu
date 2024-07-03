<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>

<div class="container">
    <div class="row">
        <div class="col">
            <h2>contact</h2>
            <?php foreach ($alamat as $row) : ?>

                <ul>
                    <li><?= $row['tipe']; ?></li>
                    <li><?= $row['alamat']; ?></li>
                    <li><?= $row['kota']; ?></li>
                </ul>

            <?php endforeach; ?>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>