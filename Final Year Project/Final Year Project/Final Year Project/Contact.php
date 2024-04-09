<?php
ini_set('session.gc_maxlifetime', 3600); // Menetapkan masa tamat sesi kepada 1 jam (3600 saat)
session_start(); // Memulakan sesi
include("connection.php");


if(isset($_SESSION['id']) || isset($_GET['user_id']) && isset($_GET['id_tempahan_makanan'])) {
    $user_id = $_SESSION['id'];
    $id_tempahan_makanan = $_GET['id_tempahan_makanan'];

    // Query untuk mendapatkan detail permohonan berdasarkan ID pengguna
    //$result =  mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM table_makanan WHERE id_tempahan_makanan = $id_tempahan_makanan AND user_id  = $user_id"));
    $sql = "SELECT tm.*, r.Email 
        FROM table_makanan tm
        JOIN register r ON r.id = tm.user_id
        WHERE tm.id_tempahan_makanan = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_tempahan_makanan);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();









?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aduan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            background-color: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            width: 100%;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }

        input[type="text"],
        input[type="email"],
        textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
            background-color: #f9f9f9;
            color: #333;
        }

        input[type="submit"] {
            background-color: #007bff;
            color: white;
            padding: 15px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
            font-size: 16px;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Hubungi Kami</h2>
        <form action="process_contact.php" method="post">
            <input type="hidden" name="user_id" value="<?php echo $row['user_id']; ?>">
            <input type="hidden" name="Unit_Bahagian" value="<?php echo $row['Unit_Bahagian']; ?>">
            <input type="hidden" name="id_tempahan_makanan" value="<?php echo $row['id_tempahan_makanan']; ?>">
            <input type="text" id="name" name="name" value="<?php echo $row['Nama_Pegawai']; ?>" required>
            <input type="email" id="email" name="email" value="<?php echo $row['Email']; ?>" required>
            <input type="text" id="subject" name="subject" placeholder="Subject" required>
            <textarea id="message" name="message" rows="5" placeholder="Pesan" required></textarea>
            <input type="submit" value="Submit">
        </form>
    </div>
</body>
</html>
<?php } ?>
