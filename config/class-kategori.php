<?php
include_once 'db-config.php';

class Kategori extends Database {
    public function getAllKategori(){
        $query = "SELECT * FROM tb_kategori ORDER BY nama_kategori";
        return $this->conn->query($query);
    }

    public function getKategoriById($id){
        $stmt = $this->conn->prepare("SELECT * FROM tb_kategori WHERE id_kategori=?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function inputKategori($nama){
        $stmt = $this->conn->prepare("INSERT INTO tb_kategori (nama_kategori) VALUES (?)");
        $stmt->bind_param("s", $nama);
        return $stmt->execute();
    }

    public function deleteKategori($id){
        $stmt = $this->conn->prepare("DELETE FROM tb_kategori WHERE id_kategori=?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
}
?>