<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['aksi']) && $_POST['aksi'] === 'pinjam') {
    $kode        = trim($_POST['kode_peminjaman']);
    $peminjam    = trim($_POST['nama_peminjam']);
    $buku_id     = (int)$_POST['buku_id'];
    $tgl_pinjam  = $_POST['tgl_pinjam'];
    $tgl_kembali = $_POST['tgl_kembali_rencana'];

    // Kurangi stok buku
    $pdo->prepare("UPDATE buku SET stok = stok - 1 WHERE id_buku = ? AND stok > 0")
        ->execute([$buku_id]);

    // Insert peminjaman
    $pdo->prepare("INSERT INTO peminjaman (kode_peminjaman, nama_peminjam, id_buku, tgl_pinjam, tgl_kembali_rencana, status) VALUES (?,?,?,?,?,'Dipinjam')")
        ->execute([$kode, $peminjam, $buku_id, $tgl_pinjam, $tgl_kembali]);

    header('Location: ?page=pinjam&success=pinjam'); exit;
}

if (isset($_GET['kembali'])) {
    $id = (int)$_GET['kembali'];

    // Ambil id_buku dari peminjaman
    $stmt = $pdo->prepare("SELECT id_buku FROM peminjaman WHERE id_peminjaman = ?");
    $stmt->execute([$id]);
    $data = $stmt->fetch();

    if ($data) {
        // Tambah stok lagi
        $pdo->prepare("UPDATE buku SET stok = stok + 1 WHERE id_buku = ?")
            ->execute([$data['id_buku']]);
        // Update status pinjaman
        $pdo->prepare("UPDATE peminjaman SET status = 'Dikembalikan' WHERE id_peminjaman = ?")
            ->execute([$id]);
    }

    header('Location: ?page=pinjam&success=kembali'); exit;
}

// Auto update status Terlambat kalau dikembalikan diluar jadwal
$pdo->prepare("UPDATE peminjaman SET status = 'Terlambat' WHERE tgl_kembali_rencana < ? AND status = 'Dipinjam'")
    ->execute([date('Y-m-d')]);

$showForm = isset($_GET['form']) && $_GET['form'] === 'catat';

// Ambil data peminjaman dengan join ke buku
$pinjamList = $pdo->query("
    SELECT p.*, b.judul, b.kode_buku 
    FROM peminjaman p 
    LEFT JOIN buku b ON p.id_buku = b.id_buku 
    ORDER BY p.id_peminjaman ASC
")->fetchAll();

$bukuTersedia = $pdo->query("SELECT id_buku, judul, stok FROM buku WHERE stok > 0 ORDER BY judul ASC")->fetchAll();
?>

<?php if ($showForm): ?>
<div class="form-page-container">
    <div class="form-page-title">Form Data Peminjaman</div>

    <form method="POST" action="?page=pinjam">
        <input type="hidden" name="aksi" value="pinjam">
        <div class="form-group">
            <label>Kode Peminjaman</label>
            <input type="text" name="kode_peminjaman" class="form-control" placeholder="Contoh: PJ011" required>
        </div>
        <div class="form-group">
            <label>Nama Peminjam</label>
            <input type="text" name="nama_peminjam" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Pilih Buku</label>
            <select name="buku_id" class="form-control" required>
                <option value="">Pilih Buku Tersedia</option>
                <?php foreach ($bukuTersedia as $b): ?>
                    <option value="<?= $b['id_buku'] ?>">
                        <?= htmlspecialchars($b['judul']) ?> - Stok: <?= $b['stok'] ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div style="display:flex; gap:15px;">
            <div class="form-group" style="flex:1">
                <label>Tanggal Pinjam</label>
                <input type="date" name="tgl_pinjam" class="form-control" required>
            </div>
            <div class="form-group" style="flex:1">
                <label>Tanggal Kembali</label>
                <input type="date" name="tgl_kembali_rencana" class="form-control" required>
            </div>
        </div>
        <div class="form-group">
            <label>Status</label>
            <input type="text" value="Dipinjam" class="form-control" readonly>
        </div>
        <div style="display:flex; justify-content:center; gap:10px; margin-top:10px;">
            <a href="?page=pinjam" class="btn-batal">Kembali</a>
            <button type="submit" class="btn-submit">Simpan</button>
        </div>
    </form>
</div>

<?php else: ?>

<?php if (isset($_GET['success'])): ?>
<div class="alert alert-success">
    <?= $_GET['success']==='pinjam' ? 'Peminjaman berhasil dicatat!' : 'Buku berhasil dikembalikan!' ?>
</div>
<?php endif; ?>

<h2 class="page-title">Database Peminjaman</h2>

<div class="action-bar">
    <a href="?page=pinjam&form=catat" class="btn-tambah">&#128196; Catat Peminjaman</a>
</div>

<div class="card">
    <div class="card-body">
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Kode Peminjaman</th>
                    <th>Peminjam</th>
                    <th>Judul Buku</th>
                    <th>Tanggal Pinjam</th>
                    <th>Tanggal Kembali</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($pinjamList as $i => $p): ?>
                <tr>
                    <td><?= $i + 1 ?></td>
                    <td><?= htmlspecialchars($p['kode_peminjaman']) ?></td>
                    <td><?= htmlspecialchars($p['nama_peminjam']) ?></td>
                    <td><?= htmlspecialchars($p['judul'] ?? '-') ?></td>
                    <td><?= $p['tgl_pinjam'] ?></td>
                    <td><?= $p['tgl_kembali_rencana'] ?></td>
                    <td><?= $p['status'] ?></td>
                    <td>
                        <?php if ($p['status'] === 'Dikembalikan'): ?>
                            <button class="btn-selesai" disabled>Selesai</button>
                        <?php else: ?>
                            <button class="btn-kembalikan" onclick="confirmKembali(<?= $p['id_peminjaman'] ?>)">Kembalikan</button>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?php endif; ?>