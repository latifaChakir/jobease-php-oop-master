<?php
include_once('../../database/connection.php');
require_once('../../models/user.php');

$userQuery = new User($conn); 
$allUsers = $userQuery->getAllUsers();

foreach ($allUsers as $user) {
    echo $user['id'] . '<br />';
    echo $user['username'] . '<br />';
    echo $user['email'] . '<br />';
    echo $user['password'] . '<br />';
    echo $user['role_name'] . '<br />';
}
?>


