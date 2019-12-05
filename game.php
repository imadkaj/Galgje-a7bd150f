<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Het spel</title>
        <link rel="stylesheet" type="text/css" href="stylecssgalgje.css">
		<style>
			.mid {
				display: inline-block;
				width: 55%;
			}

			.right {
				display: inline-block;
				width: 44%;
			}

			.right img {
				width: 50%;
			}
		</style>
	</head>
	<body>
		<div class="mid">
			<?php

			
			$mistakesCount = 0;

			if(isset($_POST['button'])){
				if($_POST['button'] != 'reset'){
					$lastCharacter   = $_POST['button'];
					if(isset($_COOKIE['characters'])){
						$characters = $_COOKIE['characters'] . ',' . $_POST['button'];
					} else {
						$characters = $_POST['button'];
					}
					setcookie('characters' , $characters , time() + (86400 * 10) );

					header("Location: game.php");
				} else {
					setcookie("woord", "", time() - 3600); 
					setcookie("characters", "", time() - 3600); 
					setcookie("mistakes", "", time() - 3600); 
					header("Location: galgje.php");

				}
			}

			$woordKarakters = str_split($_COOKIE['woord']);
			$keuzeKarakters = explode(",", $_COOKIE['characters']);
			$won = true;

			foreach ($woordKarakters as $woordKarakter) {
				$keuzeCorrect = false;
				foreach ($keuzeKarakters as $keuzeKarakter) {
					if($woordKarakter === $keuzeKarakter){
						$keuzeCorrect = true;
					}
				}
				if($keuzeCorrect){
					echo($woordKarakter);
				} else {
					echo('_');
					$won = false;
				}
			}

			foreach ($keuzeKarakters as $keuzeKarakter) {
				$keuzeCorrect = false;
				foreach ($woordKarakters as $woordKarakter) {
					if($woordKarakter === $keuzeKarakter){
						$keuzeCorrect = true;
					}
				}
				
				if(!$keuzeCorrect){
					$mistakesCount++;
				}
			}

			$lose = false;

			if($mistakesCount === 10){
				$lose = true;
			}
			
			if($won){
				echo '<br>' . '<h1>Je hebt gewonnen</h1> <img src="img/win.png" alt="Bit logo">';
			}		

			if($lose){
				echo '<br>' . '<h1>Je hebt verloren</h1>';
			}
			?>
			<br>
			<br>
			<br>
			<form action="game.php" method="post">
			<button type="submit" name="button" value="reset">reset</button>

			<?php 

				$alphabet = array('a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z', ' ');

				foreach ($alphabet as $value) {
					$display = true;
					foreach ($keuzeKarakters as $keuzeKarakter) {
						if ($value === $keuzeKarakter) {
							$display = false;
						}
					}
					if ($won) {
						$display = false;
					}
					if ($lose){
						$display = false;
					}
					if ($display){
						echo('<button type="submit" name="button" value="' . $value . '">' . $value . '</button>');
					} else {
						echo('<button type="submit" name="button" value="' . $value . '" disabled>' . $value . '</button>');
					}
					
				}

			?>

			</form>

			<h1>Gebruikte letters:</h1><p>
			<?php
				foreach ($keuzeKarakters as $keuzeKarakter) {
					echo($keuzeKarakter . ' , ');
				}
			?>
			</p>
		</div>
		<div class="right">
			<?php
				if($mistakesCount === 0){
					echo('<img src="img/0.jpg">');
				} else {
				echo('<img src="img/' . $mistakesCount . '.jpg">');
				}
			?>
		</div>
	</body>
</html>