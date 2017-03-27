<?php
session_start();

require 'config.php';
?>

<!DOCTYPE html>
<html>
<head>
	<title>Mina bokningar</title>
</head>
<body>
<h1>Mina Bokningar</h1>

<?php
// kollar om användaren är inloggad
if (isset($_SESSION['session_id'])) {
	
	$now = date("Y-m-d H:i:s"); // dagens datum och tid på servern
	$sql = "SELECT * FROM `bookingtutor` WHERE `userId` = :userid";
	$stm = $pdo->prepare($sql);
	$stm->execute(['userid' => $_SESSION['session_id']]); 
	?>
	<!--kollar att userid stämmer överens och visar bara den inloggades bokningar-->
		<h2>Läxhjälpsbokningar</h2>
		<table>
		<tr><th>Name</th> <th>Ämne</th> <th>Tutor</th> <th>Starttid</th> <th>Sluttid</th> 
		</tr>
	<?php
	foreach ($stm as $row) {
		$userName = $row['userName'];
		$subject = $row['subject'];
		$tutor = $row['tutor'];
		$startTime = $row['startTime'];
		$endTime = $row['endTime'];
			if ($startTime > $now) { 
				?>
				<!-- jämför starttid för bokning med dagens datum och visar bara kommande bokningar-->
				<tr>
				<?php echo "<td>$userName</td> <td>$subject</td> <td>$tutor</td> <td>$startTime</td> <td>$endTime</td>";?>
				<td>
				<form action="../includes/delete_booking.php" method="post">
				<input type="hidden" name="idtutor" value="<?php echo $row['id'];?>" />
				<button type="submit">Ta bort</button>
				</form>
				</td>
				</tr>
			<?php
			}
			} 
			?>
		</table>
	<?php
	$sql = "SELECT * FROM `bookingbabysitter` WHERE `userId` = :userid";
	$stm = $pdo->prepare($sql);
	$stm->execute(['userid' => $_SESSION['session_id']]);
	?>
	<!--kollar att userid stämmer överens och visar bara den inloggades bokningar-->
		<h2>Barnvaktsbokningar</h2>
		<table>
		<tr><th>Name</th> <th>Antal barn</th> <th>Barnvakt</th> <th>Starttid</th> <th>Sluttid</th>
		</tr>
	<?php
	foreach ($stm as $row) {
		$id = $row['id'];
		$userName = $row['userName'];
		$children = $row['children'];
		$babysitter = $row['babysitter'];
		$startTime = $row['startTime'];
		$endTime = $row['endTime'];
			if ($startTime > $now) { 
				?>
				<!--jämför starttid för bokning med dagens datum och visar bara kommande bokningar-->
				<tr>
				<?php echo "<td>$userName</td> <td>$children</td> <td>$babysitter</td> <td>$startTime</td> <td>$endTime</td>";?>
				<td>
				<form action="../includes/delete_booking.php" method="post">
				<input type="hidden" name="idbabysitter" value="<?php echo $row['id'];?>" />
				<button type="submit">Ta bort</button>
				</form>
				</td>
				</tr>
			<?php
			}
			}
			?>
		</table>
<?php
}
?>