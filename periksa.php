<?php  
if (!isset($_SESSION)) {  
    session_start();  
}  
if (!isset($_SESSION['nama'])) {  
    // Jika pengguna belum login, arahkan ke halaman beranda  
    header("Location: berandaDokter.php?page=profilDokter");  
    exit;  
}  

if (isset($_POST['simpan'])) {  
    // Mendapatkan data dari formulir  
    $id_daftar_poli = $_GET['id'];  
    $biaya_dokter = 150000;  
    $tgl_periksa = date('Y-m-d H:i:s');  
    $catatan = $_POST['catatan'];  

    // Menghitung total biaya periksa  
    $total = $biaya_dokter;  

    // Menambahkan data periksa ke dalam tabel 'periksa'  
    $tambah = mysqli_query($mysqli, "INSERT INTO periksa (id_daftar_poli, tgl_periksa, catatan, biaya_periksa)   
        VALUES (  
            '$id_daftar_poli',  
            '$tgl_periksa',  
            '$catatan',  
            '$total'  
        )");  
    // Mendapatkan ID periksa yang baru ditambahkan  
    $id_periksa = mysqli_insert_id($mysqli);  

    // Menambahkan data detail periksa ke dalam tabel 'detail_periksa'  
    if (isset($_POST['id_obat'])) {  
        foreach ($_POST['id_obat'] as $id_obat) {  
            // Mengambil harga obat dari database  
            $result = mysqli_query($mysqli, "SELECT harga FROM obat WHERE id = '$id_obat'");  
            $row = mysqli_fetch_assoc($result);  
            $harga = $row['harga'];  

            // Menambahkan harga obat ke total biaya  
            $total += $harga;  

            // Menambahkan detail obat ke tabel detail_periksa  
            $sql = "INSERT INTO detail_periksa (id_periksa, id_obat) VALUES ('$id_periksa', '$id_obat')";  
            $tambahdetail = mysqli_query($mysqli, $sql);  
        }  

        // Update total biaya periksa setelah menambahkan obat  
        mysqli_query($mysqli, "UPDATE periksa SET biaya_periksa = '$total' WHERE id = '$id_periksa'");  
    }  

    if (!$tambah) {  
        echo "Error: " . mysqli_error($mysqli);  
    }  

    echo "<script>   
            alert('Pasien telah diperiksa');  
            document.location='berandaDokter.php?page=periksa';  
        </script>";  
}  

// Jika terdapat parameter 'aksi' pada URL  
if (isset($_GET['aksi'])) {  
    // Jika nilai 'aksi' adalah 'hapus'  
    if ($_GET['aksi'] == 'hapus') {  
        $hapus = mysqli_query($mysqli, "DELETE FROM periksa WHERE id = '" . $_GET['id'] . "'");  
    }  

    echo "<script>   
            document.location='berandaDokter.php?page=periksa';  
        </script>";  
}  
?>  
<br>  

<div class="container">  
    <div class="row justify-content-center">  
        <div class="col-md-6">  
            <div class="card">  
                <div class="card-header text-center fw-bold" style="font-size: 2rem;">Periksa Pasien</div>  
                <div class="card-body">  
                    <form method="POST" action="">  
                        <?php  
                        // inisialisasi variabel  
                        $id_pasien = '';  
                        $id_dokter = $_SESSION['id'];  
                        $nama_dokter = $_SESSION['nama'];  
                        $nama_pasien = '';  
                        $no_antrian = '';  
                        $keluhan = '';  

                        if (isset($_GET['id'])) {  
                            // Ambil data pasien berdasarkan ID yang diberikan  
                            $ambil = mysqli_query($mysqli, "SELECT daftar_poli.*, pasien.nama AS nama  
                                    FROM daftar_poli  
                                    JOIN pasien ON daftar_poli.id_pasien = pasien.id  
                                    WHERE daftar_poli.id='" . $_GET['id'] . "'");  
                            while ($row = mysqli_fetch_array($ambil)) {  
                                // Isi variabel dengan data yang sesuai  
                                $id_pasien = $row['id_pasien'];  
                                $nama_pasien = $row['nama'];  
                                $no_antrian = $row['no_antrian'];  
                                $keluhan = $row['keluhan'];  
                            }  
                            ?>  
                            <input type="hidden" name="id" value="<?php echo isset($_GET['id']) ? $_GET['id'] : '' ?>">  
                            <input type="hidden" name="id_pasien" value="<?php echo $id_pasien; ?>">  
                            <input type="hidden" name="id_dokter" value="<?php echo $id_dokter; ?>">  
                            <?php  
                        }  
                        ?>  

                        <div class="form-group mb-3">  
                            <label for="id_pasien">Nama Pasien</label>  
                            <input value="<?php echo $nama_pasien ?>" type="text" name="id_pasien"  
                                class="form-control form-control-lg fs-6" placeholder="Masukkan nama pasien" required readonly>  
                        </div>  

                        <div class="form-group mb-3">  
                            <label for="id_dokter">Nama Dokter</label>  
                            <input value="<?php echo $nama_dokter ?>" type="text" name="id_dokter"  
                                class="form-control form-control-lg bg-light fs-6" placeholder="Masukkan nama dokter" required readonly>  
                        </div>  

                        <div class="row mt-1 mb-3">  
                            <label for="catatan" class="form-label fw-bold">Catatan</label>  
                            <textarea placeholder="Catatan..." class="form-control" name="catatan" id="catatan"  
                                aria-label="With textarea"></textarea>  
                        </div>  

                        <div class="row mt-1 mb-3">  
                            <label for="id_obat" class="form-label fw-bold">Obat</label>  
                            <div id="obat-container">  
                                <select class="form-select" aria-label="id_obat" name="id_obat[]" required>  
                                    <option selected>Pilih Obat...</option>  
                                    <?php  
                                    $result = mysqli_query($mysqli, "SELECT * FROM obat");  
                                    while ($data = mysqli_fetch_assoc($result)) {  
                                        echo "<option value='" . $data['id'] . "'>" . $data['nama_obat'] . "</option>";  
                                    }  
                                    ?>  
                                </select>  
                            </div>  
                            <button type="button" class="btn btn-secondary mt-2" id="tambah-obat">Tambah Obat</button>  
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

<br>  
<br>  
<!-- Table-->  
<table class="table table-bordered table-striped table-hover">  
    <thead>  
        <tr class="text-center">  
            <th scope="col">No</th>  
            <th scope="col">Nama Pasien</th>  
            <th scope="col">Nomor Antrian</th>  
            <th scope="col">Keluhan</th>  
            <th scope="col">Aksi</th>  
        </tr>  
    </thead>  
    <tbody>  
        <?php  
        $id_dokter = $_SESSION['id'];  
        $result = mysqli_query($mysqli, "  
                SELECT daftar_poli.*, pasien.nama AS nama, jadwal_periksa.hari, jadwal_periksa.jam_mulai, jadwal_periksa.jam_selesai  
                FROM daftar_poli  
                JOIN (  
                    SELECT id_pasien, MAX(tanggal) as max_tanggal  
                    FROM daftar_poli  
                    GROUP BY id_pasien  
                ) as latest_poli ON daftar_poli.id_pasien = latest_poli.id_pasien AND daftar_poli.tanggal = latest_poli.max_tanggal  
                JOIN jadwal_periksa ON daftar_poli.id_jadwal = jadwal_periksa.id   
                JOIN pasien ON daftar_poli.id_pasien = pasien.id  
                LEFT JOIN periksa ON daftar_poli.id = periksa.id_daftar_poli  
                WHERE jadwal_periksa.id_dokter = '$id_dokter' AND periksa.id_daftar_poli IS NULL  
            ");  
        $no = 1;  
        while ($data = mysqli_fetch_array($result)) {  
            ?>  
            <tr>  
                <th scope="row" class="text-center"><?php echo $no++ ?></th>  
                <td><?php echo $data['nama'] ?></td>  
                <td class="text-center"><?php echo $data['no_antrian'] ?></td>  
                <td><?php echo $data['keluhan'] ?></td>  
                <td class="d-flex justify-content-center ">  
                    <a class="btn btn-success rounded-pill px-3"  
                        href="berandaDokter.php?page=periksa&id=<?php echo $data['id'] ?>">Periksa</a>  
                </td>  
            </tr>  
            <?php  
        }  
        ?>  
    </tbody>  
</table>  
</div>  

<script>  
    document.getElementById('tambah-obat').addEventListener('click', function() {  
        // Membuat elemen select baru untuk obat  
        var newSelect = document.createElement('select');  
        newSelect.className = 'form-select mt-2';  
        newSelect.name = 'id_obat[]'; // Menggunakan array untuk menyimpan beberapa obat  
        newSelect.required = true;  

        // Menambahkan opsi obat ke select baru  
        var option = document.createElement('option');  
        option.selected = true;  
        option.textContent = 'Pilih Obat...';  
        newSelect.appendChild(option);  

        <?php  
        // Mengambil semua obat dari database untuk ditambahkan ke select  
        $result = mysqli_query($mysqli, "SELECT * FROM obat");  
        while ($data = mysqli_fetch_assoc($result)) {  
            echo "var option = document.createElement('option');";  
            echo "option.value = '" . $data['id'] . "';";  
            echo "option.textContent = '" . $data['nama_obat'] . "';";  
            echo "newSelect.appendChild(option);";  
        }  
        ?>  

        // Menambahkan select baru ke container obat  
        document.getElementById('obat-container').appendChild(newSelect);  
    });  
</script>