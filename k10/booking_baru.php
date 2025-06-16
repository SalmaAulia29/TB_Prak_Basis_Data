 <!-- Tab Booking Baru -->
        <div id="booking" class="tab-content active">
            <h2>Booking Servis Baru</h2>
            
            <?php
           
            
            // Proses form booking
            if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit_booking'])) {
                $nama_pelanggan = $_POST['nama_pelanggan'];
                $no_telepon = $_POST['no_telepon'];
                $email = $_POST['email'];
                $alamat = $_POST['alamat'];
                $merk = $_POST['merk'];
                $model = $_POST['model'];
                $tahun = $_POST['tahun'];
                $no_polisi = $_POST['no_polisi'];
                $warna = $_POST['warna'];
                $id_layanan = $_POST['id_layanan'];
                $tanggal_booking = $_POST['tanggal_booking'];
                $jam_booking = $_POST['jam_booking'];
                $catatan = $_POST['catatan'];
                
                // Insert pelanggan
                $sql_pelanggan = "INSERT INTO pelanggan (nama_lengkap, no_telepon, email, alamat) VALUES (?, ?, ?, ?)";
                $stmt = $conn->prepare($sql_pelanggan);
                $stmt->bind_param("ssss", $nama_pelanggan, $no_telepon, $email, $alamat);
                
                if ($stmt->execute()) {
                    $id_pelanggan = $conn->insert_id;
                    
                    // Insert kendaraan
                    $sql_kendaraan = "INSERT INTO kendaraan (id_pelanggan, merk, model, tahun, no_polisi, warna) VALUES (?, ?, ?, ?, ?, ?)";
                    $stmt2 = $conn->prepare($sql_kendaraan);
                    $stmt2->bind_param("ississ", $id_pelanggan, $merk, $model, $tahun, $no_polisi, $warna);
                    
                    if ($stmt2->execute()) {
                        $id_kendaraan = $conn->insert_id;
                        
                        // Get harga layanan
                        $sql_harga = "SELECT harga FROM layanan_servis WHERE id_layanan = ?";
                        $stmt3 = $conn->prepare($sql_harga);
                        $stmt3->bind_param("i", $id_layanan);
                        $stmt3->execute();
                        $result_harga = $stmt3->get_result();
                        $harga = $result_harga->fetch_assoc()['harga'];
                        
                        // Insert booking
                        $sql_booking = "INSERT INTO booking_servis (id_pelanggan, id_kendaraan, id_layanan, tanggal_booking, jam_booking, catatan, total_biaya) VALUES (?, ?, ?, ?, ?, ?, ?)";
                        $stmt4 = $conn->prepare($sql_booking);
                        $stmt4->bind_param("iiisssd", $id_pelanggan, $id_kendaraan, $id_layanan, $tanggal_booking, $jam_booking, $catatan, $harga);
                        
                        if ($stmt4->execute()) {
                            echo '<div class="alert alert-success">Booking berhasil dibuat!</div>';
                        }
                    }
                }
            }
            
            // Get layanan servis untuk dropdown
            $sql_layanan = "SELECT * FROM layanan_servis WHERE status = 'aktif'";
            $result_layanan = $conn->query($sql_layanan);
            ?>
            
            <form method="POST" action="">
                <h3> Data Pelanggan</h3>
                <div class="form-row">
                    <div class="form-group">
                        <label>Nama Lengkap</label>
                        <input type="text" name="nama_pelanggan" required>
                    </div>
                    <div class="form-group">
                        <label>No. Telepon</label>
                        <input type="tel" name="no_telepon" required>
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" name="email">
                    </div>
                    <div class="form-group">
                        <label>Alamat</label>
                        <textarea name="alamat" rows="3"></textarea>
                    </div>
                </div>
                
                <h3> Data Kendaraan</h3>
                <div class="form-row">
                    <div class="form-group">
                        <label>Merk</label>
                        <input type="text" name="merk" required>
                    </div>
                    <div class="form-group">
                        <label>Model</label>
                        <input type="text" name="model" required>
                    </div>
                    <div class="form-group">
                        <label>Tahun</label>
                        <input type="number" name="tahun" min="1980" max="2025" required>
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label>No. Polisi</label>
                        <input type="text" name="no_polisi" required>
                    </div>
                    <div class="form-group">
                        <label>Warna</label>
                        <input type="text" name="warna">
                    </div>
                </div>
                
                <h3> Data Booking</h3>
                <div class="form-row">
                    <div class="form-group">
                        <label>Layanan Servis</label>
                        <select name="id_layanan" required>
                            <option value="">Pilih Layanan</option>
                            <?php while($row = $result_layanan->fetch_assoc()): ?>
                                <option value="<?php echo $row['id_layanan']; ?>">
                                    <?php echo $row['nama_layanan'] . ' - Rp ' . number_format($row['harga'], 0, ',', '.'); ?>
                                </option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label>Tanggal Booking</label>
                        <input type="date" name="tanggal_booking" required>
                    </div>
                    <div class="form-group">
                        <label>Jam Booking</label>
                        <input type="time" name="jam_booking" required>
                    </div>
                </div>
                
                <div class="form-group">
                    <label>Catatan</label>
                    <textarea name="catatan" rows="3" placeholder="Catatan tambahan untuk servis..."></textarea>
                </div>
                
                <button type="submit" name="submit_booking" class="btn">Buat Booking</button>
            </form>
        </div>