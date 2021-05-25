<?php include 'Layout.php'; ?>
<?=template_header('SchimbaParola')?>

<?php 
      $user=new User();

      //DOAR PT UTILIZATORII LOGATI
      if (!$user->get_session()){
      header("location:Login.php");
      }

      $parolavecheErr=$parolanouaErr=$parolanoua2Err=''; 
      $message='';

      if($_SERVER["REQUEST_METHOD"]=="POST") {
            //VALIDARE DATE FORMULAR

          if(empty($_POST["parolaveche"])) {
         $parolavecheErr="Parola este obligatorie";
         }
         else {
         $parolaveche = htmlspecialchars(trim(($_POST["parolaveche"])));
          $parolavecheErr="";
         }


        if(empty($_POST["parolanoua"])) {
         $parolanouaErr="Parola noua este obligatorie";
         }
         else {
         $parolanoua = htmlspecialchars(trim(($_POST["parolanoua"])));
          $parolanouaErr="";
         }  


         if(empty($_POST["parolanoua2"])) {
         $parolanoua2Err="Repetarea parolei este obligatorie";
         }
         else {
         $parolanoua2 = htmlspecialchars(trim(($_POST["parolanoua2"])));
          if($parolanoua!=$parolanoua2)
              $parolanoua2Err="Nu se potrivesc parolele!";
          else
            $parolanoua2Err="";
         }

          //DACA DATELE INTRODUSE SUNT VALIDE SE POATE SCHIMBA PAROLA
        if($parolavecheErr=='' && $parolanouaErr=='' && $parolanoua2Err==''){
          
          if(isset($_SESSION['user']))
           if($user->change_password($_SESSION['user']['id'],$parolaveche,$parolanoua))
            $message='<p class="alert alert-success">Parola a fost actualizata cu succes!</p>';
           else
            $message='<p class="alert alert-danger">Parola veche nu este corecta!</p>';

        }
    }
?>

  <div class="container pt-5 pb-4 text-center ">
<div class="row pt-3 pb-3" style="background-color: white;border-radius: 10px;">
    <div class="col-md-5 mt-2 mb-2 ml-3" style="border:1px solid black;border-radius: 5px" ><img src="usericon.jpg" height="400px"></a></div>
    <div class="col-md-6 mt-2 mb-2 mr-3 justify-content-center">
      <div class='d-flex justify-content-center mt-2 mb-2'><?php echo $message ?></div>
      
      <form action="" method="post">
      
      
       
      <label for="parolaveche" class="input-group">Parola veche:</label>
      <input type="password" name="parolaveche" class="form-control input-group" required>
      <span class="text-danger input-group"><?php echo $parolavecheErr;?></span>
      

    
      
      <label for="prenume" class="input-group">Parola noua:</label>
      <input type="password" name="parolanoua" class="form-control input-group"     required>
      <span class="text-danger input-group"><?php echo $parolanouaErr;?></span>


        <label for="prenume" class="input-group">Repeta parola noua:</label>
      <input type="password" name="parolanoua2" class="form-control input-group"  required>
      <span class="text-danger input-group"><?php echo $parolanoua2Err;?></span>

      
    
    
      <div class="d-flex justify-content-center mt-3 login_container">
          <button type="submit" name="register" class="btn-danger login_btn ">Update</button>
      </div>
  </form>

   </div>
</div>
 </div>

 <?=template_footer()?>


 