<?php
session_start();

if (isset($_SESSION['username'])) {
    echo json_encode([
        'loggedIn' => true,
        'username' => $_SESSION['username'],
/*         'profile_pic' => $_SESSION['profile_pic']
 */    ]);
} else {
    echo json_encode(['loggedIn' => false]);
}
?>