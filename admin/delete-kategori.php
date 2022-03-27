<?php 
session_start();
include '../dbconnect.php';

if (!isset($_SESSION["login"])) {
    header("Location: ../login.php");
    exit;
}

if (!isset($_SESSION["admin"])) {
    header("Location: ../index.php");
    exit;
}

// Get id from URL to delete that user
$id = $_GET['id'];
 
// Delete user row from table based on given id
$result = mysqli_query($conn, "DELETE FROM kategori WHERE idkategori=$id");
 
// After delete redirect to Home, so that latest user list will be displayed.
header("Location: kategori.php");
?>