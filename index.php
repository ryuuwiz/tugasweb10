<?php
require_once 'config/koneksi.php';

// Proses CRUD
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $kode_dosen = $_POST['kode_dosen'];
    $nama_dosen = $_POST['nama_dosen'];
    $jenis_kelamin = $_POST['jenis_kelamin'];
    $alamat = $_POST['alamat'];
    $telp = $_POST['telepon'];

    if (isset($_POST['save'])) {
        $sql = "INSERT INTO tabel_dosen (kode_dosen, nama_dosen, jenis_kelamin, alamat, telepon) VALUES (?, ?, ?, ?, ?)";
        $stmt = koneksi()->prepare($sql);
        $stmt->execute([$kode_dosen, $nama_dosen, $jenis_kelamin, $alamat, $telp]);
    } elseif (isset($_POST['update'])) {
        $sql = "UPDATE tabel_dosen SET nama_dosen = ?, jenis_kelamin = ?, alamat = ?, telepon = ? WHERE kode_dosen = ?";
        $stmt = koneksi()->prepare($sql);
        $stmt->execute([$nama_dosen, $jenis_kelamin, $alamat, $telp, $kode_dosen]);
    }

    header('Location: index.php');
    exit();
}

if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['id'])) {
    $kode_dosen = $_GET['id'];

    $sql = "DELETE FROM tabel_dosen WHERE kode_dosen = ?";
    $stmt = koneksi()->prepare($sql);
    $stmt->execute([$kode_dosen]);

    header('Location: index.php');
    exit();
}

// Ambil semua data dosen
$sql = "SELECT * FROM tabel_dosen";
$stmt = koneksi()->query($sql);
$allDosen = $stmt->fetchAll();
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
                    <a class="nav-link active" aria-current="page" href="index.php">Dosen</a>
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
                    <a class="nav-link" href="matkul.php">Mata Kuliah</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
<div class="container-fluid mt-2 mb-5">
    <div class="row">
        <div class="col-md-4">
            <h2>Form Input Dosen</h2>
            <form action="" method="POST">
                <div class="mb-3">
                    <label for="kode_dosen" class="form-label">Kode Dosen</label>
                    <input type="text" class="form-control" id="kode_dosen" name="kode_dosen" required>
                </div>
                <div class="mb-3">
                    <label for="nama_dosen" class="form-label">Nama Dosen</label>
                    <input type="text" class="form-control" id="nama_dosen" name="nama_dosen" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Jenis Kelamin</label>
                    <div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="jenis_kelamin" id="laki" value="Laki-laki">
                            <label class="form-check-label" for="laki">Laki-laki</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="jenis_kelamin" id="perempuan" value="Perempuan">
                            <label class="form-check-label" for="perempuan">Perempuan</label>
                        </div>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="alamat" class="form-label">Alamat</label>
                    <input type="text" class="form-control" id="alamat" name="alamat" required>
                </div>
                <div class="mb-3">
                    <label for="telp" class="form-label">Telepon</label>
                    <input type="number" class="form-control" id="telp" name="telepon" required>
                </div>
                <button type="submit" name="save" class="btn btn-primary">Simpan</button>
            </form>
        </div>

        <div class="col-md-8">
            <h2>Data Dosen</h2>
            <table class="table table-striped table-hover">
                <thead>
                <tr>
                    <th>Kode Dosen</th>
                    <th>Nama Dosen</th>
                    <th>Jenis Kelamin</th>
                    <th>Alamat</th>
                    <th>Telepon</th>
                    <th>Aksi</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($allDosen as $row): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['kode_dosen']) ?></td>
                        <td><?= htmlspecialchars($row['nama_dosen']) ?></td>
                        <td><?= htmlspecialchars($row['jenis_kelamin']) ?></td>
                        <td><?= htmlspecialchars($row['alamat']) ?></td>
                        <td><?= htmlspecialchars($row['telepon']) ?></td>
                        <td>
                            <button class="btn btn-warning btn-sm" onclick="editDosen('<?= htmlspecialchars($row['kode_dosen']) ?>', '<?= htmlspecialchars($row['nama_dosen']) ?>', '<?= htmlspecialchars($row['jenis_kelamin']) ?>', '<?= htmlspecialchars($row['alamat']) ?>', '<?= htmlspecialchars($row['telepon']) ?>')">Edit</button>
                            <a href="?action=delete&id=<?= htmlspecialchars($row['kode_dosen']) ?>" class="btn btn-danger btn-sm" onclick="return confirm('Anda yakin ingin menghapus data ini?')">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Edit Data Dosen</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editForm" action="" method="POST">
                    <input type="hidden" name="kode_dosen" id="editKodeDosen">
                    <div class="mb-3">
                        <label for="editNamaDosen" class="form-label">Nama Dosen</label>
                        <input type="text" class="form-control" id="editNamaDosen" name="nama_dosen" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Jenis Kelamin</label>
                        <div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="jenis_kelamin" id="editLaki" value="Laki-laki">
                                <label class="form-check-label" for="editLaki">Laki-laki</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="jenis_kelamin" id="editPerempuan" value="Perempuan">
                                <label class="form-check-label" for="editPerempuan">Perempuan</label>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="editAlamat" class="form-label">Alamat</label>
                        <input type="text" class="form-control" id="editAlamat" name="alamat" required>
                    </div>
                    <div class="mb-3">
                        <label for="editTelepon" class="form-label">Telepon</label>
                        <input type="number" class="form-control" id="editTelepon" name="telepon" required>
                    </div>
                    <button type="submit" name="update" class="btn btn-primary">Simpan</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function editDosen(kode_dosen, nama_dosen, jenis_kelamin, alamat, telepon) {
        document.getElementById('editKodeDosen').value = kode_dosen;
        document.getElementById('editNamaDosen').value = nama_dosen;
        document.getElementById('editAlamat').value = alamat;
        document.getElementById('editTelepon').value = telepon;
        if (jenis_kelamin === 'Laki-laki') {
            document.getElementById('editLaki').checked = true;
        } else {
            document.getElementById('editPerempuan').checked = true;
        }
        var editModal = new bootstrap.Modal(document.getElementById('editModal'));
        editModal.show();
    }
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>