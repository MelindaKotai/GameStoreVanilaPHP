
<?php 
function template_header($title) {
	session_start();
  include_once 'class.user.php';
  include "Conection.php";
  $user = new User();
  
 //se verifica daca utilizatorul vrea sa se logheze
  if (isset($_GET['q'])){
    $user->user_logout();
   header("location:login.php");
  }

//3 cazuri -daca userul este nelogat atunci ii arata home,contact,Login,Register
//-daca userul este logat 1. este client ii arata home, contact , cosul de cumparaturi, myaccount, logout
//2.clientul este admin home,contact,produs nou, clienti,comenzi,myaccount,logout

  echo <<<EOT
  <!DOCTYPE html>
  <html>
  <head>
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
 
  <!-- BOOTSTRAP -->

  <!-- CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">

  <!-- jQuery and JS bundle w/ Popper.js -->
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
  

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  
  <link rel="stylesheet" href="stylelogin.css">
  	


    <title>$title</title>



  </head>
  <body>
  	
  	
  <nav class="navbar navbar-expand-md navbar-dark bg-danger pl-5 pb-1 pt-0" >
        <a class="navbar-brand" style="font-family: Brush Script MT, Brush Script Std, cursive;font-size: 25px;" href="Index.php">
        <img src="pixlr-bg-result (1).png" height="75px" width="70px" class="align-item-center">The Dice Knighthood
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarsExampleDefault">
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

}


// Template footer
function template_footer() {

echo <<<EOT
 <div id="Contact" class="pt-4">
    <footer class="page-footer font-small pt-3 pb-2 bg-danger">
      <div class="container" style="color:white;">
	        <p><i class="fa fa-map-marker" style="font-size:24px;margin-right: 8px;"></i>  Adresa: Str. Bucuresti nr.2, Cluj-Napoca</p>
			<p><i class="fa fa-phone-square" style="font-size:24px;margin-right: 8px;"></i>Telefon: 0745234568</p>
			<p><i class="fa fa-calendar" style="font-size:24px;margin-right: 8px;"></i>Program: Luni-Vineri, 09:00-21:00</p>
			<p><i class="fa fa-envelope" style="font-size:24px;margin-right: 8px;"></i>E-mail: thediceknighthood@yahoo.com</p>
	      </div>
    </footer>

</div>

</body>
</html>
EOT;
}
?>