<?php
class Database{
    public $conn;
    private $servername;
    private $username;
    private $password;
    private $dbname;
    public function __construct($servername,$username,$password,$dbname){
        $this->servername=$servername;
        $this->username=$username;
        $this->password=$password;
        $this->dbname=$dbname;
        $this->conn=new mysqli($this->servername,$this->username,$this->password,$this->dbname);
        if(!$this->conn){
            die("error!".mysqli_error($this->conn));

        }

    }
    public function getConnection() {
        return $this->conn;
    }

}
$database = new Database('localhost', 'root', '', 'jobeasy');
$conn = $database->getConnection();

class Candidature extends Database
{

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function saveApplication($jobId, $userId)
    {
        $status = null;
        $checkSql = "SELECT candidature_status FROM candidature WHERE job_id = ? AND user_id = ?";
        $checkStmt = $this->conn->prepare($checkSql);
        $checkStmt->bind_param("ii", $jobId, $userId);
        $checkStmt->execute();
        $checkStmt->bind_result($status);
    
       
       
    
        if ($checkStmt->fetch()) {
            if ($status === 'Rejected') {
                $this->redirectAndExit("You have already applied for this job and it has been rejected.");
            } elseif ($status === 'Approved') {
                $this->redirectAndExit("You have already applied for this job and it has been approved.");
            } elseif ($status === 'Pending') {
                $this->redirectAndExit("You have already applied for this job and it is still pending.");
            }
        } else {
            $checkStmt->close();
    
            // L'utilisateur n'a pas encore postulé
            $insertSql = "INSERT INTO candidature (job_id, user_id, candidature_status) VALUES (?, ?, 'Pending')";
            $insertStmt = $this->conn->prepare($insertSql);
    
            if ($insertStmt->execute([$jobId, $userId])) {
                $this->redirectAndExit("You have successfully applied to this job!");
            } else {
                echo '<script>alert("Failed to apply. Please try again.");</script>';
            }
        }
    }
    

    public function getOffresPostuler(){
        $offres=array();
        $req="SELECT * 
        FROM candidature 
        JOIN jobs ON candidature.job_id = jobs.job_id 
        JOIN users ON candidature.user_id = users.id;
        ";
        $result=$this->conn->query($req);
        while($array=$result->fetch_array()){
            $offres[]=$array;
    }
    return $offres;
    }


    private function redirectAndExit($message)
    {
        echo '<script>';
        echo 'alert("' . $message . '");';
        echo 'window.location.href = "../../../public/index.php";';
        echo '</script>';
        exit();
    }

    public function updateStatus($jobId, $userId, $status)
    {
        // Récupérer le titre de l'offre
        $getJobTitleSql = "SELECT jobs.title FROM candidature
                           JOIN jobs ON candidature.job_id = jobs.job_id
                           WHERE candidature.job_id = ? AND candidature.user_id = ?";
        $getJobTitleStmt = $this->conn->prepare($getJobTitleSql);
        $getJobTitleStmt->execute([$jobId, $userId]);
        $jobTitleResult = $getJobTitleStmt->get_result();
    
        if ($jobTitleRow = $jobTitleResult->fetch_assoc()) {
            $jobTitle = $jobTitleRow['title'];
    
            $updateSql = "UPDATE candidature SET candidature_status = ? WHERE job_id = ? AND user_id = ?";
            $updateStmt = $this->conn->prepare($updateSql);
    
            if (!$updateStmt->execute([$status, $jobId, $userId])) {
                echo '<script>alert("Failed to update candidature status. Please try again.");</script>';
                return;
            }
    
            $notificationMessage = "Le statut de votre candidature pour l'offre \"$jobTitle\" a été mis à jour: $status";
            $insertNotificationSql = "INSERT INTO notifications (user_id, message) VALUES (?, ?)";
            $insertNotificationStmt = $this->conn->prepare($insertNotificationSql);
    
            if (!$insertNotificationStmt->execute([$userId, $notificationMessage])) {
                echo '<script>alert("Failed to insert notification. Please try again.");</script>';
                return;
            }
    
            echo '<script>';
            echo 'alert("Candidature status updated successfully!");';
            echo 'window.location.href = "../../../views/admin/dashboard/offre.php";';
            echo '</script>';
        } else {
            echo '<script>alert("Failed to retrieve job title. Please try again.");</script>';
        }
    }
    


 


    public function getNotificationsForUser($userId)
    {
        $notifications = array();
    
        $selectNotificationsSql = "SELECT * FROM notifications WHERE user_id = ?";
        $selectNotificationsStmt = $this->conn->prepare($selectNotificationsSql);
        $selectNotificationsStmt->bind_param("i", $userId);
        
        if ($selectNotificationsStmt->execute()) {
            $result = $selectNotificationsStmt->get_result();
    
            while ($array = $result->fetch_assoc()) {
                $notifications[] = $array;
            }
    
            $selectNotificationsStmt->close();
        } else {
            echo '<script>alert("Failed to retrieve notifications. Please try again.");</script>';
        }
    
        return $notifications;
    }
    


    



    
    

}



?>
