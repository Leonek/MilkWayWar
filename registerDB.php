<?php
		
		if (!isset($pdo))
			require_once("db_normal_connect.php");	
			
		if (isset($pdo_alert))
			echo $pdo_alert;
		else
		{
			
			$login = $_POST['ajax_login'];
			$password = $_POST['ajax_password'];
			$email = $_POST['ajax_email'];
				
			$login = trim($login);
			$login = stripslashes($login);
			$login = htmlspecialchars($login); 
			
			$password = trim($password);
			$password = stripslashes($password);
			$password = htmlspecialchars($password); 
			
			$email = trim($email);
			$email = stripslashes($email);
			$email = htmlspecialchars($email); 
			
			$password = crypt($password, '$5$krfgsdg');			
				
			try
			{
				$r = $pdo -> prepare('INSERT INTO `users` (`login`, `password`, `email`) VALUES (:log, :pas, :ema)');
				
				$r -> bindValue(':log', $login, PDO::PARAM_STR); 
				$r -> bindValue(':pas', $password, PDO::PARAM_STR);
				$r -> bindValue(':ema', $email, PDO::PARAM_STR);
					
				$rows = $r -> execute();
					
				if ($rows > 0)
					$sys_msg = "Rejestracja przebiegła pomyślnie!";
				else
					$sys_msg = "Bład. Nie można przesłać danych.";
					
				echo $sys_msg;
			}
			catch(PDOException $e)
			{
				$pdo_alert = 'Błąd połączenia: '. $e->getMessage();
				echo $pdo_alert;
			}
		}
?>