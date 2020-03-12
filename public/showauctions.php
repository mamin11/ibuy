<?php
require_once 'core/init.php';
require 'header.php';

$userID = $_GET['user_id'];

$productList = $pdo->query('SELECT * FROM products WHERE user_id = "'. $userID .'"');
$NonApprovedproducts = $pdo->query('SELECT * FROM moderations WHERE user_id = "'. $userID .'"');

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
                    <a href="auction.php?page=<?php echo $productcategory ?>&productName=<?php echo $productname ?>&ID=<?php echo $product['product_id'] ?>" class="more">More &gt;&gt;</a>
                    <a href="editDeleteAuction.php?productName=<?php echo $productname ?>&ID=<?php echo $product['product_id'] ?>&user_id=<?php echo $userID ?>"><h2>Ammend Auction</h2></a>
                </article>
            </li>
        </ul>

    <?php
    }

//diplaying non approved products
foreach ($NonApprovedproducts as $product) {
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
                    <h1>AWAITING APPROVAL</h1><br>
                    <h2><?php echo $productname?></h2>
                    <h3><?php echo $productcategory?></h3>
                    <p><?php echo $productdesc?></p>
                    <time>Time left: <?php 
                require_once 'timeRemaining.php';
                getDiff($duration);                       
                    ?></time>
    
                </article>
            </li>
        </ul>
    
    <?php
    }


?>
