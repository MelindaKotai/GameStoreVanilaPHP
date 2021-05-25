<?php include 'Layout.php'; ?>
<?=template_header('MyAccount')?>

     
 <?php
 
      $user = new User();
      
      //DOAR PENTRU USERI LOGATI
      if (!$user->get_session()){
        header("location:Login.php");
      }

      
      
      $numeErr=$prenumeErr=$emailErr=$telErr=$judetErr=$localitateErr=$adresaErr=''; 
      $message='';
      

      if(isset($_SESSION['user']['id']))
      {
        $id = $_SESSION['user']['id'];
      }
     
      //SE INITIALIZEAZA VARIABILELE CU DATELE USER-ULUI LOGAT
      $user_data=$user->get_data($id);

      $nume=$user_data['nume'];
      $prenume=$user_data['prenume'];
      $email=$user_data['email'];
      $tel=$user_data['telefon'];
      $judet=$user_data['judet'];
      $localitate=$user_data['localitate'];
      $adresa=$user_data['adresa'];

     if($_SERVER["REQUEST_METHOD"]=="POST") {
        //VALIDARE DATE FORMULAR
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
         if(!preg_match("/^[a-zA-Z ]*$/",$adresa)) 
         $adresaErr="Numai literele si spatiul sunt permise";
         else
          $adresaErr="";
         }

        //DACA DATELE INTRODUSE SUNT CORECTE POT FI INTRODUSE IN BAZA DE DATE
         if($numeErr=='' && $prenumeErr=='' && $emailErr=='' && $telErr=='' && $judetErr=='' && $localitateErr=='' && $adresaErr==''){
         
             $update=$user->update_user($nume,$prenume,$email,$tel,$judet,$localitate,$adresa,$id);
             if($update)
              $message="<p class='alert alert-success'>Datele au fost actualizate cu succes </p>";
             else
                $message="<p class='alert alert-danger'>Nu se poate efectua actualizarea deoarece exista deja un cont cu email-ul introdus! Introduceti alt email! </p>";

         
        }
    }
 ?>


  <div class="container pt-5 pb-4 text-center ">
   
  <div class="row pt-3 pb-3" style="background-color: white;border-radius: 10px;">
    <div class="col-md-5 mt-2 mb-2 ml-3" style="border:1px solid black;border-radius: 5px" ><img src="usericon.jpg" height="400px"></a></div>
    <div class="col-md-6 mt-2 mb-2 mr-3 justify-content-center">
      
      <form action="" method="post">
      
      <div class='f-flex justify-content-center mt-2 mb-2'><?php echo $message ?></div>
       
      <label for="nume" class="input-group">Nume:</label>
      <input type="text" name="nume" class="form-control input-group"   value="<?php echo $nume; ?>" required>
      <span class="text-danger input-group"><?php echo $numeErr;?></span>
      

    
      
      <label for="prenume" class="input-group">Prenume:</label>
      <input type="text" name="prenume" class="form-control input-group"    value="<?php echo $prenume; ?>" required>
      <span class="text-danger input-group"><?php echo $prenumeErr;?></span>
    
    
      <label for="email" class="input-group">Email:</label>
      <input type="email" name="email" class="form-control input-group"  value="<?php echo $email;?>" required>
      <span class="text-danger input-group"><?php echo $emailErr;?></span>
   
    
      
      <label for="tel" class="input-group">Telefon:</label>
      <input type="tel" name="tel" class="form-control input-group"  value="<?php echo $tel;?>" required>
      <span class="text-danger input-group"><?php echo $telErr;?></span>
     
    

      
      <label for="judet" class="input-group">Judet:</label>
      <input type="text" name="judet" class="form-control input-group"  value="<?php echo $judet;?>" required>
      <span class="text-danger input-group"><?php echo $judetErr;?></span>
     
   

     
      <label for="localitate" class="input-group">Localitate:</label>
      <input type="text" name="localitate" class="form-control input-group"  value="<?php echo $localitate;?>" required>
      <span class="text-danger input-group"><?php echo $localitateErr;?></span>
      


     
      <label for="adresa" class="input-group">Adresa:</label>
      <input type="text" name="adresa" class="form-control input-group"  placeholder="Adresa" value="<?php echo $adresa;?>" required="">
      <span class="text-danger input-group"><?php echo $adresaErr;?></span>
   
    
    
      <div class="d-flex justify-content-center mt-3 login_container">
          <button type="submit" name="register" class="btn-danger login_btn ">Update</button>
    </div>
  </form>
   <div class="mt-3 mb-3"><a href="SchimbaParola.php"><button type="button" class="btn btn-danger">Schimba parola</button></a>
</div>
   </div>
</div>
 </div>


<?=template_footer()?>
