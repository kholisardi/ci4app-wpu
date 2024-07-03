<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>

<div class="container">
    <div class="row">
        <div class="col-4">
            <h2 class="mt-2">Daftar orang</h2>
            <form action="" method="post">
                <div class="input-group mb-3">
                    <input type="text" class="form-control" placeholder="masukan keyword pencarian" name="keyword">
                    <div class="input-group-append">
                        <button class="btn btn-outline-secondary" type="submit" name="submit">Cari</button>
                    </div>
                </div>
            </form>

        </div>
    </div>
    <div class="row">
        <div class="col">

            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">nama</th>
                        <th scope="col">Alamat</th>
                        <th scope="col">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 1 + (10 * ($currentPage - 1)); ?>
                    <?php foreach ($orang as $row) : ?>
                        <tr>
                            <th><?= $i++; ?></th>
                            <td><?= $row['nama']; ?></td>
                            <td><?= $row['alamat']; ?></td>
                            <td>
                                <a href="#" class="btn btn-success"> Detail</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <?= $pager->links('orang', 'orang_pagination') ?>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>