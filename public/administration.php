<?php
require_once 'core/init.php';
require 'header.php';
require 'config.php';

?>

<h2>Administration Panel</h2>

<?php

//greating the user once logged in
$user = new User();

//check if the user is logged in
if($user->isLoggedin()){

//check if the user is admin and present appropriate functionality
   if($user->hasPermission('admin')){
       ?>
    <h3>Hello <a href="#"> <?php echo escape($user->data()->username); ?> </a> ! </h3>
        <div class="adminPanel">
                <div class="adminPanel1">
                    <h2>Auction & Category Maintainance</h2>
                    <ul>
                        <li><a href="category.php">Add Category</a></li>
                        <li><a href="category.php">Show All Categories</a></li>
                        <li><a href="addproducts.php">Add Auction</a></li>
                        <li><a href="approveauction.php">Approve Auctions</a></li>
                        <li><a href="showauctions.php?user_id=<?php echo $user->data()->user_id ?>">My Auctions</a></li>
                        <li><a href="showauctions.php?user_id=<?php echo $user->data()->user_id ?>">Edit Auction</a></li>
                        <li><a href="showauctions.php?user_id=<?php echo $user->data()->user_id ?>">Delete Auction</a></li>
                    </ul>   
                </div>

                <div class="adminPanel2">
                    <h2>User Maintainace</h2>
                    <ul>
                        <li><a href="viewprofile.php?id=<?php echo $user->data()->user_id ?>"> View my Profile</a></li>
                        <li><a href="editadmin.php"> Add Admins</a></li>
                        <li><a href="editadmin.php"> Delete Admins</a></li>
                        <li><a href="editadmin.php"> Delete A User</a></li>
                    </ul>
                </div>
        </div>
   <?php
   } else {
       //display normal user panel
       ?>
    <h3>Hello <a href="#"> <?php echo escape($user->data()->username); ?> </a> ! </h3>
        <div class="adminPanel">
                <div class="adminPanel1">
                    <h2>Auction Maintainance</h2>
                    <ul>
                        <li><a href="addproducts.php">Add Auction</a></li>
                        <li><a href="showauctions.php?user_id=<?php echo $user->data()->user_id ?>">My Auctions</a></li>
                    </ul>   
                </div>

                <div class="adminPanel2">
                    <h2>My Profile</h2>
                    <ul>
                        <li><a href="viewprofile.php?id=<?php echo $user->data()->user_id ?>"> View my Profile</a></li>
                    </ul>
                </div>
        </div>
   <?php

   }
} else {
    //if the user is not logged in
    echo '<p>You need to <a href="signin.php">login </a> or <a href="register.php">register</a></p>';
}