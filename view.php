<?php
session_start();
?>

<html>
    <head>
        <style>
            body{
                background-image: url(back.jpg)
            }
        </style>
    </head>
    <body>
        <?php 
        if (isset($_SESSION["name"])) {
            echo ("Logged in as " . $_SESSION["name"] . "<br>");
        }

        function check($data) {
          $con = mysqli_connect("xxx","xxx","xxx","xxx");
          $data = trim($data);
          $data = stripslashes($data);
          $data = htmlspecialchars($data);
          $data = mysqli_real_escape_string($con,$data);
          return $data;
        }
        if (isset($_REQUEST["com"])) {
           if(check($_REQUEST["com"]) != "") {
              $comtext = check($_REQUEST["com"]);
              $username = $_SESSION["name"];
              $date = date('Y-m-d');
              $time = date('H:i:s');
              $topname = $_SESSION["Viewinfo"];
              $connect = mysqli_connect('xxx','xxx','xxx','xxx');
              $q = "insert into xxx (username, topname,comtext, comdate, comtime)
              values ('" . $username . "' , '" . $topname . "' , '" .$comtext. 
              "' , '" .$date.  "' , '" .$time. "');";
              $result = mysqli_query($connect, $q);
          }
        } 
        $back = "";
        $error = false;
        $fullname = "";
        $username = "";
        $password = "";
        $com = "";
        
        $connect = mysqli_connect('xxx','xxx','xxx','xxx');
        $q = "select * from xxx WHERE topname=" . "'" .$_SESSION["Viewinfo"]. "';";
        $result = mysqli_query($connect, $q);
        $row = mysqli_fetch_array($result);
        ?> 
        Topic Name: <?php echo $row['topname'] ?> <br>
        Topic Text: <?php echo $row["toptext"] ?> <br>
        Topic Autor: <?php echo $row["username"] ?> <br>
        Topic Date: <?php echo $row["topdate"] ?> <br>
        Topic Time: <?php echo $row["toptime"] ?> <br>
        Topic Rating: <?php echo $row["rating"] ?> <br>
        Comments: <br>
        <?php
        if (isset($_SESSION["name"])) {
            ?>
            <form method="post">
                <input type="text" name="com">
                <input type="submit" value="Add Comment">
            </form>
            <?php
        } ?>
        <?php
        $connect = mysqli_connect('xxx','xxx','xxx','xxx');
        $q = "select * from xxx WHERE topname=" . "'" .$_SESSION["Viewinfo"]. "' ORDER BY comdate DESC, comtime DESC;";
        $result = mysqli_query($connect, $q);
        while($row = mysqli_fetch_array($result)) {
            ?>Comment Author: <?php echo $row['username'] ?>&nbsp;
            Comment Date: <?php echo $row["comdate"] . " " . $row["comtime"]?> <br>
            Comment Text: <?php echo $row["comtext"] ?> <br><br> <?php
        } ?>
        <br>

        <a href="index.php"><input type="button" value="Back"></a>
    </body>
</html>