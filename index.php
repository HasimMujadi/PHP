<?php
require 'function.php';
$menu = query("SELECT * FROM menu");

// tombol cari ditekan
if( isset($_POST["cari"]) ) {
	$menu = cari($_POST["keyword"]);
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Belajar PHP</title>
</head>
<body>
	<h1>Daftar Menu</h1>
	<form action="" method="post">
	  <input type="text" name="keyword" size="25" autofocus placeholder="Masukan pencarian anda..." autocomplete="off">
	  <button type="submit" name="cari">Cari</button>
	</form>
	<br>
	<table border="1" cellpadding="10" cellspacing="0">
		<tr>
			<th>No.</th>
			<th>Aksi</th>
			<th>Nama</th>
			<th>Harga</th>
			<th>Gambar</th>
			
		</tr>
		<?php $i = 1; ?>
		<?php foreach( $menu as $row ) : ?>
		<tr>
			<td><?= $i; ?></td>
			<td>
				<a href="edit.php?id=<?= $row['id']; ?>">Edit</a>  |
				<a href="hapus.php?id=<?= $row['id']; ?>" onclick="return confirm('yakin???');">Hapus</a>
			</td>
			<td><?= $row["nama"]; ?></td>
			<td><?= $row["harga"]; ?></td>
			<td><img src="image/<?= $row["gambar"]; ?>"width="50"></td>
		<?php $i++ ;?>
	    <?php endforeach; ?>
	</table>	
	<br>
 	<a href="tambah.php">Tambah Menu</a>
  
		</tr>
</body>
</html>