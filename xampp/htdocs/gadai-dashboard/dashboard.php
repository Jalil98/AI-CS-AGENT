<?php
$conn = new mysqli("localhost", "root", "", "gadai_db");
$result = $conn->query("SELECT * FROM reports ORDER BY created_at DESC");
?>

<!DOCTYPE html>
<html>
<head>
<title>Dashboard Gadai</title>
<style>
body { font-family: Arial; background:#f4f6f9; }
table { width:90%; margin:auto; border-collapse: collapse; background:white; }
th, td { padding:10px; border:1px solid #ddd; text-align:center; }
th { background:#2c3e50; color:white; }
</style>
</head>
<body>

<h2 style="text-align:center;">Dashboard Reporting Gadai</h2>

<table>
<tr>
<th>Nama</th>
<th>Jenis</th>
<th>Pertanyaan</th>
<th>Estimasi</th>
<th>Waktu</th>
</tr>

<?php while($row = $result->fetch_assoc()): ?>
<tr>
<td><?= $row['nama_user'] ?></td>
<td><?= $row['jenis_barang'] ?></td>
<td><?= $row['pertanyaan'] ?></td>
<td>Rp <?= number_format($row['estimasi'],0,",",".") ?></td>
<td><?= $row['created_at'] ?></td>
</tr>
<?php endwhile; ?>

</table>
</body>
</html>