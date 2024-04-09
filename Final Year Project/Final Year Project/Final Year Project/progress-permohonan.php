<?php
ini_set('session.gc_maxlifetime', 3600); // Menetapkan masa tamat sesi kepada 1 jam (3600 saat)
session_start(); // Memulakan sesi
// Koneksi database dan ambil data
include("connection.php");
// Query untuk ambil data

if (isset($_SESSION['id']) || isset($_GET['id'])) {
    $id = $_SESSION['id'];

    $result = mysqli_query($conn, "SELECT id_tempahan_makanan, user_id, Tarikh_Memohon, tujuan, status_pemohonan , Catatan FROM table_makanan WHERE user_id = $id");
    $result2 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM register WHERE id = $id"));
?>

    <!DOCTYPE html>
    <html>

    <head>
        <!-- Include file CSS -->
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Process System</title>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
        <!-- <link rel="stylesheet" type="text/css" href="css/progress-permohonan.css">-->
        <style>
            body {
                background-color: #f8f9fa; /* Membuat latar belakang lebih cerah untuk kenyamanan membaca */
            }

            .container {
                padding-top: 100px; /* Memberikan jarak atas yang cukup tanpa terlalu jauh */
            }

            h2 {
                text-align: center;
                padding: 20px 0; /* Memberikan padding yang lebih simetris */
                margin: 20px 0 50px 0; /* Mengurangi margin untuk lebih efisien */
                border-radius: 5px; /* Mengurangi radius untuk tampilan yang lebih modern */
                color: #333; /* Warna gelap untuk kontras yang lebih baik */
                background-color: #eee; /* Latar belakang ringan untuk judul */
            }

            td {
                border: 1px solid #dee2e6;
                text-align: center;
            }

            th {
                border: 1px solid #dee2e6;
                text-align: center;
            }

            th.th-tarikh {
                width: 12%;
            }

            th.th-Id {
                width: 10%;
            }

            th.th-tujuan {
                width: 24%;
            }

            th.th-status {
                width: 9%;
            }

            th.th-aksi {
                width: 50%;
            }

            th.th-comment {
                width: 38%;
            }

            td i {
                margin-right: 10px; /* Menambahkan ruang antara ikon-ikon */
            }

            /* Icon hover styles */
            td i:hover {
                color: orange; /* Ubah warna ikon saat dihover */
                cursor: pointer; /* Ubah kursor menjadi ikon tangan saat dihover */
            }

            @media (max-width: 768px) {
                .table-responsive {
                    overflow-x: auto; /* Menambahkan scroll horizontal pada tabel di perangkat kecil */
                }
            }
        </style>
    </head>

    <body>
        <header>
            <nav class="navbar fixed-top">
                <div class="container-fluid">
                    <div class="brand">
                        <img src="img/logo.jpeg" alt="logo" width="78">
                    </div>
                    <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="offcanvas offcanvas-end bg-light" tabindex="-1" id="offcanvasNavbar">
                        <div class="offcanvas-header border-bottom">
                            <h5 class="offcanvas-title" id="offcanvasNavbarLabel">Pegawai</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
                        </div>
                        <div class="offcanvas-body d-flex flex-column p-0">
                            <nav class="nav flex-column flex-grow-1">
                                <a href="form.php?id=<?= $result2["id"] ?>" class="nav-link text-dark  py-3 px-4 border-bottom">
                                    <i class="fa-solid fa-house"></i> Rumah
                                </a>
                                <a href="#" class="nav-link text-dark fw-bold py-3 px-4 border-bottom">
                                    <i class="fa-solid fa-hourglass-start"></i> Status Permohonan
                                </a>
                                <a href="update_profile.php?id=<?= $result2["id"] ?>" class="nav-link text-dark py-3 px-4 border-bottom">
                                    <i class="fa-solid fa-user"></i> Profil
                                </a>
                            </nav>
                            <div class="mt-auto">
                                <a href="logout.php" class="nav-link text-dark py-3 px-4">
                                    <i class="fa-solid fa-right-from-bracket"></i> Keluar
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </nav>
        </header>

        <div class="container">
            <!-- HTML for notifications -->
            <?php if (isset($_SESSION['success_message'])) : ?>
                <div id="success_message" style="background-color: #4CAF50; color: white; text-align: center; padding: 10px;">
                    <?php echo $_SESSION['success_message']; ?>
                </div>

                <?php unset($_SESSION['success_message']); ?>
            <?php endif; ?>

            <?php if (isset($_SESSION['error_message'])) : ?>
                <i class="fas fa-exclamation-circle mr-2"></i>
                <div id="error_message" style="background-color: #f44336; color: white; text-align: center; padding: 10px;">
                    <?php echo $_SESSION['error_message']; ?>
                </div>

                <?php unset($_SESSION['error_message']); ?>
            <?php endif; ?>

            <h2>Status Permohonan</h2>
            <table class="table table-responsive">
                <colgroup>
                    <col class="th-id">
                    <col class="th-tarikh">
                    <col class="th-tujuan">
                    <col class="th-status">
                    <col class="th-comment">
                    <col class="th-aksi">
                </colgroup>
                <thead>
                    <tr>
                        <th class="th-Id">Id Tempahan Makakanan</th>
                        <th class="th-tarikh">Tarikh Memohon</th>
                        <th class="th-tujuan">Tujuan</th>
                        <th class="th-comment">Catatan</th>
                        <th class="th-status">Status</th>
                        <th class="th-aksi">Tindakan</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Looping data hasil query MySQL, tampilkan dalam <tr>
                    while ($row = mysqli_fetch_assoc($result)) {
                        $status = $row['status_pemohonan'];
                        $statusColor = '';

                        switch ($status) {
                            case 'Dalam proses':
                                $statusColor = '#ffa807'; // Kuning
                                break;
                            case 'Diluluskan':
                                $statusColor = '#28a745'; // Hijau
                                break;
                            case 'Ditolak':
                                $statusColor = '#dc3545'; // Merah
                                break;
                            default:
                                $statusColor = '#000000'; // Hitam (warna lalai)
                        }

                        if (strcasecmp($row['status_pemohonan'], 'Dalam proses') == 0) {
                            echo "<tr>";
                            echo "<td>" . $row['id_tempahan_makanan'] . "</td>";
                            echo "<td>" . $row['Tarikh_Memohon'] . "</td>";
                            echo "<td style='text-align:left'>" . $row['tujuan'] . "</td>";
                            echo "<td style='text-align:left'>" . $row['Catatan'] . "</td>"; // Menambahkan sel kosong untuk kolom Comment
                            echo "<td style='color: $statusColor'>$status</td>";
                            echo '<td>';
                            

                            echo '<a href="update_permohonan_pegawai.php?user_id=' . $row['user_id'] . '&id_tempahan_makanan=' . $row['id_tempahan_makanan'] . '">';
                            echo '<i class="fa-solid fa-pen-to-square"></i>';
                            echo '</a>';

                            echo '<a href="delete_permohonan_pegawai.php?user_id=' . $row['user_id'] . '&id_tempahan_makanan=' . $row['id_tempahan_makanan'] . '">';
                            echo '<i class="fa-solid fa-trash text-danger"></i>';
                            echo '</a>';

                            echo '<a href="list_permohonan_pegawai.php?user_id=' . $row['user_id'] . '&id_tempahan_makanan=' . $row['id_tempahan_makanan'] . '">';
                            echo '<i class="fa-solid fa-file"></i>';
                            echo '</a>';

                            echo '<a href="Contact.php?user_id=' . $row['user_id'] . '&id_tempahan_makanan=' . $row['id_tempahan_makanan'] . '">';
                            echo '<i class="fa-regular fa-envelope"></i>';
                            echo '</a>';

                            echo '</td>';
                            echo "</tr>";
                        } elseif (strcasecmp($row['status_pemohonan'], 'Ditolak') == 0) {
                            echo "<tr>";
                            echo "<td>" . $row['id_tempahan_makanan'] . "</td>";
                            echo "<td>" . $row['Tarikh_Memohon'] . "</td>";
                            echo "<td style='text-align:left'>" . $row['tujuan'] . "</td>";
                            echo "<td style='text-align:left' >" . $row['Catatan'] . "</td>"; // Menambahkan sel kosong untuk kolom Comment
                            echo "<td style='color: $statusColor'>$status</td>";
                            echo '<td>';
                    

                            echo '<a href="delete_permohonan_pegawai.php?user_id=' . $row['user_id'] . '&id_tempahan_makanan=' . $row['id_tempahan_makanan'] . '">';
                            echo '<i class="fa-solid fa-trash text-danger"></i>';
                            echo '</a>';

                            echo '<a href="list_permohonan_pegawai.php?user_id=' . $row['user_id'] . '&id_tempahan_makanan=' . $row['id_tempahan_makanan'] . '">';
                            echo '<i class="fa-solid fa-file"></i>';
                            echo '</a>';

                            echo '</td>';
                            echo "</tr>";
                        } else {
                            echo "<tr>";
                            echo "<td>" . $row['id_tempahan_makanan'] . "</td>";
                            echo "<td>" . $row['Tarikh_Memohon'] . "</td>";
                            echo "<td style='text-align:left'>" . $row['tujuan'] . "</td>";
                            echo "<td style='text-align:left'>" . $row['Catatan'] . "</td>"; // Menambahkan sel kosong untuk kolom Comment
                            echo "<td style='color: $statusColor'>$status</td>";
                            echo '<td>';

                            echo '<a href="delete_permohonan_pegawai.php?user_id=' . $row['user_id'] . '&id_tempahan_makanan=' . $row['id_tempahan_makanan'] . '">';
                            echo '<i class="fa-solid fa-trash text-danger"></i>';
                            echo '</a>';

                            echo '<a href="list_permohonan_pegawai.php?user_id=' . $row['user_id'] . '&id_tempahan_makanan=' . $row['id_tempahan_makanan'] . '">';
                            echo '<i class="fa-solid fa-file"></i>';
                            echo '</a>';

                            echo '</td>';
                            echo "</tr>";
                        }
                    }
                    ?>
                </tbody>
            </table>
        </div>

        <!-- Script Bootstrap JS -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
        <script src="https://kit.fontawesome.com/42211e8bf7.js" crossorigin="anonymous"></script>
        <script>
            setTimeout(function() {
                document.getElementById('success_message').style.display = 'none';
            }, 7000); // Menghilangkan notifikasi setelah 10 detik (10000 milidetik)
        </script>
        <script>
            setTimeout(function() {
                document.getElementById('error_message').style.display = 'none';
            }, 7000); // Menghilangkan notifikasi setelah 10 detik (10000 milidetik)
        </script>
    </body>

    </html>

<?php
}
?>