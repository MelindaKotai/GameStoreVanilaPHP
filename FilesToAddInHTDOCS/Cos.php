<?php include 'Layout.php'; ?>
<?=template_header('Cos')?>



<?php
		include "class.product.php";
		$product= new Product();
		$user = new User();
		
      if (!$user->get_session()){
      header("location:Login.php");
      }

		// Dacă utilizatorul a dat clic pe butonul Adăugare la coș de pe pagina produsului, putem verifica datele formularului
		if (isset($_GET['id_produs'], $_GET['cantitate']) && is_numeric($_GET['id_produs']) && is_numeric($_GET['cantitate'])) {
				 
				 $id_produs = (int)$_GET['id_produs'];
				 $cantitate = (int)$_GET['cantitate'];
				 $produs = $product->show_product($id_produs);
				 if (!$produs)
				 	header('location:Produse.php');
				 
				 if ($produs && $cantitate > 0) {
				
					 if (isset($_SESSION['cart']) && is_array($_SESSION['cart'])) {
					 if (array_key_exists($id_produs, $_SESSION['cart'])) {
					 // Produsul există în coș, așa că trebuie doar să actualizați cantitatea
					 		$_SESSION['cart'][$id_produs] += $cantitate;
					 } else {
					 // Produsul nu este în coș, așa că il adaugam
					 $_SESSION['cart'][$id_produs] = $cantitate;
					 }
					 } else {
					 // se adauga primul produs in cosul gol
					 $_SESSION['cart'] = array($id_produs => $cantitate);
					 }
				 }//stop retrimiterea
				 header('location:cos.php');
				 exit;
		}
		

		//se elimina un produs din cos
		if (isset($_GET['remove']) && is_numeric($_GET['remove']) && isset($_SESSION['cart']) && isset($_SESSION['cart'][$_GET['remove']])) {
		 // Stergere produs din cos
		 unset($_SESSION['cart'][$_GET['remove']]);
		}


		// Actualizați cantitățile de produse în coș dacă utilizatorul face clic pe butonul „Actualizare” de pepagina coșului de cumpărături
		if (isset($_GET['update']) && isset($_SESSION['cart'])) {
		 // Buclă prin datele de postare, astfel încât să putem actualiza cantitățile pentru fiecare produs dincoș
		 foreach ($_GET as $k => $v) {
		 $id =  (int)$k;
		 $quantity = (int)$v;
		 // Verifica si validam
		 if (is_numeric($id) && isset($_SESSION['cart'][$id]) && $quantity > 0) {
		 // Udate cantitate nou
		 $_SESSION['cart'][$id] = $quantity;
		 }
		 }
		 header('location:cos.php');
		 exit;
		}


         //golire cos
		if(isset($_GET["empty"]) && isset($_SESSION['cart']) && !empty($_SESSION['cart'])){
			unset($_SESSION['cart']);
		}

			//array cu id-urile produselor din cos
		$products_in_cart = isset($_SESSION['cart']) ? array_keys($_SESSION['cart']) : array();
		$products = array();
		$subtotal = 0.00;
		if($products_in_cart){

			
			foreach($products_in_cart as $p){
				
				$produs=$product->show_product($p);
				if($produs)
				$products[]=$produs;
			}

			foreach ($products as $produs) {
		 $subtotal += (float)$produs['pret'] * (int)$_SESSION['cart'][$produs['id']];
		 }


		}

?>



<div class="container mt-5 mb-5 pt-4 pl-3 pr-3 pb-3 text-center" style="min-height: 50vh;background-color: white;border-radius: 20px;">
	 <div  class="mb-3" style="font-size: 20px;">Cos Cumparaturi</div>
	 <form action="" method="get">
		 <table cellpadding="10" cellspacing="1" style="width: 100%;" class="mt-3s">
		 <thead>
			 <tr>
			 <td colspan="2">Produs</td>
			 <td>Pret</td>
			 <td>Cantitate</td>
			 <td>Total</td>
			 <td>Eliminare</td>
			 </tr>
		 </thead>
		 <tbody>
			 <?php if (empty($products)): ?>
			 <tr>
			 <td colspan="6" style="text-align:center;" class="alert alert-danger">Nu aveti produse in Cos</td>
			 </tr>
			 <?php else: ?>

			 	<a id='btnEmpty' href='Cos.php?empty=1' style='text-decoration:none;color:red;'><i class='fa fa-cart-arrow-down' style='font-size:24px'></i>Goleste cosul!</a> 
			           
			 <?php foreach ($products as $produs): ?>
				 <tr>
				 <td  style="border-bottom: #F0F0F0 1px solid;">
					 <a href="DetaliiProdus.php?id=<?=$produs['id']?>">
					 <img src="<?=$produs['img']?>" width="50" height="50"
					alt="<?=$produs['denumire']?>">
					 </a>
				 </td>
				 <td style="border-bottom: #F0F0F0 1px solid;">
					 <?=$produs['denumire']?>
				 	<br>

				 </td>
				 <td style="border-bottom: #F0F0F0 1px solid;"><?=$produs['pret']?> Lei</td>
				 <td style="border-bottom: #F0F0F0 1px solid;">
				 <input type="number" name="<?=$produs['id']?>" value="<?=$_SESSION['cart'][$produs['id']]?>" min="1"  placeholder="Quantity" required>
				 </td>
				<td style="border-bottom: #F0F0F0 1px solid;"><?=$produs['pret'] * $_SESSION['cart'][$produs['id']];?> Lei</td>
				<td style="border-bottom: #F0F0F0 1px solid;"> <a href="Cos.php?remove=<?=$produs['id']?>"
				class="remove">Sterge</a></td>
				 </tr>
			 <?php endforeach; ?>
			 <?php endif; ?>
		 </tbody>
		 </table>
		 <div class="subtotal">
		 <span class="text">Subtotal</span>
		 <span class="price"><?=$subtotal?> Lei</span>
		 </div>

		 <a href="Produse.php"><div class="btn btn-danger">Continuati cumparaturile!</div></a>
		        <?php if (!empty($products)) echo "<button class='btn btn-dark' type='submit'  value='Update' name='update'>Actualizati cosul</button>
		        <div class='btn btn-success' onclick='Confirmare()'>Plasati comanda</div>"; ?>

	 </form>
</div>

<script type="text/javascript">
	function Confirmare(){
		if (confirm('Vrei sa plasezi comanda?')) 
 
  window.location.href = "http://localhost/pROIECT/ComandaSucces.php";
else
	return false;
	}
</script>


 <?=template_footer()?>