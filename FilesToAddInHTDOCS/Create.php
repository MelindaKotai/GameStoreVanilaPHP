
<?php include 'Layout.php'; ?>
<?=template_header('Create')?>

<?php 
 include 'class.product.php';
 $user = new User();

  if (!$user->get_session()){
    header("location:Login.php");
  }
  //doar admin are acces la aceasta pagina
  if(!($_SESSION['user']['rol']=='admin')){
    header("location:Index.php");
  }

  $product=new Product();
  $categorii=$product->getcategories();

 
  
  $denumireErr=$pretErr=$minErr=$maxErr=$descriereErr=$categorieIDErr=$message=''; 
  $denumire=$pret=$min=$max=$descriere=$categorieID=''; 

  //se verifica daca formularul a fost trimis
  if($_SERVER["REQUEST_METHOD"]=="POST") {
  //validare formular
     if(empty($_POST["denumire"])) {
       $denumireErr="Denumirea este obligatorie";
     }
     else {
        $denumire = htmlspecialchars(trim(($_POST["denumire"])));
        $denumireErr="";
     }


     if(empty($_POST["pret"])) {
      $pretErr="Pretul este obligatoriu";
     }
     else {
       $pret=htmlspecialchars(trim(($_POST["pret"])));
      if(!preg_match("/^[0-9]*$/",$pret)) 
        $pretErr="Numai numere sunt permise";
       else
        $pretErr="";
     }


     if (empty($_POST["min"])) {
      $minErr="Numarul minim de jucatori este obligatoriu";
     } else {
      $min=htmlspecialchars(trim(($_POST["min"])));
      if (!preg_match('/^[0-9]*$/', $min)) 
        $minErr = "Trebuie introduse doar cifre";
      else
        $minErr="";
     }

     if (empty($_POST["max"])) {
       $minErr="Numarul maxim de jucatori este obligatoriu";
     } else {
         $max=htmlspecialchars(trim(($_POST["max"])));
         if (!preg_match('/^[0-9]*$/', $min)) 
            $maxErr = "Trebuie introduse doar cifre";
            if($min>$max)
                $maxErr="numarul maxim trebuie sa fie mai mare decat numarul minim!";
         else
            $maxErr="";
     }


    if(empty($_POST["descriere"])) {
      $descriereErr="Descrierea este obligatorie";
     }
    else {
     $descriere = htmlspecialchars(trim(($_POST["descriere"])));
     $descriereErr="";
    }



    if(empty($_POST["categorieID"])) {
     $categorieIDErr="Categoria este obligatorie";
    }
    else {
     $categorieID = (int)$_POST["categorieID"];
     $categorieIDErr="";
    }


    //se verifica daca a fost selectata vreo imagine
    if($_FILES['img']['name']!=''){
      //numele directorului unde se va salva imaginea
        $images_dir = "Images/";
      //un numar unic pentru ca numele fiecarei imagini indroduse sa fie diferit  
        $RandomNum = time();
      //se inlocuiesc spatiile din numele imaginii cu -
        $ImageName = str_replace(' ','-',strtolower($_FILES['img']['name']));
      //se ia extensia fisierului trimis
        $ImageExt = substr($ImageName, strrpos($ImageName,'.'));
        //se ia numele imaginii fara extensie
        $ImageName = substr($ImageName,0,strrpos($ImageName,'.'));
        //se elimina . din extensie 
        $ImageExt = str_replace('.','',$ImageExt);

        //numele cu care imaginea va fi salvata in aplicatie
        $NewImageName = $ImageName.'-'.$RandomNum.'.'.$ImageExt;

        //se verifica daca fisierul trimis este o imagine
        if($ImageExt!='jpg' && $ImageExt!='png' && $ImageExt!='jpeg')
          $imgErr='Doar fisiere de tip jpg,png si jpeg sunt permise!';
        else{
          //se salveaza imaginea 
          //$imgpath va fi salvat in baza de date
        $imgpath= $images_dir.$NewImageName;
        move_uploaded_file($_FILES["img"]["tmp_name"],$images_dir."/".$NewImageName );
        $imgErr='';
        }
      }
      else
        $imgpath='';


    if($denumireErr=='' && $pretErr=='' && $minErr=='' && $maxErr=='' && $descriereErr=='' && $categorieIDErr==''){
      
      $produs=$product->create_product($denumire,$pret,$min,$max,$descriere,$categorieID,$imgpath);
      
      if($produs)
        $message="<p class='alert alert-success'>Produsul a fost creat cu succes!</p>";
      else
        $message="<p class='alert alert-danger'>Produsul nu a putut fi creat!</p>";
      
 
}

}

?>
  <div class="container pt-5 pb-4 d-flex justify-content-center ">
   <div class="row pt-3 pb-3" style="background-color: white;border-radius: 10px;">
    <div class=" mt-5 mb-5 mr-5 ml-5 ">
      <div class="d-flex justify-content-center">
        <?php echo $message ?>
      </div>
      <form action="" method="post" enctype="multipart/form-data">
      
      
       
      <label for="denumire" class="input-group">Denumire:</label>
      <input type="text" name="denumire" class="form-control input-group"   value="<?php echo $denumire; ?>" required>
      <span class="text-danger input-group"><?php echo $denumireErr;?></span>
      

    
      
      <label for="pret" class="input-group">Pret:</label>
      <input type="text" name="pret" class="form-control input-group"    value="<?php echo $pret; ?>" required>
      <span class="text-danger input-group"><?php echo $pretErr;?></span>
    
    
      <label for="min" class="input-group">Numar minim de jucatori:</label>
      <input type="number" name="min" class="form-control input-group"  value="<?php echo $min;?>" required>
      <span class="text-danger input-group"><?php echo $minErr;?></span>
   
    
      
      <label for="max" class="input-group">Numar maxim de jucatori:</label>
      <input type="number" name="max" class="form-control input-group"  value="<?php echo $max;?>" required>
      <span class="text-danger input-group"><?php echo $maxErr;?></span>
     
    

      
      <label for="descriere" class="input-group">Descriere:</label>
      <textarea  name="descriere" class="form-control input-group"  value="<?php echo $descriere;?>" required><?php echo $descriere;?></textarea>
      <span class="text-danger input-group"><?php echo $descriereErr;?></span>
     
   

     
      <label for="categorieID" class="input-group">Categorie:</label>
      <select  name="categorieID" class="form-control input-group"  required>
         <?php if($categorii)
                    foreach($categorii as $categorie)
                      echo "<option value='".$categorie['id']."'>Jocuri de ".$categorie['nume']."</option>";
         ?>
      </select>
      <span class="text-danger input-group"><?php echo $categorieIDErr;?></span>
      


     
      <label for="poza" class="input-group">Poza:</label>
      <input type="file" name="img" class="form-control input-group" >
     
   
    
    
      <div class="d-flex justify-content-center mt-3 login_container">
          <button type="submit" class="btn-danger login_btn ">Creaza</button>
    </div>
  </form>
   </div>

 </div>
</div>

<?=template_footer()?>



    