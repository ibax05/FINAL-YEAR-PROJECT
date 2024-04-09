<?php
include("connection.php");

if(isset($_GET['id_tempahan_makanan']) && isset($_GET['user_id']) ) {
    $user_id = $_GET['user_id'];
    $id_tempahan_makanan = $_GET['id_tempahan_makanan'];

    // Query untuk mendapatkan detail permohonan berdasarkan ID pengguna
    $result = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM table_makanan WHERE id_tempahan_makanan = $id_tempahan_makanan AND user_id = $user_id"));
    $previous_memo = $result['memo_name'];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Memo</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
.memo-container {
    max-width: 100%; /* Menyesuaikan maksimum lebar container dengan lebar elemen induk */
    margin: 0 auto; /* Pusatkan container */
    border: 1px solid #ccc; /* Garis pinggir memo */
    padding: 20px; /* Ruang dalam memo */
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); /* Efek bayangan */
    border-radius: 5px; /* Sudut memo yang melengkung */
}

.memo-container img {
    max-width: 100%; /* Gambar memenuhi lebar container */
    height: auto; /* Tinggi gambar disesuaikan */
    display: block; /* Posisikan gambar sebagai blok untuk mengatur margin */
    margin: 0 auto; /* Pusatkan gambar */
    border-radius: 5px; /* Sudut gambar yang melengkung */
}
    </style>
    
</head>
<body>
<div class="container">
    <div class="memo-container">

        
        <?php
        // ...
        if ($result) {
        $memo_path = $result['memo_path'];
        $memo_extension = strtolower(pathinfo($memo_path, PATHINFO_EXTENSION));
        $memo_name = $result['memo_name'];

        if (in_array($memo_extension, array("jpg", "jpeg", "png", "gif"))) {
        // Menampilkan gambar
        echo "<h2>MEMO</h3>";
        echo "<img src='./uploads/$memo_name' alt='Gambar'>";
       } elseif ($memo_extension == "pdf") {
        // Menampilkan PDF
        echo "<embed src='./uploads/$memo_name' width='100%' height='1000px' type='application/pdf'>";
       } else {
        // Format file tidak didukung
        echo "Format file tidak didukung";
        }
      } else {
      // Permohonan tidak ditemukan
     echo "Permohonan tidak ditemukan";
      }
?>

        <div class="text-center mt-3">
            <a href="javascript:history.back()" class="btn btn-primary">Kembali</a>
        </div>

    </div>
</div>
<?php

?>

</body>
</html>
<?php
}
?>
