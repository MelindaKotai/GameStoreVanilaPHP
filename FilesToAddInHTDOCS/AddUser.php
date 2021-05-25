<?php include 'Layout.php'; ?>
<?=template_header('CreateUser')?>

 <?php 
	  $user = new User();

	  if (!$user->get_session()){
	  	header("location:Login.php");
	  }
	  	//doar administratorii pot sa acceseze aceasta pagina
	  if(!($_SESSION['user']['rol']=='admin')){
	  header("location:Index.php");
	  }

	  $mesaj='';
	  $numeErr=$prenumeErr=$emailErr=$telErr=$judetErr=$localitateErr=$adresaErr=$parolaErr=$parola2Err=$rolErr=''; 
	  $prenume=$nume=$email=$tel=$judet=$localitate=$adresa=$parola=$parola2=''; 
	  if($_SERVER["REQUEST_METHOD"]=="POST") {
	 //validare date formular
			 if(empty($_POST["nume"])) {
			 $numeErr="Numele este obligatoriu";
			 }
			 else {
			 $nume = htmlspecialchars(trim(($_POST["nume"])));
			 if(!preg_match("/^[a-zA-Z ]*$/",$nume))
			 $numeErr="Numai literele si spatiul sunt permise";
			 else
			 	$numeErr="";
			 }


			 if(empty($_POST["prenume"])) {
			 $prenumeErr="Prenumele este obligatoriu";
			 }
			 else {
			 $prenume=htmlspecialchars(trim(($_POST["prenume"])));
			 if(!preg_match("/^[a-zA-Z ]*$/",$prenume)) 
			 $prenumeErr="Numai literele si spatiul sunt permise";
			 else
			 	$prenumeErr="";
			 }


			 if (empty($_POST["tel"])) {
			 $telErr="Numarul de telefon este obligatoriu";
			 } else {
			 $tel=htmlspecialchars(trim(($_POST["tel"])));
			 if (!preg_match('/^[0-9]{10}+$/', $tel)) 
			 $telErr = "Trebuie introduse 10 cifre";
			 else
			 	$telErr="";
			 }



			 if (empty($_POST["email"])) {
			 $emailErr="Email-ul este obligatoriu";
			 } else {
			 $email = trim(($_POST["email"]));
			 if (!filter_var($email, FILTER_VALIDATE_EMAIL))
			 $emailErr = "Introduceti o adresa de email valida!";
			 else
			 	$emailErr="";
			 }

			 if(empty($_POST["judet"])) {
			 $judetErr="Judetul este obligatoriu";
			 }
			 else {
			 $judet = htmlspecialchars(trim(($_POST["judet"])));
			 if(!preg_match("/^[a-zA-Z ]*$/",$judet)) 
			 $judetErr="Numai literele si spatiul sunt permise";
			 else
			 	$judetErr="";
			 }

			 if(empty($_POST["localitate"])) {
			 $localitateErr="Localitatea este obligatorie";
			 }
			 else {
			 $localitate = htmlspecialchars(trim(($_POST["localitate"])));
			 if(!preg_match("/^[a-zA-Z -]*$/",$localitate)) 
			 $prenumeErr="Numai literele, spatiul si liniuta - sunt permise";
			 else
			 	$localitateErr="";

			 }

			 if(empty($_POST["adresa"])) {
			 $adresaErr="Adresa este obligatorie";
			 }
			 else {
			 $adresa = htmlspecialchars(trim(($_POST["adresa"])));

			 	$adresaErr="";
			 }

			 if(empty($_POST["parola"])) {
			 $parolaErr="Parola este obligatorie";
			 }
			 else {
			 $parola = htmlspecialchars(trim(($_POST["parola"])));
			 	$parolaErr="";
			 }


			 if(empty($_POST["parola2"])) {
			 $parola2Err="Repetarea parolei este obligatorie";
			 }
			 else {
			 $parola2 = htmlspecialchars(trim(($_POST["parola2"])));
			 	if($parola!=$parola2)
			 			$parola2Err="Nu se potrivesc parolele!";
			 	else
			 		$parola2Err="";

			 }
			 if(empty($_POST["rol"])) {
			 $rolErr="Rolul este obligatoriu";
			 }
			 else {
			 $rol = $_POST["rol"];
			 	$rolErr="";
			 }


			if( $numeErr=='' && $prenumeErr=='' && $emailErr=='' && $telErr=='' && $judetErr=='' && $localitateErr=='' && $adresaErr=='' && $parolaErr=='' && $parola2Err=='' && $rolErr==''){
			 $user = new User();
			 $register = $user->reg_user($nume,$prenume,$email,$tel,$judet,$localitate,$adresa,$parola,$rol);
			 
			 if ($register) {
			// Inregistrare Success

			$mesaj='<p class="alert alert-success">Inregistrer realizata cu succes !';
			} else
			//email-ul deja exista in baza de date
			 $mesaj='<p class="alert alert-danger">Inregistrarea nu s-a putut efectua. Email-ul seste deja utilizat<p>';
			}
	}

?>

<div class="container pt-5 pb-4 text-center d-flex justify-content-center">
	<div class="loginform">

		<div class="d-flex justify-content-center mt-4 mb-2">
		<p class="text-danger" style="font-size: 35px;">Creaza cont</p>
		</div>

		<div class="d-flex justify-content-center mt-4 mb-2">
		<?php echo $mesaj ?>
		</div>

		<form action="" method="post">
		  		<div class="input-group mb-3 mt-4">
					<div class="input-group-append">
						<span class="input-group-text"><i class="fa fa-user" style="font-size:24px"></i></span>
					</div>
					<input type="text" name="nume" class="form-control"  placeholder="Nume" value="<?php echo $nume;?>" required>
					<span class="text-danger input-group"><?php echo $numeErr;?></span>
				</div>

				<div class="input-group mb-3">
					<div class="input-group-append">
						<span class="input-group-text"><i class="fa fa-user" style="font-size:24px"></i></span>
					</div>
					<input type="text" name="prenume" class="form-control"  placeholder="Prenume"  value="<?php echo $prenume;?>" required>
					<span class="text-danger input-group"><?php echo $prenumeErr;?></span>
				</div>

				<div class="input-group mb-3 mt-4">
					<div class="input-group-append">
						<span class="input-group-text"><i class="fa fa-envelope" style="font-size:19px"></i></span>
					</div>
					<input type="email" name="email" class="form-control"  placeholder="Email"  value="<?php echo $email;?>"required>
					<span class="text-danger input-group"><?php echo $emailErr;?></span>
				</div>

				<div class="input-group mb-3 mt-4">
					<div class="input-group-append">
						<span class="input-group-text"><i class="fa fa-phone" style="font-size:22px"></i></span>
					</div>
					<input type="tel" name="tel" class="form-control"  placeholder="Numar de telefon" value="<?php echo $tel;?>" required>
					<span class="text-danger input-group"><?php echo $telErr;?></span>
				</div>

				<div class="input-group mb-3 mt-4">
					<div class="input-group-append">
						<span class="input-group-text"><i class="fa fa-map-marker" style="font-size:24px"></i></span>
					</div>
					<input type="text" name="judet" class="form-control"  placeholder="Judet" value="<?php echo $judet;?>" required>
					<span class="text-danger input-group"><?php echo $judetErr;?></span>
				</div>

				<div class="input-group mb-3 mt-4">
					<div class="input-group-append">
						<span class="input-group-text"><i class="fa fa-map-marker" style="font-size:24px"></i></span>
					</div>
					<input type="text" name="localitate" class="form-control"  placeholder="Localitate" value="<?php echo $localitate;?>" required>
					<span class="text-danger input-group"><?php echo $localitateErr;?></span>
				</div>

				<div class="input-group mb-3 mt-4">
					<div class="input-group-append">
						<span class="input-group-text"><i class="fa fa-map-marker" style="font-size:24px"></i></span>
					</div>
					<input type="text" name="adresa" class="form-control"  placeholder="Adresa" value="<?php echo $adresa;?>" required="">
					<span class="text-danger input-group"><?php echo $adresaErr;?></span>
				</div>

				<div class="input-group mb-3 mt-4">
					<div class="input-group-append">
						<span class="input-group-text"><i class="fa fa-lock" style="font-size:24px"></i></span>
					</div>
					<input type="password" name="parola" class="form-control"  placeholder="Parola" value="<?php echo $parola;?>" required>
					<span class="text-danger input-group"><?php echo $parolaErr;?></span>
				</div>

				<div class="input-group mb-3 mt-4">
					<div class="input-group-append">
						<span class="input-group-text"><i class="fa fa-lock" style="font-size:24px"></i></span>
					</div>
					<input type="password" name="parola2" class="form-control"  placeholder="Repetati parola" value="<?php echo $parola2;?>" required>
					<span class="text-danger input-group"><?php echo $parola2Err;?></span>
				</div>

				<div class="input-group mb-3 mt-4">
					<div class="input-group-append">
						<span class="input-group-text"><i class="fa fa-address-card" style="font-size:24px"></i></span>
					</div>
					<select  name="rol" class="form-control"  placeholder="rol" value="<?php echo $rol;?>" required>
						<option value="client">Client</option>
						<option value="admin">Administrator</option>
					</select>
					<span class="text-danger input-group"><?php echo $rolErr;?></span>
				</div>

				<div class="d-flex justify-content-center mt-3 login_container">
						 	<button type="submit" name="register" class="btn-danger login_btn ">Creaza</button>
				</div>
				
		</form>
		
	  </div>
</div>
<?=template_footer()?>

