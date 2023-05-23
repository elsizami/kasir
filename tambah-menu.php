<?php 
session_start();

// jika session ada dia bisa masuk ke halaman home, jika tidak ada kita lempar ke halaman login

if (empty($_SESSION['USERNAME'])) {
	header("location:index.php?login=access");
}

include 'koneksi.php';

// tampilkan seluruh data dari table user dimana urutannya dari yang terbesar ke terkecil

$query = mysqli_query($koneksi, "SELECT * From tbl_kategori ORDER BY id DESC");

// jika tombol bernama add diklik action adalah : masukan kedalam table use, dimana nilainya diambil dari inputan, fullname=inputan fullname.
// Jika berhasil lempar kehalaman user, kalo gagal kembali kehalaman tambah user

if (isset($_POST['add'])) {
	$id_kategori = $_POST['id_kategori'];
	$name = $_POST['name'];
	$price = $_POST['price'];
	$qty = $_POST['qty'];
	$description = $_POST['description'];
	

	$insert = mysqli_query($koneksi, "INSERT INTO tbl_menu (id_kategori, name, price, qty, description) VALUES ('$id_kategori','$name', '$price', '$qty', '$description')");

	if ($insert) {
		header("location:menu.php?tambah=berhasil");

	}
	
}

// Jika ada parameter yang bernama delete maka id diambil dari

if (isset($_GET['delete'])) {
$id = $_GET['delete']; //nilai id
$delete = mysqli_query($koneksi, "DELETE FROM tbl_menu WHERE id='$id'");
if ($delete) {
	header("location:menu.php?hapus=berhasil");
}else{
	header("location:menu.php?hapus=gagal");
	// echo("Error description: " . mysqli_error($koneksi));

}
}



// Jika parameter edit ada maka diambil dari nilai id
if (isset($_GET['edit'])) {
	$id = $_GET['edit'];

	$editData = mysqli_query($koneksi, "SELECT * FROM tbl_menu WHERE id= '$id'");

	$editData = mysqli_fetch_assoc($editData);
}


// edit: mengubah data yg sudah ada jadi baru berdasarkan primary key atau id
// lempar ke halaman user.

if (isset($_POST['edit'])) {
	$id_kategori= $_POST['id_kategori'];
	$name = $_POST['name'];
	$price = $_POST['price'];
	$qty = $_POST['qty'];
	$description = $_POST['description'];

	$update = mysqli_query($koneksi, "UPDATE tbl_menu SET id_kategori ='$id_kategori', name ='$name', price ='$price', qty='$qty', description ='$description' WHERE id='$id' ");


	
	if ($update) {
		header("location:menu.php?ubah=berhasil");

	}

}

$kategori = mysqli_query($koneksi, "SELECT * FROM tbl_kategori ORDER BY id DESC");



?>

<!DOCTYPE html>
<html lang="">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Home</title>
	<link rel="stylesheet" href="css/style.css">
	<!-- Bootstrap CSS -->
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

	<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
		<!--[if lt IE 9]>
			<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.2/html5shiv.min.js"></script>
			<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
		<![endif]-->
			<title>Edit Kategori</title>
		</head>
		<body>
			<?php include('inc/navbar.php') ?>
			
			<div class="container mt-5">
				<div class="row">
					<div class="col-sm-12">
						<div class="card">
							<div class="card-body">
								<div class="card-title">
									<!-- shortland if php -->
									<h3><?php echo isset($_GET['edit'])?'Edit':'Tambah' ?>Kategori Menu</h3>
								</div>
								<?php if (isset($_GET['edit'])): ?>
									<!-- disini form edit user -->

									<form method="post">
										<form method="post">
											<div class="form-group">
												<label>Kategori Menu *</label>
												<select type="text" name="id_kategori" class="form-control">
													<option value="">--Pilih Kategori--</option>
													<?php while($rowkategori =mysqli_fetch_assoc($kategori)) { ?>
														<option <?php echo ($editData['id_kategori'] == $rowkategori['id'])? 'selected':'' ?> value="<?php echo $rowkategori['id'] ?>">
															<?php echo $rowkategori['name'] ?> </option>
														<?php } ?>
													}
												</select>
											</div>

											<div class="form-group">
												<label>Nama menu *</label>
												<input type="text" name="name" class="form-control" placeholder="Nama Menu" value="<?php echo $editData['name'] ?>">
											</div>
											<div class="form-group">
												<label>Harga *</label>
												<input type="number" name="price" class="form-control" placeholder="Harga" value="<?php echo $editData['price'] ?>">
											</div>
											<div class="form-group">
												<label>Qty *</label>
												<<input type="number" name="qty" class="form-control" placeholder="Qty" value="<?php echo $editData['qty'] ?>">
											</div>
											<div class="form-group">
												<label>Keterangan</label>
												<textarea name="description" class="form-control" id="" cols="30" rows="10"><?php echo $editData['description'] ?>"</textarea>
											</div>
											<div class="form-group">
												<input type="submit" name="edit" class="btn btn-primary" value="Simpan">
											</div>
										</form>

									<?php else: ?>
										<!-- disini form tambah user-->
										<form method="post">
											<div class="form-group">
												<label>Kategori Menu *</label>
												<select type="text" name="id_kategori" class="form-control">
													<option value="">--pilih Kategori--</option>
													<?php while($rowKategori = mysqli_fetch_assoc($kategori)) { ?>
														<option value="<?php echo $rowkategori['id'] ?>">
															<?php echo $rowKategori['name'] ?> </option>
														<?php } ?>
													</select>

												</div>
												<div class="form-group">
														<label>Nama menu *</label>
														<input type="text" name="name" class="form-control" placeholder="Nama Menu">
													</div>
													<div class="form-group">
														<label>Harga *</label>
														<input type="number" name="price" class="form-control" placeholder="Harga">
													</div>
													<div class="form-group">
														<label>Qty *</label>
														<input type="number" name="qty" class="form-control" placeholder="Qty">
													</div>
													<div class="form-group">
														<label>Keterangan *</label>
														<textarea name="description" class="form-control" id="" cols="30" rows="10"></textarea>
													</div>
													<div class="form-group">
														<input type="submit" name="add" class="btn btn-primary mt-5" value="Simpan">
													</div>
												</form>
										<?php endif ?>
									</div>
								</div>
							</div>
						</div>	
					</div>

					<!-- jQuery -->
					<script src="//code.jquery.com/jquery.js"></script>
					<!-- Bootstrap JavaScript -->
					<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

				</body>
				</html>

