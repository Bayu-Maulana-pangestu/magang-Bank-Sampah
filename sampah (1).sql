-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Waktu pembuatan: 09 Jul 2024 pada 02.25
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sampah`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `nasabah`
--

CREATE TABLE `nasabah` (
  `id` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `email` varchar(200) NOT NULL,
  `jenis_kelamin` enum('Laki-laki','Perempuan') NOT NULL,
  `no_hp` varchar(20) NOT NULL,
  `alamat` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `nasabah`
--

INSERT INTO `nasabah` (`id`, `id_user`, `nama`, `email`, `jenis_kelamin`, `no_hp`, `alamat`) VALUES
(1, 7, 'bayu maulana', 'tes@tes.com', 'Laki-laki', '085751603191', 'Jl. H. Mistar Cokrokusumo'),
(2, 5, 'saruwati', '123@gmail.com', 'Perempuan', '09080808080', 'banjarmasin');

-- --------------------------------------------------------

--
-- Struktur dari tabel `penarikan`
--

CREATE TABLE `penarikan` (
  `id_penarikan` int(11) NOT NULL,
  `id_user` int(11) DEFAULT NULL,
  `jumlah` decimal(10,2) DEFAULT NULL,
  `tanggal` datetime DEFAULT current_timestamp(),
  `status` enum('Belum disetujui','Disetujui','Ditolak') DEFAULT 'Belum disetujui'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `penarikan`
--

INSERT INTO `penarikan` (`id_penarikan`, `id_user`, `jumlah`, `tanggal`, `status`) VALUES
(4, 7, 2000.00, '2024-06-27 09:37:06', 'Ditolak'),
(5, 7, 1000.00, '2024-06-27 09:39:59', 'Disetujui'),
(6, 7, 1000.00, '2024-06-27 09:41:03', 'Disetujui'),
(7, 5, 2000.00, '2024-06-27 10:03:28', 'Ditolak'),
(8, 7, 2000.00, '2024-06-27 12:41:25', 'Disetujui'),
(9, 7, 1000.00, '2024-06-27 12:42:14', 'Disetujui'),
(10, 7, 1000.00, '2024-07-01 12:36:06', 'Ditolak'),
(11, 7, 2000.00, '2024-07-01 23:13:54', 'Ditolak'),
(12, 7, 2000.00, '2024-07-01 23:18:47', 'Ditolak'),
(13, 7, 1000.00, '2024-07-01 23:19:26', 'Ditolak'),
(14, 7, 2000.00, '2024-07-01 23:30:49', 'Ditolak'),
(15, 7, 2000.00, '2024-07-03 08:10:58', 'Disetujui');

-- --------------------------------------------------------

--
-- Struktur dari tabel `saldo`
--

CREATE TABLE `saldo` (
  `id` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `saldo` decimal(10,2) NOT NULL DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `saldo`
--

INSERT INTO `saldo` (`id`, `id_user`, `saldo`) VALUES
(1, 7, 64000.00),
(2, 5, 5000.00);

-- --------------------------------------------------------

--
-- Struktur dari tabel `sampah`
--

CREATE TABLE `sampah` (
  `id_sampah` int(11) NOT NULL,
  `jenis_sampah` varchar(255) NOT NULL,
  `harga` int(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `sampah`
--

INSERT INTO `sampah` (`id_sampah`, `jenis_sampah`, `harga`) VALUES
(4, 'kayu', 1000),
(5, 'baja', 2000),
(7, 'plastik', 1000),
(8, 'besi', 1000),
(9, 'kaleng', 5000),
(10, 'tulang', 1000);

-- --------------------------------------------------------

--
-- Struktur dari tabel `transaksi`
--

CREATE TABLE `transaksi` (
  `id_transaksi` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_sampah` int(11) NOT NULL,
  `tanggal` date NOT NULL,
  `jumlah_beli` int(10) NOT NULL,
  `total_harga` int(10) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `transaksi`
--

INSERT INTO `transaksi` (`id_transaksi`, `id_user`, `id_sampah`, `tanggal`, `jumlah_beli`, `total_harga`, `created_at`) VALUES
(21, 7, 5, '2024-06-27', 2, 4000, '2024-06-27 02:36:54'),
(22, 7, 4, '2024-06-27', 2, 2000, '2024-06-27 02:58:29'),
(23, 5, 9, '2024-06-27', 1, 5000, '2024-06-27 03:03:13'),
(24, 7, 7, '2024-06-28', 2, 2000, '2024-06-27 05:42:04'),
(25, 7, 4, '2024-06-28', 2, 2000, '2024-06-28 01:24:29'),
(26, 7, 9, '2024-06-28', 1, 5000, '2024-06-28 01:25:05'),
(27, 7, 5, '2024-07-01', 22, 44000, '2024-07-01 15:59:17'),
(29, 7, 5, '2024-07-02', 5, 10000, '2024-07-02 02:39:43'),
(30, 7, 4, '2024-07-02', 2, 2000, '2024-07-02 02:40:26'),
(31, 7, 5, '2024-07-02', 2, 4000, '2024-07-02 02:45:29'),
(32, 7, 4, '2024-07-02', 1, 1000, '2024-07-02 02:49:50'),
(33, 7, 8, '2024-07-02', 1, 1000, '2024-07-02 02:52:05'),
(34, 7, 8, '2024-07-02', 1, 1000, '2024-07-02 02:57:18'),
(35, 5, 4, '2024-07-02', 2, 2000, '2024-07-02 02:57:35'),
(36, 7, 7, '2024-07-02', 5, 5000, '2024-07-02 03:12:00'),
(37, 7, 5, '2024-07-07', 3, 6000, '2024-07-02 03:14:01');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id_user` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password_hash` char(60) NOT NULL,
  `role` enum('masyarakat','admin') NOT NULL DEFAULT 'masyarakat'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id_user`, `username`, `email`, `password_hash`, `role`) VALUES
(5, 'saru', '123@gmail.com', '$2y$10$3/4S3845YC5fqPz5H6cBVOAuS/QiN9SeOyoG5btvwHhxJmopenpeS', 'masyarakat'),
(6, 'admin', 'admin@gmail.com', '$2y$10$3f0hyB0hcIAEcZdVQexgJuRxs4YbHQv14RC8xaqJ3dBMqjEMUckj.', 'admin'),
(7, 'bayu', 'tes@tes.com', '$2y$10$Ky/fk8WlyaAdXMNdVkocee0PvwKV06BRjVot3RIaGGBV9JjZNeNKW', 'masyarakat'),
(8, 'hana', 'hana@gmail.com', '$2y$10$xykUKPgPZ9XgALp1a/AkIONS07ZJ/4ev7jyi.sC8iv1yNxEVbGM1W', 'masyarakat');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `nasabah`
--
ALTER TABLE `nasabah`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`id_user`);

--
-- Indeks untuk tabel `penarikan`
--
ALTER TABLE `penarikan`
  ADD PRIMARY KEY (`id_penarikan`),
  ADD KEY `id_user` (`id_user`);

--
-- Indeks untuk tabel `saldo`
--
ALTER TABLE `saldo`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_user` (`id_user`);

--
-- Indeks untuk tabel `sampah`
--
ALTER TABLE `sampah`
  ADD PRIMARY KEY (`id_sampah`);

--
-- Indeks untuk tabel `transaksi`
--
ALTER TABLE `transaksi`
  ADD PRIMARY KEY (`id_transaksi`),
  ADD KEY `id_sampah` (`id_sampah`),
  ADD KEY `id_user` (`id_user`) USING BTREE;

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `nasabah`
--
ALTER TABLE `nasabah`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `penarikan`
--
ALTER TABLE `penarikan`
  MODIFY `id_penarikan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT untuk tabel `saldo`
--
ALTER TABLE `saldo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `sampah`
--
ALTER TABLE `sampah`
  MODIFY `id_sampah` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT untuk tabel `transaksi`
--
ALTER TABLE `transaksi`
  MODIFY `id_transaksi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `nasabah`
--
ALTER TABLE `nasabah`
  ADD CONSTRAINT `nasabah_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`);

--
-- Ketidakleluasaan untuk tabel `penarikan`
--
ALTER TABLE `penarikan`
  ADD CONSTRAINT `penarikan_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`);

--
-- Ketidakleluasaan untuk tabel `saldo`
--
ALTER TABLE `saldo`
  ADD CONSTRAINT `saldo_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`);

--
-- Ketidakleluasaan untuk tabel `transaksi`
--
ALTER TABLE `transaksi`
  ADD CONSTRAINT `transaksi_ibfk_1` FOREIGN KEY (`id_sampah`) REFERENCES `sampah` (`id_sampah`),
  ADD CONSTRAINT `transaksi_ibfk_2` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
