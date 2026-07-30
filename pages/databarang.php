<div class="container-fluid" style="margin-bottom: 80vh">
    <h4><b>Barang > Data Barang</b></h4>
    <a href="index.php?page=tambahbarang" class="btn btn-primary mb-3">+ Tambah Barang</a>
    <div class="table-responsive">
        <table class="table search-table align-middle text-nowrap">
            <thead class="table-info">
                <tr>
                    <th>No</th>
                    <th>Nama Barang</th>
                    <th>Rak</th>
                    <th>Kategori</th>
                    <th>Harga</th>
                    <th>Stok</th>
                    <th>Expired</th>
                    <th>Gambar</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody class="text-center">
                <?php
                include 'proses/koneksi.php';

                // Query dengan JOIN supaya bisa ambil nama rak dan kategori
                $query = $koneksi->query("
                    SELECT b.*, r.nama_rak, k.nama_kategori
                    FROM barang b
                    LEFT JOIN rak r ON b.id_rak = r.id
                    LEFT JOIN kategori k ON b.id_kategori = k.id
                ");

                $no = 1;
                while($row = $query->fetch_assoc()):
                ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= $row['nama_barang']; ?></td>
                    <td><?= $row['nama_rak']; ?></td>
                    <td><?= $row['nama_kategori']; ?></td>
                    <td>Rp <?= number_format($row['harga'], 0, ',', '.') ?></td>
                    <td><?= $row['stok']; ?></td>
                    <td><?= $row['expired_date']; ?></td>
                    <td>
                        <?php if (!empty($row['gambar'])): ?>
                            <img src="proses/gambar/<?= $row['gambar']; ?>" width="70">
                        <?php else: ?>
                            <span class="text-muted">-</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <div class="btn-group btn-group-sm" role="group">
                            <a href="index.php?page=tambahbarang&id=<?= $row['id']; ?>" class="btn btn-primary">Edit</a>
                            <a href="proses/barang/delete.php?id=<?= $row['id']; ?>" class="btn btn-danger" onclick="return confirm('Yakin ingin menghapus?')">Hapus</a>
                        </div>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>
