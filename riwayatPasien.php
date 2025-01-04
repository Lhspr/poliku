<?php  
if (!isset($_SESSION)) {  
    session_start();  
}  
if (!isset($_SESSION['nama'])) {  
    // Jika pengguna sudah login, tampilkan tombol "Logout"  
    header("Location: berandaDokter.php?page=profilDokter");  
    exit;  
}  

if (isset($_GET['aksi'])) {  
    if ($_GET['aksi'] == 'hapus') {  
        $hapus = mysqli_query($mysqli, "DELETE FROM periksa WHERE id = '" . $_GET['id'] . "'");  
    }  

    echo "<script>   
        document.location='index.php?page=riwayatPasien';  
    </script>";  
}  
?>  

<h2 class="text-center">Riwayat Pasien</h2>  
<br>  

<div class="container">  
    <table class="table table-bordered table-striped table-hover">  
        <thead class="table-light">  
            <tr class="text-center">  
                <th scope="col">No</th>  
                <th scope="col">Tanggal Periksa</th>  
                <th scope="col">Nama Pasien</th>  
                <th scope="col">Nomor Antrian</th>  
                <th scope="col">Keluhan</th>  
                <th scope="col">Catatan</th>  
                <th scope="col">Biaya Periksa</th>  
                <th scope="col">Nama Obat</th>  
            </tr>  
        </thead>  
        <tbody>  
            <?php  
                // Mendapatkan ID dokter dari sesi  
                $id_dokter = $_SESSION['id'];  
                // Menampilkan data riwayat pasien berdasarkan dokter  
                $result = mysqli_query($mysqli, "  
                    SELECT daftar_poli.*,   
                           pasien.nama AS nama,   
                           jadwal_periksa.hari,   
                           periksa.tgl_periksa,   
                           periksa.catatan,   
                           periksa.biaya_periksa,   
                           GROUP_CONCAT(obat.nama_obat SEPARATOR ', ') AS nama_obat  
                    FROM daftar_poli  
                    JOIN jadwal_periksa ON daftar_poli.id_jadwal = jadwal_periksa.id   
                    JOIN pasien ON daftar_poli.id_pasien = pasien.id  
                    LEFT JOIN periksa ON daftar_poli.id = periksa.id_daftar_poli  
                    LEFT JOIN detail_periksa ON periksa.id = detail_periksa.id_periksa  
                    LEFT JOIN obat ON detail_periksa.id_obat = obat.id  
                    WHERE jadwal_periksa.id_dokter = '$id_dokter' AND periksa.id_daftar_poli IS NOT NULL  
                    GROUP BY daftar_poli.id, pasien.nama, jadwal_periksa.hari, periksa.tgl_periksa, periksa.catatan, periksa.biaya_periksa  
                ");   
                $no = 1;  
                // Menampilkan data dalam bentuk tabel  
                while ($data = mysqli_fetch_array($result)) {  
            ?>  
                <tr>  
                    <th scope="row" class="text-center"><?php echo $no++ ?></th>  
                    <td class="text-center"><?php echo date('d-m-Y', strtotime($data['tgl_periksa'])) ?></td>  
                    <td><?php echo $data['nama'] ?></td>  
                    <td class="text-center"><?php echo $data['no_antrian'] ?></td>  
                    <td><?php echo $data['keluhan'] ?></td>  
                    <td><?php echo $data['catatan'] ?></td>  
                    <td class="text-center">Rp. <?php echo number_format($data['biaya_periksa'], 0, ',', '.') ?></td>  
                    <td><?php echo $data['nama_obat'] ?></td>  
                </tr>  
            <?php  
            }  
            ?>  
        </tbody>  
    </table>  
</div> 