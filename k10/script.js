function showTab(tabName) {
            // Menyembunyikan semua konten tab
            const tabContents = document.querySelectorAll('.tab-content');
            tabContents.forEach(tab => tab.classList.remove('active'));
            
            // Menghapus kelas aktif dari semua tab
            const tabs = document.querySelectorAll('.nav-tab');
            tabs.forEach(tab => tab.classList.remove('active'));
            
            // Menampilkan konten tab yang dipilih
            document.getElementById(tabName).classList.add('active');
            
            // Menambahkan kelas aktif ke tab yang diklik
            event.target.classList.add('active');
        }
        
        // Tetapkan tanggal minimum ke hari ini
        const today = new Date().toISOString().split('T')[0];
        const dateInput = document.querySelector('input[type="date"]');
        if (dateInput) {
            dateInput.setAttribute('min', today);
        }