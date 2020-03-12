<?php
require_once 'core/init.php';
require 'header.php';
require 'config.php';

//$pageId = $_GET['categoryID'];
$pageName = $_GET['page'];
$auctionName = $_GET['productName'];
$auctionID = $_GET['ID'];


//to display the right image for each product
$productList = $pdo->query('SELECT * FROM products WHERE product_id = "'. $auctionID .'"');

//store the auction detials in variables
foreach ($productList as $product) {
$productname = $product['product_name'];
$productcategory = $product['product_category'];
$productdesc = $product['product_description'];
$productImage = $product['product_image'];
$postedbyUserID = $product['user_id'];
$duration = $product['duration'];

//get the user details from the databse using their id
$seller = DB::getInstance()->getAll('webass1.users', array('user_id', '=', $postedbyUserID));
$sellerUsername = $seller->first()->username;
$sellerID = $seller->first()->user_id;


?>
<h1>Product Page</h1>
			<article class="product">

                    <img src="images/<?php echo $productImage ?>" alt="product name">
					<section class="details">
						<h2><?php $productname ?></h2>
						<h3><?php echo $productcategory ?></h3>
						<p>Auction created by <a href="auctionsby.php?postedby=<?php echo $sellerUsername ?>&&sellerID= <?php echo $sellerID ?>"><?php echo $sellerUsername ?></a></p> 
						<p class="price">Current bid: £123.45</p>
                        <time>Time left: <?php 
                                        require_once 'timeRemaining.php';
                                        getDiff($duration);
                        ?></time>
						<form action="#" class="bid">
                        <?php 
						if($user->isLoggedin()){
                            ?>
                            <!-- if user's is logged in, they can bid -->
                            <input type="text" placeholder="Enter bid amount" />
                            <input type="submit" value="Place bid" />
							<?php
						} else {
							?>
                                <!-- else dont give the user the option to bid -->
                                <input type="text" placeholder="Log in to bid" />
							<?php
						}
					?>
						</form>
					</section>
					<section class="description">
					<p> <?php echo $productdesc ?> </p>

					</section>

					<section class="reviews">
                        <h2>Reviews of <?php echo $sellerUsername ?> </h2>
                        <?php 
                        //GET REVIEWS FROM DATABASE
                        $reviewList = $pdo->query('SELECT * FROM reviews WHERE user_id = "'. $sellerID .'"');

                        foreach ($reviewList as $review) {
                        $reviewText = $review['review_details'];
                        $seller_name = $review['seller_name'];
                        $review_date = $review['review_date'];
                        $added_by = $review['added_by'];
                        ?>
                        <ul>
                        <li><strong><?php echo $added_by ?> Added </strong> <?php echo $reviewText ?>.<em><?php echo $review_date ?></em></li>
                        </ul>
                        <?php

                        }
                        ?>

						<form action="auction.php?page=<?php echo $productcategory ?>&productName=<?php echo $productname ?>&ID=<?php echo $product['product_id'] ?>" method="POST">
                        <label>Add your review</label>
                         <?php 
						if($user->isLoggedin()){
                            ?>
                            <!-- if user's is logged in, they can add reviews -->
                            <textarea name="reviewtext"></textarea>
							<input type="submit" name="addreview" value="Add Review" />
							<?php
						} else {
							?>
                                <!-- dont give the user the option to add review -->
                                <textarea name="reviewtext" placeholder="Log in to add review"></textarea>
							<?php
						}
					?>
                           
						</form>
					</section>
                    </article>
                    
<?php
}

if(isset($_POST['addreview'])){
    //add review to database
    $reviewdetails = DB::getInstance()->insert('webass1.reviews', array(
        'review_details' => $_POST['reviewtext'],
        'user_id' => $sellerID ,
        'seller_name' => $sellerUsername,
        'review_date' => date('Y/m/d'),
        'added_by' => ($user->data()->username)
   
    ));
}
?>
