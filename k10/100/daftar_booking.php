 <!-- Tab Daftar Booking -->
        <div id="daftar" class="tab-content">
            <h2> Daftar Booking Servis</h2>
            
            <?php
            // Proses update status
            if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_status'])) {
                $id_booking = $_POST['id_booking'];
                $status_baru = $_POST['status_baru'];
                
                $sql_update = "UPDATE booking_servis SET status_booking = ? WHERE id_booking = ?";
                $stmt = $conn->prepare($sql_update);
                $stmt->bind_param("si", $status_baru, $id_booking);
                
                if ($stmt->execute()) {
                    echo '<div class="alert alert-success">Status booking berhasil diupdate!</div>';
                }
            }
            
            // Get semua booking dengan join table
            $sql_booking = "SELECT bs.*, p.nama_lengkap, p.no_telepon, k.merk, k.model, k.no_polisi, ls.nama_layanan, ls.harga 
                           FROM booking_servis bs 
                           JOIN pelanggan p ON bs.id_pelanggan = p.id_pelanggan 
                           JOIN kendaraan k ON bs.id_kendaraan = k.id_kendaraan 
                           JOIN layanan_servis ls ON bs.id_layanan = ls.id_layanan 
                           ORDER BY bs.created_at DESC";
            $result_booking = $conn->query($sql_booking);
            ?>
            
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Pelanggan</th>
                        <th>Kendaraan</th>
                        <th>Layanan</th>
                        <th>Tanggal & Jam</th>
                        <th>Status</th>
                        <th>Total Biaya</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($row = $result_booking->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['id_booking']; ?></td>
                        <td>
                            <strong><?php echo $row['nama_lengkap']; ?></strong><br>
                            <small><?php echo $row['no_telepon']; ?></small>
                        </td>
                        <td>
                            <?php echo $row['merk'] . ' ' . $row['model']; ?><br>
                            <small><?php echo $row['no_polisi']; ?></small>
                        </td>
                        <td><?php echo $row['nama_layanan']; ?></td>
                        <td>
                            <?php echo date('d/m/Y', strtotime($row['tanggal_booking'])); ?><br>
                            <small><?php echo date('H:i', strtotime($row['jam_booking'])); ?></small>
                        </td>
                        <td>
                            <span class="status-badge status-<?php echo $row['status_booking']; ?>">
                                <?php echo str_replace('_', ' ', $row['status_booking']); ?>
                            </span>
                        </td>
                        <td>Rp <?php echo number_format($row['total_biaya'], 0, ',', '.'); ?></td>
                        <td>
                            <form method="POST" style="display: inline;">
                                <input type="hidden" name="id_booking" value="<?php echo $row['id_booking']; ?>">
                                <select name="status_baru" onchange="this.form.submit()">
                                    <option value="menunggu_konfirmasi" <?php echo ($row['status_booking'] == 'menunggu_konfirmasi') ? 'selected' : ''; ?>>Menunggu Konfirmasi</option>
                                    <option value="dikonfirmasi" <?php echo ($row['status_booking'] == 'dikonfirmasi') ? 'selected' : ''; ?>>Dikonfirmasi</option>
                                    <option value="sedang_dikerjakan" <?php echo ($row['status_booking'] == 'sedang_dikerjakan') ? 'selected' : ''; ?>>Sedang Dikerjakan</option>
                                    <option value="selesai" <?php echo ($row['status_booking'] == 'selesai') ? 'selected' : ''; ?>>Selesai</option>
                                    <option value="dibatalkan" <?php echo ($row['status_booking'] == 'dibatalkan') ? 'selected' : ''; ?>>Dibatalkan</option>
                                </select>
                                <input type="hidden" name="update_status" value="1">
                            </form>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>