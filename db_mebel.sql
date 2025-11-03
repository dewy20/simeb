-- Database: db_mebel
CREATE DATABASE IF NOT EXISTS db_mebel DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE db_mebel;

CREATE TABLE IF NOT EXISTS tb_kategori (
  id_kategori INT AUTO_INCREMENT PRIMARY KEY,
  nama_kategori VARCHAR(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS tb_mebel (
  id_mebel INT AUTO_INCREMENT PRIMARY KEY,
  nama_mebel VARCHAR(255) NOT NULL,
  harga INT DEFAULT 0,
  stok INT DEFAULT 0,
  kategori_id INT,
  deskripsi TEXT,
  FOREIGN KEY (kategori_id) REFERENCES tb_kategori(id_kategori) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO tb_kategori (nama_kategori) VALUES ('Kursi'),('Meja'),('Lemari');