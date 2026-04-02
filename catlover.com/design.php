<?php
session_start();

if (!isset($_SESSION['status_login']) || $_SESSION['status_login'] !== true) {
    echo "<script>
            alert('Anda harus melakukan pendaftaran terlebih dahulu untuk mengakses halaman ini!');
            window.location.href = 'daftar.php';
          </script>";
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Design</title>
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
                    <li class="nav-item"><a class="nav-link" href="daftar.php">Daftar</a></li>
                    <li class="nav-item"><a class="nav-link active" href="design.php">Design</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-5 text-center">
        <h1 class="fst-italic mb-3">Design Laboratory</h1>
        <p>Image Effects</p>
        
        <img src="lucu.jpg" alt="Kucing di Rumput" class="img-fluid rounded mt-2 shadow" style="max-width: 500px;">
        
    </div>

</body>
</html>