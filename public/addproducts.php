<?php
require 'config.php';
require 'header.php';


?>

    <!-- the form to input the auction details -->
    <form action="addproducts.php" method="POST" enctype="multipart/form-data">
    <div class="field">
        <link rel="stylesheet" href="form.css">
        <label for="product_name">prouduct Name</label><br>
        <input type="text" name="product_name" />
    </div>

    <div class="field">
    <label for="duration">Duration</label>
    <input type="time" name="duration" step="2" >
    </div>

    <div class="field">
        <label for="product_image">Product Image</label><br>
        <input type="file" name = "product_image">
    </div>

    <div class="field">
    <label for="product_category">product category</label><select name="product_category">
            <?php
            //loop through the categories to display them
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
    <textarea name="product_description" id="product_description" cols="30" rows="10"></textarea>
    </div>

    <div class="field">
    <input type="submit" name="add" value="add">
    </div>

  </form>
    


<?php
if(isset($_POST['add'])){

//uploading the image starts here 
    $file = $_FILES['product_image'];

    $file_name = $_FILES['product_image']['name']; //file name
    $file_tmp_name = $_FILES['product_image']['tmp_name']; //temp file location
    $file_size = $_FILES['product_image']['size']; //file size
    $file_error = $_FILES['product_image']['error']; //error
    $file_type = $_FILES['product_image']['type']; //file type

    $file_initial_extension = explode('.', $file_name);
    $file_actual_extension = strtolower(end($file_initial_extension));

    $allowed = array('jpg', 'jpeg', 'png');

    if(in_array($file_actual_extension, $allowed)){
        if($file_error===0){
            //print_r($file); //for debugging 
            //if theres no error
            if($file_size < 2000000){
                //limit the size of the file to be uploaded
                //if size is less than 5000kb/5mb
                //file new name will give the file a unique code so that 
                //if files with similar names are uploaded
                //they do not overwrite the initial uploads
                $file_new_name = uniqid('', true).".".$file_actual_extension; //unique code based on the current micro-seconds
                $file_destination = 'images/'.$file_new_name;
                move_uploaded_file($file_tmp_name, $file_destination);
                //header("Locaton: upload.php?uploadsuccessful");
            }else{
                echo 'Your file is too big';
            }
        }else{
            //if theres an error tell the user
            echo 'There was an error uploading your file';
        }
    }else{
        echo ' You cannot upload this file type.';
    }
    //uploading the image ends here


    //convert the end time into unix timestamp
    $pickedTime = $_POST['duration'];
    $pickedStr = strtotime($pickedTime);
    
        //adding the product details to the database
        $stmt = $pdo->prepare('INSERT INTO moderations (product_name, duration, product_image, user_id, product_category, product_description)
        VALUES (:product_name, :duration, :product_image, :user_id, :product_category, :product_description )
       ');
       //reduce redundancy by using _POST array instead of the values array
       $values = [
        'product_name' => $_POST['product_name'],
        'duration' => $pickedStr,
        'product_image' => $file_new_name,
        'user_id' => $user->data()->user_id,
        'product_category' => $_POST['product_category'],
        'product_description' => $_POST['product_description']
        ];
    
       $stmt->execute($values);
       echo 'success';


}
?>