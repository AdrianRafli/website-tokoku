<?php 
// hide error messages
// error_reporting(0);

// isi nama host, username mysql, dan password mysql anda
$conn = mysqli_connect("localhost","root","","tokoku");

// Remote Database
// $conn = mysqli_connect("remotemysql.com","lXypJsq1eu","MkxUI2sJUu","lXypJsq1eu");

if(!$conn){
	echo "Gagal Koneksi Database";
} else {
	
};

?>