<?php
require_once 'core/init.php';
require 'header.php';

?>

<!-- add category -->
<form action="category.php"  method="POST">
    <div class="field">
        <label for="category_name" id="category_name">Category Name</label>
        <input type="text" name="category_name">
    </div>
    <input type="submit" name="add" value="Add">
    <input type="submit" name="show" value="Show All categories">
    <!-- <input type="submit" name="edit" value="Edit Categories"> -->
</form>

<?php
if(isset($_POST['add'])){
    //add
    $catname = $_POST['category_name'] ;
    if(!empty($catname)){
    $category = DB::getInstance()->insert('webass1.categories', array(
        'category_name' => $_POST['category_name']
    ));
    echo 'addeds';
    // var_dump($category);
   }
}
if(isset($_POST['show'])){
    //query
    $categoryList = DB::getInstance()->query("SELECT * FROM webass1.categories"); ?>
    <div class="categorylist">
        <!-- <a href="editcategory.php">    </a> -->
             <!-- <li> -->

             <?php
					$results = $pdo->query('SELECT * FROM categories ');
				foreach ($results as $row) {
					$category_name = $row['category_name'];
					?>
					
						<li><a href="editcategory.php?page=<?php echo $category_name ?>&categoryID=<?php echo $row['category_id'];?>"><?php echo $category_name; ?>  </a></li>
					
			<?php
				}

			?>

            <!-- </li>  -->

    </div>
    <?php
   
    } 
    ?>
