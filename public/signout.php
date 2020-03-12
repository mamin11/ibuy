<?php
require_once 'core/init.php';

$user = new User();

//call the logout function and redirect the user to the homepage
$user->logout();

Redirect::to('home.php');

?>