<?php
// Start the session
session_start();
?>
<html>
    <head>
        <style>
            body {
                background-image: url(back.jpg)
            }
        </style>
    </head>
    <body>
<?php
    $connect = mysqli_connect('xxx','xxx','xxx','xxx');
    if(!$connect){
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
    $info = false;
    if (isset($_REQUEST["topname"]) && isset($_REQUEST["topname"])) {
        if($_REQUEST["topname"] && $_REQUEST["toptext"] != "") {
	        $toptext = check($_REQUEST["toptext"]);
            $topname = check($_REQUEST["topname"]);
            $info = true;
        } else {
            $error = true;
            $msg = "Please fill all lines!";
        }
        if(strlen($_REQUEST["toptext"]) > 500) {
            $error = true;
            $msg += " Topic text must be less than 500 char!";
        }
        if(strlen($_REQUEST["topname"]) > 50) {
            $error = true;
            $msg += " Topic text must be less than 50 char!";
        }
    }

    $username = $_SESSION["name"];
    
    $q = "select * from xxx where username ='$username'";
    $result = mysqli_query($connect, $q);
    
    if(!$error && $info) {
        while($row = mysqli_fetch_array($result)) {
            if($row["topname"] == $topname) {
                $error=true;
                $msg = "Topic name is busy!";
            } else {
                $error=false;        
            }
        }
    }
     $date = date('Y-m-d');
     $time = date('H:i:s');
     $null = 0;
    if(!$error && $info) {
        $q = "insert into xxx (username, topname, toptext, topdate, rating,toptime) values ('" . $username . "' , '" . $topname . "' , '" .$toptext. "' , '" .$date.  "' , '" .$null. "' , '" .$time. "');";
            $result = mysqli_query($connect, $q);
            header('Location: index.php');
    } else {
        echo "<body>";
    }

    if (isset($error)) {
        if ($error == true) {
            echo $msg . "<br>";
        }
    }
?>
<form method="post">
            Topic Name: <input type="text" name="topname"><br><br>
            Topic Text: <input type="text" name="toptext"><br><br>
            <input type="submit" value="Submit"><br>
            <a href="index.php"><input type="button"value="Back"></a>
</form>
</body>
</html>