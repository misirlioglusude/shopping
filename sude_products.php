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
    <body>
        <h1><?php echo "List of products"; ?></h1>
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
                      echo '<td><form method="post" action="cart.php">'
                        .'<input type="hidden" name="id" value="'.$row["id"].'">'
                        .'<input type="submit" name ="submit" value="Add">'
                        .'</form></td>';
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
