<?php
$conn = new mysqli("localhost", "root", "", "gadai_db");

if ($conn->connect_error) {
    die("DB gagal");
}

$data = json_decode(file_get_contents("php://input"), true);

$nama_user = $data['nama_user'];
$jenis_barang = $data['jenis_barang'];
$pertanyaan = $data['pertanyaan'];
$estimasi = $data['estimasi'];

if (!$estimasi || $estimasi <= 0) {
    exit;
}

$stmt = $conn->prepare("INSERT INTO reports (nama_user, jenis_barang, pertanyaan, estimasi) VALUES (?, ?, ?, ?)");
$stmt->bind_param("sssi", $nama_user, $jenis_barang, $pertanyaan, $estimasi);
$stmt->execute();

echo "OK";
?>