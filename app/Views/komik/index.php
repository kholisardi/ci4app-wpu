<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>

<div class="container">
    <div class="row">
        <div class="col">
            <a href="/komik/create" class="btn btn-primary mt-3"> Tambah Data Komik</a>
            <h2 class="mt-2">Daftar Komik</h2>
            <?php if (session()->getFlashdata('message')) : ?>
                <div class="alert alert-success" role="alert">
                    <?= session()->getFlashdata('message'); ?>
                </div>


            <?php endif; ?>
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Sampul</th>
                        <th scope="col">Judul</th>
                        <th scope="col">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 1; ?>
                    <?php foreach ($komik as $row) : ?>
                        <tr>
                            <th><?= $i++; ?></th>
                            <td><img src="/img/<?= $row['sampul']; ?>" alt="" class="sampul"></td>
                            <td><?= $row['judul']; ?></td>
                            <td>
                                <a href="/komik/<?= $row['slug']; ?>" class="btn btn-success"> Detail</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

        </div>
    </div>
</div>

<?= $this->endSection(); ?>