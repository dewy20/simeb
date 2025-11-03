<?php
include_once '../includes/header.php';
include_once '../includes/sidebar.php';
include_once '../config/class-mebel.php';
include_once '../config/class-kategori.php';

$kat = new Kategori();
$mebel = new Mebel();
$kats = $kat->getAllKategori();

if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['save'])){
    $data = [
        'nama_mebel' => $_POST['nama_mebel'],
        'harga' => (int)$_POST['harga'],
        'stok' => (int)$_POST['stok'],
        'kategori_id' => (int)$_POST['kategori_id'],
        'deskripsi' => $_POST['deskripsi']
    ];
    $ok = $mebel->inputMebel($data);
    if($ok) echo '<div class="alert alert-success">Data berhasil disimpan.</div>';
    else echo '<div class="alert alert-danger">Gagal menyimpan data.</div>';
}
?>
<div class="container">
  <div class="card p-4">
    <h4>Input Data Mebel</h4>
    <form method="post">
      <div class="form-group">
        <label>Nama Produk</label>
        <input required class="form-control" name="nama_mebel">
      </div>
      <div class="form-group">
        <label>Harga</label>
        <input required type="number" class="form-control" name="harga" min="0">
      </div>
      <div class="form-group">
        <label>Stok</label>
        <input required type="number" class="form-control" name="stok" min="0" value="1">
      </div>
      <div class="form-group">
        <label>Kategori</label>
        <select name="kategori_id" class="form-control" required>
          <option value="">-- Pilih Kategori --</option>
          <?php while($r = $kats->fetch_assoc()): ?>
            <option value="<?php echo $r['id_kategori'];?>"><?php echo $r['nama_kategori'];?></option>
          <?php endwhile; ?>
        </select>
      </div>
      <div class="form-group">
        <label>Deskripsi</label>
        <textarea name="deskripsi" class="form-control"></textarea>
      </div>
      <button name="save" class="btn btn-primary">Submit</button>
    </form>
  </div>
</div>
<?php include_once '../includes/footer.php'; ?>