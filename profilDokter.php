<?php  
if (!isset($_SESSION)) {  
    session_start();  
}  
if (!isset($_SESSION['nama'])) {  
    // Jika pengguna belum login, arahkan ke halaman beranda  
    header("Location: berandaDokter.php?page=profilDokter");  
    exit;  
}  

// Koneksi ke database  
include_once("koneksi.php");  

// Ambil ID dokter dari parameter URL  
if (isset($_GET['id'])) {  
    $id_dokter = $_GET['id'];  

    // Query untuk mengambil data dokter berdasarkan ID  
    $result = mysqli_query($mysqli, "SELECT * FROM dokter WHERE id = '$id_dokter'");  
    
    if ($result) {  
        // Jika data dokter ditemukan  
        $data_dokter = mysqli_fetch_assoc($result);  
        $nama = $data_dokter['nama'];  
        $alamat = $data_dokter['alamat'];  
        $no_hp = $data_dokter['no_hp'];  
        $id_poli = $data_dokter['id_poli'];  

        // Query untuk mengambil nama poli berdasarkan ID poli  
        $poli_result = mysqli_query($mysqli, "SELECT nama_poli FROM poli WHERE id = '$id_poli'");  
        $data_poli = mysqli_fetch_assoc($poli_result);  
        $nama_poli = $data_poli['nama_poli'];  
    } else {  
        // Jika terjadi kesalahan dalam query  
        echo "Error: " . mysqli_error($mysqli);  
        exit;  
    }  
} else {  
    // Jika tidak ada parameter ID dokter  
    echo "ID Dokter tidak ditemukan.";  
    exit;  
}  

// Proses penyimpanan perubahan  
if ($_SERVER['REQUEST_METHOD'] == 'POST') {  
    $nama = $_POST['nama'];  
    $alamat = $_POST['alamat'];  
    $no_hp = $_POST['no_hp'];  

    // Update data dokter ke database  
    $update_query = "UPDATE dokter SET nama = '$nama', alamat = '$alamat', no_hp = '$no_hp' WHERE id = '$id_dokter'";  
    if (mysqli_query($mysqli, $update_query)) {  
        echo "<script>alert('Profil berhasil diperbarui.');</script>";  
        echo "<script>document.location='berandaDokter.php?page=profilDokter&id=$id_dokter';</script>";  
        exit;  
    } else {  
        echo "Error: " . mysqli_error($mysqli);  
    }  
}  
?>  

<div class="container mt-5">  
    <div class="row justify-content-center">  
        <div class="col-md-6">  
            <div class="card">  
                <div class="card-header text-center fw-bold" style="font-size: 2rem;">Profil Dokter</div>  
                <div class="card-body">  
                    <form class="form row" method="POST" style="width: 30rem;">  
                        <div class="row mb-3">  
                            <label for="inputNama" class="form-label fw-bold">Nama</label>  
                            <div>  
                                <input type="text" class="form-control" name="nama" id="inputNama" value="<?php echo htmlspecialchars($nama); ?>" required>  
                            </div>  
                        </div>  
                        <div class="row mb-3">  
                            <label for="inputAlamat" class="form-label fw-bold">Alamat</label>  
                            <div>  
                                <input type="text" class="form-control" name="alamat" id="inputAlamat" value="<?php echo htmlspecialchars($alamat); ?>" required>  
                            </div>  
                        </div>  
                        <div class="row mb-3">  
                            <label for="inputNohp" class="form-label fw-bold">No Hp</label>  
                            <div>  
                                <input type="text" class="form-control" name="no_hp" id="inputNohp" value="<?php echo htmlspecialchars($no_hp); ?>" required>  
                            </div>  
                        </div>  
                        <div class="row mb-3">  
                            <label for="nama_poli" class="form-label fw-bold">Poli Dokter</label>  
                            <div>  
                                <input type="text" class="form-control" name="nama_poli" id="nama_poli" value="<?php echo htmlspecialchars($nama_poli); ?>" readonly>  
                            </div>  
                        </div>  
                        <div class="row mb-3">  
                            <div class="col text-center">  
                                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>  
                                <a href="berandaDokter.php?page=profilDokter&id=<?php echo $id_dokter; ?>" class="btn btn-secondary">Batal</a>  
                            </div>  
                        </div>  
                    </form>  
                </div>  
            </div>  
        </div>  
    </div>  
</div>