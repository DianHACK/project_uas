<?php include 'proses/koneksi.php'; ?>
<div class="container-fluid" style="margin-bottom: 25vh">
    <h4><b>Kategori > Data Kategori</b></h4>
    <a href="index.php?page=tambahkategori" class="btn btn-primary mb-3">+ Tambah Kategori</a>
    <div class="table-responsive">
        <table class="table search-table align-middle text-nowrap">
            <thead class="table-info">
                <tr>
                    <th>No</th>
                    <th>Nama Kategori</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $no = 1;
                $data = $koneksi->query("SELECT * FROM kategori");
                while($row = $data->fetch_assoc()):
                ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= $row['nama_kategori'] ?></td>
                    <td>
                        <a href="index.php?page=tambahkategori&id=<?= $row['id'] ?>" class="btn btn-warning btn-sm">Edit</a>
                        <a href="proses/kategori/hapus.php?id=<?= $row['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin hapus?')">Hapus</a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>
