<?php
include_once 'db-config.php';

class Mebel extends Database 
{
    public function getAllMebel(){
        $query = "SELECT m.*, k.nama_kategori FROM tb_mebel m 
                  LEFT JOIN tb_kategori k ON m.kategori_id = k.id_kategori
                  ORDER BY m.id_mebel DESC";
        return $this->conn->query($query);
    }

    public function getMebelById($id){
        $stmt = $this->conn->prepare("SELECT * FROM tb_mebel WHERE id_mebel=?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function inputMebel($data){
        $stmt = $this->conn->prepare("INSERT INTO tb_mebel (nama_mebel, harga, stok, kategori_id, deskripsi) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("siiis", $data['nama_mebel'], $data['harga'], $data['stok'], $data['kategori_id'], $data['deskripsi']);
        return $stmt->execute();
    }

    public function updateMebel($data){
        $stmt = $this->conn->prepare("UPDATE tb_mebel SET nama_mebel=?, harga=?, stok=?, kategori_id=?, deskripsi=? WHERE id_mebel=?");
        $stmt->bind_param("siiisi", $data['nama_mebel'], $data['harga'], $data['stok'], $data['kategori_id'], $data['deskripsi'], $data['id_mebel']);
        return $stmt->execute();
    }

    public function deleteMebel($id){
        $stmt = $this->conn->prepare("DELETE FROM tb_mebel WHERE id_mebel=?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }

    public function cariMebel($keyword){
        $like = "%{$keyword}%";
        $stmt = $this->conn->prepare("SELECT m.*, k.nama_kategori FROM tb_mebel m LEFT JOIN tb_kategori k ON m.kategori_id=k.id_kategori WHERE m.nama_mebel LIKE ? ORDER BY m.id_mebel DESC");
        $stmt->bind_param("s", $like);
        $stmt->execute();
        return $stmt->get_result();
    }
}
?>