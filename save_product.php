<?php
session_start();

$servername = "localhost";
$username = "sudeAdmin";
$password = "123456";
$dbname = "sudeshop";
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


//sql queries:
$customerDetailSql = "SELECT id, customer, address FROM orders";
$customerDetailSql_result = $conn->query($customerDetailSql);

$orderDetailSql = "SELECT * FROM order_products INNER JOIN products ON products.id = order_products.id_product";
$orderDetailSql_result = $conn -> query($orderDetailSql);

?>

<!DOCTYPE html>
<html>
    <head>
        <title>Admin | Order Records</title>
        <meta charset="utf8">
        <style>
            table {
                width: 100%;
                border-collapse: collapse;
            }

            table, td {
                border: 1px solid black;
            }
        </style>
    </head>
    <body>
        <?php
        
        if($customerDetailSql_result -> num_rows > 0){
            //checking if any data is present in table: orders
            
            while($row = $customerDetailSql_result -> fetch_assoc()){
                //getting each row from the table: "Orders"
                
                //customer's details:
                echo "<p> Order Number: ".$row["id"]."</p>";
                echo "<p> Customer's Name: ".$row["customer"]."</p>";
                echo "<p> Customer's Address: ".$row["address"]."</p><br>";
                echo "<br>";
                
                if($orderDetailSql_result -> num_rows > 0){
                    //checking if any data is present in table: order_products
                    
                    while($row_detail = $orderDetailSql_result -> fetch_assoc()){
                        
                        if($row["id"] == $row_detail["id_order"]){
                            
                            echo "Product Name: ".$row_detail["name"].
                                 " Quantity Orderd: ".$row_detail["quontity"]."<br>";
                        }
                    }
                }
                else{
                    echo "0 results found from table: order_products";
                }
                echo "<br>";
            }
            
        }
        else {
            echo "0 result";
        }
        
        $conn -> close();
        ?>
        <br>
        <a href="./Products.php">To Product List</a> 
    </body>
</html>

