<?php

$servername = "localhost";
$username = "myshopadmin";
$password = "123456";
$dbname = "myshop";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}


$sql = "Select * from orders";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo 'Customer:' . $row["customer"].','.$row["address"]. '<br>';
        
        $sql2 = "Select p.name from order_products op inner "
                . "join products p on p.id_product = op.id_product"
                . "WHERE op.id_order = ". $row["id_order"];
        
        $result2 = $conn->query($sql2);
        if ($result2->num_rows > 0) {
            while($row2 = $result2->fetch_assoc()) {
                echo 'Product:' . $row2["name"]. '<br>';
            }
        }
   
    }
}
