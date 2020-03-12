<?php
require 'header.php';

$toedituser = $_GET['user'];
$currentuser = $pdo->query('SELECT * FROM users WHERE username = "'.$toedituser.'"');
foreach($currentuser as $cols){
$currentuserRight = $cols['user_group']; 
$currentuserID = $cols['user_id'];
$currentuserName = $cols['username'];
}
 if($currentuserRight === '1'){
     $permission = 'Not Admin';
 } else {
     $permission = 'An Admin';
 }

 
?>
<div class="field">
    <h2><?php echo $toedituser ?></h2>
</div>

<div class="field">
    <h3><?php echo $permission ?></h3>
</div>


<form action="" method="POST">

<input type="submit" name="make" value="Make Admin">
<input type="submit" name="remove" value="Remove Admin Right">
<input type="submit" name="delete" value="Delete User">

</form>

<?php
if(isset($_POST['make'])){
//update group - change to 2 
    $update = DB::getInstance()->update('webass1.users', 'user_id', $currentuserID, array(
        'user_group' => 2
    ));
    // var_dump($update);
    header("Refresh:0");
}
if(isset($_POST['remove'])){
//update group - change to 1  
    $update = DB::getInstance()->update('webass1.users', 'user_id', $currentuserID, array(
        'user_group' => 1
    ));
    header("Refresh:0");
}
if(isset($_POST['delete'])){
//delete user column
        $toBeDeleted = DB::getInstance()->delete('webass1.users', array( 'user_id', '=', $currentuserID));
         Redirect::to('administration.php');
}