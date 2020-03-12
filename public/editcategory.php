<?php
require_once 'core/init.php';
$page = $_GET['page'];
$page_id = $_GET['categoryID'];

if(isset($_POST['edit'])){
    //update 
        $catname = $_POST['category_name'] ;
        //check if the user has typed in something
        if(!empty($catname)){
            $update = DB::getInstance()->update('webass1.categories', 'category_id', $page_id, array(
                'category_name' => $_POST['category_name']
            ));
            // print_r($update);

        }
}
if(isset($_POST['delete'])){
    //delete 
    $toBeDeleted = DB::getInstance()->delete('webass1.categories', array( 'category_id', '=', $_GET['categoryID']));
    // $pdo->query('DELETE FROM categories WHERE category_id = '. $page_id );
    header('Location: category.php');
    // var_dump($toBeDeleted);
}

require 'header.php';


?>

<form action=""  method="POST">
<div class="field">
    <li> <?php echo $page ?></li>
    <div class="field">
        <label for="category_name" id="category_name">Category Name</label>
        <input type="text" name="category_name">
    </div>
    <input type="submit" name="edit" value="edit">
    <input type="submit" name="delete" value="delete">
</div>
</form>

<?php

// echo $page;

//display two buttons under the categ name, edit and delete

?>