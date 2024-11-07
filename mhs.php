<?php
require_once 'config/koneksi.php';

// Proses insert data
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add'])) {
    $nim = $_POST['nim'];
    $nama_mahasiswa = $_POST['nama_mahasiswa'];
    $jenis_kelamin = $_POST['jenis_kelamin'];
    $alamat = $_POST['alamat'];
    $jurusan = $_POST['jurusan'];
    $sql = "INSERT INTO tabel_mahasiswa (nim, nama_mahasiswa, jenis_kelamin, alamat, jurusan) VALUES (?, ?, ?, ?, ?)";
    $stmt = koneksi()->prepare($sql);
    $stmt->execute([$nim, $nama_mahasiswa, $jenis_kelamin, $alamat, $jurusan]);
    // Reset
    header('Location: mhs.php');
    exit();
}

// Proses update data
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update'])) {
    $nim = $_POST['nim'];
    $nama_mahasiswa = $_POST['nama_mahasiswa'];
    $jenis_kelamin = $_POST['jenis_kelamin'];
    $alamat = $_POST['alamat'];
    $jurusan = $_POST['jurusan'];
    $sql = "UPDATE tabel_mahasiswa SET nama_mahasiswa = ?, jenis_kelamin = ?, alamat = ?, jurusan = ? WHERE nim = ?";
    $stmt = koneksi()->prepare($sql);
    $stmt->execute([$nama_mahasiswa, $jenis_kelamin, $alamat, $jurusan, $nim]);
    // Reset
    header('Location: mhs.php');
    exit();
}

// Proses delete data
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete'])) {
    $nim = $_POST['nim'];
    $sql = "DELETE FROM tabel_mahasiswa WHERE nim = ?";
    $stmt = koneksi()->prepare($sql);
    $stmt->execute([$nim]);
    // Reset
    header('Location: mhs.php');
    exit();
}

// Ambil data dari database
$sql = "SELECT * FROM tabel_mahasiswa";
$stmt = koneksi()->query($sql);
$mhs = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Mahasiswa</title>
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
                    <a class="nav-link active" href="mhs.php">Mahasiswa</a>
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
            <h2>Form Input Mahasiswa</h2>
            <form action="" method="POST">
                <div class="mb-3">
                    <label for="nim" class="form-label">NIM</label>
                    <input type="text" class="form-control" id="nim" name="nim" required>
                </div>
                <div class="mb-3">
                    <label for="nama_mahasiswa" class="form-label">Nama Mahasiswa</label>
                    <input type="text" class="form-control" id="nama_mahasiswa" name="nama_mahasiswa" required>
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
                    <label for="jurusan" class="form-label">Jurusan</label>
                    <input type="text" class="form-control" id="jurusan" name="jurusan" required>
                </div>
                <button type="submit" name="add" class="btn btn-primary">Simpan</button>
            </form>
        </div>
        <div class="col-md-8">
            <h2>Data Mahasiswa</h2>
            <table class="table table-striped table-hover">
                <thead>
                <tr>
                    <th>NIM</th>
                    <th>Nama Mahasiswa</th>
                    <th>Jenis Kelamin</th>
                    <th>Alamat</th>
                    <th>Jurusan</th>
                    <th>Aksi</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($mhs as $row): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['nim']) ?></td>
                        <td><?= htmlspecialchars($row['nama_mahasiswa']) ?></td>
                        <td><?= htmlspecialchars($row['jenis_kelamin']) ?></td>
                        <td><?= htmlspecialchars($row['alamat']) ?></td>
                        <td><?= htmlspecialchars($row['jurusan']) ?></td>
                        <td>
                            <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#updateModal" onclick="setUpdateModal('<?= htmlspecialchars($row['nim']) ?>', '<?= htmlspecialchars(addslashes($row['nama_mahasiswa'])) ?>', '<?= htmlspecialchars($row['jenis_kelamin']) ?>', '<?= htmlspecialchars(addslashes($row['alamat'])) ?>', '<?= htmlspecialchars(addslashes($row['jurusan'])) ?>')">Edit</button>
                            <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal" onclick="setDeleteModal('<?= htmlspecialchars($row['nim']) ?>')">Delete</button>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Update Modal -->
<div class="modal fade" id="updateModal" tabindex="-1" aria-labelledby="updateModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="" method="POST">
                <div class="modal-header">
                    <h5 class="modal-title" id="updateModalLabel">Edit Mahasiswa</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="updateNim" class="form-label">NIM</label>
                        <input type="text" class="form-control" id="updateNim" name="nama_mahasiswa" required>
                    </div>
                    <div class="mb-3">
                        <label for="updateNama" class="form-label">Nama Mahasiswa</label>
                        <input type="text" class="form-control" id="updateNama" name="nama_mahasiswa" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Jenis Kelamin</label>
                        <div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="jenis_kelamin" id="updateLaki" value="Laki-laki">
                                <label class="form-check-label" for="updateLaki">Laki-laki</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="jenis_kelamin" id="updatePerempuan" value="Perempuan">
                                <label class="form-check-label" for="updatePerempuan">Perempuan</label>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="updateAlamat" class="form-label">Alamat</label>
                        <input type="text" class="form-control" id="updateAlamat" name="alamat" required>
                    </div>
                    <div class="mb-3">
                        <label for="updateJurusan" class="form-label">Jurusan</label>
                        <input type="text" class="form-control" id="updateJurusan" name="jurusan" required>
                    </div>
                    <button type="submit" name="update" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Delete Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="" method="POST">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Delete Mahasiswa</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="deleteNim" name="nim">
                    <p>Apakah anda yakin ingin menghapus data mahasiswa ini?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" name="delete" class="btn btn-danger">Delete</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    function setUpdateModal(nim, nama, jenis_kelamin, alamat, jurusan) {
        document.getElementById('updateNim').value = nim;
        document.getElementById('updateNama').value = nama;
        if (jenis_kelamin === 'Laki-laki') {
            document.getElementById('updateLaki').checked = true;
        } else {
            document.getElementById('updatePerempuan').checked = true;
        }
        document.getElementById('updateAlamat').value = alamat;
        document.getElementById('updateJurusan').value = jurusan;
    }

    function setDeleteModal(nim) {
        document.getElementById('deleteNim').value = nim;
    }
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>