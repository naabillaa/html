<!DOCTYPE html>
<html>
<head>
	<title>Pengaduan Masyarakat</title>
	<link rel="stylesheet" type="text/css" href="css/bootstrap.css">
	<script type="text/javascript" src="js/jquery.js"></script>
	<script type="text/javascript" src="js/bootstrap.js"></script>
    <meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
<style>
.table {
      border: 1px solid #dee2e6; /* Tambahkan border pada tabel */
    }

    .table th, .table td {
      border: 1px solid #dee2e6; /* Tambahkan border pada sel tabel */
    }

    .table th {
      text-align: center; /* Menengahkan teks pada elemen th */
    }
    .search{
      justify-content:center;
    }

</style>
	</head>
  <body>

  <h1 style="text-align:center;" >Data Pengaduan Masyarakat</h1>    

<div class="container"style=" padding:5%; container-shadow:black;">
<div class="search"style="center">

      <form class="form-inline"method="post">
      <a href="iindex.html" class="btn btn-danger mb-2">
  <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-bar-left" viewBox="0 0 16 16">
    <path fill-rule="evenodd" d="M12.5 15a.5.5 0 0 1-.5-.5v-13a.5.5 0 0 1 1 0v13a.5.5 0 0 1-.5.5M10 8a.5.5 0 0 1-.5.5H3.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L3.707 7.5H9.5a.5.5 0 0 1 .5.5"/>
  </svg>
</a>
      <label for="inputState" style="  margin-left: 10px; ">Cari Berdasarkan </label>
      <select id="inputState" class="form-control"name="pilih">
      <option value="id_pengaduan">ID Pengaduan</option>
            <option value="NIK">NIK</option>
            <option value="tgl_pengaduan">Tanggal Pengaduan</option>
            <option value="isi_laporan">Isi Laporan</option>
           
      </select>

  <div class="form-group mx-sm-3 mb-2">
    <label for="search" class="sr-only"name="cari" value="cari"name="tekscari">Cari</label>
    <input type="text" name="tekscari" class="form-control" id="search" placeholder="Cari apa">
  </div>
      <button type="submit" class="btn btn-primary mb-2" name="cari" value="cari"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
      <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0"/>
    </svg></button>
    <div class="form-group mx-sm-3 mb-2">
    <button  type="submit" class="btn btn-secondary mb-2" name="semua" value="Tampilkan semua">Tampilkan Semua</button>
    </form>
    </div>
<table class="table">
  <thead class="thead-dark">
    <tr>
 
      <th scope="col">Tanggal Pengaduan</th>
      <th scope="col">Isi Laporan</th>
      <th scope="col">Gambar</th>

    </tr>
  </thead>
  <tbody>
    <tr>

     <?php
   include"koneksi.php";
   $tampil="";
   if (isset($_POST['cari'])){
       $pilih = $_POST['pilih'];
       $tekscari = $_POST['tekscari'];
       $tampil = mysqli_query($koneksi, "select * from pengaduan where $pilih like '%$tekscari%'");
   }else {
    $tampil = mysqli_query($koneksi, "select * from pengaduan");
   }
   foreach($tampil as $row){
   ?>
<tr>
               
                <td><?php echo "$row[tgl_pengaduan]"; ?></td>
                <td><?php echo "$row[isi_laporan]"; ?></td>
             <center><td><img src="uploads/<?php echo $row['gambar']; ?>"style="width: 300px;height: 300;display: block; margin: 0 auto;"></td>
   </center>
               
</tr>
<?php
   }
?>
    
  </tbody>
</table>
</div>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>


</body>
</html>