<?php

	$err = array();
	$firstName = $lastName = $email = "";

	if ($_SERVER["REQUEST_METHOD"] == "POST") {

    	if (!$_POST["firstname"]) {
    		$err["firstname"] = "Ime je obavezno.";
    	} else {
    		$firstName = $_POST["firstname"];
    	}

    	if (!$_POST["lastname"]) {
    		$err["lastname"] = "Prezime je obavezno.";
    	} else {
			$lastName = $_POST["lastname"];
    	}

    	if (!$_POST["email"]) {
    		$err["email"] = "E-mail je obavezan.";
    	} else {
    		$email = $_POST["email"];
    	}

    	if (empty($err)) {
    		echo $firstName . " " . $lastName . " " . $email . "<br><br><br>";
    	}

	}

?>
<html>
    <body>

        <form action = "" method = "POST">

            Ime: <input type = "text" name = "firstname" value="<?php echo $firstName?>"/>
        	<span><?php echo $err["firstname"];?></span>
            <br><br>

            Prezime: <input type = "text" name = "lastname"  value="<?php echo $lastName?>"/>
            <span><?php echo $err["lastname"];?></span>
            <br><br>

            E-mail: <input type = "email" name = "email"  value="<?php echo $email?>"/>
            <span><?php echo $err["email"];?></span>
            <br><br>

            <input type = "submit" />
        </form>

    </body>
</html>