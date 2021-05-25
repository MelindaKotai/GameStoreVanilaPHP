<?php include 'Layout.php'; ?>
<?=template_header('Login')?>


<?php
	
	include_once 'class.user.php';
	$message='';
	$emailErr=$parolaErr='';
	$email=$parola='';
	//se verifica daca s-a trimis formularul de login cu metoda post
	if($_SERVER["REQUEST_METHOD"]=="POST") {
	     
	     //se valideaza datele din formular-email, parola obligatorii + email format corect
		 //escape data from sql injections
		 if(empty($_POST["email"])) {
			 $emailErr="Email-ul este obligatoriu";
		 }
		 else {
			 $email = htmlspecialchars(trim(($_POST["email"])));
			 if (!filter_var($email, FILTER_VALIDATE_EMAIL))
					 $emailErr = "Introduceti o adresa de email valida!";
 			 else
 					 $emailErr="";
		 }

		 if(empty($_POST["parola"])) {
		 	$numeErr="Parola este obligatorie";
		 }
		 else {
			 $parola = htmlspecialchars(trim(($_POST["parola"])));
		 	 $parolaErr="";
		 }

         //daca datele intoduse in formular sunt corecte se poate face login
		 if($emailErr=='' && $parolaErr==''){
		 	$user=new User();
		 	$login=$user->login_user($email, $parola);
		 	//daca login se realizeaza cu succes user-ul este redirectionat la pagina Home a site-ului alfel ii este transmis mesaj-ul corespunzator
		 	if($login)
		 		header('location:Index.php');
		 	else
		 		$message="<p class='alert alert-danger'>Parola sau email-ul nu sunt corecte!</p>";
		 
		 }
	}
?>


<div class="container pt-5 pb-4 text-center d-flex justify-content-center" style="min-height: 80vh;">

	<div class="loginform">
		<div class="d-flex justify-content-center mt-4 mb-2">
			<p class="text-danger" style="font-size: 35px;">Login</p>
		</div>

		<div class="d-flex justify-content-center mt-4 mb-2">
		<?php echo $message; ?>
		</div>

		<form action="" method="post">
		  	
		  	<div class="input-group mb-3 mt-4">
				<div class="input-group-append">
					<span class="input-group-text"><i class="fa fa-user" style="font-size:24px"></i></span>
				</div>
				<input type="email" name="email" class="form-control" value="" placeholder="email" required>
				<span class="text-danger input-group"><?php echo $emailErr;?></span>
			</div>

			<div class="input-group mb-3">
				<div class="input-group-append">
					<span class="input-group-text"><i class="fa fa-lock" style="font-size:24px"></i></span>
				</div>
				<input type="password" name="parola" class="form-control" value="" placeholder="parola" required>
				<span class="text-danger input-group"><?php echo $parolaErr;?></span>
			</div>

			<div class="d-flex justify-content-center mt-3 login_container">
				<button type="submit" name="button" class="btn-danger login_btn ">Login</button>
			</div>

		</form>
		
		<div class="mt-4">
			<div class="d-flex justify-content-center links">
		        Nu aveti un cont? <a href="Register.php" class="ml-2">Register</a>
			</div>
							
		</div>
	</div>
</div>

 <?=template_footer()?>