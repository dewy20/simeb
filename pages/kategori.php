<?php
include_once '../includes/header.php';
include_once '../includes/sidebar.php';
include_once '../config/class-kategori.php';

$k = new Kategori();

if($_SERVER['REQUEST_METHOD']=='POST' && isset($_POST['add'])){
    $nama = trim($_POST['nama_kategori']);
    if($nama!='') $k->inputKategori($nama);
}

if(isset($_GET['del'])){
    $id = (int)$_GET['del'];
    $k->deleteKategori($id);
    echo '<div class="alert alert-success">Kategori dihapus.</div>';
}

$res = $k->getAllKategori();
?>
<div class="container">
  <div class="card p-3">
    <h4>Data Kategori</h4>
    <form method="post" class="form-inline mb-3">
      <input class="form-control mr-2" name="nama_kategori" placeholder="Nama kategori" required>
      <button class="btn btn-primary" name="add">Tambah</button>
    </form>

    <table class="table table-striped">
      <thead><tr><th>#</th><th>Nama Kategori</th><th>Aksi</th></tr></thead>
      <tbody>
        <?php $i=1; while($row = $res->fetch_assoc()): ?>
          <tr>
            <td><?php echo $i++;?></td>
            <td><?php echo htmlspecialchars($row['nama_kategori']);?></td>
            <td><a class="btn btn-sm btn-danger" href="?del=<?php echo $row['id_kategori'];?>" onclick="return confirm('Hapus kategori?')">Hapus</a></td>
          </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  </div>
</div>

<?php include_once '../includes/footer.php'; ?>