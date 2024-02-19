<?php
include "koneksi.php";

function clean_input($data)
{
    global $koneksi;
    return mysqli_real_escape_string($koneksi, htmlspecialchars($data));
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $NIK = clean_input($_POST["NIK"]);
    $nama = clean_input($_POST["nama"]);
    $telp = clean_input($_POST["telp"]);
    $tgl_pengaduan = clean_input($_POST["tgl_pengaduan"]);
    $isi_laporan = clean_input($_POST["isi_laporan"]);

    // Memeriksa apakah file gambar telah diunggah
    if(isset($_FILES['gambar']) && $_FILES['gambar']['error'] === UPLOAD_ERR_OK) {
        // Mendapatkan informasi file yang diunggah
        $nama_file = $_FILES['gambar']['name'];
        $ukuran_file = $_FILES['gambar']['size'];
        $tmp_file = $_FILES['gambar']['tmp_name'];

        // Mengonversi isi laporan menjadi format yang aman
        // $isi_laporan = clean_input($_POST["isi_laporan"]);

        // Mendapatkan ekstensi file
        $ekstensi_diperbolehkan = array('png', 'jpg', 'jpeg');
        $ekstensi_file = explode('.', $nama_file);
        $ekstensi_file = strtolower(end($ekstensi_file));

        // Membuat nama file baru agar tidak ada duplikasi
        $nama_baru = uniqid() . '.' . $ekstensi_file;

        // Lokasi penyimpanan file
        $lokasi = 'uploads/' . $nama_baru;

        // Memeriksa ekstensi file
        if (in_array($ekstensi_file, $ekstensi_diperbolehkan)) {
            // Upload file
            if (move_uploaded_file($tmp_file, $lokasi)) {
                // Simpan data ke database
                $query_masyarakat = "INSERT INTO masyarakat (NIK, nama, telp) VALUES ('$NIK', '$nama', '$telp')";
                $result_masyarakat = $koneksi->query($query_masyarakat);

                // $id_masyarakat = $koneksi->insert_id;

                $query_pengaduan = "INSERT INTO pengaduan (NIK, tgl_pengaduan, isi_laporan, gambar) VALUES ('$NIK', '$tgl_pengaduan', '$isi_laporan', '$nama_baru')";
                $result_pengaduan = $koneksi->query($query_pengaduan);

                if ($result_masyarakat && $result_pengaduan) {
                    header('location:datapengaduan.php');
                    echo "Data berhasil disimpan.";
                } else {
                    echo "Error: " . $koneksi->error;
                }
            } else {
                echo "Gagal mengunggah file.";
            }
        } else {
            echo "Ekstensi file tidak diperbolehkan.";
        }
    } else {
        echo "File gambar tidak diunggah atau terdapat kesalahan dalam proses unggah.";
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="shortcut icon" type="image/png" href="images/lapor.png">

  <title>BUAT LAPORAN ANDA</title>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/JiK2x4IepVX+04WOgDE0C5gEl" crossorigin="anonymous">
  <link href="https://fonts.googleapis.com/css2?family=Sen:wght@400;700;800&display=swap" rel="stylesheet">
  <!-- Scrollbar Custom CSS -->
  <link rel="stylesheet" href="css/jquery.mCustomScrollbar.min.css">
  <!-- Tweaks for older IEs-->
  <link rel="stylesheet" href="https://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css">

  <style>
 

    .form-holder {
      max-width: 400px;
      margin: 0 auto;
      margin-top: 50px;
    }

    .form-content {
      background-color: #fff;
      padding: 20px;
      border-radius: 10px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    .form-items {
      text-align: center;
    }
       .logo-container {
      display: flex;
      justify-content: center;
      align-items: center;
      margin-top: 30px;
    }

    .logo {
      max-width: 50px;
      max-height: 50px;
      margin-right: 10px;
    }
   
  
    .cutout-text {
  background: linear-gradient(transparent 50%, white 50%);
  background-clip: text;
  color: transparent;
  font-size: 24px; /* Ukuran teks */
  display: inline-block; /* Membuat latar belakang hanya memengaruhi teks, bukan seluruh lebar container */
}

body {
  /* background: url('nama_file.svg') no-repeat center center fixed; */
  background-size: cover;
  background-color: #000000;
background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='400' height='400' viewBox='0 0 800 800'%3E%3Cg fill='none' stroke='%23440804' stroke-width='1'%3E%3Cpath d='M769 229L1037 260.9M927 880L731 737 520 660 309 538 40 599 295 764 126.5 879.5 40 599-197 493 102 382-31 229 126.5 79.5-69-63'/%3E%3Cpath d='M-31 229L237 261 390 382 603 493 308.5 537.5 101.5 381.5M370 905L295 764'/%3E%3Cpath d='M520 660L578 842 731 737 840 599 603 493 520 660 295 764 309 538 390 382 539 269 769 229 577.5 41.5 370 105 295 -36 126.5 79.5 237 261 102 382 40 599 -69 737 127 880'/%3E%3Cpath d='M520-140L578.5 42.5 731-63M603 493L539 269 237 261 370 105M902 382L539 269M390 382L102 382'/%3E%3Cpath d='M-222 42L126.5 79.5 370 105 539 269 577.5 41.5 927 80 769 229 902 382 603 493 731 737M295-36L577.5 41.5M578 842L295 764M40-201L127 80M102 382L-261 269'/%3E%3C/g%3E%3Cg fill='%23530000'%3E%3Ccircle cx='769' cy='229' r='5'/%3E%3Ccircle cx='539' cy='269' r='5'/%3E%3Ccircle cx='603' cy='493' r='5'/%3E%3Ccircle cx='731' cy='737' r='5'/%3E%3Ccircle cx='520' cy='660' r='5'/%3E%3Ccircle cx='309' cy='538' r='5'/%3E%3Ccircle cx='295' cy='764' r='5'/%3E%3Ccircle cx='40' cy='599' r='5'/%3E%3Ccircle cx='102' cy='382' r='5'/%3E%3Ccircle cx='127' cy='80' r='5'/%3E%3Ccircle cx='370' cy='105' r='5'/%3E%3Ccircle cx='578' cy='42' r='5'/%3E%3Ccircle cx='237' cy='261' r='5'/%3E%3Ccircle cx='390' cy='382' r='5'/%3E%3C/g%3E%3C/svg%3E");}


  </style>
</head>

<body>
  
    <div class="logo-container">
        <img src="images/lapor.png" class="logo">
        <a class="navbar-brand" href="iindex.html" style="color: #ffffff; font-weight: bold;">lAPOR PAK!!</a>
      </div>
       <div class="form-holder">
    <div class="form-content">
      <div class="form-items">
        <h3>Buat Laporanmu!</h3>
        <p>Tambah laporan yang ingin kamu sampaikan</p>
        <form method="post" action="" enctype="multipart/form-data">
            <div class="mb-3 input-group">
                <span class="input-group-text"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#808080" class="bi bi-person-fill" viewBox="0 0 16 16">
                    <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6"/>
                  </svg>
                  </span>
                <input class="form-control" type="text" name="NIK" placeholder="NIK" required>
              </div>
              
              <div class="mb-3 input-group">
                <span class="input-group-text"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#808080" class="bi bi-person-fill" viewBox="0 0 16 16">
                <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6"/>
              </svg>
              </span>
            <input class="form-control" type="text" name="nama" placeholder="Nama" required>
          </div>
          <div class="mb-3 input-group">
            <span class="input-group-text"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#808080" class="bi bi-telephone-fill" viewBox="0 0 16 16">
                <path fill-rule="evenodd" d="M1.885.511a1.745 1.745 0 0 1 2.61.163L6.29 2.98c.329.423.445.974.315 1.494l-.547 2.19a.68.68 0 0 0 .178.643l2.457 2.457a.68.68 0 0 0 .644.178l2.189-.547a1.75 1.75 0 0 1 1.494.315l2.306 1.794c.829.645.905 1.87.163 2.611l-1.034 1.034c-.74.74-1.846 1.065-2.877.702a18.6 18.6 0 0 1-7.01-4.42 18.6 18.6 0 0 1-4.42-7.009c-.362-1.03-.037-2.137.703-2.877z"/>
              </svg>
              </span>
            <input class="form-control" type="number" name="telp" placeholder="No. Telpon" required>
          </div>
            <div class="mb-3 input-group">
                <span class="input-group-text"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#808080" class="bi bi-calendar2-fill" viewBox="0 0 16 16">
                    <path d="M4 .5a.5.5 0 0 0-1 0V1H2a2 2 0 0 0-2 2v11a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V3a2 2 0 0 0-2-2h-1V.5a.5.5 0 0 0-1 0V1H4zM2.545 3h10.91c.3 0 .545.224.545.5v1c0 .276-.244.5-.546.5H2.545C2.245 5 2 4.776 2 4.5v-1c0-.276.244-.5.545-.5"/>
                </svg>
                </span>
                <input class="form-control" type="date" name="tgl_pengaduan" placeholder="Tanggal Pengaduan" required>
            </div>
            
          <div class="mb-3 input-group">
            <span class="input-group-text">
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#808080" class="bi bi-flag-fill" viewBox="0 0 16 16">
                <path d="M14.778.085A.5.5 0 0 1 15 .5V8a.5.5 0 0 1-.314.464L14.5 8l.186.464-.003.001-.006.003-.023.009a12 12 0 0 1-.397.15c-.264.095-.631.223-1.047.35-.816.252-1.879.523-2.71.523-.847 0-1.548-.28-2.158-.525l-.028-.01C7.68 8.71 7.14 8.5 6.5 8.5c-.7 0-1.638.23-2.437.477A20 20 0 0 0 3 9.342V15.5a.5.5 0 0 1-1 0V.5a.5.5 0 0 1 1 0v.282c.226-.079.496-.17.79-.26C4.606.272 5.67 0 6.5 0c.84 0 1.524.277 2.121.519l.043.018C9.286.788 9.828 1 10.5 1c.7 0 1.638-.23 2.437-.477a20 20 0 0 0 1.349-.476l.019-.007.004-.002h.001"/>
              </svg>
            </span>
            <textarea class="form-control" name="isi_laporan" placeholder="Isi Laporan" rows="4" required></textarea>
          </div>
          <div class="mb-3 input-group">
          <span class="input-group-text"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-image" viewBox="0 0 16 16">
          <path d="M6.002 5.5a1.5   1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0"/>
          <path d="M2.002 1a2 2 0 0 0-2 2v10a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V3a2 2 0 0 0-2-2zm12 1a1 1 0 0 1 1 1v6.5l-3.777-1.947a.5.5 0 0 0-.577.093l-3.71 3.71-2.66-1.772a.5.5 0 0 0-.63.062L1.002 12V3a1 1 0 0 1 1-1z"/>
        </svg></span>
          <input class="form-control" type="file" name="gambar" id="gambar" accept="image/*" required>
        </div>
          <div class="d-grid gap-5">
            <div class="row">
              <div class="col-5">
                <button id="submit" type="submit" class="btn btn-primary">Submit</button>
              </div>
              <div class="col-7">
                <button type="button" class="btn btn-danger ml-1 w-70">Cancel</button>
              </div>
              
            </div>
          </div>
          <br>
          <a href="datapengaduan.php">lihat Pengaduan lainnya</a>
        </form>
      </div>
    </div>
  </div>

  <!-- Bootstrap JS and Popper.js (Optional) -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
