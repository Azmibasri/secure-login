<?php
// create_table.php
$servername = "localhost";
$username = "root";
$password = ""; // ganti jika ada password MySQL
$dbname = "db_auth";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Buat tabel users jika belum ada
$sql_users = "CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(100) NOT NULL UNIQUE,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_email (email),
    INDEX idx_username (username)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";

if ($conn->query($sql_users) === TRUE) {
    echo "✅ Tabel users berhasil dibuat/diperiksa!<br>";
    
    // Cek apakah kolom username sudah ada, jika belum tambahkan
    $check_column = $conn->query("SHOW COLUMNS FROM users LIKE 'username'");
    if ($check_column->num_rows == 0) {
        // Cek apakah ada data di tabel
        $check_data = $conn->query("SELECT COUNT(*) as count FROM users");
        $data_count = $check_data->fetch_assoc()['count'];
        
        if ($data_count > 0) {
            // Jika ada data, tambahkan kolom sebagai nullable dulu
            $alter_sql = "ALTER TABLE users ADD COLUMN username VARCHAR(100) NULL AFTER id";
            if ($conn->query($alter_sql) === TRUE) {
                // Update username dari email untuk data yang sudah ada
                $update_sql = "UPDATE users SET username = SUBSTRING_INDEX(email, '@', 1) WHERE username IS NULL";
                $conn->query($update_sql);
                
                // Sekarang buat kolom NOT NULL dan UNIQUE
                $alter_sql2 = "ALTER TABLE users MODIFY COLUMN username VARCHAR(100) NOT NULL UNIQUE";
                if ($conn->query($alter_sql2) === TRUE) {
                    echo "✅ Kolom username berhasil ditambahkan dan diisi untuk data yang sudah ada!<br>";
                } else {
                    echo "⚠️ Kolom username ditambahkan tetapi gagal membuat UNIQUE: " . $conn->error . "<br>";
                }
            } else {
                echo "⚠️ Peringatan: Gagal menambahkan kolom username: " . $conn->error . "<br>";
            }
        } else {
            // Jika tidak ada data, langsung tambahkan sebagai NOT NULL UNIQUE
            $alter_sql = "ALTER TABLE users ADD COLUMN username VARCHAR(100) NOT NULL UNIQUE AFTER id";
            if ($conn->query($alter_sql) === TRUE) {
                echo "✅ Kolom username berhasil ditambahkan ke tabel users!<br>";
            } else {
                echo "⚠️ Peringatan: Gagal menambahkan kolom username: " . $conn->error . "<br>";
            }
        }
    }
    
    echo "Struktur tabel users:<br>";
    echo "- id (INT, AUTO_INCREMENT, PRIMARY KEY)<br>";
    echo "- username (VARCHAR 100, UNIQUE)<br>";
    echo "- email (VARCHAR 255, UNIQUE)<br>";
    echo "- password (VARCHAR 255)<br>";
    echo "- created_at (DATETIME)<br><br>";
} else {
    echo "❌ Error membuat tabel users: " . $conn->error . "<br><br>";
}

// Hapus tabel lama jika ada (hati-hati, data akan hilang!)
$conn->query("DROP TABLE IF EXISTS login_attempts");

// Buat tabel login_attempts
$sql_attempts = "CREATE TABLE login_attempts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(255) NOT NULL,
    ip_address VARCHAR(45) NOT NULL,
    attempt_time DATETIME DEFAULT CURRENT_TIMESTAMP,
    success TINYINT(1) DEFAULT 0,
    INDEX idx_email (email),
    INDEX idx_ip (ip_address),
    INDEX idx_time (attempt_time)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";

if ($conn->query($sql_attempts) === TRUE) {
    echo "✅ Tabel login_attempts berhasil dibuat!<br>";
    echo "Struktur tabel login_attempts:<br>";
    echo "- id (INT, AUTO_INCREMENT)<br>";
    echo "- email (VARCHAR 255)<br>";
    echo "- ip_address (VARCHAR 45)<br>";
    echo "- attempt_time (DATETIME)<br>";
    echo "- success (TINYINT)<br><br>";
    echo "✅ Semua tabel siap digunakan!";
} else {
    echo "❌ Error membuat tabel login_attempts: " . $conn->error;
}

$conn->close();
?>