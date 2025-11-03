<?php
include_once '../includes/header.php';
include_once '../includes/sidebar.php';
include_once '../config/class-mebel.php';

$mebel = new Mebel();

// Hapus
if(isset($_GET['delete'])){
    $id = (int)$_GET['delete'];
    $mebel->deleteMebel($id);
    echo '<div class="alert alert-success">Data dihapus.</div>';
}

$res = $mebel->getAllMebel();
?>
<div class="container">
  <div class="card p-3">
    <h4>Daftar Mebel</h4>
    <table class="table table-striped">
      <thead><tr><th>#</th><th>Nama</th><th>Harga</th><th>Stok</th><th>Kategori</th><th>Aksi</th></tr></thead>
      <tbody>
        <?php $i=1; while($row = $res->fetch_assoc()): ?>
          <tr>
            <td><?php echo $i++;?></td>
            <td><?php echo htmlspecialchars($row['nama_mebel']);?></td>
            <td><?php echo number_format($row['harga'],0,',','.');?></td>
            <td><?php echo $row['stok'];?></td>
            <td><?php echo $row['nama_kategori'];?></td>
            <td>
              <!-- Edit simple: link to same page could be implement later -->
              <a class="btn btn-sm btn-danger" href="?delete=<?php echo $row['id_mebel'];?>" onclick="return confirm('Yakin ingin hapus?')">Hapus</a>
            </td>
          </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  </div>
</div>
<?php include_once '../includes/footer.php'; ?>