<?php include 'Layout.php'; ?>
<?=template_header('DeleteUser')?>

<?php 
  $user = new User();
  if (!$user->get_session()){
  header("location:Login.php");
  }

  //DOAR ADMINISTRATORII AU ACCES 
  if(!($_SESSION['user']['rol']=='admin')){
  header("location:Index.php");
  }
  ?>


  <?php
 
     include_once 'class.user.php';
     $message='';
     $user=new User();

     //SE VERIFICA DACA ESTE SETAT ID-UL UTILIZATORULUI 
     if(isset($_GET['id']))
     	$data=$user->get_data($_GET['id']);
     else
      header('location:Users.php');
        //SE VERIFICA DACA A FOST TRIMIS FORMULARUL DE DELETE
        if(isset($_POST['delete'])){   
        if($user->delete_user($_GET['id']))
          header('location:Users.php?message=<b><p class="alert alert-danger">Utilizatorul a fost sters</p></b>');
        else
           $message="<b><p class='alert alert-danger'>Nu se poate sterge</p></b>";
      }
 
 
 ?>

<div class="container pt-5 pb-4  " style="min-height: 80vh;">
	<div class="pt-4 pr-4 pl-4 pb-4" style="background-color: white;font-size: 18px;border-radius: 20px;">
    <?php echo $message ?>
    <b><p>Date despre persoana</p></b>
    <p>Nume: <?php echo $data['nume'] ?></p>
    <p>Prenume: <?php echo $data['prenume'] ?></p>
    <p>Email: <?php echo $data['email'] ?></p>
    <p>Telefon: <?php echo $data['telefon'] ?></p>
    <p>Judet: <?php echo $data['judet'] ?></p>
    <p>Localitate: <?php echo $data['localitate'] ?></p>
    <p>Adresa: <?php echo $data['adresa'] ?></p>
    <p>Rol: <?php echo $data['rol'] ?></p>
    <b><p class="text-center" style="font-size: 30px">Sunteti sigur ca doriti a stergeti acest cont? </p></b>
    <form action="" method="post" class="text-center">
        <button type="submit" class="btn btn-danger mt-3 mb-3 ml-3 mr-3 " name="delete">DA</button> 

    </form>
    <div class="text-center"><a href="Users.php"><button class="btn btn-success mt-3 mb-3 ml-3 mr-3">NU</button></a></div>
 
  </div>

</div>

<?=template_footer()?>