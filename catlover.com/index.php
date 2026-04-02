<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f9fbe7; } /* Warna background kekuningan/hijau muda */
        .cat-img { border-radius: 10px; border: 3px solid #ffc107; width: 100%; }
    </style>
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
                    <li class="nav-item"><a class="nav-link active" href="index.php">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="daftar.php">Daftar</a></li>
                    <li class="nav-item"><a class="nav-link" href="design.php">Design</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <h2 class="mb-4 fst-italic">Selamat Datang di Komunitas Kucing</h2>
        
        <div class="row">
            <div class="col-md-5 mb-3">
                <img src="rawr.webp" alt="Gambar Kucing" class="cat-img mb-3">
                <a href="daftar.php" class="btn btn-primary">Informasi Lebih Lanjut</a>
            </div>
            
            <div class="col-md-7 text-danger" style="font-size: 0.95rem;">
                <p>Kucing adalah hewan mamalia kecil yang dikenal dengan sifatnya yang lincah, anggun dan penuh rasa ingin tahu. Tubuhnya lentur dengan bulu lembut yang beragam warna serta mata tajam yang mampu melihat jelas di kondisi minim cahaya.Kucing termasuk hewan karnivora, namun dapat beradaptasi hidup bersama manusia sebagai hewan peliharaan.Mereka memiliki kebiasaan mencakar untuk menandai wilayah, merawat diri dengan menjilat bulunya, serta tidur dalam waktu lama, bisa mencapai 12-16 jam per hari.Kucing sering dianggap membawa kenyamanan dan kasih sayang, sehingga menjadi salah satu hewan peliharaan paling populer di dunia.</p>
                

                <p class="text-primary">Kucing seperti anjing termasuk hewan yang penyayang.Riset yang dilakukan scientificamerican mengungkapkan kucing mempelajari sendiri cara mengeluarkan bunyi meow yang bisa menarik perhatian manusia. Berikut Macam-Macam Kucing :</p>

                <h6 class="text-dark">Jenis-Jenis Kucing:</h6>
                <ol style="color: purple;">
                    <li>Kucing Garong</li>
                    <li>Kucing Kampung</li>
                    <li>Kucing Anggora</li>
                    <li>Kucing Persia</li>
                    <li>dll</li>
                </ol>
            </div>
        </div>
    </div>

</body>
</html>