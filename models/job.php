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
   private $image_name;
   
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
    $uploadDir = __DIR__ . "/../views/admin/dashboard/img/";

    if (is_uploaded_file($_FILES['image_path']['tmp_name'])) {

        $uploadFileName = uniqid() . basename($_FILES['image_path']['name']);
        $uploadFile = $uploadDir . $uploadFileName;

        move_uploaded_file($_FILES['image_path']['tmp_name'], $uploadFile);

        $imagePathInDatabase = $uploadFileName;

        if ($this->id) {
            $requete = $this->conn->prepare("UPDATE jobs SET title = ?, description = ?, company = ?, location = ?, status = ?, date_created = ?, image_path = ? WHERE job_id = ?");
            $requete->bind_param("sssssssi", $this->title, $this->description, $this->company, $this->location, $this->status, $this->date_created, $imagePathInDatabase, $this->id);
            $requete->execute();
        } else {
            $requete = $this->conn->prepare("INSERT INTO jobs (title, description, company, location, status, date_created, image_path) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $requete->bind_param("sssssss", $this->title, $this->description, $this->company, $this->location, $this->status,$this->date_created,$imagePathInDatabase);
            $requete->execute();
            $this->id = $this->conn->insert_id;
        }

        $requete->close();

        echo "Chemin complet : " . $uploadFile . "<br>";
    } else {
        echo "Erreur lors du téléchargement du fichier. Code d'erreur : " . $_FILES['image_path']['error'];
    }
}



public function getOffresById($id) {
    $req = "SELECT * FROM jobs WHERE job_id = ?";
    $stmt = $this->conn->prepare($req);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $jobDetails = $result->fetch_assoc();

        $this->id = $jobDetails['job_id'];
        $this->title = $jobDetails['title'];
        $this->description = $jobDetails['description'];
        $this->company = $jobDetails['company'];
        $this->location = $jobDetails['location'];
        $this->status = $jobDetails['status'];
        $this->date_created = $jobDetails['date_created'];
        $this->image_path = $jobDetails['image_path'];

        return $jobDetails;
    }

    return null;
}


public function supprimer(){
    $requete = "DELETE FROM jobs WHERE job_id = ?";
    $stmt = $this->conn->prepare($requete);
    $stmt->bind_param("i", $this->id);
    $stmt->execute();
    $stmt->close();
}

public function search($searchTerm)
{
    $stmt = "SELECT * FROM jobs WHERE (title LIKE  '%$searchTerm%' OR company LIKE '%$searchTerm%' OR location LIKE '%$searchTerm%' ) AND status='Open'";
    $result = $this->conn->query($stmt);

    $searchResults = [];
    
    while ($row = $result->fetch_assoc()) {
        $searchResults[] = $row;
    }

    return $searchResults;
}


function getTotalOffres($conn) {
    $offreCountQuery = "SELECT COUNT(*) as total_offres FROM jobs";
    $offreCountStmt = $conn->prepare($offreCountQuery);
    
    if ($offreCountStmt) {
        $offreCountStmt->execute();
        $offreCountResult = $offreCountStmt->get_result();

        if ($offreCountResult) {
            $offreData = $offreCountResult->fetch_assoc();
            return $offreData['total_offres'];
        }
    }

    return 0;
}


}
?>