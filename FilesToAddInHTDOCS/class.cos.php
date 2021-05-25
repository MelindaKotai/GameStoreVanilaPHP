<?php

class Cos
{
        public $db;
       


        public function __construct(){
            $this->db = new mysqli(DB_SERVER, DB_USERNAME,DB_PASSWORD, DB_DATABASE);
            if(mysqli_connect_errno()) {
              echo "Error: Nu se poate conecta la bd.";
              exit;
            }
        }  


     //returneaza cosul de cumparaturi al unu client
     function getClientCartItems($id_client)
     {
     $sql = $this->db->prepare("SELECT jocuri.*, cos.id as cart_id, cos.cantitate FROM jocuri, cos WHERE jocuri.id = cos.id_produs AND cos.id_client = ? AND cos.starecomanda='necomandata' ");
       
       
       $sql->bind_param('i', $id_client);
       
       $sql->execute();
       $result = $sql->get_result();

       if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
        $resultset[] = $row;
       }
       }

       if (!empty($resultset)) 
          return $resultset;
      else
      	return false;
    }

     
     //returneaza id-ul inregistrarii din tabelul cos im functie de id-ul clientului si a produsului
     function getCartItemByProduct($id_produs, $id_client)
     {
     $sql = $this->db->prepare("SELECT * FROM cos WHERE id_produs = ? AND id_client = ? AND starecomanda='necomandata' ");
     $sql->bind_param('ii',$id_produs,$id_client);
       $sql->execute();
       $result = $sql->get_result();
       $result=$result->fetch_assoc();

       if (!empty($result)) 
          return $result;
      else
      	return false;
     }
     

     //adauga un prodsu nou in cosul de cumparaturi a unui client cu cantitatea aleasa de client
     function addToCart($id_produs, $cantitate, $id_client)
     {
     $sql = $this->db->prepare("INSERT INTO cos(id_produs,cantitate,id_client,starecomanda) VALUES (?, ?, ?,'necomandata')");
     $sql->bind_param('iii',$id_produs,$cantitate,$id_client);
     if($sql->execute())
     	return true;
     	else
     	return false;
     }
     

     //actualizeaza cantitatea unei  inregistrari din tabela cos 
     function updateCartQuantity($cantitate, $id_cos)
     {
     $sql = $this->db->prepare("UPDATE cos SET cantitate = ? WHERE id= ?");
     $sql->bind_param('ii',$cantitate, $id_cos);
    if($sql->execute())
     	return true;
     	else
     	return false;
     }

     //sterge o inregistrare din cos
     function deleteCartItem($id_cos)
     {
     $sql = $this->db->prepare("DELETE FROM cos WHERE id = ?");
     $sql->bind_param('i',$id_cos);
     if($sql->execute())
     	return true;
     else
     	return false;
     }


     //get cart by id
     function getCart($id){

     	$sql = $this->db->prepare("SELECT * FROM cos WHERE id = ?");
     	$sql->bind_param('i',$id_cos);
       if($sql->execute())
     	  return true;
       else
     	  return false;
     }


     //sterge cosul de cumparaturi a unui client
     function emptyCart($id_client)
     {
     $sql = $this->db->prepare("DELETE FROM cos WHERE id_client = ? AND starecomanda='necomandata' ");

     $sql->bind_param('i',$id_client);
     if($sql->execute())
     	return true;
     else
     	return false;
     }



     //se inregistreaza o comanda in tabela vanzari
     function plasarecomanda($id_client,$id_produs,$cantitate,$starecomanda){
  

    $sql=$this->db->prepare("INSERT INTO cos(id_client,id_produs,cantitate,starecomanda) VALUES(?,?,?,?)");
    $sql->bind_param("iiis",$id_client,$id_produs,$cantitate,$starecomanda);
    if($sql->execute())
      return true;
     else
      return false; 
     }


    function plasarecomandapersistent($id_client){
  
    $sql=$this->db->prepare("UPDATE cos SET starecomanda='neprocesata' WHERE id_client=? AND starecomanda='necomandata' ");
    $sql->bind_param("i",$id_client);
    if($sql->execute())
      return true;
     else
      return false; 
     }

    

     //returneaza toate vanzarile realizate de magazin ordonate in functie de cele mai vechi la cele mai recente 
     function getsales(){
      $data=array();
      $sql="select cos.*,pret, nume , prenume , email, telefon,judet, localitate, adresa, denumire from cos,jocuri,users WHERE cos.id_client=users.id AND cos.id_produs=jocuri.id AND (starecomanda='neprocesata' OR starecomanda='procesata') order by cos.data";
      $sql=$this->db->query($sql) or die('faileddd');
      while ($s = $sql-> fetch_assoc()){
             array_push ($data , $s);
        }
        return $data;

     }
     
     //modifica starea unei comenzi din procesata in neprocesata
     function modificastare($id,$stare){
      
     
      $sql=$this->db->prepare("UPDATE cos SET starecomanda=? WHERE id IN ($id)");

      $sql->bind_param("s",$stare);
      if($sql->execute())
        return true;
      else
        return false;
     }

     
     //returneaza toate comenzile user-ului logat
     function getsalesbyid($id_client){
       $data=array();
      $sql="select cos.*, pret, denumire from cos,jocuri WHERE cos.id_produs=jocuri.id AND id_client=$id_client AND (starecomanda='neprocesata' OR starecomanda='procesata') order by data DESC";
      $sql=$this->db->query($sql) or die('failed');
      while ($s = $sql-> fetch_assoc()){
             array_push ($data , $s);
        }
        return $data;


     }


}
