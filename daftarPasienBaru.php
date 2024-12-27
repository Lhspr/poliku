<?php 
    // Memeriksa apakah request yang diterima adalah POST
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Mengambil data dari formulir POST
        $nama = $_POST['nama'];
        $alamat = $_POST['alamat'];
        $no_ktp = $_POST['no_ktp'];
        $no_hp = $_POST['no_hp'];
        $password = $_POST['password'];

        // Hash password sebelum disimpan ke database
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Ambil jumlah total pasien dari database
        $result = mysqli_query($mysqli, "SELECT COUNT(*) as total FROM pasien");
        $row = mysqli_fetch_assoc($result);
        $totalPasien = $row['total'];

        // Generate no_rm berdasarkan tahun, bulan, dan total pasien
        // Menggunakan str_pad untuk menambahkan nol di depan nomor pasien
        $no_rm = date('Y') . date('m') . '-' . str_pad($totalPasien + 1, 3, '0', STR_PAD_LEFT);

        // Menyimpan data pasien ke dalam database
        $sql = "INSERT INTO pasien (nama, alamat, no_ktp, no_hp, no_rm, password) VALUES ('$nama', '$alamat', '$no_ktp', '$no_hp', '$no_rm', '$hashed_password')";
        $tambah = mysqli_query($mysqli, $sql);
        
        if ($tambah) {
            // Jika berhasil, arahkan ke halaman dengan no_rm yang baru
            header("Location: index.php?page=daftarpasienbaru&no_rm=$no_rm");
        } else {
            // Jika gagal, tampilkan pesan error
            $error = "Gagal menambah data pasien.";
        }
    }
?>

<div class="container d-flex justify-content-center align-items-center min-vh-100">
    <div class="row border rounded-5 p-3 bg-white shadow box-area"> 
        <!-------------------------- Right Box ---------------------------->
        <div class="col-md-6 right-box">
            <div class="row align-items-center">
                <div class="header-text mb-4">
                    <h2 class="text-center">Hello! </h2>
                    <p>Selamat Datang di Pusat Pendaftaran!</p>
                </div>
                <form method="POST" action="index.php?page=daftarpasienbaru">
                    <?php
                        if (!isset($error) && isset($_GET['no_rm'])) {
                            echo '
                                <svg xmlns="http://www.w3.org/2000/svg" class="d-none">
                                    <symbol id="check-circle-fill" viewBox="0 0 16 16">
                                        <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
                                    </symbol>
                                </svg>
                                <div class="alert alert-success d-flex align-items-center" role="alert">
                                    <svg class="bi flex-shrink-0 me-2" style="width: 20; height: 20;" role="img" aria-label="Success:"><use xlink:href="#check-circle-fill"/></svg>
                                    <div>
                                        Nomor RM anda adalah ' .$_GET['no_rm']. '
                                    </div>
                                </div>
                            ';
                        }
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
                        <input type="text" name="nama" class="form-control form-control-lg bg-light fs-6" placeholder="Masukkan nama lengkap" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="password">Password</label> 
                        <input type="password" name="password" class="form-control form-control-lg bg-light fs-6" placeholder="Masukkan password" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="alamat">Alamat</label> 
                        <input type="text" name="alamat" class="form-control form-control-lg bg-light fs-6" placeholder="Masukkan alamat" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="no_ktp">No KTP</label> 
                        <input type="number" name="no_ktp" class="form-control form-control-lg bg-light fs-6" placeholder="Masukkan no ktp" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="no_hp">No Hp</label> 
                        <input type="number" name="no_hp" class="form-control form-control-lg bg-light fs-6" placeholder="Masukkan no hp" required>
                    </div>
                    
                    <div class="form-group mb-3">
                        <button class="btn btn-lg btn-success w-100 fs-6" type="submit">Daftar</button>
                    </div>
                    <div class="text-center">
                        <p class="mt-3"><a>Sudah terdaftar? </a><a href="index.php?page=daftarPasien" style="text-decoration: none;">Masuk pasien</a></p>
                    </div>
                </form>
            </div>
        </div> 

        <div class="col-md-6 rounded-4 d-flex justify-content-center align-items-center flex-column left-box loginpage">
            <div class="featured-image mb-3">
            <img src="img/loginpage.png" class="img-fluid" style="width: 250px;">
            </div>
            <p class="text-white fs-6" style="font-family: 'Courier New', Courier, monospace; font-weight: 600;">Pendaftaran Nomor Rekam Medis (RM)</p>
            <small class="text-white text-wrap text-center" style="width: 17rem;font-family: 'Courier New', Courier, monospace;">
                Untuk memulai perjalanan kesehatan Anda bersama kami, silakan ikuti pendaftaran berikut untuk mendapatkan nomor rekam medis (RM).
            </small>
            <small class="text-white text-wrap text-center" style="width: 17rem;font-family: 'Courier New', Courier, monospace;">
            Nomor rekam medis (RM) adalah identitas unik Anda dalam sistem kami, memastikan pelayanan kesehatan yang efektif dan akurat. Pastikan untuk menyimpan nomor RM Anda dengan aman.
            </small>
        </div>
    </div>
</div>
