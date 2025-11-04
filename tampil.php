<?php
include "koneksi.php";

// --- Tambah Data ---
if (isset($_POST['simpan'])) {
  $nama = $_POST['nama'];
  $alamat = $_POST['alamat'];
  $tgl_lahir = $_POST['tgl_lahir'];
  mysqli_query($conn, "INSERT INTO pegawai (nama, alamat, tgl_lahir) VALUES ('$nama','$alamat','$tgl_lahir')");
  header("Location: tampil.php");
  exit;
}

// --- Update Data ---
if (isset($_POST['update'])) {
  $id = $_POST['id'];
  $nama = $_POST['nama'];
  $alamat = $_POST['alamat'];
  $tgl_lahir = $_POST['tgl_lahir'];
  mysqli_query($conn, "UPDATE pegawai SET nama='$nama', alamat='$alamat', tgl_lahir='$tgl_lahir' WHERE id='$id'");
  header("Location: tampil.php");
  exit;
}

// --- Hapus Data ---
if (isset($_GET['hapus'])) {
  $id = $_GET['hapus'];
  mysqli_query($conn, "DELETE FROM pegawai WHERE id='$id'");
  header("Location: tampil.php");
  exit;
}

// --- Cek Edit Mode ---
$editMode = false;
if (isset($_GET['update'])) {
  $editMode = true;
  $id = $_GET['update'];
  $editData = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM pegawai WHERE id='$id'"));
}

$result = mysqli_query($conn, "SELECT * FROM pegawai ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Data Pegawai</title>
  <style>
    body {
      background: #121212;
      color: #f1f1f1;
      font-family: Arial, sans-serif;
    }
    .container {
      width: 50%;
      margin: 30px auto;
    }
    table {
      width: 100%;
      border-collapse: collapse;
      background: #1e1e1e;
    }
    th, td {
      padding: 10px;
      border-bottom: 1px solid #333;
    }
    th {
      background: #222;
    }
    a {
      color: #00adb5;
      text-decoration: none;
    }
    a:hover {
      text-decoration: underline;
    }
    .form-box {
      background: #1e1e1e;
      padding: 20px;
      border-radius: 10px;
      margin-bottom: 25px;
    }
    input, button {
      width: 100%;
      padding: 10px;
      margin: 5px 0;
      border: none;
      border-radius: 5px;
    }
    input {
      background: #2b2b2b;
      color: white;
    }
    button {
      background: #00adb5;
      color: white;
      cursor: pointer;
    }
    button:hover {
      background: #08c2c9;
    }
  </style>
</head>
<body>

<div class="container">
  <h2>📋 Manajemen Pegawai</h2>

  <div class="form-box">
    <form method="POST">
      <?php if ($editMode) { ?>
        <input type="hidden" name="id" value="<?= $editData['id']; ?>">
      <?php } ?>

      <input type="text" name="nama" placeholder="Nama Pegawai" value="<?= $editMode ? $editData['nama'] : '' ?>" required>
      <input type="text" name="alamat" placeholder="Alamat" value="<?= $editMode ? $editData['alamat'] : '' ?>" required>
      <input type="date" name="tgl_lahir" value="<?= $editMode ? $editData['tgl_lahir'] : '' ?>" required>

      <button type="submit" name="<?= $editMode ? 'update' : 'simpan'; ?>">
        <?= $editMode ? '💾 Simpan Perubahan' : '➕ Tambah Pegawai'; ?>
      </button>

      <?php if ($editMode) { ?>
        <a href="tampil.php" style="display:block;text-align:center;margin-top:8px;">Batal Edit</a>
      <?php } ?>
    </form>
  </div>

  <table>
    <tr>
      <th>ID</th>
      <th>Nama</th>
      <th>Alamat</th>
      <th>Tanggal Lahir</th>
      <th>Aksi</th>
    </tr>
    <?php while ($row = mysqli_fetch_assoc($result)) { ?>
      <tr>
        <td><?= $row['id']; ?></td>
        <td><?= $row['nama']; ?></td>
        <td><?= $row['alamat']; ?></td>
        <td><?= $row['tgl_lahir']; ?></td>
        <td>
          <a href="tampil.php?update=<?= $row['id']; ?>">✏️ Update</a> |
          <a href="tampil.php?hapus=<?= $row['id']; ?>" onclick="return confirm('Yakin mau hapus data ini?')">🗑️ Hapus</a>
        </td>
      </tr>
    <?php } ?>
  </table>
</div>

</body>
</html>
