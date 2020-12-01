<?php

function plugins() { ?>
	<link rel="stylesheet" href="/pelaporan-sampah/assets/plugins/bootstrap-more/css/bootstrap.min.css">
	<link rel="stylesheet" href="/pelaporan-sampah/assets/dist/css2/components.css">
	<script src="/pelaporan-sampah/assets/dist/jquery.min.js"></script>
	<script src="/pelaporan-sampah/assets/dist/sweetalert/sweetalert.min.js"></script>
<?php }
require('../../../koneksi.php');

// SUBMIT MASYARAKAT
if (isset($_POST['submit_pekerja'])) {
	$nik_pekerja = $_POST['nik_pekerja'];
	$nama_pekerja = $_POST['nama_pekerja'];
	$jenis_kelamin_pekerja = $_POST['jenis_kelamin_pekerja'];
	$usia_pekerja = $_POST['usia_pekerja'];
	$alamat_pekerja = $_POST['alamat_pekerja'];
	$latling_pekerja = "-";
	$telpon_pekerja = $_POST['telpon_pekerja'];
	$kelurahan_pekerja = $_POST['kelurahan_pekerja'];
	$password = password_hash($nik_pekerja, PASSWORD_DEFAULT);
	$area_pekerja = $_POST['area_pekerja'];
	$kendaraan_pekerja = $_POST['kendaraan_pekerja'];
	$status_pekerja = "Aktif";
	$status_kerja_pekerja = "Off";

	// SET FOTO
	$foto = $_FILES['foto_pekerja']['name'];
	$ext = pathinfo($foto, PATHINFO_EXTENSION);
	$nama_foto = "image_".time().".".$ext;
    $file_tmp = $_FILES['foto_pekerja']['tmp_name'];

    // TAMBAH DATA
	$query= "INSERT INTO tb_pekerja VALUES (NULL, '$nik_pekerja', '$nama_pekerja', '$alamat_pekerja', '$telpon_pekerja','$usia_pekerja', '$kelurahan_pekerja', '-', '$password', '$nama_foto', '$status_pekerja', 'Sudah')";
	mysqli_query($conn, $query);
	if (mysqli_affected_rows($conn) > 0) {
		move_uploaded_file($file_tmp, 'foto/'.$nama_foto);
		plugins(); ?>
		<script>
			$(document).ready(function() {
				swal({
					title: 'Berhasil',
					text: 'Data Pekerja Berhasil ditambah!',
					icon: 'success'
				}).then((data) => {
					location.href = 'data.php';
				});
			});
		</script>
	<?php }
}


// UPDATE MASYARAKAT
if (isset($_POST['edit_pekerja'])) {
	$id_pekerja = $_POST['id_pekerja'];
	$nik_pekerja = $_POST['nik_pekerja'];
	$nama_pekerja = $_POST['nama_pekerja'];
	$alamat_pekerja = $_POST['alamat_pekerja'];
	$telpon_pekerja = $_POST['telpon_pekerja'];
	$usia_pekerja = $_POST['usia_pekerja'];
	$kelurahan_pekerja = $_POST['kelurahan_pekerja'];
	// $password = password_hash($nik_pekerja, PASSWORD_DEFAULT);
	// $status_pekerja = "Aktif";

    // SET FOTO
	if ($_FILES['foto_pekerja']['name'] != '') {
		$foto = $_FILES['foto_pekerja']['name'];
		$ext = pathinfo($foto, PATHINFO_EXTENSION);
		$nama_foto = "image_".time().".".$ext;
		$file_tmp = $_FILES['foto_pekerja']['tmp_name'];
		// HAPUS OLD FOTO
		$target = "foto/".$_POST['foto_now'];
		if (file_exists($target) && $_POST['foto_now'] != 'default.png') unlink($target);
		// UPLOAD NEW FOTO
		move_uploaded_file($file_tmp, 'foto/'.$nama_foto);
	} else {
		$nama_foto = $_POST['foto_now'];
	}
		$query = "UPDATE tb_pekerja SET nik_pekerja = '$nik_pekerja',
											nama_pekerja = '$nama_pekerja',
											alamat_pekerja = '$alamat_pekerja',
											telpon_pekerja = '$telpon_pekerja',
											usia_pekerja = '$usia_pekerja',
											kelurahan_pekerja = '$kelurahan_pekerja',
											foto_pekerja = '$nama_foto' WHERE id_pekerja = '$id_pekerja'";
		mysqli_query($conn, $query);
	// EDIT PARTAI
	if (mysqli_affected_rows($conn) > 0) {
		plugins(); ?>
		<script>
			$(document).ready(function() {
				swal({
					title: 'Berhasil',
					text: 'Data Pekerja berhasil diubah',
					icon: 'success'
				}).then((data) => {
					location.href = 'data.php';
				});
			});
		</script>
	<?php }
}


// HAPUS ADMIN
if (isset($_GET['hapus_pekerja'])) {
	$id_pekerja = $_GET['id_pekerja'];

	$query = "DELETE FROM tb_pekerja WHERE id_pekerja = '$id_pekerja'";
	mysqli_query($conn, $query);
	if (mysqli_affected_rows($conn) > 0) {
		plugins(); ?>
		<script>
			$(document).ready(function() {
				swal({
					title: 'Berhasil Dihapus',
					text: 'Data Pekerja berhasil dihapus',
					icon: 'success'
				}).then((data) => {
					location.href = 'data.php';
				});
			});
		</script>
	<?php }
}

?>