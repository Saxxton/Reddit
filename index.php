<?php
// Start the session
session_start();
?>
<html>
    <head>
    <style>
   body {
    background-image: url(back.jpg);
    height: 100%;
    background-position: center;
    background-size: cover;
   }
    </style> 
<?php  

    if (!isset($_SESSION["name"])) {
        $connect = mysqli_connect('xxx','xxx','xxx','xxx');
        if(!$connect) {
            echo "error";
        }

        function check($data) {
            $con = mysqli_connect("xxx","xxx","xxx","xxx");
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            $data = mysqli_real_escape_string($con,$data);
            return $data;
        }

        $error = false;
        $username = null;
        $msg = "";
        $password = null;

        if (isset($_REQUEST["username"]) && isset($_REQUEST["password"])) {
            if($_REQUEST["username"]!="" && $_REQUEST["password"]!="") {
                $username = check($_REQUEST["username"]);
                $password = check($_REQUEST["password"]);
            } else { 
                $error = true;
                $msg = "Please fill all lines";
            }
        }

        $q = "select * from xxx where username ='$username'";
        $result = mysqli_query($connect, $q);
        while($row = mysqli_fetch_array($result)) {
            if($row["password"] == $password) {
                $error=false;
                $_SESSION["name"] = $username;
                $_SESSION['error'] = false;
                echo 'Login successful';
                header('Location: index.php');

            } else {
                $error=true;
                $msg = "Wrong user or pass";
            }
        }
    }
    if (isset($_REQUEST["logout"])) {
        unset($_SESSION["name"]);
    }
    if (isset($_REQUEST["View"])) {
        $_SESSION["Viewinfo"] = $_REQUEST["View"];
        header("Location: http://dijkstra.cs.ttu.ee/~runest/prax4/view.php");
    }
?>
<?php
    if (isset($_SESSION["name"])) {
        ?>
        <div style='text-align: left; padding-top: 10px;'>
            Logged in as <?php echo $_SESSION["name"]?><br>
            <form method="post">
            <input type="hidden" name="logout" >
            <input type="submit" value="Logout">
            </form>
            <a href="newtopic.php"><input type="button"value="New Topic"></a>
            <br><br>
        </div>
        <?php ;
    } else {
        ?>
        <div style='text-align: left; padding-top: 10px;'>
        Please, enter your login details or register a new user.<br><br>
        <?php
        if (isset($error)) {
            if ($error == true) {
                echo $msg . "<br>";
            }
        }
        ?>
        <form method="post">
            Username: <input type="text" name="username"><br><br>
            Password: <input type="text" name="password"><br><br>
            <input type="submit" value="login">&nbsp;
            <a href="register.php"><input type="button"value="Register"></a>
        </form>
        </div>
        <?php ;
    }
?>
    </head>
    <body>
    
    <?php
        $connect = mysqli_connect('xxx','xxx','xxx','xxx');
        if(isset($_REQUEST['Rate+']) and isset($_SESSION["name"])){
            $tempname = $_REQUEST["Rate+"];
            $q = "UPDATE xxx SET rating= rating + 1 WHERE topname='" . $tempname . "';";
            $result = mysqli_query($connect, $q);
        }
        if(isset($_REQUEST['Rate-']) and isset($_SESSION["name"])) {
            $tempname = $_REQUEST["Rate-"];
            $q = "UPDATE xxx SET rating= rating - 1 WHERE topname='" . $tempname . "';";
            $result = mysqli_query($connect, $q);
        }
        $q = "select * from xxx ORDER BY topdate DESC, toptime DESC;";
        $result = mysqli_query($connect, $q);
        while($row = mysqli_fetch_array($result)) {
            ?> Topic Name: <?php echo $row['topname'] ?> <br>
            Topic Text: <?php echo $row["toptext"] ?> <br>
            Topic Autor: <?php echo $row["username"] ?> <br>
            Topic Date: <?php echo $row["topdate"] ?> <br>
            Topic Time: <?php echo $row["toptime"] ?> <br>
            Topic Rating: <?php echo $row["rating"] ?> &nbsp;
            <br>
            <?php
            if (isset($_SESSION["name"])) {
                ?>
                <form method="post">
                    <input type="hidden" name="Rate+" value= "<?php echo $row['topname'] ?>" >
                    <input type="submit" value="Rate+">
                </form>
                <form method="post">
                    <input type="hidden" name="Rate-" value= "<?php echo $row['topname'] ?>" >
                    <input type="submit" value="Rate-">
                </form>
                <?php
            }
            ?>
            <form method="post">
                <input type="hidden" name="View" value= "<?php echo $row['topname'] ?>" > 
                <input type="submit" value="View"> 
            </form>
            <br><br>
            <?php
        }
    ?>
    
    </body>
</html>