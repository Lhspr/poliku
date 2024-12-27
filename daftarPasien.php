<?php 
    // Memeriksa apakah request yang diterima adalah POST
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $nama = $_POST['nama'];
        $no_rm = $_POST['no_rm'];
        $password = $_POST['password'];

        // Query untuk mencari pasien berdasarkan nama dan nomor rekam medis
        $query = "SELECT * FROM pasien WHERE nama = '$nama' AND no_rm = '$no_rm'";
        $result = $mysqli->query($query);

        // Memeriksa apakah query berhasil dieksekusi
        if (!$result) {
            die("Query error: " . $mysqli->error);
        }

        // Memeriksa apakah ada satu baris data pasien yang sesuai
        if ($result->num_rows == 1) {
            // Mengambil data pasien dari hasil query
            $row = $result->fetch_assoc();

            // Verifikasi password
            if (password_verify($password, $row['password'])) {
                // Menyimpan informasi nama dan id_pasien ke dalam sesi
                $_SESSION['nama'] = $row['nama'];
                $_SESSION['id_pasien'] = $row['id'];
                header("Location: index.php?page=daftarPoli&no_rm=$no_rm");
            } else {
                $error = "Password tidak sesuai";
            }
        } else {
            $error = "Nama atau Nomor RM tidak ditemukan";
        }
    }
?>

<div class="container d-flex justify-content-center align-items-center min-vh-100">
    <div class="row border rounded-5 p-3 bg-white shadow box-area">
        <!-------------------------- Right Box ---------------------------->
        <div class="col-md-6 right-box">
            <div class="row align-items-center">
                <div class="header-text mb-4">
                    <h2 class="text-center">Hello!</h2>
                    <p>Silakan masukkan nama, nomor rekam medis (RM), dan password Anda untuk memulai proses pendaftaran dan mendapatkan layanan medis kami.</p>
                </div>
                
                <form method="POST" action="index.php?page=daftarPasien">
                    <?php
                        if (isset($error)) {
                            echo '<div class="alert alert-danger">' . $error . '
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>';
                        }
                    ?>
                    <div class="form-group mb-3">
                        <label for="nama">Nama Lengkap</label> 
                        <input type="text" name="nama" class="form-control form-control-lg bg-light fs-6" placeholder="Masukkan nama lengkap Anda" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="no_rm">Nomor RM</label> 
                        <input type="text" name="no_rm" class="form-control form-control-lg bg-light fs-6" placeholder="Masukkan nomor RM Anda" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="password">Password</label>
                        <input type="password" name="password" class="form-control form-control-lg bg-light fs-6" placeholder="Masukkan password Anda" required>
                    </div>
                    
                    <div class="form-group mb-3">
                        <button class="btn btn-lg btn-success w-100 fs-6" type="submit">Cari</button>
                    </div>
                    <div class="text-center">
                        <p class="mt-3"><a>Belum terdaftar? </a><a href="index.php?page=daftarPasienBaru" style="text-decoration: none;">Mendaftar pasien baru</a></p>
                    </div>
                </form>
            </div>
        </div> 

        <!-------------------------- Left Box ---------------------------->
        <div class="col-md-6 rounded-4 d-flex justify-content-center align-items-center flex-column left-box loginpage">
            <div class="featured-image">
                <img src="img/loginpage.png" class="img-fluid" style="width: 250px;">
            </div>
            <p class="text-white fs-5" style="font-family: 'Courier New', Courier, monospace; font-weight: 600;">Nomor Rekam Medis (RM):</p>
            <small class="text-white text-wrap text-center mb-5" style="width: 17rem;font-family: 'Courier New', Courier, monospace;">
                Mohon masukkan nama, nomor rekam medis (RM), dan password Anda pada kolom yang tersedia. Jika Anda belum memiliki nomor RM, silakan melakukan pendaftaran.
            </small>
        </div> 
    </div>
</div>
