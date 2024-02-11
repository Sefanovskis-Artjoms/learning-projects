<?php
  if(isset($_SESSION['user_id'])){

    $user_id = $_SESSION['user_id'];

    $errors = [];

    if(isset($_POST['add_car'])){

      $car_model = mysqli_real_escape_string($conn,$_POST['car_model']);
      $car_producer = mysqli_real_escape_string($conn,$_POST['car_producer']);
      $car_year = mysqli_real_escape_string($conn,$_POST['car_year']);
      $car_numbersign = mysqli_real_escape_string($conn,$_POST['car_numbersign']);
      $car_color = mysqli_real_escape_string($conn,$_POST['car_color']);
      $car_interior = mysqli_real_escape_string($conn,$_POST['car_interior']);
      $car_details = mysqli_real_escape_string($conn,$_POST['car_details']);

      if(validateField($car_numbersign)){
        $errors["numbersign"] = validateField($car_numbersign);
      }
      if(validateNumberField($car_year)){
        $errors["year"] = validateNumberField($car_year);
      }
      
      if(empty($errors)){
        $query = "insert into cars(car_owner_id, car_producer, car_model, car_year, car_number_sign, car_color, car_interior_material, car_details) ";
        $query.= "values($user_id, '$car_producer', '$car_model', $car_year, '$car_numbersign', '$car_color', '$car_interior', '$car_details' )";
      
        $create_car_query = mysqli_query($conn, $query);

        if (!$create_car_query) {
          die('Query Failed ' . mysqli_error($conn));
        }
        else {
          header('Location: profile.php?source=view_cars');
        }
      }
    }
  ?>
  <div class="second-header-box">
    <div>
      <h2 class="second-heading">Add Car</h2>
      <span class="second-header-line"></span>
    </div>
    
    <a href="profile.php?source=view_cars" class="btn--cta user-edit-btn" >
      <i class="fas fa-angle-right"></i>
      <span>Back</span>
    </a>
  </div>

  <form action="profile.php?source=add_car" method="post">

  
    <table class="user-data-box">
      <tr>
        <td class="user-data-label">
          Mandatory&nbsp;Fields&nbsp;(*)
        </td>
      </tr>
      <tr>
        <td class="user-data-label">Number Sign*: </td>
        <td>
          <input value="<?php echo $car_numbersign ?? ''; ?>" class="text user-data-input" name="car_numbersign" type="text">
          <p class="error-message"><?php echo $errors['numbersign'] ?? ''; ?></p>
        </td>
      </tr>
      <tr>
        <td class="user-data-label">Producer: </td>
        <td>
          <input value="<?php echo $car_producer ?? ''; ?>" class="text user-data-input" name="car_producer">
        </td>
      </tr>
      <tr>
        <td class="user-data-label">Car Model: </td>
        <td>
          <input value="<?php echo $car_model ?? ''; ?>" class="text user-data-input" name="car_model" type="text">
        </td>
      </tr>
      <tr>
        <td class="user-data-label">Year of Production: </td>
        <td>
          <input value="<?php echo $car_year ?? ''; ?>" class="text user-data-input" name="car_year" >
          <p class="error-message"><?php echo $errors['year'] ?? ''; ?></p>
        </td>
      </tr>
      <tr>
        <td class="user-data-label">Color: </td>
        <td>
          <input value="<?php echo $car_color ?? ''; ?>" class="text user-data-input" name="car_color">
        </td>
      </tr>
      <tr>
        <td class="user-data-label">Interior Material: </td>
        <td>
          <input value="<?php echo $car_interior ?? ''; ?>" class="text user-data-input" name="car_interior">
        </td>
      </tr>
      <tr>
        <td class="user-data-label">Details: </td>
        <td>
          <textarea placeholder="Write something here about your car that is worth knowing when we will work with your car." class="text user-data-input-textfield" name="car_details"><?php echo $car_details ?? ''; ?></textarea>
        </td>
      </tr>
    </table>
    <div class="update-profile-btn-box">
      <button type="submit" name="add_car" class="btn--cta">
        <i class="fas fa-plus"></i>  
        Add
      </button>
    </div>

  </form>
  <?php  
  }
?>