<!-- Tab Layanan Servis -->
<div id="layanan" class="tab-content">
    <h2>Layanan Servis</h2>

    <?php
    include 'koneksi.php';

    // Tambah layanan
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['tambah_layanan'])) {
        $nama = $_POST['nama_layanan'];
        $deskripsi = $_POST['deskripsi'];
        $harga = $_POST['harga'];
        $estimasi = $_POST['estimasi_waktu'];

        $stmt = $conn->prepare("INSERT INTO layanan_servis (nama_layanan, deskripsi, harga, estimasi_waktu) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssii", $nama, $deskripsi, $harga, $estimasi);
        $stmt->execute();
    }

    // Hapus layanan
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['hapus_layanan'])) {
        $id_hapus = $_POST['id_layanan'];
        $conn->query("DELETE FROM layanan_servis WHERE id_layanan = $id_hapus");
    }

    // Edit layanan
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['simpan_edit_layanan'])) {
        $id = $_POST['id_layanan'];
        $nama = $_POST['nama_layanan'];
        $deskripsi = $_POST['deskripsi'];
        $harga = $_POST['harga'];
        $estimasi = $_POST['estimasi_waktu'];

        $stmt = $conn->prepare("UPDATE layanan_servis SET nama_layanan=?, deskripsi=?, harga=?, estimasi_waktu=? WHERE id_layanan=?");
        $stmt->bind_param("ssiii", $nama, $deskripsi, $harga, $estimasi, $id);
        $stmt->execute();
    }

    $sql_layanan_all = "SELECT * FROM layanan_servis ORDER BY id_layanan";
    $result_layanan_all = $conn->query($sql_layanan_all);

    $edit_id = isset($_POST['edit_layanan']) ? $_POST['id_layanan'] : null;
    ?>

    <!-- Form Tambah Layanan -->
    <h3>Tambah Layanan Baru</h3>
    <form method="POST">
        <input type="text" name="nama_layanan" placeholder="Nama Layanan" required>
        <input type="text" name="deskripsi" placeholder="Deskripsi" required>
        <input type="number" name="harga" placeholder="Harga" required>
        <input type="number" name="estimasi_waktu" placeholder="Estimasi Waktu (menit)" required>
        <button type="submit" name="tambah_layanan" class="btn btn-primary">Tambah</button>
    </form>
    <br>

    <!-- Tabel Daftar Layanan -->
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nama Layanan</th>
                <th>Deskripsi</th>
                <th>Harga</th>
                <th>Estimasi Waktu</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result_layanan_all->fetch_assoc()): ?>
                <?php if ($edit_id == $row['id_layanan']): ?>
                    <!-- Form Edit -->
                    <tr>
                        <form method="POST">
                            <td><?php echo $row['id_layanan']; ?>
                                <input type="hidden" name="id_layanan" value="<?php echo $row['id_layanan']; ?>">
                            </td>
                            <td><input type="text" name="nama_layanan" value="<?php echo $row['nama_layanan']; ?>"></td>
                            <td><input type="text" name="deskripsi" value="<?php echo $row['deskripsi']; ?>"></td>
                            <td><input type="number" name="harga" value="<?php echo $row['harga']; ?>"></td>
                            <td><input type="number" name="estimasi_waktu" value="<?php echo $row['estimasi_waktu']; ?>"></td>
                            <td>
                                <button type="submit" name="simpan_edit_layanan" class="btn btn-success">Simpan</button>
                            </td>
                        </form>
                    </tr>
                <?php else: ?>
                    <tr>
                        <td><?php echo $row['id_layanan']; ?></td>
                        <td><?php echo $row['nama_layanan']; ?></td>
                        <td><?php echo $row['deskripsi']; ?></td>
                        <td>Rp <?php echo number_format($row['harga'], 0, ',', '.'); ?></td>
                        <td><?php echo $row['estimasi_waktu']; ?> menit</td>
                        <td>
                            <!-- Edit -->
                            <form method="POST" style="display:inline;">
                                <input type="hidden" name="id_layanan" value="<?php echo $row['id_layanan']; ?>">
                                <button type="submit" name="edit_layanan" class="btn btn-warning">Edit</button>
                            </form>
                            <!-- Hapus -->
                            <form method="POST" style="display:inline;" onsubmit="return confirm('Yakin ingin menghapus layanan ini?')">
                                <input type="hidden" name="id_layanan" value="<?php echo $row['id_layanan']; ?>">
                                <button type="submit" name="hapus_layanan" class="btn btn-danger">Hapus</button>
                            </form>
                        </td>
                    </tr>
                <?php endif; ?>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>
