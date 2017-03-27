<?php
session_start();

require 'config.php';

if (isset($_SESSION['session_id'])) {

	$form = $_POST;
	$id = $_SESSION['session_id'];
	$name = $form['name'];
	$email = $form['epost'];
	$adress = $form['adress'];
	$zipCode = $form['zipCode'];
	$city = $form['city'];
	$phoneNumber = $form['phoneNumber'];

	$sql = "UPDATE users SET name = :name, email = :email, role = :role, adress = :adress, zipCode = :zipCode, city = :city, phoneNumber = :phoneNumber WHERE id = :id";

		$stmt = $pdo->prepare($sql);
		$stmt->execute([
			'name' => $_POST['name'],
			'email' => $_POST['epost'],
			'role' => $_POST['role'],
			'adress' => $_POST['adress'],
			'zipCode' => $_POST['zipCode'],
			'city' => $_POST['city'],
			'phoneNumber' => $_POST['phoneNumber'],
			'id' => $_SESSION['session_id'],
			]);

	}

header("Location: ../html/my_page.php");