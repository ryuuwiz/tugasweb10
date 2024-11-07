<?php
require_once 'config/koneksi.php';

// Proses insert data
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] == 'insert') {
    $kode_matakuliah = $_POST['kode_matakuliah'];
    $nama_matakuliah = $_POST['nama_matakuliah'];
    $sks = $_POST['sks'];
    $sql = "INSERT INTO tabel_matakuliah (kode_matakuliah, nama_matakuliah, sks) VALUES (?, ?, ?)";
    $stmt = koneksi()->prepare($sql);
    $stmt->execute([$kode_matakuliah, $nama_matakuliah, $sks]);
    header('Location: matkul.php');
    exit();
}

// Proses update data
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] == 'update') {
    $kode_matakuliah = $_POST['kode_matakuliah'];
    $nama_matakuliah = $_POST['nama_matakuliah'];
    $sks = $_POST['sks'];
    $id = $_POST['id'];
    $sql = "UPDATE tabel_matakuliah SET kode_matakuliah = ?, nama_matakuliah = ?, sks = ? WHERE id = ?";
    $stmt = koneksi()->prepare($sql);
    $stmt->execute([$kode_matakuliah, $nama_matakuliah, $sks, $id]);
    header('Location: matkul.php');
    exit();
}

// Proses delete data
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $sql = "DELETE FROM tabel_matakuliah WHERE id = ?";
    $stmt = koneksi()->prepare($sql);
    $stmt->execute([$id]);
    header('Location: matkul.php');
    exit();
}

// Ambil data dari database
$sql = "SELECT * FROM tabel_matakuliah";
$stmt = koneksi()->query($sql);
$matkul = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Mata Kuliah</title>
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
                    <a class="nav-link" href="krs.php">KRS</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="mhs.php">Mahasiswa</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="matkul.php">Mata Kuliah</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
<div class="container-fluid mt-2 mb-5">
    <div class="row">
        <div class="col-md-4">
            <h2>Form Input Mata Kuliah</h2>
            <form action="" method="POST">
                <input type="hidden" name="action" value="insert">
                <div class="mb-3">
                    <label for="kode_matakuliah" class="form-label">Kode Mata Kuliah</label>
                    <input type="number" class="form-control" id="kode_matakuliah" name="kode_matakuliah" required>
                </div>
                <div class="mb-3">
                    <label for="nama_matakuliah" class="form-label">Nama Mata Kuliah</label>
                    <input type="text" class="form-control" id="nama_matakuliah" name="nama_matakuliah" required>
                </div>
                <div class="mb-3">
                    <label for="sks" class="form-label">SKS</label>
                    <input type="number" class="form-control" id="sks" name="sks" required>
                </div>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </form>
        </div>
        <div class="col-md-8">
            <h2>Data Mata Kuliah</h2>
            <table class="table table-striped table-hover">
                <thead>
                <tr>
                    <th>Kode Mata Kuliah</th>
                    <th>Nama Mata Kuliah</th>
                    <th>SKS</th>
                    <th>Aksi</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($matkul as $row): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['kode_matakuliah']) ?></td>
                        <td><?= htmlspecialchars($row['nama_matakuliah']) ?></td>
                        <td><?= htmlspecialchars($row['sks']) ?></td>
                        <td>
                            <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editModal" onclick="editMatkul(
                            '<?= htmlspecialchars($row['kode_matakuliah']) ?>',
                            '<?= htmlspecialchars($row['nama_matakuliah']) ?>',
                            '<?= htmlspecialchars($row['sks']) ?>')
                                    ">Edit</button>
                            <a href="?delete=<?= $row['kode_matakuliah'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal for Edit -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Edit Mata Kuliah</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editForm" action="" method="POST">
                    <input type="hidden" name="action" value="update">
                    <div class="mb-3">
                        <label for="edit-kode_matakuliah" class="form-label">Kode Mata Kuliah</label>
                        <input type="number" class="form-control" id="edit-kode_matakuliah" name="kode_matakuliah" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit-nama_matakuliah" class="form-label">Nama Mata Kuliah</label>
                        <input type="text" class="form-control" id="edit-nama_matakuliah" name="nama_matakuliah" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit-sks" class="form-label">SKS</label>
                        <input type="number" class="form-control" id="edit-sks" name="sks" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    function editMatkul(kodeMatkul, namaMatkul, sks) {
        document.getElementById('edit-kode_matakuliah').value = kodeMatkul;
        document.getElementById('edit-nama_matakuliah').value = namaMatkul;
        document.getElementById('edit-sks').value = sks;
    }
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>