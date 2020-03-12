<?php
require_once 'core/init.php';
require 'header.php';
require 'config.php';

?>
<div class="field">
<ul>
<li> Firstname: <?php echo $user->data()->user_firstname ?></li>
<li> Surname: <?php echo $user->data()->user_surname  ?></li>
<li> Email: <?php echo $user->data()->user_email  ?></li>
<li> Username: <?php echo $user->data()->username  ?></li>
<li> User Rights: <?php
   if($user->hasPermission('admin')){
       echo 'ADMIN';
   } else {
       echo 'NORMAL USER';
   }
?></li>
</ul>
</div>