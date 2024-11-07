<?php
require_once 'config/koneksi.php';

// Proses insert data
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['insert'])) {
    $nim = $_POST['nim'];
    $id_jadwal = $_POST['id_jadwal'];
    $sql = "INSERT INTO tabel_krs (nim, id_jadwal) VALUES (?, ?)";
    $stmt = koneksi()->prepare($sql);
    $stmt->execute([$nim, $id_jadwal]);
    header('Location: krs.php');
    exit();
}

// Proses update data
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update'])) {
    $id = $_POST['id'];
    $nim = $_POST['nim'];
    $id_jadwal = $_POST['id_jadwal'];
    $sql = "UPDATE tabel_krs SET nim = ?, id_jadwal = ? WHERE id = ?";
    $stmt = koneksi()->prepare($sql);
    $stmt->execute([$nim, $id_jadwal, $id]);
    header('Location: krs.php');
    exit();
}

// Proses delete data
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete'])) {
    $id = $_POST['id'];
    $sql = "DELETE FROM tabel_krs WHERE id = ?";
    $stmt = koneksi()->prepare($sql);
    $stmt->execute([$id]);
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
    <title>Data KRS</title>
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
                <input type="hidden" name="insert" value="1">
                <div class="mb-3">
                    <label for="nim" class="form-label">Nama Mahasiswa</label>
                    <select class="form-select" aria-label="Pilih Nama Mahasiswa" id="nim" name="nim">
                        <option selected>Pilih Nama Mahasiswa</option>
                        <?php foreach ($mhs as $row): ?>
                            <option value="<?= json_encode($row['nim']) ?>">
                                <?= htmlspecialchars($row['nama_mahasiswa'] ?? '') ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="id_jadwal" class="form-label">Jadwal</label>
                    <select class="form-select" aria-label="Pilih Dosen" id="id_jadwal" name="id_jadwal">
                        <option selected>Pilih Jadwal</option>
                        <?php foreach ($jadwal as $row): ?>
                            <option value="<?= htmlspecialchars($row['id']) ?>">
                                Hari: <?= htmlspecialchars($row['hari']) ?>, Jam Ke-<?= htmlspecialchars($row['jam']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </form>
        </div>
        <div class="col-md-8">
            <h2>Data KRS</h2>
            <table class="table table-striped table-hover">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>NIM</th>
                    <th>Nama Mahasiswa</th>
                    <th>Mata Kuliah</th>
                    <th>Hari</th>
                    <th>Jam</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($krs as $row): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['id']) ?></td>
                        <td><?= htmlspecialchars($row['nim']) ?></td>
                        <td><?= htmlspecialchars($row['nama_mahasiswa']) ?></td>
                        <td><?= htmlspecialchars($row['nama_matakuliah']) ?></td>
                        <td><?= htmlspecialchars($row['hari']) ?></td>
                        <td><?= htmlspecialchars($row['jam']) ?></td>
                        <td>
                            <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#updateModal"
                                    data-id="<?= $row['id'] ?>"
                                    data-nim="<?= $row['nim'] ?>"
                                    data-id_jadwal="<?= $row['id'] ?>"
                                    data-nama_mahasiswa="<?= htmlspecialchars($row['nama_mahasiswa']) ?>"
                                    data-hari="<?= htmlspecialchars($row['hari']) ?>"
                                    data-jam="<?= htmlspecialchars($row['jam']) ?>">Edit
                            </button>
                            <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteModal"
                                    data-id="<?= $row['id'] ?>">Delete
                            </button>
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
                <input type="hidden" name="update" value="1">
                <input type="hidden" id="updateID" name="id">
                <div class="modal-header">
                    <h5 class="modal-title" id="updateModalLabel">Edit KRS</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="updateNim" class="form-label">Nama Mahasiswa</label>
                        <select class="form-select" id="updateNim" name="nim">
                            <option>Pilih Nama Mahasiswa</option>
                            <?php foreach ($mhs as $row): ?>
                                <option value="<?= htmlspecialchars($row['nim']) ?>">
                                    <?= htmlspecialchars($row['nama_mahasiswa']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="updateIdJadwal" class="form-label">Jadwal</label>
                        <select class="form-select" id="updateIdJadwal" name="id_jadwal">
                            <option>Pilih Jadwal</option>
                            <?php foreach ($jadwal as $row): ?>
                                <option value="<?= htmlspecialchars($row['id']) ?>">
                                    Hari: <?= htmlspecialchars($row['hari']) ?>, Jam Ke-<?= htmlspecialchars($row['jam']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Simpan</button>
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
                <input type="hidden" name="delete" value="1">
                <input type="hidden" id="deleteID" name="id">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Delete KRS</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete this item?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-danger">Delete</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const updateModal = document.getElementById('updateModal');
        if (updateModal) {
            updateModal.addEventListener('show.bs.modal', event => {
                const button = event.relatedTarget;
                const id = button.getAttribute('data-id');
                const nim = button.getAttribute('data-nim');
                const id_jadwal = button.getAttribute('data-id_jadwal');

                updateModal.querySelector('#updateID').value = id;
                updateModal.querySelector('#updateNim').value = nim;
                updateModal.querySelector('#updateIdJadwal').value = id_jadwal;
            });
        }

        const deleteModal = document.getElementById('deleteModal');
        if (deleteModal) {
            deleteModal.addEventListener('show.bs.modal', event => {
                const button = event.relatedTarget;
                const id = button.getAttribute('data-id');

                deleteModal.querySelector('#deleteID').value = id;
            });
        }
    });
</script>
</body>
</html>