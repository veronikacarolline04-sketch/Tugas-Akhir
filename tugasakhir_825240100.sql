-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 06 Des 2025 pada 17.11
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
-- Database: `tugasakhir`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `admin`
--

CREATE TABLE `admin` (
  `admin_ID` char(2) NOT NULL,
  `admin_USER` char(30) NOT NULL,
  `admin_PASS` char(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `admin`
--

INSERT INTO `admin` (`admin_ID`, `admin_USER`, `admin_PASS`) VALUES
('11', 'paes@yahoo.com', '123');

-- --------------------------------------------------------

--
-- Struktur dari tabel `bimbinganskripsi`
--

CREATE TABLE `bimbinganskripsi` (
  `dosen_NIDN` char(10) NOT NULL,
  `mhs_NPM` int(9) NOT NULL,
  `bimbingan_TANGGAL` date NOT NULL,
  `bimbingan_ISI` text NOT NULL,
  `bimbingan_DOKUMEN` char(90) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `bimbinganskripsi`
--

INSERT INTO `bimbinganskripsi` (`dosen_NIDN`, `mhs_NPM`, `bimbingan_TANGGAL`, `bimbingan_ISI`, `bimbingan_DOKUMEN`) VALUES
('0007653205', 23110001, '0000-00-00', 'bimbingan skripsi pertama', 'dokumen pdf.pdf'),
('0007653205', 23110002, '2025-12-16', 'bimbingan skripsi kedua', 'dokumen pdf.pdf');

-- --------------------------------------------------------

--
-- Struktur dari tabel `daftarseminar`
--

CREATE TABLE `daftarseminar` (
  `mhs_NPM` int(9) NOT NULL,
  `seminar_Nama` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `daftarseminar`
--

INSERT INTO `daftarseminar` (`mhs_NPM`, `seminar_Nama`) VALUES
(23110004, 'satu dua tiga empat lima'),
(23110002, 'satu dua tiga');

-- --------------------------------------------------------

--
-- Struktur dari tabel `dosen`
--

CREATE TABLE `dosen` (
  `dosen_NIDN` char(10) NOT NULL,
  `dosen_NIK` char(8) NOT NULL,
  `dosen_Nama` char(30) NOT NULL,
  `dosen_Ket` varchar(160) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `dosen`
--

INSERT INTO `dosen` (`dosen_NIDN`, `dosen_NIK`, `dosen_Nama`, `dosen_Ket`) VALUES
('0007653205', '31790232', 'Drs. Hendra Wijaya, M.M', 'Dosen Tetap, Bisnis Digital Marketing'),
('0007653274', '31781221', 'Drh. Veronika', 'Dosen Tetap, Kedokteran Hewan'),
('0008765403', '31771254', 'Ir. Bambang Santoso, M.Eng', 'Dosen Tidak Tetap, Teknik Informatika'),
('0009347807', '31775278', 'Prof. Dr. Iwan Saputra', 'Dosen Tetap, Ilmu Komputer'),
('0012345601', '31781234', 'Dr. Andi Rahman, M.Kom', 'Dosen Tetap, Sistem Informasi'),
('0014356810', '31786268', 'Dr. Nabila Purnama, M.Sc', 'Dosen Tidak Tetap, Data Science'),
('0016532406', '31784234', 'Dr. Laila Amalia, M.Kom', 'Dosen Tidak Tetap, Sistem Informasi'),
('0018765408', '31782254', 'Dr. Maya Sari, M.Kom', 'Dosen Tetap, Rekayasa Perangkat Lunak'),
('0019874502', '31791245', 'Dr. Siti Nurjanah, M.Sc', 'Dosen Tetap, Sains Komputer'),
('0021457909', '31789279', 'Dr. Yusuf Mahendra, M.T', 'Dosen Tetap, Teknik Komputer'),
('0023456704', '31783256', 'Dr. Rina Febriyanti, M.T', 'Dosen Tetap, Teknologi Informasi');

-- --------------------------------------------------------

--
-- Struktur dari tabel `jadwalseminar`
--

CREATE TABLE `jadwalseminar` (
  `seminar_Nama` varchar(100) NOT NULL,
  `seminar_Tanggal` date NOT NULL,
  `seminar_Waktu` time NOT NULL,
  `seminar_Ruangan` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `jadwalseminar`
--

INSERT INTO `jadwalseminar` (`seminar_Nama`, `seminar_Tanggal`, `seminar_Waktu`, `seminar_Ruangan`) VALUES
('satu dua tiga', '2025-11-12', '14:58:00', 'Auditorium'),
('satu dua tiga empat lima', '2025-11-04', '15:29:00', 'Auditorium lt. 1');

-- --------------------------------------------------------

--
-- Struktur dari tabel `mahasiswa`
--

CREATE TABLE `mahasiswa` (
  `mhs_NPM` int(9) NOT NULL,
  `mhs_Nama` char(40) NOT NULL,
  `mhs_Alamat` varchar(100) NOT NULL,
  `mhs_DOB` date NOT NULL,
  `mhs_Ket` varchar(120) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `mahasiswa`
--

INSERT INTO `mahasiswa` (`mhs_NPM`, `mhs_Nama`, `mhs_Alamat`, `mhs_DOB`, `mhs_Ket`) VALUES
(23110001, 'Ahmad Fadillah Susanto', 'Jl. Melati No. 12, Bandung', '2018-05-07', 'Mahasiswa berasal dari luar JKT'),
(23110002, 'Rina Anggraini', 'Jl. Cihanjuang No. 45, Kel. Cibabat, Kec. Cimahi Utara, Cimahi, Jawa Barat', '2002-06-04', 'Mahasiswa berasal dari luar JKT'),
(23110003, 'Dimas Pratama', 'Jl. Rawamangun No. 21, Kel. Rawamangun, Kec. Pulo Gadung, Jakarta Timur', '2025-11-12', 'Mahasiswa berasal dari JKT'),
(23110004, 'Siti Khairunnisa', 'Jl. Margonda Raya No. 88, Kel. Kemiri Muka, Kec. Beji, Depok, Jawa Barat', '2025-11-06', 'Mahasiswa berasal dari luar JKT'),
(23110005, 'Muhammad Alfarizi', 'Jl. Ahmad Yani No. 101, Kel. Ciwalen, Kec. Garut Kota, Garut, Jawa Barat', '2025-11-07', 'Mahasiswa berasal dari luar JKT'),
(23110006, 'Putri Melania', 'Jl. MH. Thamrin No. 10, Kel. Kebon Sirih, Kec. Menteng, Jakarta Pusat', '2025-10-28', 'Mahasiswa berasal dari JKT'),
(23110007, 'Kevin Saputra', 'Jl. Cikutra No. 15, Kel. Sukapada, Kec. Cibeunying Kidul, Bandung, Jawa Barat', '2025-11-25', 'Mahasiswa berasal dari luar JKT'),
(23110008, 'Nurul Lestari', 'Jl. Asia Afrika No. 20, Kel. Braga, Kec. Sumur Bandung, Kota Bandung, Jawa Barat', '2025-11-19', 'Mahasiswa berasal dari luar JKT'),
(23110009, 'Rizky Hernawan', 'Jl. Antapani No. 4, Kel. Antapani Kidul, Kec. Antapani, Bandung, Jawa Barat', '2025-11-12', 'Mahasiswa berasal dari luar JKT'),
(23110085, 'Velterra Cassandra', 'jalan satu dua tiga', '2025-12-09', 'Mahasiswa berasal dari luar JKT'),
(825190001, 'Cinta Kasih', 'Jl. Taman S.Parman', '2019-11-06', 'Mahasiswa berasal dari luar  JKT');

-- --------------------------------------------------------

--
-- Struktur dari tabel `penasihat`
--

CREATE TABLE `penasihat` (
  `mhs_NPM` int(9) NOT NULL,
  `dosen_NIDN` char(10) NOT NULL,
  `penasihat_FILE` char(60) NOT NULL,
  `penasihat_KET` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `penasihat`
--

INSERT INTO `penasihat` (`mhs_NPM`, `dosen_NIDN`, `penasihat_FILE`, `penasihat_KET`) VALUES
(23110008, '0023456704', 'download (8).jpg', 'Bimbingan dosen'),
(23110085, '0007653274', 'download (6).jpg', 'konsultasi akademik'),
(825190001, '2222', 'Screenshot 2025-09-11 002234.png', 'Bimbingan dosenn');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pesertaskripsi`
--

CREATE TABLE `pesertaskripsi` (
  `mhs_NPM` int(9) NOT NULL,
  `peserta_SMT` char(6) NOT NULL,
  `peserta_THAKD` char(9) NOT NULL,
  `peserta_TGLDAFTAR` date NOT NULL,
  `peserta_JUDUL` char(80) NOT NULL,
  `peserta_DOKUMEN` char(60) NOT NULL,
  `dosen_NIDN` char(10) NOT NULL,
  `peserta_KET` varchar(90) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `pesertaskripsi`
--

INSERT INTO `pesertaskripsi` (`mhs_NPM`, `peserta_SMT`, `peserta_THAKD`, `peserta_TGLDAFTAR`, `peserta_JUDUL`, `peserta_DOKUMEN`, `dosen_NIDN`, `peserta_KET`) VALUES
(23110001, 'Pilih', '2027-2028', '2025-12-17', 'Penerapan Metode Machine Learning untuk Prediksi Kelulusan Mahasiswa', 'download (8).jpg', '0021457909', 'satu dua tiga empat'),
(23110002, 'Genap', '2027-2028', '2025-12-10', 'Implementasi Metode K-Means untuk Pengelompokan Pelanggan pada Toko Retail', 'Tweets Of Hamster (@TweetsOfHamster) on X.jpg', '0007653274', 'satu dua tiga empat'),
(23110003, 'Ganjil', '2024-2025', '2025-12-18', 'Pengembangan Aplikasi Mobile Absensi Pegawai Menggunakan Flutter', 'download (8).jpg', '0021457909', 'satu dua tiga ');

-- --------------------------------------------------------

--
-- Struktur dari tabel `ujianskripsi`
--

CREATE TABLE `ujianskripsi` (
  `mhs_NPM` int(9) NOT NULL,
  `ujian_TANGGAL` date NOT NULL,
  `ujian_FOTO` char(60) NOT NULL,
  `ujian_WAKTU` time NOT NULL,
  `peserta_JUDUL` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `ujianskripsi`
--

INSERT INTO `ujianskripsi` (`mhs_NPM`, `ujian_TANGGAL`, `ujian_FOTO`, `ujian_WAKTU`, `peserta_JUDUL`) VALUES
(23110006, '2025-11-04', 'download (2).jpg', '13:45:00', NULL),
(825190001, '2025-11-23', 'ham.jpg', '16:39:00', NULL),
(23110001, '2025-12-17', 'download (8).jpg', '13:34:00', ''),
(23110002, '2025-12-23', 'Tweets Of Hamster (@TweetsOfHamster) on X.jpg', '10:40:00', '');

-- --------------------------------------------------------

--
-- Struktur dari tabel `ukm`
--

CREATE TABLE `ukm` (
  `mhs_NPM` int(9) NOT NULL,
  `ukm_NAMA` varchar(60) NOT NULL,
  `ukm_KET` text NOT NULL,
  `ukm_FOTO` char(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `ukm`
--

INSERT INTO `ukm` (`mhs_NPM`, `ukm_NAMA`, `ukm_KET`, `ukm_FOTO`) VALUES
(23110004, 'UKM Voli', 'melatih voli', 'download (7).jpg');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`admin_ID`);

--
-- Indeks untuk tabel `dosen`
--
ALTER TABLE `dosen`
  ADD PRIMARY KEY (`dosen_NIDN`);

--
-- Indeks untuk tabel `mahasiswa`
--
ALTER TABLE `mahasiswa`
  ADD PRIMARY KEY (`mhs_NPM`);

--
-- Indeks untuk tabel `penasihat`
--
ALTER TABLE `penasihat`
  ADD PRIMARY KEY (`mhs_NPM`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
