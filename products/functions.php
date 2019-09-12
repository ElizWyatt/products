<?

//select
function select_products() {
    
    include 'credentials.php';
    
    $sql = "SELECT * FROM products";
    $result = mysqli_query($conn, $sql);
    
    if (mysqli_num_rows($result) > 0) {
        // output data of each row
        while($row = mysqli_fetch_assoc($result)) {
            ?>
            <tr>
                <td><?=$row['product_name']?></td>
                <td><?=$row['product_description']?></td>
                <td><?=$row['product_category']?></td>
                <td><?=$row['product_cost']?></td>
                <td>
                    <form action="index.php" method="POST">
                    <input type="hidden" value="<?=$row['product_id']?>" name='delete_product_id'>  
                    <button type="submit" name="delete_product" class="btn btn-danger">Delete</button>
                    </form>
                    <form action="index.php" method="POST">
                    <input type="hidden" value="<?=$row['product_id']?>" name="update_product_id">
                    <input type="hidden" value="<?=$row['product_name']?>" name="update_product_name">
                    <input type="hidden" value="<?=$row['product_description']?>" name="update_product_description">
                    <input type="hidden" value="<?=$row['product_cost']?>" name="update_product_cost">
                    <button type="submit" name="update_product" class="btn btn-info">Edit</button>
                    </form>
                </td>
            </tr>
            <?
        }
    } else {
        echo "0 results";
    }
    
    mysqli_close($conn);
//insert
}
function insert_products() {
    include 'credentials.php';
    $product_name = filter_var($_POST['product_name'], FILTER_SANITIZE_STRING);
    $product_description = filter_var($_POST['product_description'], FILTER_SANITIZE_STRING);
    $product_cost = filter_var($_POST['product_cost'], FILTER_SANITIZE_STRING);
    
    $sql = "INSERT INTO products (
        product_name, 
        product_description, 
        product_category, 
        product_cost
        )
    VALUES (
        '{$product_name}', 
        '{$product_description}', 
        '{$_POST['product_category']}',
        '{$product_cost}'
        )";
    
    if (mysqli_query($conn, $sql)) {
        echo '<div class="container-fluid">
        <div class="row">
          <div class="col"></div>
            <div class="col text-center">
              <p class="alert alert-success">Record added successfully</p>
          </div>
          <div class="col"></div>
        </div>
        </div>';
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
    
    mysqli_close($conn);

}
//delete
function delete_product() {
    include 'credentials.php';
$sql = "DELETE FROM products WHERE product_id='{$_POST['delete_product_id']}'";

     if (mysqli_query($conn, $sql)) {
      echo '<div class="container-fluid">
            <div class="row">
              <div class="col"></div>
                <div class="col text-center">
                  <p class="alert alert-success" style="font-size: 20px;" >Record deleted successfully</p>
              </div>
              <div class="col"></div>
            </div>
            </div>';
      } else {
      echo "Error deleting record: " . mysqli_error($conn);
    
    }




mysqli_close($conn);
}
//update
function update_product_form() {
    $update_form = '<form action="index.php" method="POST">
    <input type="hidden" value="'.$_POST['update_product_id'].'" name="confirm_update_product_id"> 
    <div class="form-group">
        <input type="text" name="update_product_name" placeholder="Update Product Name" class="form-control"
        value="'.$_POST['update_product_name'].'">
    </div>
  <div class="form-group">
      <textarea class="form-control" name="update_product_description" placeholder="Update Product Description">'.$_POST['update_product_description'].'</textarea>
  </div>
   <div class="form-group">
      <select class="form-control" name="update_product_category">  
          <option value="choose_category">Choose Category</option>
          <option value="lipstick">Lipstick</option>
          <option value="mascara">Mascara</option>
          <option value="moisturizer">Moisturizer</option>
          <option value="blush">Blush</option>
          <option value="eyeliner">Eyeliner</option>
          <option value="primer">Primer</option>
          <option value="lip_balm">Lip Balm</option>
          <option value="foundation">Foundation</option>
          <option value="powder">Powder</option>
          <option value="eye_shadow">Eye Shadow</option>
          
</select>
      </div>
  <div class="form-group">
      <input type="text" name="update_product_cost" placeholder="Update Product Cost" class="form-control" value="'.$_POST['update_product_cost'].'">
  </div>
  <button type="submit" name="confirm_update" class="btn btn-warning btn-block text-white">Confirm Update</button>
  </form>';

echo $update_form;
}

//update product
function update_product() {

    include 'credentials.php';

    $update_product_name = filter_var($_POST['update_product_name'], FILTER_SANITIZE_STRING);
    $update_product_description = filter_var($_POST['update_product_description'], FILTER_SANITIZE_STRING);
    $update_product_cost = filter_var($_POST['update_product_cost'], FILTER_SANITIZE_STRING);
    
$sql = "UPDATE products SET product_name='{$update_product_name}', product_description = '{$update_product_description}', product_category ='{$_POST['update_product_description']}', product_cost ='{$update_product_cost}' WHERE product_id='{$_POST['confirm_update_product_id']}'";

if (mysqli_query($conn, $sql)) {
    echo "Record updated successfully";
} else {
    echo "Error updating record: " . mysqli_error($conn);
}

mysqli_close($conn);

}
//add product form
function add_product_form() {
    $add_product_form = '<div class="container-fluid pb-3">
    <div class="row">
        <div class="col"></div>
        <div class="col">
            <form action="index.php" method="POST">
                <div class="form-group">
                    <input type="text" name="product_name" placeholder="Product Name" class="form-control">
                </div>
              <div class="form-group">
                  <textarea class="form-control" name="product_description" placeholder="Product Description"></textarea>
              </div>
               <div class="form-group">
                  <select class="form-control" name="product_category">  
                      <option value="choose_category">Choose Category</option>
                      <option value="lipstick">Lipstick</option>
                      <option value="mascara">Mascara</option>
                      <option value="moisturizer">Moisturizer</option>
                      <option value="blush">Blush</option>
                      <option value="eyeliner">Eyeliner</option>
                      <option value="primer">Primer</option>
                      <option value="lip_balm">Lip Balm</option>
                      <option value="foundation">Foundation</option>
                      <option value="powder">Powder</option>
                      <option value="eye_shadow">Eye Shadow</option>
                      
            </select>
                  </div>
              <div class="form-group">
                  <input type="text" name="product_cost" placeholder="Product Cost" class="form-control">
              </div>
              <button type="submit" name="add_product" class="btn btn-warning btn-block text-white">Add Product</button>
              </form>
        </div>
        <div class="col"></div>
    </div>
</div>';
echo $add_product_form;

}
?>