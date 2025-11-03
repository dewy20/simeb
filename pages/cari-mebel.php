<?php
include_once '../includes/header.php';
include_once '../includes/sidebar.php';
include_once '../config/class-mebel.php';

$mebel = new Mebel();
$results = null;
$keyword = '';

if($_SERVER['REQUEST_METHOD']=='GET' && isset($_GET['q'])){
    $keyword = trim($_GET['q']);
    $results = $mebel->cariMebel($keyword);
}
?>
<div class="container">
  <div class="card p-3">
    <h4>Cari Mebel</h4>
    <form method="get" class="form-inline mb-3">
      <input class="form-control mr-2" name="q" placeholder="Nama mebel..." value="<?php echo htmlspecialchars($keyword);?>">
      <button class="btn btn-primary" type="submit">Cari</button>
    </form>

    <?php if($results): ?>
    <table class="table table-bordered">
      <thead><tr><th>#</th><th>Nama</th><th>Harga</th><th>Kategori</th></tr></thead>
      <tbody>
        <?php $i=1; while($r = $results->fetch_assoc()): ?>
          <tr>
            <td><?php echo $i++;?></td>
            <td><?php echo htmlspecialchars($r['nama_mebel']);?></td>
            <td><?php echo number_format($r['harga'],0,',','.');?></td>
            <td><?php echo $r['nama_kategori'];?></td>
          </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
    <?php elseif($keyword !== ''): ?>
      <div class="alert alert-warning">Tidak ditemukan hasil untuk "<strong><?php echo htmlspecialchars($keyword);?></strong>"</div>
    <?php endif; ?>
  </div>
</div>
<?php include_once '../includes/footer.php'; ?>