<?php include 'Layout.php'; ?>
<?=template_header('DetaliiProdus')?>

<?php 
  include 'class.product.php';
  $user = new User();


  //daca utilizatorul e admin nu poate accesa aceasta pagina
  if(isset($_SESSION['user'])){
      if($_SESSION['user']['rol']=='admin')
        header("location:Produse.php");
  }

  $product=new Product();
  //daca id-ul produsului este setat atunci se iau datele despre produs altfel se redirectioneaza userul la pagina Produse
  if(isset($_GET['id']))
    $produs=$product->show_product($_GET['id']);
  else
    header("location:Produse.php");

  //daca nu se gaseste un produs cu id-ul cerut in baza de date user-ul este trimis la pagina Produse
  if(!$produs)
     header("location:Produse.php");

   $categorie=(int)$produs['categorieID'];
    
    $sql="SELECT nume FROM categorii WHERE id=$categorie";
    $numecategorie=$user->db->query($sql) or die('failed');
    $numecategorie=$numecategorie->fetch_assoc();
    
?>


  <div class="container pt-5 pb-4 text-center ">
      <div class="row" style="background-color: white;border-radius: 10px;">
          <div class="col-md-7" style="overflow:hidden;" >
            <img src="<?php echo $produs['img'] ?>" height="500px" class="productpageimg">
          </div>

          <div class="col-md-5 pt-5 pl-3 pr-3 pb-3 text-center">
            <h2 style="border-bottom: 1px solid red;"><?php echo $produs['denumire'] ?></h2>

            <b><h4 class="pt-3">Pret:<?php echo $produs['pret'] ?> lei</h4></b>

            <p class="pt-2 pl-2 pr-2"><b>Durata de livrare:</b> Livrare in 24 de ore pentru comenzile plasate pana in ora 16.00 in zilele lucratoare</p>

            <div class="mb-3" style="overflow: scroll;height:120px;border:1px solid black;border-radius: 3px">
                <?php echo $produs['descriere'] ?>
            </div>

            <p class="mr-5" style="display: inline" >Numar jucatori: <?php echo $produs['nr_min_jucatori'] ?>-<?php echo $produs['nr_max_jucatori'] ?></p>
           
            <p style="display: inline">Categorie: <?php if($numecategorie) echo $numecategorie['nume'] ?></p>


    <!-- se afiseaza doar la clienti -->
      <div class="d-flex justify-content-center">
        <form action="CosPersistent.php" method="GET">
          <label for="cantitate">Cantitate:</label>
          <input type="number" name="cantitate" class="form-control ml-5 mt-4 mr-2 mb-2" style="width:150px;display: inline;" min="1" value="1">

          <input type="hidden" name="id_produs" value="<?php echo $produs['id'] ?>" >
          <input type="hidden" name="action" value="add">

          <?php 
          //USER-UL POATE ADAUGA PRODUS IN COS DOAR DACA ESTE LOGAT
            if($user->get_session())
                 echo " <button type='submit' class='btn btn-danger' style='display:block;width:400px'>Cumpara</button>";
            else
                  echo " <a href='Login.php' class='btn btn-danger'>Cumpara</a>";
          ?>
        
       </form>
     </div>



          </div>
      </div>
 </div>

<?=template_footer()?>

