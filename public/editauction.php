<?php
require 'header.php';

$productID = $_GET['ID'];
$productName = $_GET['productName'];
$userID = $user->data()->user_id;


if(isset($_POST['update'])){
    ?>
        <a href="administration.php"><h3>Go to Admin Panel</h3></a>
    <?php

}


$productList = $pdo->query('SELECT * FROM products WHERE product_name = "'. $productName .'"');

foreach ($productList as $product) {
$productname = $product['product_name'];
$productcategory = $product['product_category'];
$productdesc = $product['product_description'];
$productImage = $product['product_image'];
$duration = $product['duration'];

?>
  <ul class="productList">
        <li>
            <img src="images/<?php echo $productImage ?>" alt="product name">
            <article>
                <h2><?php echo $productname?></h2>
                <h3><?php echo $productcategory?></h3>
                <p><?php echo $productdesc?></p>
                <time>Time left: <?php 
                                require_once 'timeRemaining.php';
                                getDiff($duration); 
                ?></time>
                <form action="auction.php" class="bid"> <!-- goes to auctions where all auctions will be handled-->
                    <input type="text" placeholder="Enter bid amount" />
                    <input type="submit" value="Place bid" />
                </form>

                <p class="price">Current bid: £123.45</p>
                <a href="auction.php?page=<?php echo $productName ?>&productName=<?php echo $productname ?>&ID=<?php echo $product['product_id'] ?>" class="more">More &gt;&gt;</a>
            </article>
        </li>
    </ul>

<?php
}

?>

<form action="editauction.php?page=<?php echo $productName ?>&productName=<?php echo $productname ?>&ID=<?php echo $product['product_id'] ?>" method="POST" enctype="multipart/form-data">
<div class="field">
    <link rel="stylesheet" href="form.css">
    <label for="product_name">produduct Name</label><br>
    <input type="text" name="product_name" value="<?php echo escape($productname); ?>" />
</div>

<div class="field">
    <label for="duration">Duration</label>
    <input type="time" name="duration" step="2" value="<?php echo date('H:i:s',$duration) ?>" >
    </div>

<div class="field">
<label for="product_category">product category</label><select name="product_category">
        <?php
            $results = $pdo->query('SELECT * FROM categories ');
            foreach ($results as $row) {
            $category_name = $row['category_name'];
            ?>
            <option selected="selected" ><?php echo $category_name; ?></option>
            <?php
            }   
        ?>
</div>

<div class="field">
<label for="product_description">product Description</label><br>
<textarea name="product_description" id="product_description" cols="30" rows="10"><?php echo escape($productdesc); ?></textarea>
    <!-- <input type="text" name="product_description" /> -->
</div>

<div class="field">
<input type="submit" name="update" value="Update">
</div>

</form>

<?php
if(isset($_POST['update'])){
    // Redirect::to('administration.php');    
//update the data
    $prodCat = $_POST['product_category'] ;
    // $prodImage = $_POST['product_image'];
    if(!empty($prodCat)){
        $update = DB::getInstance()->update('webass1.products', 'product_id', $productID, array(
                    'product_name' => Input::get('product_name'),
                    // 'product_image' => $file_new_name,
                    'product_category' => $_POST['product_category'],
                    'product_description' => $_POST['product_description'],
                    'duration' => strtotime($_POST['duration'])
        ));

    } else {
        echo '<p>Add image and product category</p>';

    }

}


//end of editing
