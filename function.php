<?php 
$conn = mysqli_connect("localhost", "root", "", "makanan");

function query($query) {
	global $conn;
	$result = mysqli_query($conn, $query);
	$rows = [];
	while($row = mysqli_fetch_assoc($result)) {
	$rows[] = $row;
	}
	return $rows;
}



function tambah($data) {
	global $conn;
	$nama = htmlspecialchars($data["nama"]);
	$harga = htmlspecialchars($data["harga"]);
	 
	$gambar = upload();
	if( !$gambar ) {
		return false;
	}

	$query = "INSERT INTO menu
				VALUES
				('', '$nama', '$harga', '$gambar')
				";
	mysqli_query($conn, $query);

	return mysqli_affected_rows($conn);
}

function upload() {

	$namaFile = $_FILES['gambar']['name'];
	$ukuranFile = $_FILES['gambar']['size'];
	$error = $_FILES['gambar']['error'];
	$tmpName = $_FILES['gambar']['tmp_name'];

	// cek apakah toidak ada gambar yang di upload
	if( $error === 4 ) {
		echo "<script>
                alert('pilih gabar terlebih dahulu!');
		      </script>";
		    return false;
	}

	// cek apakah yang di uploaad adalah gambar
	$ekstensiGambarValid = ['jpg', 'jpeg', 'png'];
	$ekstensiGambar = explode('.', $namaFile);
	$ekstensiGambar = strtolower (end($ekstensiGambar));
	if( !in_array($ekstensiGambar, $ekstensiGambarValid) ) {
		echo "<script>
                alert('yang anda upload bukan gambar!')
		      </script>";
	    return false;
	}

	// cek jika ukuran terlalu besar
	if( $ukuranFile > 10000000 ) {
		echo "<script>
                alert('ukuran gambar terlalu besar!')
		      </script>";
	    return false;
	}

	// lolos pengecekan, gambar siap di upload
	$namaFileBaru = uniqid(); 
    $namaFileBaru .='.';
    $namaFileBaru .= $ekstensiGambar;
	move_uploaded_file($tmpName, 'image/' . $namaFileBaru);
	return $namaFileBaru;
    }




function hapus($id) {
	global $conn;
	mysqli_query($conn, "DELETE FROM menu WHERE id = $id");
	return mysqli_affected_rows($conn);
}



function edit($data) {
	global $conn;
	$id = $data["id"];
	$nama = htmlspecialchars($data["nama"]);
	$harga = htmlspecialchars($data["harga"]);
	$gambarLama = htmlspecialchars($data["gambarLama"]);

    if ( $_FILES['gambar']['error'] === 4){
    $gambar = $gambarLama;
  }  else {
    $gambar = upload();
  }

	$query = " UPDATE menu SET
				nama = '$nama',
				harga = '$harga',
				gambar = '$gambar'
				WHERE id = $id
				";
	mysqli_query($conn, $query);

	return mysqli_affected_rows($conn);
}


function cari($keyword) {
	$query = "SELECT * FROM menu
	            WHERE
              nama = '$keyword'
             ";
    return query($query);
}


function registrasi($data) {
	global $conn;

	$username = strtolower(stripcslashes($data["username"]));
	$password = mysqli_real_escape_string($conn, $data["password"]);
    $password2 = mysqli_real_escape_string($conn, $data["password2"]);

    $result = mysqli_query($conn, "SELECT username FROM user WHERE username = '$username'");

    if( mysqli_fetch_assoc($result) ) {
	 	echo "<script>
	 			alert('username sudah terdaftar')
	 			</script>";
	 			return false;
	 }

    if( $password !== $password2 ) {
		echo "<script>
				alert('konfirmasi tidak sesuai!');
			</script>";

			return false;

	}
    $password = pasword_hash($password, PASSWORD_DEFAULT);

    mysqli_query($conn, "INSERT  INTO user VALUES('', '$username', '$password')");

    return mysqli_affected_rows($conn);



 }

 ?>