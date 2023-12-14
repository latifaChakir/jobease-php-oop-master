<?php
include('../../../database/connection.php');
include('postuler.php');
session_start();

if (isset($_SESSION["id"])) {
    $user_id = $_SESSION["id"];
}

$id = $_GET['id'];

$candidature = new Candidature($conn);
$candidature->saveApplication($id, $user_id);

?>