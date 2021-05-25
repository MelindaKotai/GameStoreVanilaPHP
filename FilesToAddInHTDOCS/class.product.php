<?php

class Product{
    public $db;
    
    public function __construct(){
        $this->db = new mysqli(DB_SERVER, DB_USERNAME,DB_PASSWORD, DB_DATABASE);
        if(mysqli_connect_errno()) {
            echo "Error: Nu se poate conecta la bd.";
            exit;
        }
    }  

    
    //afisare produse 
    public function show_products($offset,$numberofproducts,$str='default',$categorie='default',$min='default',$max='default',$nrjucatori='default'){
        $data= array();
        $str=strtolower($str);

        //initializare query de baza 
        $sql = "SELECT * from jocuri ";
        $sql1 = "SELECT COUNT(id) as total from jocuri ";
        
        //initializare continuari query-uri in functie de datele transmise 
        $sqlsearch= " LOWER(denumire) LIKE '%$str%' AND";
        $sqlcategorie=" categorieID=$categorie AND";
        $sqlpret=" pret>=$min AND pret<=$max AND";
        $sqljucatori=" nr_min_jucatori<=$nrjucatori AND nr_max_jucatori>=$nrjucatori ";
        

        if($str!='default' || $categorie!='default' || $min!='default' || $max!='default' ||  $nrjucatori!='default')
            {
                $sql=$sql." WHERE ";
                $sql1= $sql1." WHERE ";
            }    

       
        if( $str!='default')  
            {
                $sql=$sql.$sqlsearch;
                $sql1= $sql1.$sqlsearch;
            }    


        if( $categorie!='default')
        {
            $sql=$sql.$sqlcategorie;
            $sql1= $sql1.$sqlcategorie;
        }


        if($min!='default' || $max!='default')
        {
            $sql=$sql.$sqlpret;
            $sql1= $sql1.$sqlpret;
        }
        

        if($nrjucatori!='default')
        {
            $sql=$sql.$sqljucatori;
            $sql1= $sql1.$sqljucatori;
        }

        //se verifica daca ultimul cuvant din query-ul de baza este AND
        if(substr($sql, -3)=="AND")
        {//DACA ESTE ATUNCI SE STERGE 
            $sql=substr($sql, 0, -3);
            $sql1=substr($sql1, 0, -3);
        }
        
        //SE ADAUGA LIMITELE PT PAGINARE
        $sql=$sql." LIMIT $offset,$numberofproducts ";
        


        $q = $this->db->query($sql) or die ("failed");
        while ($s = $q-> fetch_assoc()){
             array_push ($data , $s);
        }



        //SE SALVEAZA NUMARUL TOTAL DE INREGISTRARI CARE SE INCADREAZA IN CRITERIILE TRANSMISE
        $q2 = $this->db->query($sql1) or die ("failed2");
        $q2=$q2->fetch_assoc();
        $total=$q2['total'];
        
        $data['total_products']=$total;
        return $data;

       
    }



    //date despre un produs dupa id
    public function show_product($id){ 
        $result = $this->db->prepare("SELECT * FROM jocuri WHERE id=?");
        $result->bind_param('i',$id);
        $result->execute();
        $result=$result->get_result();
        if($result->num_rows==1)
        {
            $result= $result->fetch_assoc();
            return $result;
        }
        else
            return false;
    }



   //stergerea unui produs
    public function delete_product($id){
        $result = $this->db->prepare("DELETE from jocuri where id=?");
        $result->bind_param('i',$id);
        if( $result->execute()){
            return true;
        }else{
            return false;
        }
    }

    

    //actualizarea unui produs
    public function update_product($id,$denumire,$pret,$min,$max,$descriere,$categorieID,$imgpath){
   
        if($imgpath!='')
             {$sql=$this->db->prepare("UPDATE jocuri SET denumire=?,pret=? ,nr_min_jucatori=? ,nr_max_jucatori=? ,descriere=?,categorieID=? ,img=? WHERE id=?");
             $sql->bind_param("siiisisi",$denumire,$pret,$min,$max,$descriere,$categorieID,$imgpath,$id);
         }
        else{
            $sql=$this->db->prepare("UPDATE jocuri SET denumire=?,pret=?,nr_min_jucatori=? ,nr_max_jucatori=? ,descriere=? ,categorieID=? WHERE id=?");
            $sql->bind_param("siiisii",$denumire,$pret,$min,$max,$descriere,$categorieID,$id);
        }

      
        if($sql->execute()){
            return true;
        }else{
            return false;
        }
    }



    //crearea unui produs nou
    public function create_product($denumire,$pret,$min,$max,$descriere,$categorieID,$imgpath){
    
            
             $sql=$this->db->prepare("INSERT INTO jocuri SET denumire=?,pret=? ,nr_min_jucatori=? ,nr_max_jucatori=? ,descriere=? ,categorieID=? ,img=? ");
             $sql->bind_param("siiisis",$denumire,$pret,$min,$max,$descriere,$categorieID,$imgpath);


            
            if( $sql->execute()){
                return true;
            }else{
                return false;
            }
        }


    public function getcategories(){
        $result=array();
        $sql="SELECT * FROM categorii";
        $q=$this->db->query($sql) or die ("failed");
       
       
        while ($s = $q-> fetch_assoc()){
             array_push ($result, $s);
        }

        if($result)
            return $result;
        else
            return false;
    }
    
 
}