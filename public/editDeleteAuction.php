<?php
require 'header.php';


$productID = $_GET['ID'];
$productName = $_GET['productName'];
$userID = $user->data()->user_id;

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
            <form action="" method="POST">
                <input type="submit" name="delete" value="Delete">
               <a href="editauction.php??page=<?php echo $productName ?>&productName=<?php echo $productname ?>&ID=<?php echo $product['product_id'] ?>"><input type="button" name="edit" value="Edit"></a>
            </form>
            </article>
        </li>
    </ul>

<?php
}

?>
<?php 
if(isset($_POST['delete'])){
    //delete the auction
    $toBeDeleted = DB::getInstance()->delete('webass1.products', array( 'product_id', '=', $productID));
    // $pdo->query('DELETE FROM categories WHERE category_id = '. $page_id );
    Redirect::to('administration.php');
}
