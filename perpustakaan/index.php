<?php
session_start();
require_once 'koneksi.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$page = $_GET['page'] ?? 'buku';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Pustaka Digital</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <div class="topbar">
        <div style="display:flex; align-items:center; gap:20px;">
            <span class="topbar-brand">Pustaka Digital</span>
            <div class="topbar-nav">
                <a href="?page=buku" class="<?= $page == 'buku' ? 'active' : '' ?>">Koleksi Buku</a>
                <a href="?page=pinjam" class="<?= $page == 'pinjam' ? 'active' : '' ?>">Peminjaman</a>
            </div>
        </div>
        <div class="topbar-right">
            <a href="logout.php"> Keluar</a>
        </div>
    </div>

    <div class="container">
        <?php
        if ($page == 'buku') {
            include 'buku.php';
        } elseif ($page == 'pinjam') {
            include 'pinjam.php';
        }
        ?>
    </div>

    <script>
        function confirmHapus(id) {
            if (confirm('Apakah anda yakin mau hapus buku ini?')) {
                window.location.href = '?page=buku&hapus=' + id;
            }
        }
        function confirmKembali(id) {
            if (confirm('Konfirmasi pengembalian buku?')) {
                window.location.href = '?page=pinjam&kembali=' + id;
            }
        }// buka tutup
        function openModal(modalId) {
            document.getElementById(modalId).style.display = 'block';
        }
        function closeModal(modalId) {
            document.getElementById(modalId).style.display = 'none';
        }
        // Tutup kalau user klik diluar pop up
        window.onclick = function(e) {
            document.querySelectorAll('.modal').forEach(function(m) {
                if (e.target === m) m.style.display = 'none';
            });
        }
    </script>
</body>
</html>