<?php
session_start();

if (isset($_SESSION['id_user']) && $_SESSION['id_user'] != null) {
    echo $_SESSION['id_user'];
} else {
    echo '<h1>Access fobidden.</h1>';
    echo "<a href='login.php'>Login</a>";
    exit;
}

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

$delete_message = false;
if(isset($_GET['action']) && $_GET['action'] == 'delete'){
    if(isset($_GET['id'])){
        $id = $_GET['id'];
        $sql = "DELETE FROM products WHERE id = ".$id;
        $result = $conn->query($sql);
        $delete_message = true;
    }
}

if(isset($_GET['action']) && $_GET['action'] == 'edit'){
    if(isset($_GET['id'])){
        
        $result = $conn->query($sql);
    }
}


$sql = "SELECT id, name, price FROM products";
$result = $conn->query($sql);




?>

<!DOCTYPE html>
<html>
    <head>
        <title>List of products</title>
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
    <form method="post" action="add_product.php">
        <input type="submit" name ="add" value="Add">
    </form>
    <body>
        <h1><?php echo "List of products"; ?></h1>
        <?php
        if(isset($_GET['message']) && $_GET['message'] == 'add_product')
            echo '<h2>Product has been added successfully.</h2>';
        if(isset($_GET['message']) && $_GET['message'] == 'edit_product')
            echo '<h2>Product has been updated successfully.</h2>';
        if ($delete_message) 
             echo '<h2>Product has been deleted successfully.</h2>';
                
        ?>
        <table>
            <thead>
                <tr>
                    <td>Name</td>
                    <td>Price</td>
                    <td></td>
                </tr>
            </thead>
                
            <tbody>
                <?php
                
                 if ($result->num_rows > 0) {
                    // output data of each row
                     
                    while($row = $result->fetch_assoc()) {
                        
                      echo "<tr>";  
                      echo "<td>".$row["name"]."</td>";
                      echo "<td>".$row["price"]."</td>";
                      echo '<td>'
                      . '<a href="add_product.php?id='.$row["id"].'&action=edit" >Edit</a> &nbsp; '
                      . '<a href="manage_products.php?id='.$row["id"].'&action=delete" >Delete</a> ';
                      echo "</tr>";
                       }
                  } else {
                    echo "0 results";
                  }
                  $conn->close();

                ?>

            </tbody>
        </table>
        
        
    </body>
    
    <br>
        <a href="cart.php">Go to cart</a> 
</html>

