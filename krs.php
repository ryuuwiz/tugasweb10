<?php
require_once 'config/koneksi.php';

// Proses insert data
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nim = $_POST['nim'];
    $id_jadwal = $_POST['id_jadwal'];

    $sql = "INSERT INTO tabel_krs (nim, id_jadwal) VALUES (?, ?)";
    $stmt = koneksi()->prepare($sql);
    $stmt->execute([$nim, $id_jadwal]);

//  Reset
    header('Location: krs.php');
    exit();
}

// Ambil data dari database
$sql = "SELECT
    k.id,
    m.nim,
    m.nama_mahasiswa,
    j.hari,
    j.jam,
    mk.nama_matakuliah
FROM
    tabel_krs k
        JOIN
    tabel_mahasiswa m ON k.nim = m.nim
        JOIN
    tabel_jadwal j ON k.id_jadwal = j.id
        JOIN
    tabel_matakuliah mk ON j.kode_matakuliah = mk.kode_matakuliah;";
$stmt = koneksi()->query($sql);
$krs = $stmt->fetchAll();

$mhs = koneksi()->query("SELECT * FROM tabel_mahasiswa")->fetchAll();
$jadwal = koneksi()->query("SELECT * FROM tabel_jadwal")->fetchAll();
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
                    <a class="nav-link" href="jadwal.php">Jadwal</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="krs.php">KRS</a>
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
            <h2>Form Input KRS</h2>
            <form action="" method="POST">
                <div class="mb-3">
                    <label for="nim" class="form-label">Nama Mahasiswa</label>
                    <select class="form-select" aria-label="Pilih Nama Mahasiswa" id="nim" name="nim">
                        <option selected>Pilih Nama Mahasiswa</option>
                        <?php foreach ($mhs as $row): ?>
                            <option value="<?= htmlspecialchars($row['nim']) ?>">
                                <?= htmlspecialchars($row['nama_mahasiswa']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="id_jadwal" class="form-label">Jadwal</label>
                    <select class="form-select" aria-label="Pilih Dosen" id="id_jadwal" name="id_jadwal">
                        <option selected>Pilih Jadwal</option>
                        <?php foreach ($jadwal as $row): ?>
                            <option value="<?= htmlspecialchars($row['id'])?>">
                                Hari: <?= htmlspecialchars($row['hari']) ?>, Jam Ke-<?= htmlspecialchars($row['jam']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
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
                    <th>NIM</th>
                    <th>Nama Mahasiswa</th>
                    <th>Mata Kuliah</th>
                    <th>Hari</th>
                    <th>Jam</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($krs as $row): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['id']) ?></td>
                        <td><?= htmlspecialchars($row['nim']) ?></td>
                        <td><?= htmlspecialchars($row['nama_mahasiswa']) ?></td>
                        <td><?= htmlspecialchars($row['hari']) ?></td>
                        <td><?= htmlspecialchars($row['jam']) ?></td>
                        <td><?= htmlspecialchars($row['nama_matakuliah']) ?></td>
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