<?php
$databaseHost = 'localhost';
$databaseName = 'poliklinik';
$databaseUsername = 'root';
$databasePassword = '';

$hostname = "localhost";
$user = "root";
$password = "";
$db_name ="poliklinik";

$koneksi = mysqli_connect($hostname,$user,$password,$db_name) or die (mysqli_error($koneksi));
$mysqli = mysqli_connect($databaseHost,
    $databaseUsername, $databasePassword,$databaseName) ;


// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// SQL query to join two tables
$sql = "SELECT * FROM table1 INNER JOIN table2 ON table1.periksa = table2.obat";

if ($result = $conn->query($sql)) {
  if ($result->num_rows > 0) {
    // Output data of each row
    while ($row = $result->fetch_assoc()) {
      echo "column1: " . $row["column1"] . " - column2: " . $row["column2"] . "<br>";
    }
  } else {
    echo "0 results";
  }
} else {
  echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>