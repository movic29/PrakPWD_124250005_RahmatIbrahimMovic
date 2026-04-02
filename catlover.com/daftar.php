<?php
session_start();
include 'koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = $_POST['nama'];
    $tgl_lahir = $_POST['tgl_lahir'];
    $kelompok_umur = $_POST['kelompok_umur'];
    $jenis_kelamin = $_POST['jenis_kelamin'];
    $hobi = isset($_POST['hobi']) ? implode(", ", $_POST['hobi']) : '';
    $asal = $_POST['asal_daerah'];
    $alasan = $_POST['alasan'];

    $query = "INSERT INTO pendaftaran (nama_lengkap, tanggal_lahir, kelompok_umur, jenis_kelamin, hobi, asal_daerah, alasan) 
              VALUES ('$nama', '$tgl_lahir', '$kelompok_umur', '$jenis_kelamin', '$hobi', '$asal', '$alasan')";
    
    if (mysqli_query($conn, $query)) {
        $_SESSION['status_login'] = true;
        $_SESSION['nama_user'] = $nama;
        
        header("Location: design.php");
        exit;
    } else {
        echo "<script>alert('Gagal mendaftar!');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Daftar</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style> body { background-color: #f9fbe7; } </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand fw-bold" href="index.php">Komunitas Kucing</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
                    <li class="nav-item"><a class="nav-link active" href="daftar.php">Daftar</a></li>
                    <li class="nav-item"><a class="nav-link" href="design.php">Design</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-4 mb-5">
        <h3 class="text-center mb-4">Pendaftaran Komunitas Kucing</h3>
        
        <div class="card p-4 mx-auto shadow-sm border-0" style="max-width: 700px;">
            <form action="" method="POST">
                
                <div class="row mb-3">
                    <label class="col-sm-4 col-form-label">Nama Lengkap</label>
                    <div class="col-sm-8">
                        <input type="text" name="nama" class="form-control" required>
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-sm-4 col-form-label">Tanggal Lahir</label>
                    <div class="col-sm-8">
                        <input type="date" name="tgl_lahir" class="form-control" required>
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-sm-4 col-form-label">Kelompok Umur</label>
                    <div class="col-sm-8">
                        <select name="kelompok_umur" class="form-select" required>
                            <option value="">Pilih kelompok umur</option>
                            <option value="Anak-anak">Anak-anak</option>
                            <option value="Remaja">Remaja</option>
                            <option value="Dewasa">Dewasa</option>
                        </select>
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-sm-4 col-form-label">Jenis Kelamin</label>
                    <div class="col-sm-8">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="jenis_kelamin" value="Laki-laki" required>
                            <label class="form-check-label">Laki-laki</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="jenis_kelamin" value="Perempuan" required>
                            <label class="form-check-label">Perempuan</label>
                        </div>
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-sm-4 col-form-label">Hobi</label>
                    <div class="col-sm-8">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="hobi[]" value="Main Game">
                            <label class="form-check-label">Main Game</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="hobi[]" value="Ngoding">
                            <label class="form-check-label">Ngoding</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="hobi[]" value="Bermain dengan kucing">
                            <label class="form-check-label">Bermain dengan kucing</label>
                        </div>
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-sm-4 col-form-label">Asal Daerah</label>
                    <div class="col-sm-8">
                        <input type="text" name="asal_daerah" class="form-control" required>
                    </div>
                </div>

                <div class="row mb-4">
                    <label class="col-sm-4 col-form-label">Alasan Ingin Bergabung</label>
                    <div class="col-sm-8">
                        <textarea name="alasan" class="form-control" rows="3" required></textarea>
                    </div>
                </div>

                <div class="text-center">
                    <button type="submit" class="btn btn-success px-4">KIRIM PENDAFTARAN</button>
                </div>

            </form>
        </div>
    </div>

</body>
</html>