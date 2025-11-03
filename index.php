<?php
include_once 'includes/header.php';
include_once 'includes/sidebar.php';
?>
<div class="content">
  <div class="container mt-4">
    <div class="card p-4 shadow-sm">
        <h3>Selamat Datang di SIMEB!</h3>
        <p>SIMEB adalah Sistem Informasi CRUD Mebel untuk mengelola data mebel dan kategori mebel.</p>
        <div class="mt-3">
            <a href="pages/input-mebel.php" class="btn btn-primary">🪑 Input Data Mebel</a>
            <a href="pages/daftar-mebel.php" class="btn btn-success">📋 Lihat Daftar Mebel</a>
            <a href="pages/cari-mebel.php" class="btn btn-warning">🔍 Cari Mebel</a>
        </div>
    </div>
  </div>
</div>
<?php include_once 'includes/footer.php'; ?>