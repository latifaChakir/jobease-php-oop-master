<?php

include_once('../../../../database/connection.php');
require_once('../../../../models/job.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['title']) && isset($_POST['description'])) {
        $title = $_POST['title'];
        $description = $_POST['description'];
        $company= $_POST['company'];
        $location = $_POST['location'];
        $status= $_POST['status'];
        $date_created= $_POST['date_created'];
        $nouvelUtilisateur = new Job($conn);
        $nouvelUtilisateur->setTitle($title);
        $nouvelUtilisateur->setDescription($description);
        $nouvelUtilisateur->setCompany($company);
        $nouvelUtilisateur->setLocation($location);
        $nouvelUtilisateur->setStatus($status);
        $nouvelUtilisateur->setDateCreated($date_created);

        $nouvelUtilisateur->sauvegarder();
        header('Location:index.php');
    }
}

?>
