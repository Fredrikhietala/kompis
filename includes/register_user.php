<?php
session_start();

require "config.php";

if (isset($_POST['submitReg'])) {

	// tar bort ev blanksteg
	foreach ($_POST as $key => $val) {
		$_POST[$key] = trim($val);
	}

	// letar efter tomma fält
	if (empty($_POST['name']) || empty($_POST['epost']) || empty($_POST['password']) || empty($_POST['adress']) || empty($_POST['zipCode']) || empty($_POST['city']) || empty($_POST['phoneNumber'])) {
		$reg_error[] = 0;
	}

	// kollar om lösenordet är för kort
	if (strlen($_POST['password']) < 8) {
		$reg_error[] = 1;
	}

	// kollar om lösenorden stämmer överens
	if ($_POST['password'] != $_POST['password2']) {
		$reg_error[] = 2;
	} 
	else {
		$password = $_POST['password'];
	}
	
	// kolla att lösenordet innehåller minst en versal
	if (!preg_match('/[A-Z]/', $_POST['password'])) {
		$reg_error[] = 3;	
	}

	function isValidEmail($email) {
	    return filter_var($email, FILTER_VALIDATE_EMAIL) 
        && preg_match('/@.+\./', $email);
	}

	if (!isValidEmail($_POST['epost']))
  		$reg_error[] = 4;
	
	$name = $_POST['name'];
	$email = $_POST['epost'];
	$adress = $_POST['adress'];
	$zipcode = $_POST['zipCode'];
	$city = $_POST['city'];
	$phonenumber = $_POST['phoneNumber'];

	
  	// Inga fel? Spara och logga in samt skicka till välkomstsida
	if (!isset($reg_error)) {

		$password = $_POST['password'];
		$hashed = password_hash($password, PASSWORD_BCRYPT); //Alla gamla lösenord som är gjorda innan denna raden funkar ej med inloggningen
		$stm = $pdo->prepare("INSERT INTO `users` (`name`, `email`, `role`, `hashedPw`, `adress`, `zipCode`, `city`, `phoneNumber`)
			VALUES (:name, :email, :role, :hashed, :adress, :zipCode, :city, :phoneNumber)");
		
			$stm->execute([
				'name' => $_POST['name'],
				'email' => $_POST['epost'],
				'role' => $_POST['role'],
				'hashed' => $hashed,
				'adress' => $_POST['adress'],
				'zipCode' => $_POST['zipCode'],
				'city' => $_POST['city'],
				'phoneNumber' => $_POST['phoneNumber'],
				]);
		
	
		$_SESSION['userid'] = $pdo->lastInsertId();
		
		$_SESSION['userobj'] = $_POST;
		// sparar registerinfon i sessionen userobj, används senare i usersummary

		header("Location: ../html/login.html");
	}

	else {
		echo "<p>Något blev fel:<br>\n";
		echo "<ul>\n";
  		for ($i = 0; $i < sizeof($reg_error); $i++) {
    		echo "<li>{$error_list[$reg_error[$i]]}</li>\n";
  		}
  		echo "</ul>\n";
	}
	
	$error_list[0] = "Alla obligatoriska fält är inte ifyllda.";
	$error_list[1] = "Lösenordet måste vara minst 8 tecken.";
	$error_list[2] = "Lösenorden stämmer inte överens.";
	$error_list[3] = "Lösenordet måste innehålla minst en versal.";
	$error_list[4] = "E-postadressen betraktas inte som giltig.";	
}