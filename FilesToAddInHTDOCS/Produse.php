
<?php session_start();
  include_once 'class.user.php';
  include 'class.product.php';
  include 'Layout.php';
  include "Conection.php";

  $user = new User();
  $message='';
  //se verifica daca userului vrea sa se delogheze 
  if (isset($_GET['q'])){
    $user->user_logout();
    header("location:Login.php");
  }

  //mesaj de actualizare realizata cu succes a unui produs de catre admin
  if(isset($_GET['message']))
    $message=$_GET['message'];

 //se afiseaza link-uri diferite in functie de rolul user-ului si daca acesta este logat sau nu
  echo <<<EOT
    <!DOCTYPE html>
    <html>
    <head>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">

    <!-- jQuery and JS bundle w/ Popper.js -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="stylelogin.css">
      <title>Produse</title>
    </head>
    <body>
      
      
    <nav class="navbar navbar-expand-md navbar-dark bg-danger pl-5 pb-1 pt-0" >
          <a class="navbar-brand" style="font-family: Brush Script MT, Brush Script Std, cursive;font-size: 25px;" href="Index.php">
          <img src="pixlr-bg-result (1).png" height="75px" width="70px" class="align-item-center">The Dice Knighthood
          </a>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>

          <div class="collapse navbar-collapse " id="navbarsExampleDefault">
            <form class="form-inline my-2 my-lg-0 ml-auto" action="" method="get">
           <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search" name="search">
           <button class="btn btn-outline-light my-2 my-sm-0" type="submit">Search</button>
           </form>
            <ul class="navbar-nav ml-auto" style="font-size:20px;">
              <li class="nav-item">
                <a class="nav-link" href="#Contact">Contact <?php echo "test";?> </a> 
              </li>
EOT;

            if(isset($_SESSION['user'])){
               if($_SESSION['user']['rol']=='client'){
                echo <<<EOT
           <li class="nav-item">
            <a class="nav-link" href="Comenzi.php">Comenzi</a>
          </li>
            <li class="nav-item">
              <a class="nav-link" href="Cos.php"><i class="fa fa-shopping-cart" style="font-size:24px"></i></a>
            </li>
EOT;
                }
            else {
              echo <<<EOT
              <li class="nav-item">
              <a class="nav-link" href="Create.php">Produs Nou</a>
              </li> 
            <li class="nav-item">
              <a class="nav-link" href="Users.php">Clienti</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="Vanzari.php">Comenzi</a>
            </li>
EOT;
            }
             echo <<<EOT
            <li class="nav-item">
              <a class="nav-link" href="MyAccount.php">MyAccount</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="?q=1">Logout</a>
            </li>
             </ul>
        </div>
      </nav>
EOT;
        }
        else{
          echo <<<EOT
           <li class="nav-item">
            <a class="nav-link" href="Login.php">Login</a>
            </li> 
          <li class="nav-item">
            <a class="nav-link" href="Register.php">Register</a>
        </ul>
      </div>
    </nav>
EOT;
     }
?>


<?php $product=new Product();
    //obtinem categoriile din baza de date
    $categorii=$product->getcategories();
    //se verifica numarul paginii curente,daca acesta nu este setat sau nu este un numar valid ia valoarea 1
    $current_page = isset($_GET['p']) && is_numeric($_GET['p']) ? (int)$_GET['p'] : 1;
    //se verifica daca se doreste sa se realizeze o cautare si se salveaza valoarea string-ului cautat in variabila str daca nu aceasta primeste valoarea default-analog pt categorie, min , max , nrjucatori
    $str=isset($_GET['search'])?$_GET['search'] : 'default';
    $categorie=isset($_GET['categorie']) && ($_GET['categorie'])!=''?$_GET['categorie'] : 'default';
    $min=isset($_GET['min']) && is_numeric($_GET['min']) ? (int)$_GET['min'] : 0;
    $max=isset($_GET['max']) && is_numeric($_GET['max']) ? (int)$_GET['max'] : 9999;
    $nrjucatori=isset($_GET['nrjucatori']) && is_numeric($_GET['nrjucatori']) ? (int)$_GET['nrjucatori'] : 'default';
    
    //numarul de produse ce se doreste sa fie afisat pe fiecare pagina
    $num_products_on_each_page = 9;
    //de la ce produs se doreste sa inceapa interogarea 
    $offset=($current_page - 1) * $num_products_on_each_page;


    //se obtin produsele care se doresc a fi afisate 
    $produse=$product->show_products($offset,$num_products_on_each_page,$str,$categorie,$min,$max,$nrjucatori);

    //se verifica daca exista produse cu cerintele date 
    if(count($produse)==1)
       echo "<p class='alert alert-danger'>Nu este nici un produs asemanator cu cel cerut de dumneavoastra!</p>";
    //se salveaza numarul total de produse care indeplinesc cerintele cerute 
    $total_products=$produse['total_products'];
   
    //se salveaza parametrii din _get request pentru a putea fi purtati de pe o pagina pe alta
    $params = $_GET;
    //parametrul p nu va fi purtat deoarece acesta se schimba la fiecare pagina
    unset($params['p']);
    $query = http_build_query($params);
?>

  <div class="container pt-5 pb-4 text-center " style="min-height: 60vh;">
      <?php echo $message ?>
      

      <!-- filtrele -->
      <div class="productbox">

         <form style="display: inline;" class="ml-4" action="" method="get">
              <select  name="categorie" class="form-control ml-4" style="width:200px;display:inline;">
                <?php if($categorii)
                    foreach($categorii as $categorie)
                      echo "<option value='".$categorie['id']."'>Jocuri de ".$categorie['nume']."</option>";
                      ?>
                
              </select>

              <span class="ml-3">Filtreaza dupa pret</span>
              <label for="min" class="ml-2">Min:</label>
              <input type="number" name="min" class="form-control ml-2 mr-2" style="width:80px;display: inline;" min="1">

              <label for="max" class="ml-2">Max:</label>
              <input type="number" name="max" class="form-control ml-2 mr-2" style="width:80px;display: inline;" min="1">

              <label for="nrjucatori" class="ml-2">Numar de jucatori:</label>
              <input type="number" name="nrjucatori" class="form-control ml-2 mr-2" style="width:60px;display: inline;" min="1">

              <button type="submit" class="btn btn-danger">Filtreaza</button>
        </form>
    </div>

    <div class="row">
        <?php 
          for ($i=0;$i<(count($produse)-1);$i++) {

           echo "<div class='col-md-4 column'>
                   <div class='productbox' style='overflow:hidden;'>";
          
          if(isset($_SESSION['user']))
            if($_SESSION['user']['rol']=='admin')
              echo "<img src='".$produse[$i]['img']."' class='imgp'>";
            else
              echo "<a  href='DetaliiProdus.php?id=".$produse[$i]['id']."'><img class='imgp' src='".$produse[$i]['img']."'></a>";
          else
            echo "<a  href='DetaliiProdus.php?id=".$produse[$i]['id']."'><img class='imgp' src='".$produse[$i]['img']."'></a>";
          
          echo "<div class='producttitle'>".$produse[$i]['denumire']."</div>
                <div class='productprice'>";
          
          if(isset($_SESSION['user']))
            if($_SESSION['user']['rol']=='admin')
              echo "<div class='pull-right'><a href='Delete.php?id=".$produse[$i]['id']."' class='btn btn-danger btn-sm' role='button'>Sterge</a></div>
                <div class='pull-right'><a href='Edit.php?id=".$produse[$i]['id']."' class='btn btn-success btn-sm' role='button'>Editeaza</a></div>";
           else
             echo "<div class='pull-right'><a href='DetaliiProdus.php?id=".$produse[$i]['id']."' class='btn btn-danger btn-sm' role='button'>Cumpara</a></div>";
           else
             echo "<div class='pull-right'><a href='DetaliiProdus.php?id=".$produse[$i]['id']."' class='btn btn-danger btn-sm' role='button'>Cumpara</a></div>";
          echo "<div class='pricetext'>".$produse[$i]['pret']." Lei</div></div>
    </div>
</div>";

      }

    ?>
  </div>

  <div class="clear"></div>
  

 <!-- paginarea -->
  <ul class="pagination">
   <?php 
    //se calculeaza totalul de pagini care sa fie afisate
     $total_pages = ceil($total_products / $num_products_on_each_page); 
     if ($current_page > 1): ?>
       <li class="page-item"><a class="page-link" href="?p=<?php echo ($current_page-1).'&'.$query ?>">Prev</a></li>
    <?php endif; ?>
    <?php for ($i=1; $i<=$total_pages; $i++)
      echo "<li class='page-item'><a class='page-link' href='?p=".$i."&".$query."'>".$i."</a></li>";
    ?>
    <?php if ($total_products >= ($current_page * $num_products_on_each_page)): ?>
      <li class="page-item"><a class="page-link" href="?p=<?php echo ($current_page+1).'&'.$query ?>">Next</a></li>
    <?php endif; ?>
 </ul>


 </div>
 <div class="clear"></div>
 


<?=template_footer()?>


