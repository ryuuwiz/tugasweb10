<?php
require_once 'config/koneksi.php';

// Proses insert data
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $kode_matakuliah = $_POST['kode_matakuliah'];
    $kode_dosen = $_POST['kode_dosen'];
    $hari = $_POST['hari'];
    $jam = $_POST['jam'];

    $sql = "INSERT INTO tabel_jadwal (kode_matakuliah, kode_dosen, hari, jam) VALUES (?, ?, ?, ?)";
    $stmt = koneksi()->prepare($sql);
    $stmt->execute([$kode_matakuliah, $kode_dosen, $hari, $jam]);

//  Reset
    header('Location: jadwal.php');
    exit();
}

// Ambil data dari database
$sql = "SELECT
    tj.id AS jadwal_id,
    tm.nama_matakuliah,
    td.nama_dosen,
    tj.hari,
    tj.jam
FROM
    tabel_jadwal tj
    JOIN tabel_matakuliah tm ON tj.kode_matakuliah = tm.kode_matakuliah
    JOIN tabel_dosen td ON tj.kode_dosen = td.kode_dosen;";
$stmt = koneksi()->query($sql);
$jadwal = $stmt->fetchAll();

$matakuliah = koneksi()->query("SELECT * FROM tabel_matakuliah")->fetchAll();
$dosen = koneksi()->query("SELECT * FROM tabel_dosen")->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Dosen</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <a class="navbar-brand" href="index.php">Akademik</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" aria-current="page" href="index.php">Dosen</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="jadwal.php">Jadwal</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="krs.php">KRS</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="mhs.php">Mahasiswa</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="matkul.php">Mata Kuliah</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
<div class="container-fluid mt-2 mb-5">
    <div class="row">
        <div class="col-md-4">
            <h2>Form Input Jadwal</h2>
            <form action="" method="POST">
                <div class="mb-3">
                    <label for="matakuliah" class="form-label">Mata Kuliah</label>
                    <select class="form-select" aria-label="Pilih Mata Kuliah" id="matakuliah" name="kode_matakuliah">
                        <option selected>Pilih Mata Kuliah</option>
                        <?php foreach ($matakuliah as $row): ?>
                            <option value="<?= htmlspecialchars($row['kode_matakuliah'])?>">
                                <?= htmlspecialchars($row['nama_matakuliah']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="dosen" class="form-label">Nama Dosen</label>
                    <select class="form-select" aria-label="Pilih Dosen" id="dosen" name="kode_dosen">
                        <option selected>Pilih Dosen</option>
                        <?php foreach ($dosen as $row): ?>
                            <option value="<?= htmlspecialchars($row['kode_dosen'])?>">
                                <?= htmlspecialchars($row['nama_dosen']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="hari" class="form-label">Hari</label>
                    <input type="text" class="form-control" id="hari" name="hari" required>
                </div>
                <div class="mb-3">
                    <label for="jam" class="form-label">Jam</label>
                    <input type="text" class="form-control" id="jam" name="jam" required>
                </div>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </form>
        </div>

        <div class="col-md-8">
            <h2>Data Jadwal</h2>
            <table class="table table-striped table-hover">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Mata Kuliah</th>
                    <th>Nama Dosen</th>
                    <th>Hari</th>
                    <th>Jam</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($jadwal as $row): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['jadwal_id']) ?></td>
                        <td><?= htmlspecialchars($row['nama_matakuliah']) ?></td>
                        <td><?= htmlspecialchars($row['nama_dosen']) ?></td>
                        <td><?= htmlspecialchars($row['hari']) ?></td>
                        <td><?= htmlspecialchars($row['jam']) ?></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>