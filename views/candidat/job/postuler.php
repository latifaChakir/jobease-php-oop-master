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
        $checkSql = "SELECT * FROM candidature WHERE job_id = ? AND user_id = ?";
        $checkStmt = $this->conn->prepare($checkSql);
        $checkStmt->execute([$jobId, $userId]);

        $existingApplication = $checkStmt->fetch();

        if ($existingApplication) {
            $this->redirectAndExit("You have already applied for this job!");
        } else {
            $checkStmt->close();

            $insertSql = "INSERT INTO candidature (job_id, user_id) VALUES (?, ?)";
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
}



?>
