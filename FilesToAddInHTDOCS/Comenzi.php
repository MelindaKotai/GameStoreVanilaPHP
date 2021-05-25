<?php include 'Layout.php'; ?>
<?=template_header('Vanzari')?>

<?php 
include "class.cos.php";
  $user = new User();
  if ($user->get_session()){
  header("location:Login.php");
  }
  if(!($_SESSION['user']['rol']=='client')){
  header("location:Index.php");
  }
$cos= new Cos();
$comenzi=$cos->getsalesbyid($_SESSION['user']['id']);


?>

<div class="container mt-5 mb-5 pt-4 pr-4 pl-4 pb-4" style="background-color: white;min-height: 60vh;border-radius: 20px;">

<?php
if($comenzi): 
	$data=$comenzi[0]['data'];
	$pos=strpos($data,' ');
	$data=substr($data,0,-$pos+1);
	$total=0;
	$stare=$comenzi[0]['starecomanda'];
	?>

	<p>Data plasarii comenzii: <?php echo $data; ?></p>
	<b><p> Stare comanda: <?php echo $comenzi[0]['starecomanda'] ?> </p></b>
	<p>Produse achizitionate:</p>
    <table cellpadding="10"> <tr><th>Denumire</th><th>Cantitate</th><th>Pret</th> </tr>
		

<?php foreach ($comenzi as $comanda): 
	$pos=strpos($comanda['data'],' ');
	$data2=substr($comanda['data'],0,-$pos+1);
	$stare2=$comanda['starecomanda'];
	if($data!=$data2 || $stare!=$stare2): $data=$data2; ?>
		 <tr><td><b>Total: <?php echo $total;
	$total=0;
	        ?> Lei</td></b></tr>
	    </table>
		 <hr>
	     <p>Data plasarii comenzii: <?php echo $data ?></p>
	     <b><p> Stare comanda: <?php echo $stare2; $stare=$stare2 ?> </p></b>
	     
		 <p>Produse achizitionate:</p>
         <table cellpadding="10"> <tr><th>Denumire</th><th>Cantitate</th><th>Pret</th> </tr>
		
	<?php endif; ?>

	 <tr>
	<td><?php echo $comanda['denumire']; ?></td>
	<td><?php echo $comanda['cantitate']; ?></td>
	<td><?php echo $comanda['pret']; ?></td>
    </tr>
    <?php $total=$total + $comanda['pret']; ?>
<?php endforeach; ?>

<tr><td><b>Total: <?php echo $total;
	$total=0;
	 ?> Lei</td></b></tr>
</table>

<?php endif; ?>

	



</div>


  <?=template_footer()?>