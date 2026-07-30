<?php include 'proses/koneksi.php'; ?>
<div class="container-fluid">
    <h4><b>Master > Data Rak</b></h4>
    <a href="index.php?page=tambahrak" class="btn btn-primary mb-3">+ Tambah Rak</a>
    <div class="table-responsive">
        <table class="table search-table align-middle text-nowrap">
            <thead class="table-info">
                <tr>
                    <th>No</th>
                    <th>Nama Rak</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $no = 1;
                $data = $koneksi->query("SELECT * FROM rak");
                while($row = $data->fetch_assoc()):
                ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= $row['nama_rak'] ?></td>
                    <td>
                        <a href="index.php?page=tambahrak&id=<?= $row['id'] ?>" class="btn btn-warning btn-sm">Edit</a>
                        <a href="proses/rak/hapus.php?id=<?= $row['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin hapus?')">Hapus</a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>
<br><br><br><br><br><br><br>