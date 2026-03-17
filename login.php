<html>
    <head>
        <title></title>
    </head>
    <body>
        <h2></h2>
        <form action="" method='POST'>
            <label for="username">Username:</label>
            <input type="text" name="username"><br><br>
            <label for="pword">Password</label>
            <input type="password" name="password"><br><br>
            <input type="submit" name="submit" value="login">
        </form>
    </body>
    <?php
    if(isset($_POST["submit"])){
        $username = $_POST['username'];
        $password = $_POST['password'];
        if($username == 'admin' && $password == 'admin@123'){
            session_start();
            $_SESSION['username'] = $username;
            header('Location: homepage.php');
        }else{
            echo '<script>alert("Invalid username or password.")</script>';
        }
    }
    ?>
</html>