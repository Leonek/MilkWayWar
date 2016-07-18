<!DOCTYPE html>
<html lang="pl_PL">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Formularz Rejestracji</title>
	
	<!-- CSS -->
	<link href="beautiful.css" rel="stylesheet">
    <link href ="externalPlugins/bootstrap-3.3.6-dist/css/bootstrap.min.css" rel="stylesheet">
	<!-- Plugins -->
    <script src= "externalPlugins/jquery-2.2.0.min.js"></script>
    <script src= "externalPlugins/bootstrap-3.3.6-dist/js/bootstrap.min.js"></script>

  </head>
  <!-- Panel rejestracji -->
  <body>
		<h1>Rejestracja</h1>
		<!-- tutaj dodaj jakiś div -->						
			<div class="form-group">
				<label for="input_login">Login</label>
				<input type="text" class="form-control" id="input_login" name="my_login" placeholder="Tutaj wpisz login" maxlength="16">
				
				<div id="input_login_des"></div> <!-- Opis do loginu. -->
			</div>
							
			<div class="form-group">
				<label for="input_password">Hasło</label>
				<input type="password" class="form-control" id="input_password" name="my_password" placeholder="Tutaj wpisz hasło" maxlength="16">
				
				<div class="progress">
					<div class="progress-bar" role="progressbar" aria-valuenow="0" 
								aria-valuemin="0" aria-valuemax="100" style="width:0%">
					Siła hasła
					</div>
				</div>
				
				<div id="input_password_des"></div>
				 
			</div>
				
			<div class="form-group">
				<label for="input_email">E-Mail</label>
				<input type="email" class="form-control" id="input_email" name="my_email" placeholder="Podaj swój adres e-mail" maxlength="20">
				
				<div id="input_email_des"></div>
			</div>
				
			<a class="btn btn-default" href="index.php"> Powrót</a>
			<button type='button' class='btn btn-default' id='btn-add'> Dodaj</button>
			
  </body>
  
</html>

<!-- jQuery Script -->
<script type="text/javascript">
	$(document).ready(function()
	{
		$('#input_login').blur(function()
		{
			if ($('#input_login').val() != ($('#input_login').val()).match('^[A-z0-9_-]{3,16}$'))
			{
				$('#input_login').closest('.form-group').addClass('has-error');
				$('#input_login').closest('.form-group').removeClass('has-success');
				$('#input_login_des').text('Login nie może zawierać niedozwolonych znaków! Dozwolone znaki: "0-9, A-z, _".');
			}
			else
			{
				$('#input_login').closest('.form-group').addClass('has-success');
				$('#input_login').closest('.form-group').removeClass('has-error');
				$('.input_login_des').text('Login dozwolony.');
			}
		});
		
		$('#input_password').blur(function()
		{
			if ($('#input_password').val() != ($('#input_password').val()).match('^[A-z0-9_-]{6,16}$'))
			{
				$('#input_password').closest('.form-group').removeClass('has-success');
				$('#input_password').closest('.form-group').addClass('has-error');				
				$('#input_password_des').text('Hasło musi mieć przynajmniej 6 znaków, nie może również zawierać niedozwolonych znaków! Dozwolone znaki: "0-9, A-z, _".');
			}
			else
			{
				$('#input_password').closest('.form-group').removeClass('has-error');
				$('#input_password').closest('.form-group').addClass('has-success');				
				$('#input_password_des').text('');
				
				$('.progress-bar').removeClass('progress-bar-danger');
				$('.progress-bar').removeClass('progress-bar-warning');
				$('.progress-bar').removeClass('progress-bar-info');
				$('.progress-bar').removeClass('progress-bar-success');
				
				if (checkPassStrength($('#input_password').val()) < 30)
				{
					$('.progress-bar').addClass('progress-bar-danger');
					$('.progress-bar').css("width", checkPassStrength($('#input_password').val())+"%");
					$('.progress-bar').text('Siła hasła: bardzo słabe');
				}
				else 
				if (checkPassStrength($('#input_password').val()) < 50)
				{
					$('.progress-bar').addClass('progress-bar-warning');
					$('.progress-bar').css("width", checkPassStrength($('#input_password').val())+"%");
					$('.progress-bar').text('Siła hasła: bardzo słabe');
				}
				else
				if (checkPassStrength($('#input_password').val()) < 80)
				{
					$('.progress-bar').addClass('progress-bar-info');
					$('.progress-bar').css("width", checkPassStrength($('#input_password').val())+"%");
					$('.progress-bar').text('Siła hasła: średnie');
				}
				else
				{
					$('.progress-bar').addClass('progress-bar-success');
					$('.progress-bar').css("width", checkPassStrength($('#input_password').val())+"%");
					$('.progress-bar').text('Siła hasła: silne');
				}				
				
			}
		});
		
		$('#input_email').blur(function()
		{
			if ($('#input_email').val() != ($('#input_email').val()).match(/^[A-z0-9._%+-]+@[A-z0-9.-]+.[A-z]{1,8}$/))
			{
				$('#input_email').closest('.form-group').addClass('has-error');
				$('#input_email').closest('.form-group').removeClass('has-success');
				$('#input_email_des').text('Podany E-Mail jest nieprawidłowy.');
			}
			else
			{
				$('#input_email').closest('.form-group').addClass('has-success');
				$('#input_email').closest('.form-group').removeClass('has-error');
				$('#input_email_des').text('Podany adres jest prawidłowy.');
			}
		});
		
		$('#btn-add').click(function()
		{						
			if ($('#input_login').closest('.form-group').hasClass("has-success") && $('#input_password').closest('.form-group').hasClass("has-success") && $('#input_email').closest('.form-group').hasClass("has-success"))
			{
				$.ajax
				({
					type: 'POST',
					url: 'registerDB.php',
					data: 
					{
						ajax_login: $('#input_login').val(),								
						ajax_password: $('#input_password').val(),
						ajax_email: $('#input_email').val()
					},
															
					success: function(msg) 
					{
						$('body').html('<p>'+msg+'</p><p><a class="btn btn-default" href="index.php"> Powrót do strony głównej</a></p>');
					},
								
					error: function(e)
					{
						alert('Wystąpił błąd!');
						console.log(e);
					}
	 
				});
			}
		});			
	});	

	/* Funkcja sprawdza siłę hasła na podstawie zawartych w niej znaków.
	   Małe litery: +30%
	   Duże litery: +30%
	   Liczby: +20%
	   Przynajmniej 8 znaków: +10%
	   Przynajmniej 16 znaków: +10%
	*/
	function checkPassStrength(str) 
	{
		var StrengthLevel = 0; // 0 - 100
		
		// sprawdzanie długości hasła
			if (str.length >= 8)
				StrengthLevel += 10;
			if (str.length >= 16)
				StrengthLevel += 10;
		
		// sprawdzanie zawartości
		// duże litery			
			if (str.search(/[A-Z]/) > -1)
				StrengthLevel += 30;
		// małe litery	
			if (str.search(/[a-z]/) > -1)
				StrengthLevel += 30;
		// cyfry
			if (str.search(/\d/) > -1)
				StrengthLevel += 20;
			
		return StrengthLevel;
	}
</script>
	