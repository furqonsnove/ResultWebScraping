<?php
$keyword = $_POST['keyword']; // Ambil data keyword yang dikirim dengan AJAX
// Load view.php
ob_start();
include "view.php";
$html = ob_get_contents(); // Masukan isi dari view.php ke dalam variabel $html
ob_end_clean();
// Buat array dengan index hasil dan value nya $html
// Lalu konversi menjadi JSON
echo json_encode(array('hasil'=>$html));
?>