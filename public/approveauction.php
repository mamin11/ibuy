<?php
require_once 'core/init.php';
require 'header.php';
require 'config.php';
$added = false;
?>

<div class="field">
    <h2>Auctions To be Approved</h2>
</div>


<?php

$productList = $pdo->query('SELECT * FROM moderations ');

foreach ($productList as $product) {
$productname = $product['product_name'];
$productcategory = $product['product_category'];
$productdesc = $product['product_description'];
$productImage = $product['product_image'];
$sellerID = $product['user_id'];
$duration = $product['duration'];

$seller = DB::getInstance()->getAll('webass1.users', array('user_id', '=', $sellerID));
$sellerUsername = $seller->first()->username;
$sellerID = $seller->first()->user_id;
?>

  <ul class="productList">
        <li>
            <img src="images/<?php echo $productImage ?>" alt="product name">
            <article>
                <h2><?php echo $productname?></h2>
                <h3><?php echo $productcategory?></h3>
                <p>Auction created by <a href="auctionsby.php?postedby=<?php echo $sellerUsername ?>&&sellerID= <?php echo $sellerID ?>"><?php echo $sellerUsername ?></a></p>
                <p><?php echo $productdesc?></p>
                <time>Time left: <?php 
                //echo date("h:i:s A");
                // echo $hours. ':'. $minutes. ':' . $seconds;
                require_once 'timeRemaining.php';
                getDiff($duration);
                ?></time>
                <form action="approveauction.php?page=<?php echo $productname ?>" method="POST" class="bid"> <!-- goes to auctions where all auctions will be handled-->
                    <input type="submit" name="approve" value="Approve" />
                    <?php
                        if(isset($_POST['approve'])){
                            //check if the product is has been added to the products table, then present the clear button
                            if($_GET['page'] === $productname){
                            ?>
                                <p>Successfuly Approved</p>
                                <input type="submit" name="clear" value="Clear As Approved" />
                            <?php
                            }
                        }
                    ?>
                </form>

                <p class="price">Current bid: £123.45</p>
                <a href="#" class="more">More &gt;&gt;</a>
            </article>
        </li>
    </ul>

<?php
}

if(isset($_POST['approve'])){
    //add the product to products table
    $stmt = $pdo->prepare('INSERT INTO products (product_name, product_image, user_id, product_category, product_description)
    VALUES (:product_name, :product_image, :user_id, :product_category, :product_description )
   ');
   $values = [
    'product_name' => $productname,
    'product_image' => $productImage,
    'user_id' => $sellerID,
    'product_category' => $productcategory,
    'product_description' => $productdesc
    ];

   $stmt->execute($values);

}
  //then delete from mederations table
    if(isset($_POST['clear'])){
        //get the specific product id
        $moderation = DB::getInstance()->getAll('webass1.moderations', array('product_name', '=', $productname));
        $moderationID = $moderation->first()->product_id;

        
        //then delete it from moderations using moderationID
        $toBeDeleted = DB::getInstance()->delete('webass1.moderations', array( 'product_id', '=', $moderationID));
        ?>

        <a href="approveauction.php">BACK</a>

        <?php
    }
?>
