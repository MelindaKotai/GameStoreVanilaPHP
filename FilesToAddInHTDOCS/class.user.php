<?php

class User{

	public $db;
	//CONEXIUNE LA BAZA DE DATE
	public function __construct(){
		$this->db = new mysqli(DB_SERVER, DB_USERNAME,DB_PASSWORD, DB_DATABASE);
		if(mysqli_connect_errno()) {
			echo "Error: Nu se poate conecta la bd.";
 			exit;
		}
	}


	//register users-default role is client
	public function reg_user($nume,$prenume,$email,$tel,$judet,$localitate,$adresa,$parola,$rol="client"){
		$parola = md5($parola);

		$sql=$this->db->prepare("SELECT * FROM users WHERE email=?");
		
		//verific dacae email-ul este in bd
		$sql->bind_param("s",$email);
		$sql->execute();
		$result=$sql->get_result();
		
		$count_row = $result->num_rows;
		//daca email-ul nu este in tabel se insereaza user-ul atlfel se returneaza false
		if ($count_row == 0){
			$sql1=$this->db->prepare("INSERT INTO users SET nume= ?, prenume= ?, email= ?, telefon= ?,judet= ?,localitate= ?,adresa= ?,rol= ?,parola= ?");
			$sql1->bind_param("sssssssss",$nume,$prenume,$email,$tel,$judet,$localitate,$adresa,$rol,$parola);
		    if($sql1->execute())
				return true;
			else
				return false;

		}
		else  
			return false;
		}



    //Login users
	public function login_user($email, $parola){
		 $parola = md5($parola);
		 $sql2=$this->db->prepare("SELECT id,nume,prenume,email,telefon,judet,localitate,adresa,rol from users WHERE email= ? AND parola= ? ");
		 //verific daca exista contul
		 
		 $sql2->bind_param('ss',$email,$parola);
		 $sql2->execute();
		 $result=$sql2->get_result();
		 $user_data = $result->fetch_assoc();
		 $count_row = $result->num_rows;
		 //daca se gaseste exact un utiizator acesta se poate loga
		 if ($count_row == 1) {
			
			 $_SESSION['login'] = true;
			 $_SESSION['user'] = $user_data;
			 return true;
		 }
		 else{
		 return false;
		}
 }


  //update user myaccount
  public function update_user($nume,$prenume,$email,$tel,$judet,$localitate,$adresa,$id){
   	  $sql=$this->db->prepare("SELECT email FROM users WHERE id=?");
   	  $sql->bind_param("i",$id);
   	  $sql->execute();

   	  $emailuser=$sql->get_result();
   	  $emailuser=$emailuser->fetch_assoc();
      $emailuser=$emailuser['email'];
   	  //se verifica daca user-ul doreste sa isi schimbe email-ul
   	  if($email==$emailuser){
   	  	//daca user-ul nu isi schimba emai-ulatunci se actualizeaza datele sale din baza de date
   	  	$sql2=$this->db->prepare("UPDATE users SET nume=?,prenume=?,email=?,telefon=?,judet=?,localitate=?,adresa=? WHERE email=?");
   	  	$sql2->bind_param("ssssssss",$nume,$prenume,$email,$tel,$judet,$localitate,$adresa,$email);
   	  	   
   	  	    if($sql2->execute())
			 return true;
			 else
			 return false;
   	  }else{
   	  	//daca user-ul isi schimba email-ul se verifica daca mai exista useri in baza de date cu email-ul nou trimis de user
   	  $sql1=$this->db->prepare("SELECT * FROM users WHERE email=?");
   	  $sql1->bind_param("s",$email);
   	  $sql1->execute();
   	  $rezultat=$sql1->get_result();
   	  $count_row = $rezultat->num_rows;
   	  
   	  //daca nu exista alti utilizatori se realizeaza actualizarea altfel nu se realizeaza si se returneaza fals
   	  if($count_row==0){
	      $sql3=$this->db->prepare("UPDATE users SET nume=?,prenume=?,email=?,telefon=?,judet=?,localitate=?,adresa=? WHERE email=?");
	      $sql3->bind_param("ssssssss",$nume,$prenume,$email,$tel,$judet,$localitate,$adresa,$email);
	      if($sql3->execute())
				return true;
		else
				return false;
      }
      else
      	return false; 
      	}	
  }


  //stergere user
  public function delete_user($id){
  $sql = $this->db->prepare("DELETE from users where id=?");
  $sql->bind_param("i",$id);
  
  if($sql->execute())
  	return true;
  else
  	return false;
  }


  //afisare toti useri
  public function show_users(){
  	$data=array();
  	$sql="SELECT id,nume,prenume,email,telefon,judet,localitate,adresa,rol FROM users";
  	$result=$this->db->query($sql) or die('nu se poate afisa');
  	 while ($s = $result-> fetch_assoc()){
             array_push ($data , $s);
        }
        return $data;
  }

 
 //schimbare parola
 public function change_password($id,$parolaveche,$parolanoua){
 	 $parolaveche=md5($parolaveche);
 	 $parolanoua=md5($parolanoua);
 	 $sql=$this->db->prepare("SELECT parola FROM users WHERE id=?");
 	 $sql->bind_param("i",$id);
 	 $sql->execute();

 
 	 $result=$sql->get_result();
 	 $parola=$result->fetch_assoc();

 	 //se verifica daca parola veche a utilizatorului se potriveste cu parola noua
 	 if($parolaveche==$parola['parola']){
	     $sql1=$this->db->prepare("UPDATE users SET parola=? WHERE id=?");
	     $sql1->bind_param("si",$parolanoua,$id);
 	     if($sql1->execute())
 			return true;
 		 else
 		 	return false;
     }else

     return false;
 }


 //datele unui utilizator dupa id
 public function get_data($id){
 	$sql= $this->db->prepare("SELECT nume,prenume,email,telefon,judet,localitate,adresa,rol FROM users WHERE id=?");
 	$sql->bind_param("i",$id);
 	$sql->execute();
    $result=$sql->get_result();
 	$user_data=$result->fetch_assoc();
 	return $user_data;
 }


    //se verifica daca utilizatorul este logat
 	public function get_session(){
		 if(isset($_SESSION['login']))
		    return $_SESSION['login'];
		else return false;
		 }


    //se delogheaza user-ul se sterge sesiuneas
 	public function user_logout() {
		 if(isset($_SESSION['login'])){
		 $_SESSION['login'] = FALSE;
		 session_destroy();
		}
 	}

 	
}
?>