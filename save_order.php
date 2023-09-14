<?php
session_start();

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
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Cart</title>
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
        $customer = $_POST['customer'];
        $address = $_POST['address'];
        
        $sql= "INSERT INTO orders (customer, address) VALUES ('".$customer."','".$address."')";
        $result = $conn->query($sql);
        
        if ($result === TRUE) {
            $last_id = $conn->insert_id;
            
            $cart = $_SESSION['cart'];
            
            $new_cart = [];
            foreach($cart as $value) {
                if (!in_array($value, $new_cart)){
                    $new_cart[] = $value;
                }
            }         
            
            foreach ($new_cart as $value) {
                $quontity = 0;
                foreach ($cart as $product) {
                    if ($product == $value){
                        $quontity++;
                    }
                }
                        
                $sql= "INSERT INTO order_products (id_order, id_product, quontity) VALUES (".$last_id.",".$value.",".$quontity.")";
                $result = $conn->query($sql);
            }
            
            
            echo "Your order was created successfully.";
            $_SESSION['cart'] = [];
          } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
          }
        ?>
        <br>
        <a href="products.php">Back to products list</a> 
    </body>
</html>





