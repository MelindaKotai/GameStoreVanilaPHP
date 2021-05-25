<?php include 'Layout.php'; ?>
<?=template_header('Cos')?>
<?php 
    require_once "class.cos.php";
    include "class.product.php";
    $product=new Product();
    $user = new User();

      if (!$user->get_session()){
      header("location:Login.php");
      }

      //doar pt clientii logati 
      if(!($_SESSION['user']['rol']=='client')){
      header("location:Index.php");
      }


    //id-ul clientului logat
    $id_client=$_SESSION['user']['id'];
    $cos = new Cos();

    //daca user-ul vrea sa realizeze o actiune
    if (!empty($_GET["action"])) {
         switch ($_GET["action"]) {
         case "add":
         if (isset($_GET["cantitate"]) && isset($_GET["id_produs"]) && is_numeric($_GET["cantitate"]) && is_numeric($_GET["id_produs"]) && $_GET["cantitate"]>0) {
              //se verifica daca exista deja produsul in cosul clientului
              $cartResult = $cos->getCartItemByProduct($_GET["id_produs"], $id_client);
              //se verifica daca exista produsul care se doreste a fi adaugat
              if($product->show_product($_GET["id_produs"])){

                 if ($cartResult) {
                   // Modificare cantitate in cos daca produsul deja exista
                   $newQuantity = $cartResult["cantitate"] + $_GET["cantitate"];
                   $cos->updateCartQuantity($newQuantity, $cartResult["id"]);
                 } else {
                   // Adaugare in tabelul cos daca produsul nu exista in cos 
                   $cos->addToCart($_GET["id_produs"], $_GET["cantitate"], $id_client);
                 }
             }
        }
         break;

         case "remove":
         // Sterg o sg inregistrare
           if($cos->getCart($_GET["id"]))
           $cos->deleteCartItem($_GET["id"]);
         break;


         case "empty":
           //golesc tot cosul fara a plasa comanda
           $cos->emptyCart($id_client);
         break;

         
         case "update":
         //updatez cosul dupa ce modific niste cantitati
         foreach ($_GET as $k => $v) {
         
             $id = (int)$k;
             $quantity = (int)$v;
             //verificam daca exista o inregistrare cu acest id in tabela cos
             if($cos->getCart($id))
             // Verifica si validam
             if (is_numeric($id) && $quantity > 0) 
             // Udate cantitate nou
             $cos->updateCartQuantity($quantity, $id);
         }
         break;
        }
    }


    $cartItem = $cos->getClientCartItems($id_client);
?>

 <div class="container mt-5 mb-5 pt-4 pl-3 pr-3 pb-3 text-center" style="min-height: 50vh;background-color: white;border-radius: 20px;">
 
     <div  class="mb-3" style="font-size: 20px;">Cos Cumparaturi</div>
     <?php 
           if (!empty($cartItem)) 
           	     echo "<a id='btnEmpty' href='CosPersistent.php?action=empty' style='text-decoration:none;color:red;'><i class='fa fa-cart-arrow-down' style='font-size:24px'></i>Goleste cosul!</a>";  
           else echo "Cosul este gol!"; 

    		if (!empty($cartItem)){
    		 $item_total = 0;
    ?>
     <form action="" method="get">
         	<input type="hidden" name="action" value="update">

        <table cellpadding="10" cellspacing="1" style="width: 100%;" class="mt-3s">

         <tr>
         <th style="text-align: left;"><strong>Denumire</strong></th>
         <th style="text-align: left;"><strong>Cantitate</strong></th>
         <th style="text-align: right;"><strong>Pret</strong></th>
         <th style="text-align: center;"><strong>Actiune</strong></th>
         </tr>

        <?php
         foreach ($cartItem as $item) {
         ?>
        <tr>
         <td
         style="text-align: left; border-bottom: #F0F0F0 1px solid;"><strong><?php echo $item["denumire"]; ?></strong></td>
         <td style="text-align: center; border-bottom: #F0F0F0 1px solid;"><input class="form-control" style="width: 200px;" type="number" value="<?php echo $item["cantitate"];
        ?>" min="1" name="<?php echo $item['cart_id']?>"></td>
         <td style="text-align: right; border-bottom: #F0F0F0 1px solid;"><?php echo ($item["pret"]*$item["cantitate"])." Lei"; ?></td>
         <td style="text-align: center; border-bottom: #F0F0F0 1px solid;"><a href="cosPersistent.php?action=remove&id=<?php echo $item["cart_id"]; ?>"
         class="btnRemoveAction"><i class="fa fa-times-circle" style="font-size:24px"></i></a></td>
         </tr>
        <?php
         $item_total += ($item["pret"] * $item["cantitate"]);
         }
         ?>
        <tr>
         <td colspan="3" align=right style="font-size: 20px;"><strong>Total:</strong></td>
         <td align=center style="font-size: 20px;"><?php echo $item_total."Lei"; ?></td>
         <td></td>
         </tr>
         
         </table>

         <?php
        }
        ?>

        <a href="Produse.php"><div class="btn btn-danger">Continuati cumparaturile!</div></a>
        <?php if (!empty($cartItem)) echo "<button class='btn btn-dark' type='submit'>Actualizati cosul</button>
        <div class='btn btn-success' onclick='Confirmare()'>Plasati comanda</div>"; ?>

    </form>
</div>


<script type="text/javascript">
	function Confirmare(){
		if (confirm('Vrei sa plasezi comanda?')) 
 
  window.location.href = "http://localhost/pROIECT/ComandaSuccesCosPersistent.php";
else
	return false;
	}
</script>



  <?=template_footer()?>