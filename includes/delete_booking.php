<?php 
require 'config.php';

// tar bort bokningen när man trycker på knappen ta bort
if (isset($_POST['idbabysitter'])) {
	$sqlDelete = "DELETE FROM `bookingbabysitter` WHERE `id` = :idbabysitter";
	$stmDelete = $pdo->prepare($sqlDelete);
	$stmDelete->execute(['idbabysitter' => $_POST['idbabysitter']]);
}

header("Location ../html/my_page.php");

// tar bort bokningen när man trycker på knappen ta bort
if (isset($_POST['idtutor'])) {
	$sqlDelete = "DELETE FROM `bookingtutor` WHERE `id` = :idtutor";
	$stmDelete = $pdo->prepare($sqlDelete);
	$stmDelete->execute(['idtutor' => $_POST['idtutor']]);
}

header("Location: ../html/my_page.php");