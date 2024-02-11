<?php 
  if (isset($_POST['create_service'])) {
    $errors = [];
    $service_title = mysqli_real_escape_string($conn,$_POST['service_title']);
    $service_price = mysqli_real_escape_string($conn,$_POST['service_price']);
    $service_hours = mysqli_real_escape_string($conn,$_POST['service_hours']);
    $service_description = mysqli_real_escape_string($conn,$_POST['service_description']);
    
    $service_image = $_FILES['service_image']['name'];
    $service_image_temp = $_FILES['service_image']['tmp_name'];

    if(validateField($service_title)){
      $errors['title'] = validateField($service_title);
    }
    if(validatePositiveNumberField($service_price)){
      $errors["price"] = validatePositiveNumberField($service_price);
    }
    if(validatePositiveNumberField($service_hours)){
      $errors["hours"] = validatePositiveNumberField($service_hours);
    }
    if(validateField($service_description)){
      $errors['description'] = validateField($service_description);
    }
    if(validateField($service_image)){
      $errors['image'] = validateField($service_image);
    }

    if(empty($errors)){

      move_uploaded_file($service_image_temp, "../img/services-images/$service_image");
    
      $query = "insert into services(service_title, service_price, service_hours, service_description, service_image) ";
      $query.= "values('$service_title','$service_price','$service_hours','$service_description','$service_image')";
      
      $create_service_query = mysqli_query($conn,$query);

      if (!$create_service_query) {
        die('Query Failed ' . mysqli_error($conn));
      }
      else {
        header('Location: admin-services.php');
      }
    }
  }
  ?>

<div class="page-header-box">
  <div>
    <h2 class="page-heading">Add Service</h2>
    <span class="page-heading-line"></span>
  </div>
  <a href="admin-services.php" class="btn--cta services-create-btn">
    <i class="fas fa-angle-right"></i>
    <span>Back</span>
  </a>
</div>

<form action="" method="post" enctype="multipart/form-data">
  
  <label class="input-label" for="service_title">Title*</label>
  <input type="text" name="service_title" class="text input-field" value="<?php echo $service_title ?? ''; ?>">
  <p class="error-message"><?php echo $errors['title'] ?? ''; ?></p>

  <label class="input-label" for="service_price">Price*</label>
  <input type="number" name="service_price" class="text input-field" value="<?php echo $service_price ?? ''; ?>">
  <p class="error-message"><?php echo $errors['price'] ?? ''; ?></p>

  <label class="input-label" for="service_hours">Estimated Labour hours*</label>
  <input type="number" name="service_hours" class="text input-field" value="<?php echo $service_hours ?? ''; ?>">
  <p class="error-message"><?php echo $errors['hours'] ?? ''; ?></p>

  <label class="input-label" for="service_image">Post Image*</label>
  <input class="input-image" type="file" name="service_image">
  <p class="error-message"><?php echo $errors['image'] ?? ''; ?></p>

  <label class="input-label" for="service_description">Description*</label>
  <textarea id="summernote" class="text service-description" name="service_description" rows="10"><?php echo $service_description ?? ''; ?></textarea>  
  <p class="error-message"><?php echo $errors['description'] ?? ''; ?></p>

  <div class="btn--submit">
    <button class="btn--cta" type="submit" name="create_service">
      <i class="fas fa-plus"></i>
      <span>Create</span>
    </button>  
  </div>
  
</form>