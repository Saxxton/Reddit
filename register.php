<head>
    <style>
	body {
	    background-image: url(back.jpg);
	    height: 100%;
	    background-position: center;
	    background-repeat: no-repeat;
	    background-size: cover;
	}
    </style>
</head>

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
    $fullname = "";
    $username = "";
    $password = "";
    $email = "";
    $msg = "";
    
    if (isset($_REQUEST["fullname"]) && isset($_REQUEST["username"]) && isset($_REQUEST["password"]) && isset($_REQUEST["email"])) {
        if($_REQUEST["username"] && $_REQUEST["password"] && $_REQUEST["email"] && $_REQUEST["username"]!="") {
	        $fullname = check($_REQUEST["fullname"]);
            $username = check($_REQUEST["username"]);
            $password = check($_REQUEST["password"]);
            $email = check($_REQUEST["email"]);
        } else {
            $error = true;
            $msg = "Please fill all lines!";
        }
    }
    
    $q = "select * from xxx where username ='$username'";
    $result = mysqli_query($connect, $q);
    
    while($row = mysqli_fetch_array($result)) {
        if(($row["username"] == $username) || $username == "") {
            $error=true;
            $msg = "Username is busy!";
        } else {
            $error=false;        
        }
    }
    
    if(!$error && $username!="") {
        $q = "insert into xxx (username, password, fullname, email) values ('" . $username . "' , '" . $password . "' , '" .$fullname. "' , '" .$email. "');";
            $result = mysqli_query($connect, $q);
            header('Location: index.php');
    } else {
        echo "<body>";
    }
    ?>
	<div style='text-align: center; padding-top: 10px;'>
    <form method="post">
        <?php
        if ($error == true) {
            echo $msg . '<br>';
        }
    ?>
	Welcome to the registration page!<br>
	<br>
        Username: <input type="text" name="username"><br><br>
        Password: <input type="text" name="password"><br><br>
	    Full Name: <input type="text" name="fullname"><br><br>
        E-mail:    <input type="text" name="email"><br><br>
        <input type="submit" value="Register"><br><br>
        <a href="index.php"><input type="button"value="Back"></a>
    </form>
</div>
