<?php
require "config.php";


// hämtar start- och sluttid från ../html/babysitter.php
$sql = "SELECT `name`, `startTime`, `endTime` FROM `users` LEFT JOIN `bookingbabysitter` ON `users`.`name` = `bookingbabysitter`.`babysitter` WHERE `startTime` != :startTime AND `endTime` != :endTime GROUP BY `name`";
// visar alla barnvakter som inte är upptagna vald tid
$stm = $pdo->prepare($sql);
$stm->execute([
	'startTime' => $_GET['starttime'],
	'endTime' => $_GET['endtime'],
	]);

foreach($stm as $row) {
	echo $row['name'] . "\n";
}