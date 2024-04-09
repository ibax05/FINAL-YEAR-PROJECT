<?php
// Sambung database
include("connection.php");

// Query
$sql = "SELECT * FROM table_status WHERE status_pemohonan ='Ditolak'";
$result = $conn->query($sql);
if ($result) {
    




?>

<!DOCTYPE html>
<html>
<head>
<title>Permohonan Diapprove</title>

<!-- Google Fonts -->
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">



<!-- Stylesheet -->
<style>
body {
  font-family: 'Poppins', sans-serif;
  background: #f8f9fa;  
}

.wrapper {
  padding: 30px;
  max-width: 100%;
  margin: 50px auto;
  background: #ffffff;
  border-radius: 15px;
  box-shadow: 0 4px 8px rgba(0,0,0,0.1);
  transition: transform 0.3s ease-in-out;
}

.wrapper:hover {
  transform: translateY(-5px);
}

.table {
  width: 100%;
  border-collapse: collapse;
  margin-top: 20px;
}

.table thead {
  background: #007bff;
  color: #ffffff;
}

.table thead tr th {
  font-size: 16px;
  font-weight: 700;
  letter-spacing: 1px;
  padding: 15px;
  border-bottom: 2px solid #dee2e6;
}

.table tbody tr td {
  font-size: 14px;
  letter-spacing: 0.5px;
  font-weight: 500;
  padding: 10px;
  text-align: center;
  border-bottom: 1px solid #dee2e6;
}

.table tbody tr:hover {
  background-color: #f8f9fa;
}

@media (max-width: 768px) {
  .wrapper {
    margin: 20px;
    padding: 20px;
  }
}

.btn-primary {
  background-color: #007bff;
  color: #fff;
  
  padding: 12px 25px;
  border: none;
  border-radius: 3px;
  
  font-size: 16px;
  font-weight: 600;
  letter-spacing: 1px;
  
  transition: all 0.3s ease;  
}

.btn-primary:hover {
  background-color: #0062cc;
  transform: translateY(-2px);
  box-shadow: 0 2px 10px rgba(0,0,0,.2);
}

</style>

</head>
<body>

<div class="wrapper">

  <h1>Senarai Permohonan Ditolak</h1>
  
  <table class="table">
  
    <thead>
      <tr>
        <th>Id Tempahan Makanan</th>
        <th>Nama Pemohon</th>
        <th>Tarikh Permohonan</th>  
        <th>Status</th>
        <th>Aksi</th>
      </tr>
    </thead>
    
    <tbody>
    
    <?php while($row = $result->fetch_assoc()) { ?>
    
      <tr>
        <td><?php echo $row['id_tempahan_makanan']; ?></td>
        <td><?php echo $row['Nama_pemohon']; ?></td>
        <td><?php echo $row['Tarikh_Memohon']; ?></td> 
        <td>
          <span style="background-color: red; color: white; padding: 5px 10px; border-radius: 5px;">Ditolak</span>
        </td>
        <td>
        <a href="delete.php?id_tempahan_makanan=<?php echo $row['id_tempahan_makanan']; ?>&user_id=<?php echo $row['user_id']; ?>">
                    <i class="fa-solid fa-trash" style="color: red;"></i>
        </a>
        </td> 
      </tr>
      
    <?php } ?>
    
    </tbody>
    
  </table>
  
</div>
<div class="text-center mt-5">
         <button onclick="window.location.href='dashboard.php'" class="btn btn-primary btn-lg">Kembali</button>  
</div>
<script src="https://kit.fontawesome.com/42211e8bf7.js" crossorigin="anonymous"></script>
</body>
</html>
<?php 
    } 
    else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }?>

