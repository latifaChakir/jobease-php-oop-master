<?php
session_start();

include('../../../database/connection.php');
include('postuler.php'); 


if (isset($_GET['id']) && isset($_GET['id_user'])) {
    $id = $_GET['id'];
    $user_id = $_GET['id_user'];
 
    $candidature = new Candidature($conn);
    $candidature->updateStatus($id, $user_id, 'Rejected');
}
?>
