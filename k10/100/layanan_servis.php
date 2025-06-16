<!-- Tab Layanan Servis -->
        <div id="layanan" class="tab-content">
            <h2> Layanan Servis</h2>
            
            <?php
            $sql_layanan_all = "SELECT * FROM layanan_servis ORDER BY nama_layanan";
            $result_layanan_all = $conn->query($sql_layanan_all);
            ?>
            
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nama Layanan</th>
                        <th>Deskripsi</th>
                        <th>Harga</th>
                        <th>Estimasi Waktu</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($row = $result_layanan_all->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['id_layanan']; ?></td>
                        <td><?php echo $row['nama_layanan']; ?></td>
                        <td><?php echo $row['deskripsi']; ?></td>
                        <td>Rp <?php echo number_format($row['harga'], 0, ',', '.'); ?></td>
                        <td><?php echo $row['estimasi_waktu']; ?> menit</td>
                        <td>
                            <span class="status-badge status-<?php echo $row['status']; ?>">
                                <?php echo $row['status']; ?>
                            </span>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>