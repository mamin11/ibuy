<?php
    require 'header.php';

    //display 10 products in descending order 
    $productList = $pdo->query('SELECT * FROM products ORDER BY product_id DESC LIMIT 11 ');
    $products = $productList->fetch();

    //store the product details in variables and echo into appropriate positions
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
                    getDiff($duration); ?></time>
                    <form action="auction.php" class="bid"> <!-- goes to auctions where all auctions will be handled-->

                        <?php 
						if($user->isLoggedin()){
                            ?>
                            <!-- if user's is logged in, they can bid -->
                            <input type="text" placeholder="Enter bid amount" />
                            <input type="submit" value="Place bid" />
							<?php
						} else {
							?>
                                <!-- dont give the user the option to bid -->
                                <input type="text" placeholder="Log in to bid" />
							<?php
						}
					?>

                    </form>
    
                    <p class="price">Current bid: £123.45</p>
                    <a href="auction.php?page=<?php echo $productcategory ?>&productName=<?php echo $productname ?>&ID=<?php echo $product['product_id'] ?>" class="more">More &gt;&gt;</a>
                </article>
            </li>
        </ul>
    
    <?php
    }
    
    ?>