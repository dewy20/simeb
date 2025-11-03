<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include_once '../includes/header.php';
include_once '../includes/sidebar.php';
include_once '../config/class-mebel.php';

class Mebel {
    private $conn;

    public function __construct() {
        $this->conn = new mysqli("localhost", "root", "", "mebel");
        if ($this->conn->connect_error) {
            die("Koneksi gagal: " . $this->conn->connect_error);
        }
    }

    public function getAllMebel() {
        return $this->conn->query("SELECT m.*, k.nama_kategori FROM mebel m JOIN kategori k ON m.id_kategori = k.id_kategori ORDER BY m.id_mebel DESC");
    }

    public function getAllKategori() {
        return $this->conn->query("SELECT * FROM kategori ORDER BY nama_kategori ASC");
    }

    public function addMebel($nama, $harga, $stok, $id_kategori) {
        $stmt = $this->conn->prepare("INSERT INTO mebel (nama_mebel, harga, stok, id_kategori) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("siii", $nama, $harga, $stok, $id_kategori);
        return $stmt->execute();
    }

    public function deleteMebel($id) {
        $stmt = $this->conn->prepare("DELETE FROM mebel WHERE id_mebel = ?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }

    public function copyMebel($id) {
        $stmt = $this->conn->prepare("SELECT nama_mebel, harga, stok, id_kategori FROM mebel WHERE id_mebel = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($row = $result->fetch_assoc()) {
            $stmt2 = $this->conn->prepare("INSERT INTO mebel (nama_mebel, harga, stok, id_kategori) VALUES (?, ?, ?, ?)");
            $stmt2->bind_param("siii", $row['nama_mebel'], $row['harga'], $row['stok'], $row['id_kategori']);
            return $stmt2->execute();
        }
        return false;
    }
}

$mebel = new Mebel();

// Tambah produk baru dari form
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['tambah'])) {
    $nama = $_POST['nama'];
    $harga = $_POST['harga'];
    $stok = $_POST['stok'];
    $kategori = $_POST['kategori'];

    if ($mebel->addMebel($nama, $harga, $stok, $kategori)) {
        echo '<div class="alert alert-success">Produk berhasil ditambahkan.</div>';
    } else {
        echo '<div class="alert alert-danger">Gagal menambahkan produk.</div>';
    }
}

// Tambah produk dari salinan
if (isset($_GET['copy'])) {
    $id = (int)$_GET['copy'];
    if ($mebel->copyMebel($id)) {
        echo '<div class="alert alert-success">Produk berhasil ditambahkan dari salinan.</div>';
    } else {
        echo '<div class="alert alert-danger">Gagal menyalin produk.</div>';
    }
}

// Hapus produk
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $mebel->deleteMebel($id);
    echo '<div class="alert alert-success">Produk berhasil dihapus.</div>';
}

$res = $mebel->getAllMebel();
?>

<div class="container">
  <div class="card p-3 mb-4">
    <h4>Tambah Produk Mebel</h4>
    <form method="POST">
      <div class="row mb-2">
        <div class="col-md-3">
          <input type="text" name="nama" class="form-control" placeholder="Nama Mebel" required>
        </div>
        <div class="col-md-2">
          <input type="number" name="harga" class="form-control" placeholder="Harga" required>
        </div>
        <div class="col-md-2">
          <input type="number" name="stok" class="form-control" placeholder="Stok" required>
        </div>
        <div class="col-md-3">
          <select name="kategori" class="form-control" required>
            <option value="">-- Pilih Kategori --</option>
            <?php
            $kategoriList = $mebel->getAllKategori();
            while ($kat = $kategoriList->fetch_assoc()) {
                echo '<option value="'.$kat['id_kategori'].'">'.$kat['nama_kategori'].'</option>';
            }
            ?>
          </select>
        </div>
        <div class="col-md-2">
          <button type="submit" name="tambah" class="btn btn-primary w-100">Tambah</button>
        </div>
      </div>
    </form>
  </div>

  <div class="card p-3">
    <h4>Daftar Mebel</h4>
    <table class="table table-striped">
      <thead>
        <tr>
          <th>#</th>
          <th>Nama</th>
          <th>Harga</th>
          <th>Stok</th>
          <th>Kategori</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php $i = 1; while ($row = $res->fetch_assoc()): ?>
          <tr>
            <td><?php echo $i++; ?></td>
            <td><?php echo htmlspecialchars($row['nama_mebel']); ?></td>
            <td><?php echo number_format($row['harga'], 0, ',', '.'); ?></td>
            <td><?php echo $row['stok']; ?></td>
            <td><?php echo $row['nama_kategori']; ?></td>
            <td>
              <a class="btn btn-sm btn-success" href="?copy=<?php echo $row['id_mebel']; ?>" onclick="return confirm('Yakin ingin menyalin produk ini?')">Tambahkan</a>
              <a class="btn btn-sm btn-danger" href="?delete=<?php echo $row['id_mebel']; ?>" onclick="return confirm('Yakin ingin menghapus produk ini?')">Hapus</a>
            </td>
          </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  </div>
</div>

<?php include_once '../includes/footer.php'; ?>
