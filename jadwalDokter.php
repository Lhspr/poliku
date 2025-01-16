<?php
if (!isset($_SESSION)) {
    session_start();
}
if (!isset($_SESSION['nama'])) {
    header("Location: berandaDokter.php?page=jadwalDokter");
    exit;
}

// Menangani penambahan jadwal
if (isset($_POST['tambah'])) {
    // Validasi input
    if ($_POST['hari'] === "Pilih Hari..." || empty($_POST['jam_mulai']) || empty($_POST['jam_selesai'])) {
        echo "<script>alert('Silakan lengkapi semua data.');</script>";
    } else {
        // Periksa apakah sudah ada jadwal dengan hari yang sama untuk dokter yang sama
        $cek_jadwal = mysqli_query($mysqli, "SELECT * FROM jadwal_periksa WHERE id_dokter = '" . $_SESSION['id'] . "' AND hari = '" . $_POST['hari'] . "'");
        if (mysqli_num_rows($cek_jadwal) > 0) {
            echo "<script>alert('Jadwal pada hari tersebut sudah ada. Silakan pilih hari lain.');</script>";
        } else {
            // Menambahkan jadwal baru
            $tambah = mysqli_query($mysqli, "INSERT INTO jadwal_periksa (id_dokter, hari, jam_mulai, jam_selesai, status) 
                VALUES (
                    '" . $_SESSION['id'] . "',
                    '" . $_POST['hari'] . "',
                    '" . $_POST['jam_mulai'] . "',
                    '" . $_POST['jam_selesai'] . "',
                    '0'  -- Status default tidak aktif
                )");

            if (!$tambah) {
                echo "Error inserting record: " . mysqli_error($mysqli);
            }
            echo "<script>document.location='berandaDokter.php?page=jadwalDokter';</script>";
        }
    }
}

// Menangani perubahan status
if (isset($_POST['ubah_status'])) {
    if (isset($_POST['id'])) {
        // Nonaktifkan semua jadwal lain terlebih dahulu
        $nonaktifkan_jadwal = mysqli_query($mysqli, "UPDATE jadwal_periksa SET status = '0' WHERE id_dokter = '" . $_SESSION['id'] . "'");
        if (!$nonaktifkan_jadwal) {
            echo "Error updating record: " . mysqli_error($mysqli);
        }

        // Aktifkan jadwal yang dipilih
        $ubah = mysqli_query($mysqli, "UPDATE jadwal_periksa SET status = '1' WHERE id = '" . $_POST['id'] . "'");

        if (!$ubah) {
            echo "Error updating record: " . mysqli_error($mysqli);
        }
        echo "<script>document.location='berandaDokter.php?page=jadwalDokter';</script>";
    }
}

// Inisialisasi variabel
$id_dokter = '';
$hari = '';
$jam_mulai = '';
$jam_selesai = '';
$status = '0';
?>

<br>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header text-center fw-bold" style="font-size: 2rem;">Tambah Jadwal Dokter</div>
                <div class="card-body">
                    <form class="form row" method="POST" style="width: 30rem;" action="">
                        <div class="row mt-1">
                            <div class="form-group">
                                <label for="hari" class="form-label fw-bold">Hari</label>
                                <select class="form-select" aria-label="hari" name="hari">
                                    <option selected>Pilih Hari...</option>
                                    <option>Senin</option>
                                    <option>Selasa</option>
                                    <option>Rabu</option>
                                    <option>Kamis</option>
                                    <option>Jumat</option>
                                    <option>Sabtu</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="jam_mulai">Jam Mulai:</label>
                                <input type="time" class="form-control" id="jam_mulai" name="jam_mulai" required>
                            </div>

                            <div class="form-group">
                                <label for="jam_selesai">Jam Selesai:</label>
                                <input type="time" class="form-control" id="jam_selesai" name="jam_selesai" required>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col">
                                <button type="submit" class="btn btn-primary rounded-pill px-3 mt-auto" name="tambah">Tambah Jadwal</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <br>
    <br>
    <!-- Table-->
    <table class="table table-bordered table-striped table-hover">
        <thead>
            <tr class="text-center">
                <th scope="col">No</th>
                <th scope="col">Dokter</th>
                <th scope="col">Hari</th>
                <th scope="col">Mulai</th>
                <th scope="col">Selesai</th>
                <th scope="col">Status</th>
                <th scope="col">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $id_dokter = $_SESSION['id'];
            $result = mysqli_query($mysqli, "SELECT dokter.nama, jadwal_periksa.id, jadwal_periksa.hari, 
                jadwal_periksa.jam_mulai, jadwal_periksa.jam_selesai, jadwal_periksa.status 
                FROM dokter 
                JOIN jadwal_periksa ON dokter.id = jadwal_periksa.id_dokter 
                WHERE dokter.id = $id_dokter");
            $no = 1;
            while ($data = mysqli_fetch_array($result)) {
            ?>
                <tr>
                    <th scope="row" class="text-center"><?php echo $no++ ?></th>
                    <td><?php echo $data['nama'] ?></td>
                    <td class="text-center"><?php echo $data['hari'] ?></td>
                    <td class="text-center"><?php echo $data['jam_mulai'] ?></td>
                    <td class="text-center"><?php echo $data['jam_selesai'] ?></td>
                    <td class="d-flex gap-2 mb-3 d-flex justify-content-center">
                        <?php 
                            echo ($data['status'] == 1) ? 
                            '<a class="btn btn-success rounded-pill px-3">Aktif</a>' : 
                            '<a class="btn btn-danger rounded-pill px-3">Tidak Aktif</a>';
                        ?>
                    </td>
                    <td>
                        <div class="d-flex gap-2 mb-3 d-flex justify-content-center">
                            <form method="POST" action="">
                                <input type="hidden" name="id" value="<?php echo $data['id']; ?>">
                                <button type="submit" class="btn btn-primary rounded-pill px-3" name="ubah_status">
                                    Ubah Status
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            <?php
            }
            ?>
        </tbody>
    </table>
</div>
