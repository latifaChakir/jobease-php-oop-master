<?php

include_once('../../../../database/connection.php');
require_once('../../../../models/job.php');

if (isset($_GET['id'])) {
    $idSupprimer = $_GET['id'];
    $jobASupprimer = new Job($conn);
    $jobDetails = $jobASupprimer->getOffresById($idSupprimer);

    if ($jobDetails) {
        
        if (isset($jobDetails['title'])) {
          
            $jobASupprimer->supprimer();
            header('Location: index.php');
            exit();
        } else {
            echo "Error: 'title' is not set.";
        }
    } else {
        echo "Error: Job details not found.";
    }
}


?>
