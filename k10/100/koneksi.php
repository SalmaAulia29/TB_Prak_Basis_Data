<?php
            // Koneksi database
            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "10";
            
            $conn = new mysqli($servername, $username, $password, $dbname);
            
            if ($conn->connect_error) {
                die("Koneksi gagal: " . $conn->connect_error);
            }