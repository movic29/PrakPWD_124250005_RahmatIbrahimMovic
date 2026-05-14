<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['aksi'])) {
    if ($_POST['aksi'] === 'tambah') {
        $kode      = trim($_POST['kode_buku']);
        $judul     = trim($_POST['judul_buku']);
        $pengarang = trim($_POST['pengarang']);
        $kategori  = $_POST['kategori'];
        $stok      = (int)$_POST['stok'];
        
        try {
            // Masukin data baru ke DB
            $pdo->prepare("INSERT INTO buku (kode_buku, judul, pengarang, kategori, stok) VALUES (?,?,?,?,?)")
                ->execute([$kode, $judul, $pengarang, $kategori, $stok]);
            header('Location: ?page=buku&success=tambah'); exit;
        } catch (PDOException $e) {
            // Ngasih tau user eror kalau data udah di pake
            if ($e->getCode() == 23000) {
                header('Location: ?page=buku&error=duplikat'); exit;
            } else {
                header('Location: ?page=buku&error=sistem'); exit;
            }
        }
    }
    
    if ($_POST['aksi'] == 'edit') {
        $id        = $_POST['id_buku'];
        $kode      = $_POST['kode_buku'];
        $judul     = $_POST['judul_buku'];
        $pengarang = $_POST['pengarang'];
        $kategori  = $_POST['kategori'];
        $stok      = $_POST['stok'];
        
        try {
            // ngedit data buku yang udah ada
            $pdo->prepare("UPDATE buku SET kode_buku=?, judul=?, pengarang=?, kategori=?, stok=? WHERE id_buku=?")
                ->execute([$kode, $judul, $pengarang, $kategori, $stok, $id]);
            header('Location: ?page=buku&success=edit'); exit;
        } catch (PDOException $e) {
            // Buar erorr kalau kode buku sudah dipakai
            if ($e->getCode() == 23000) {
                header('Location: ?page=buku&error=duplikat'); exit;
            } else {
                header('Location: ?page=buku&error=sistem'); exit;
            }
        }
    }
}

if (isset($_GET['hapus'])) {
    $pdo->prepare("DELETE FROM buku WHERE id_buku = ?")->execute([(int)$_GET['hapus']]);
    header('Location: ?page=buku&success=hapus'); exit;
}

$bukuList = $pdo->query("SELECT * FROM buku ORDER BY id_buku ASC")->fetchAll();
?>

<?php if (isset($_GET['success'])): ?>
<div class="alert alert-success">
    <?php
    if ($_GET['success']==='tambah') echo 'Buku berhasil ditambahkan!';
    elseif ($_GET['success']==='edit') echo 'Buku berhasil diperbarui!';
    else echo 'Buku berhasil dihapus!';
    ?>
</div>
<?php endif; ?>

<?php if (isset($_GET['error'])): ?>
<div class="alert" style="background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; padding: 12px; margin-bottom: 15px; border-radius: 4px;">
    <strong>Gagal!</strong> 
    <?php
    if ($_GET['error']==='duplikat') echo 'Kode Buku tersebut sudah terdaftar. Silakan gunakan Kode Buku yang berbeda.';
    else echo 'Terjadi kesalahan pada sistem database.';
    ?>
</div>
<?php endif; ?>

<h2 class="page-title">Koleksi Buku</h2>

<div class="action-bar">
    <button class="btn-tambah" onclick="openModal('modalTambah')">+ Tambah Koleksi</button>
</div>

<div class="card">
    <div class="card-body">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Kode Buku</th>
                    <th>Judul</th>
                    <th>Pengarang</th>
                    <th>Kategori</th>
                    <th>Stok</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($bukuList as $b):
                $s = $b['stok'];
                if ($s == 0)     { $sc = 'status-habis';   $sl = 'Habis'; }
                elseif ($s <= 7) { $sc = 'status-menipis'; $sl = 'Menipis'; }
                else             { $sc = 'status-tersedia'; $sl = 'Tersedia'; }
            ?>
                <tr>
                    <td><b><?= $b['id_buku'] ?></b></td>
                    <td><?= htmlspecialchars($b['kode_buku']) ?></td>
                    <td><?= htmlspecialchars($b['judul']) ?></td>
                    <td><?= htmlspecialchars($b['pengarang']) ?></td>
                    <td><?= htmlspecialchars($b['kategori']) ?></td>
                    <td><?= $s ?></td>
                    <td><span class="<?= $sc ?>"><?= $sl ?></span></td>
                    <td>
                        <button class="btn btn-edit" onclick="openModal('modalEdit<?= $b['id_buku'] ?>')">Edit</button>
                        <button class="btn btn-hapus" onclick="confirmHapus(<?= $b['id_buku'] ?>)">hapus</button>
                    </td>
                </tr>

                <div id="modalEdit<?= $b['id_buku'] ?>" class="modal">
                    <div class="modal-content">
                        <div class="modal-header">
                            Form Edit Buku
                            <span class="close" onclick="closeModal('modalEdit<?= $b['id_buku'] ?>')">&times;</span>
                        </div>
                        <form method="POST" action="?page=buku">
                            <input type="hidden" name="aksi" value="edit">
                            <input type="hidden" name="id_buku" value="<?= $b['id_buku'] ?>">
                            <div class="modal-body">
                                <div class="form-group">
                                    <label>ID Buku</label>
                                    <input type="text" class="form-control" value="<?= $b['id_buku'] ?>" readonly>
                                </div>
                                <div style="display:flex;gap:12px;">
                                    <div class="form-group" style="flex:1">
                                        <label>Kode Buku</label>
                                        <input type="text" name="kode_buku" class="form-control" value="<?= htmlspecialchars($b['kode_buku']) ?>" required>
                                    </div>
                                    <div class="form-group" style="flex:1">
                                        <label>Jumlah Stok</label>
                                        <input type="number" name="stok" class="form-control" value="<?= $b['stok'] ?>" min="0" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Judul Buku</label>
                                    <input type="text" name="judul_buku" class="form-control" value="<?= htmlspecialchars($b['judul']) ?>" required>
                                </div>
                                <div class="form-group">
                                    <label>Pengarang</label>
                                    <input type="text" name="pengarang" class="form-control" value="<?= htmlspecialchars($b['pengarang']) ?>" required>
                                </div>
                                <div class="form-group">
                                    <label>Kategori</label>
                                    <input type="text" name="kategori" class="form-control" value="<?= htmlspecialchars($b['kategori']) ?>" placeholder="Masukkan kategori buku..." required>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn-batal" onclick="closeModal('modalEdit<?= $b['id_buku'] ?>')">Kembali</button>
                                <button type="submit" class="btn-submit">Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<div id="modalTambah" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            Tambah Koleksi Buku
            <span class="close" onclick="closeModal('modalTambah')">&times;</span>
        </div>
        <form method="POST" action="?page=buku">
            <input type="hidden" name="aksi" value="tambah">
            <div class="modal-body">
                <div style="display:flex;gap:12px;">
                    <div class="form-group" style="flex:1">
                        <label>Kode Buku</label>
                        <input type="text" name="kode_buku" class="form-control" required>
                    </div>
                    <div class="form-group" style="flex:1">
                        <label>Jumlah Stok</label>
                        <input type="number" name="stok" class="form-control" min="0" required>
                    </div>
                </div>
                <div class="form-group">
                    <label>Judul Buku</label>
                    <input type="text" name="judul_buku" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Pengarang</label>
                    <input type="text" name="pengarang" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Kategori</label>
                    <input type="text" name="kategori" class="form-control" placeholder="Masukkan kategori buku..." required>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-batal" onclick="closeModal('modalTambah')">Kembali</button>
                <button type="submit" class="btn-submit">Tambah</button>
            </div>
        </form>
    </div>
</div>