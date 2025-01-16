<?php  
    // Pengecekan apakah request yang diterima adalah POST
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Mengambil data keluhan dan id_jadwal dari formulir POST
        $keluhan = $_POST['keluhan'];
        $id_jadwal = $_POST['id_jadwal'];

        // Periksa apakah jadwal yang dipilih aktif
        $query = "SELECT status FROM jadwal_periksa WHERE id = '$id_jadwal'";
        $result = $mysqli->query($query);
        $jadwal = $result->fetch_assoc();

        if ($jadwal && $jadwal['status'] == 1) {
            // Pengecekan nomor antrian berikutnya
            $query = "SELECT MAX(no_antrian) as max_no FROM daftar_poli WHERE id_jadwal = '$id_jadwal'";
            $result = $mysqli->query($query);
            $row = $result->fetch_assoc();
            $no_antrian = $row['max_no'] !== null ? $row['max_no'] + 1 : 1;

            // Menyimpan data pendaftaran pasien ke poli dalam tabel daftar_poli 
            $insert_query = "INSERT INTO daftar_poli (id_pasien, id_jadwal, keluhan, no_antrian, tanggal) 
                             VALUES ('".$_SESSION['id_pasien']."', '$id_jadwal', '$keluhan', '$no_antrian', NOW())";
            if (mysqli_query($mysqli, $insert_query)) {
                header("Location: index.php?page=daftarPoli&no_antrian=$no_antrian");
                exit();
            } else {
                $error = "Pendaftaran gagal. Silakan coba lagi.";
            }
        } else {
            $error = "Jadwal yang dipilih tidak aktif. Silakan pilih jadwal lain.";
        }
    }

    // Query untuk mengambil data dokter dan jadwal
    $query = "SELECT dokter.id AS dokter_id, dokter.nama AS dokter_nama, jadwal_periksa.id AS jadwal_id, 
                     jadwal_periksa.hari AS hari, jadwal_periksa.jam_mulai AS jam_mulai, jadwal_periksa.jam_selesai AS jam_selesai 
              FROM dokter 
              JOIN jadwal_periksa ON dokter.id = jadwal_periksa.id_dokter 
              WHERE jadwal_periksa.status = 1";
    $result = $mysqli->query($query);

    if (!$result) {
        die("Query error: " . $mysqli->error);
    }

    $dokter_schedules = $result->fetch_all(MYSQLI_ASSOC);
?>

<div class="container" style="margin-top: 4.1rem;">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header text-center fw-bold" style="font-size: 2rem;">Pendaftaran Poli</div>
                <div class="card-body">
                    <form class="form row" method="POST" style="width: 30rem;" action="" name="myForm">
                        <?php 
                        if (isset($_GET['no_antrian'])) { 
                            echo '
                                <div class="alert alert-success">
                                    Nomor antrian anda adalah ' . $_GET['no_antrian'] . '
                                </div>';
                        }
                        if (isset($error)) { ?>
                            <div class="alert alert-danger">
                                <?= $error ?>
                            </div>
                        <?php } ?>

                        <div class="row mt-1 mb-3">
                            <label for="id_poli" class="form-label fw-bold">Poli Dokter</label>
                            <div>
                                <select class="form-select" aria-label="id_poli" name="id_poli">
                                    <option selected>Pilih Poli...</option>
                                    <?php 
                                        $result = mysqli_query($mysqli, "SELECT * FROM poli");
                                        while ($data = mysqli_fetch_assoc($result)) {
                                            echo "<option value='" . $data['id'] . "'>" . $data['nama_poli'] . "</option>";
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>

                        <div class="row mt-1 mb-3">
                            <label for="id_dokter" class="form-label fw-bold">Dokter</label>
                            <div>
                                <select class="form-select" aria-label="id_dokter" name="id_dokter">
                                    <option selected>Pilih Dokter...</option>
                                </select>
                            </div>
                        </div>

                        <div class="row mt-1 mb-3">
                            <label for="id_jadwal" class="form-label fw-bold">Jadwal</label>
                            <div>
                                <select class="form-select" aria-label="id_jadwal" name="id_jadwal">
                                    <option selected>Pilih Jadwal...</option>
                                </select>
                            </div>
                        </div>

                        <div class="row mt-1 mb-3">
                            <label for="keluhan" class="form-label fw-bold">Keluhan</label>
                            <textarea placeholder="Keluhan anda" class="form-control" name="keluhan" id="keluhan" aria-label="With textarea"></textarea>
                        </div>

                        <div class="row mt-3">
                            <div class="col">
                                <button type="submit" class="btn btn-primary rounded-pill px-3 mt-auto" name="simpan">Simpan</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.querySelector("select[name='id_poli']").addEventListener('change', function(){
        var id_poli = this.value;
        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'ambilDokter.php', true);
        xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        xhr.onload = function(){
            if (this.status == 200) {
                var response = JSON.parse(this.responseText);
                var select = document.querySelector("select[name='id_dokter']");
                select.innerHTML = "<option selected>Pilih Dokter...</option>";
                response.forEach(function(dokter) {
                    select.innerHTML += `<option value="${dokter.id}">${dokter.nama}</option>`;
                });
            }
        }
        xhr.send('id_poli=' + id_poli);
    });

    document.querySelector("select[name='id_dokter']").addEventListener('change', function(){
        var id_dokter = this.value;
        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'ambilJadwal.php', true);
        xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        xhr.onload = function(){
            if (this.status == 200) {
                var response = JSON.parse(this.responseText);
                var select = document.querySelector("select[name='id_jadwal']");
                select.innerHTML = "<option selected>Pilih Jadwal...</option>";
                response.forEach(function(jadwal) {
                    select.innerHTML += `<option value="${jadwal.id}">${jadwal.hari}, ${jadwal.jam_mulai} - ${jadwal.jam_selesai}</option>`;
                });
            }
        }
        xhr.send('id_dokter=' + id_dokter);
    });
</script>
