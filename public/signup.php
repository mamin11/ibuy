<?php
require 'header.php';

require 'config.php';
// include("config.php");

    if (isset($_POST['register'])) {
      //var_dump($_POST);
      $stmt = $pdo->prepare('INSERT INTO users (user_firstname, user_surname, user_email, user_password, username, user_group)
       VALUES (:user_firstname, :user_surname, :user_email, :user_password, :username, :user_group )
      ');
      //reduce redundancy by using _POST array instead of the values array
      $values = [
       'user_firstname' => $_POST['user_firstname'],
       'user_surname' => $_POST['user_surname'],
       'user_email' => $_POST['user_email'],
       'user_password' => $_POST['user_password'],
       'username' => $_POST['username'],
       'user_group' => '1'
       ];
      // unset($_POST['checkbox']);
      // unset($_POST['register']);
      $stmt->execute($values);
      echo 'success';
      }
      else {
  
      }

?>
<!-- <p>Sign up successful</p> -->

<form class="signup_form" action="signup.php" method="POST">
     
               <link rel="stylesheet" href="logform.css" />
                <label for="user_firstname">Firstname</label> <input type="text" name="user_firstname" />
                <label for="user_surname">Surname</label> <input type="text" name="user_surname"/>
                <label for="username">Username</label> <input type="text" name="username"/>
                <label for="user_email">Email</label> <input type="text" name="user_email" />
                <label for ="user_password">Password</label> <input type="password" name="user_password"/>
                <!-- <label for="checkbox">T&C's</label> <input name ="checkbox" type="checkbox" />  -->
                <input type="submit" name ="register" value="register" />

</form>



