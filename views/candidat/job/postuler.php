<?php

class Candidature
{
    private $conn;


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
    
            // L'utilisateur n'a pas encore postulé, nous pouvons procéder à l'insertion
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
        $updateSql = "UPDATE candidature SET candidature_status = ? WHERE job_id = ? AND user_id = ?";
        $updateStmt = $this->conn->prepare($updateSql);
    
        if ($updateStmt->execute([$status, $jobId, $userId])) {
            echo '<script>';
            echo 'alert("Candidature status updated successfully!");';
            echo 'window.location.href = "../../../views/admin/dashboard/offre.php";';
            echo '</script>';
        } else {
            echo '<script>alert("Failed to update candidature status. Please try again.");</script>';
        }
    }



    
    

}



?>
