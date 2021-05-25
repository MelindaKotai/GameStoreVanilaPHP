<?php include 'Layout.php'; ?>
<?=template_header('Succes')?>
<?php 
	
		include "class.cos.php";
		$cos= new Cos();
		$user = new User();
		if (!$user->get_session()){
		  header("location:Login.php");
		}





		$id_client=$_SESSION['user']['id'];
		$cos->plasarecomandapersistent($id_client);
				
?>


  <div class="container pt-5 pb-4 text-center " style="min-height: 80vh;">
		<div class="alert alert-success  mt-5" style="font-size: 30px;">Comanda a fost plasata cu succes! Veti primi un email cu factura comenzii. Multumim pentru cumparaturi!</div>
  </div>

<?=template_footer()?>

   