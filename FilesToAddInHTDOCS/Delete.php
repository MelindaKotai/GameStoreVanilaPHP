<?php include 'Layout.php'; ?>
<?=template_header('Delete')?>

<?php 
  include 'class.product.php';
  $user = new User();
  if (!$user->get_session()){
  header("location:Login.php");
  }
  //doar administratorii au acces
  if(!($_SESSION['user']['rol']=='admin')){
  header("location:Index.php");
  }

  $product=new Product();
  $message='';

  //se verifica daca este transmis id-ul produsului 
  if(isset($_GET['id']))
    $produs=$product->show_product($_GET['id']);
  else
    header("location:Produse.php");

  //se verifica daca exista produsul in baza de date
  if(!$produs)
     header("location:Produse.php");

    $categorie=(int)$produs['categorieID'];
    
    $sql="SELECT nume FROM categorii WHERE id=$categorie";
    $numecategorie=$user->db->query($sql) or die('failed');
    $numecategorie=$numecategorie->fetch_assoc();
    
   //daca utilizatorul a trimis formularul de delete
   if(isset($_POST['delete'])){
     //se sterge produsul din baza de date si se transmite mesajul corespunzator
     if($product->delete_product($_GET['id']))
      header('location:Produse.php?message=<b><p class="alert alert-danger">Produsul a fost sters</p></b>');
    else
       $message="<b><p class='alert alert-danger'>Nu se poate sterge</p></b>";
   }



  ?>

  <div class="container pt-5 pb-4 text-center ">
  
    <div class="row" style="background-color: white;border-radius: 10px;">
      <div class="col-md-7" >
        <img src="<?php echo $produs['img'] ?> " height="500px" class="productpageimg">
      </div>
        <div class="col-md-5 pt-5 pl-3 pr-3 pb-3 text-center">
          <h2 style="border-bottom: 1px solid red;">
            <?php echo $produs['denumire'] ?>
          </h2>

          <b><h4 class="pt-3">Pret:150 lei</h4></b>
          
          <p class="pt-2 pl-2 pr-2"><b>Durata de livrare:</b> Livrare in 24 de ore pentru comenzile plasate pana in ora 16.00 in zilele lucratoare</p>
          
          <div class="mb-3" style="overflow: scroll;height:120px;border:1px solid black;border-radius: 3px">    
            <?php echo $produs['descriere'] ?>
          </div>

          <p class="mr-5" style="display: inline" >Numar jucatori: <?php echo $produs['nr_min_jucatori'] ?>-<?php echo $produs['nr_max_jucatori'] ?></p>

          <p style="display: inline">Categorie: <?php if($numecategorie) echo $numecategorie['nume'] ?></p>


          <p style="font-size: 30px;"><b> Sunteti sigur ca doriti sa stergeti produsul selectat? <b></p>
          
          <div class="d-flex justify-content-center">
            <form action="" method="post">
                <button type="submit" class="btn btn-danger mb-2" style="display:block;width:400px" name="delete">Da</button>
            </form>
          </div>
          <div class="d-flex justify-content-center">
          <a href="Produse.php" class="btn btn-danger" style="display:block;width:400px">
          Nu
          </a>
        </div>
        
    </div>


</div>
</div>
<?=template_footer()?>





    