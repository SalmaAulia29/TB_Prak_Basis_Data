<!-- Tab Data Pelanggan -->
<div id="pelanggan" class="tab-content">
    <h2>Data Pelanggan</h2>

    <?php
    include 'koneksi.php';

    // Proses hapus pelanggan
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['hapus_pelanggan'])) {
        $id_pelanggan_hapus = $_POST['id_pelanggan_hapus'];
        $stmt = $conn->prepare("DELETE FROM pelanggan WHERE id_pelanggan = ?");
        $stmt->bind_param("i", $id_pelanggan_hapus);
        $stmt->execute();
    }

    // Proses update pelanggan
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['simpan_edit'])) {
        $id = $_POST['edit_id'];
        $nama = $_POST['edit_nama'];
        $telepon = $_POST['edit_telepon'];
        $email = $_POST['edit_email'];
        $alamat = $_POST['edit_alamat'];

        $stmt = $conn->prepare("UPDATE pelanggan SET nama_lengkap=?, no_telepon=?, email=?, alamat=? WHERE id_pelanggan=?");
        $stmt->bind_param("ssssi", $nama, $telepon, $email, $alamat, $id);
        $stmt->execute();
    }

    // Ambil data pelanggan
    $sql_pelanggan = "SELECT p.*, COUNT(bs.id_booking) as total_booking 
                     FROM pelanggan p 
                     LEFT JOIN booking_servis bs ON p.id_pelanggan = bs.id_pelanggan 
                     GROUP BY p.id_pelanggan 
                     ORDER BY p.created_at DESC";
    $result_pelanggan = $conn->query($sql_pelanggan);
    ?>

    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nama Lengkap</th>
                <th>No. Telepon</th>
                <th>Email</th>
                <th>Alamat</th>
                <th>Total Booking</th>
                <th>Terdaftar</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $edit_id = isset($_POST['edit_pelanggan']) ? $_POST['id_pelanggan_edit'] : null;

            while($row = $result_pelanggan->fetch_assoc()): 
            ?>
                <?php if ($edit_id == $row['id_pelanggan']): ?>
                    <!-- Form Edit -->
                    <tr>
                        <form method="POST">
                            <td><?php echo $row['id_pelanggan']; ?><input type="hidden" name="edit_id" value="<?php echo $row['id_pelanggan']; ?>"></td>
                            <td><input type="text" name="edit_nama" value="<?php echo $row['nama_lengkap']; ?>"></td>
                            <td><input type="text" name="edit_telepon" value="<?php echo $row['no_telepon']; ?>"></td>
                            <td><input type="email" name="edit_email" value="<?php echo $row['email']; ?>"></td>
                            <td><input type="text" name="edit_alamat" value="<?php echo $row['alamat']; ?>"></td>
                            <td><?php echo $row['total_booking']; ?></td>
                            <td><?php echo date('d/m/Y', strtotime($row['created_at'])); ?></td>
                            <td>
                                <button type="submit" name="simpan_edit" class="btn btn-success">Simpan</button>
                            </td>
                        </form>
                    </tr>
                <?php else: ?>
                    <!-- Tampilan Biasa -->
                    <tr>
                        <td><?php echo $row['id_pelanggan']; ?></td>
                        <td><?php echo $row['nama_lengkap']; ?></td>
                        <td><?php echo $row['no_telepon']; ?></td>
                        <td><?php echo $row['email']; ?></td>
                        <td><?php echo $row['alamat']; ?></td>
                        <td><?php echo $row['total_booking']; ?></td>
                        <td><?php echo date('d/m/Y', strtotime($row['created_at'])); ?></td>
                        <td>
                            <form method="POST" style="display:inline;">
                                <input type="hidden" name="id_pelanggan_edit" value="<?php echo $row['id_pelanggan']; ?>">
                                <button type="submit" name="edit_pelanggan" class="btn btn-warning"> Edit</button>
                            </form>
                            <form method="POST" style="display:inline;" onsubmit="return confirm('Yakin ingin menghapus pelanggan ini?')">
                                <input type="hidden" name="id_pelanggan_hapus" value="<?php echo $row['id_pelanggan']; ?>">
                                <button type="submit" name="hapus_pelanggan" class="btn btn-danger">Hapus</button>
                            </form>
                        </td>
                    </tr>
                <?php endif; ?>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>
