<?php include 'Layout.php'; ?>
<?=template_header('Succes')?>
<?php 
		include "class.product.php";
		include "class.cos.php";
		$product= new Product();
		$cos= new Cos();
		$user = new User();
		if (!$user->get_session()){
		  header("location:Login.php");
		}

		$products_in_cart = isset($_SESSION['cart']) ? array_keys($_SESSION['cart']) : array();

		$products = array();
		   
		if($products_in_cart){

			
			foreach($products_in_cart as $p){
					
					$produs=$product->show_product($p);
					if($produs)
					$products[]=$produs;
			}
		}


		foreach ($products as $produs) {
			 $id_client=$_SESSION['user']['id'];
			 $id_produs=$produs['id'];
			 $cantitate=$_SESSION['cart'][$produs['id']];
			 $starecomanda='neprocesata';
			 $cos->plasarecomanda($id_client,$id_produs,$cantitate,$starecomanda);
		 
		 }

		unset($_SESSION['cart']);
?>


  <div class="container pt-5 pb-4 text-center " style="min-height: 80vh;">
		<div class="alert alert-success  mt-5" style="font-size: 30px;">Comanda a fost plasata cu succes! Veti primi un email cu factura comenzii. Multumim pentru cumparaturi!</div>
  </div>

<?=template_footer()?>

   