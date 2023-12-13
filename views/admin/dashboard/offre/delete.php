<?php

require_once('utilisateur.php');
// Traitement de la suppression
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action_supprimer'])) {
        $idSupprimer = $_POST['id_supprimer'];
        $utilisateurASupprimer = Utilisateur::chargerParId($idSupprimer);
        if ($utilisateurASupprimer) {
            $utilisateurASupprimer->supprimer();
        }
    }


}



?>