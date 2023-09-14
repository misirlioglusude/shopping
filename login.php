<?php
session_start();
var_dump($_POST);
if(isset($_POST['submit'])) {
    $form_name = $_POST['name'];
    $form_surname = $_POST['surname'];
    $form_password = $_POST['password'];
    $hash = md5($form_password);
    
    $id_user = null;
    
    $servername = "localhost";
    $username = "myshopadmin";
    $password = "123456";
    $dbname = "hotel_Sude";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
    }
    $sql = "SELECT * FROM users WHERE username='".$form_username."' AND password = '". $hash."'";
    var_dump($sql);
    $result = $conn->query($sql);
    if ($result->num_rows == 1) {
        //user exist
        while($row = $result->fetch_assoc()) {
            $id_user = $row["id_user"];
        }
    }
    
    if ($id_user == null) {
        $_SESSION['id_user'] = null; 
        $message = 'Login failed';
    } else {
        $_SESSION['id_user'] = $id_user;
        var_dump($id_user);
        header('Location: manage_products.php');
    }
}
    

?>

<!DOCTYPE html>
<html>
    <head>
        <title>Sude's Hotel</title>
        <meta charset="utf8">

    </head>
    <body>
        <?php
        if(isset($message)){
            echo '<h1>'.$message. '</h1>';
        }
        ?>
       
        <form action="login.php" method="POST">
            Username: <input type="text" name="username"> <br><br>
            Password: <input type="password" name="password"> <br><br>
            
           <input type="submit" name="submit" value="Login">
        </form>

    </body>
</html>

