<?php
session_start();

require 'config.php';

if (isset($_POST['book'])) {
		
	foreach ($_POST as $key => $val) {
		$_POST[$key] = trim($val);
	}
	// letar efter tomma fält
	if (empty($_POST['name']) || empty($_POST['subject']) || empty($_POST['tutor']) || empty($_POST['starttime']) || empty($_POST['endtime'])) {
		$reg_error[] = 0;
	}

	if (!isset($reg_error)) {
		// ifall det inte är några fel läggs bokningen in i databasen
		$stm = $pdo->prepare("INSERT INTO `bookingtutor`(`userName`, `userId`, `subject`, `tutor`, `startTime`, `endTime`) VALUES (:userName, :userId, :subject, :tutor, :startTime, :endTime)");

			$stm->execute([
				'userName' => $_POST['name'],
				'userId' => $_SESSION['session_id'],
				'subject' => $_POST['subject'],
				'tutor' => $_POST['tutor'],
				'startTime' => $_POST['starttime'],
				'endTime' => $_POST['endtime'],
				]);

		$_SESSION['userid'] = $pdo->lastInsertId();
		
		header("Location: ../html/my_page.php");
	}

	else {
		echo "<p>Något blev fel:<br>\n";
		echo "<ul>\n";
  		for ($i = 0; $i < sizeof($reg_error); $i++) {
    		echo "<li>{$error_list[$reg_error[$i]]}</li>\n";
  		}
  		echo "</ul>\n";
	}
	$error_list[0] = "Alla obligatoriska fält är ej ifyllda.";
}