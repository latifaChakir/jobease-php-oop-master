<?php 

class Job{
   private $conn;
   private $id;
   private $title;
   private $description;
   private $company;
   private $location;
   private $status;
   private $date_created;
   private $image_path;
   
   public function __construct($conn)
   {
     $this->conn = $conn;
   }
public function getTitle(){
    return $this->title;
}
public function getDescription(){
    return $this->description;
}
public function getCompany(){
    return $this->company;
}
public function getLocation(){
    return $this->location;
}
public function getStatus(){
    return $this->status;
}
public function getDateCreated(){
    return $this->date_created;
}
public function getImagePath(){
    return $this->image_path;
}
public function setTitle($title){
    $this->title=$title;
}
public function setDescription($description){
    $this->description=$description;
}
public function setCompany($company){
    $this->company=$company;
}
public function setLocation($location){
    $this->location=$location;
}
public function setStatus($status){
    $this->status=$status;
}
public function setDateCreated($date_created){
    $this->date_created=$date_created;
}
public function setImagePath($image_path){
    $this->image_path=$image_path;
}

public function getOffres(){
    $offres=array();
    $req="SELECT * from jobs";
    $result=$this->conn->query($req);
    while($array=$result->fetch_array()){
        $offres[]=$array;
}
return $offres;
}
public function sauvegarder()
{
    if ($this->id) {
        $requete = $this->conn->prepare("UPDATE jobs SET title = ?, description = ? WHERE id = ?");
        $requete->execute([$this->title, $this->description, $this->id]);
    } else {
        $requete = $this->conn->prepare("INSERT INTO jobs (title, description,company,location,status,date_created) VALUES (?, ?, ?, ?, ?, ?)");
        $requete->execute([$this->title, $this->description, $this->company, $this->location, $this->status, $this->date_created]);
        $this->id = $this->conn->insert_id; 
    }
}

public function supprimer(){
    $requette="delete from jobs where job_id =?";
    $result=$this->conn->query($requette);
    
}




}
?>