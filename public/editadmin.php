<?php
require 'header.php';

//first show list of all users
    // $userList = DB::getInstance()->query("SELECT * FROM webass1.users"); 
    $userList = $pdo->query('SELECT * FROM users ');
    foreach ($userList as $user) {
        $username = $user['username'];
        $user_group = $user['user_group'];

        ?>

        <?php 
            if($user_group === '2'){
                $permission = '-    Admin';
            } else {
                $permission = '-    Not Admin';
            }
        ?>
        <div>
            <a href="editdeleteadmin.php?user=<?php echo $username ?>"> <li><?php echo $username; echo $permission  ?></li></a>
        </div>
        <?php
    }
    ?>

<?php
//display button next to each user


//if statements for each button