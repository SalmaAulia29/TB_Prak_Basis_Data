<!-- Tab Data Pelanggan -->
        <div id="pelanggan" class="tab-content">
            <h2> Data Pelanggan</h2>
            
            <?php
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
                    </tr>
                </thead>
                <tbody>
                    <?php while($row = $result_pelanggan->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['id_pelanggan']; ?></td>
                        <td><?php echo $row['nama_lengkap']; ?></td>
                        <td><?php echo $row['no_telepon']; ?></td>
                        <td><?php echo $row['email']; ?></td>
                        <td><?php echo $row['alamat']; ?></td>
                        <td><?php echo $row['total_booking']; ?></td>
                        <td><?php echo date('d/m/Y', strtotime($row['created_at'])); ?></td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>