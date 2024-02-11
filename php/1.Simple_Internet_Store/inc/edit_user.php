<?php
  if(isset($_SESSION['user_id'])){

    $user_id = $_SESSION['user_id'];

    $errors = [];

    $query = "select*from users where user_id = $user_id";
    $select_user = mysqli_query($conn,$query);

    while($row = mysqli_fetch_assoc($select_user)){
      $first_name = $row['user_first'];
      $last_name = $row['user_last'];
      $email = $row['user_email'];
      $phone = $row['user_phone'];
      $phone_code = $row['user_phone_code'];
      $password = $row['user_password'];
    }

    if(isset($_POST['update_user'])){

      $the_first_name = mysqli_real_escape_string($conn,$_POST['first_name']);
      $the_last_name = mysqli_real_escape_string($conn,$_POST['last_name']);
      $the_email = mysqli_real_escape_string($conn,$_POST['email']);
      $the_phone = mysqli_real_escape_string($conn,$_POST['phone']);
      $the_phone_code = mysqli_real_escape_string($conn,$_POST['phone_code']);

      if(validateNameField($the_first_name)){
        $errors["first"] = validateNameField($the_first_name);
      }
      if(validateNameField($the_last_name)){
        $errors["last"] = validateNameField($the_last_name);
      }
      if(validateEmail($the_email)){
        $errors["email"] = validateEmail($the_email);
      }
      if ($the_email != $email) {
        $check_email = "select * from users where user_email = '$the_email' ";
        $check_email_query = mysqli_query($conn,$check_email);
        if(mysqli_num_rows($check_email_query) != 0){
          $errors["email"] = "Email already in use";
        }
      }
      if(validatenumberField($the_phone)){
        $errors["phone"] = validatenumberField($the_phone);
      }
      if(validatenumberField($the_phone_code)){
        $errors["code"] = validatenumberField($the_phone_code);
      }

      if(empty($errors)){
        $query = "update users set ";
        $query.= "user_first = '$the_first_name', ";
        $query.= "user_last = '$the_last_name', ";
        $query.= "user_email = '$the_email', ";
        $query.= "user_phone = $the_phone, ";
        $query.= "user_phone_code = $the_phone_code ";
        $query.= "where user_id = $user_id";

        $update_user = mysqli_query($conn,$query);

        if (!$update_user) {
          die('Query Failed ' . mysqli_error($conn));
        }
        else {
          header('Location: profile.php');
        }
      }
    }
  ?>
  <div class="second-header-box">
    <div>
      <h2 class="second-heading">Edit Profile Information</h2>
      <span class="second-header-line"></span>
    </div>
    
    <a href="profile.php" class="btn--cta user-edit-btn" >
      <i class="fas fa-angle-right"></i>
      <span>Back</span>
    </a>
  </div>

  <form action="profile.php?source=edit_user" method="post">

  
    <table class="user-data-box">
      <tr>
        <td class="user-data-label">
          Mandatory&nbsp;fields&nbsp;(*)
        </td>
      </tr>
      <tr>
        <td class="user-data-label">First Name*: </td> 
        <td>
          <input type="text" class="text user-data-input" name="first_name" type="text" value="<?php echo $the_first_name ?? $first_name; ?>">
          <p class="error-message"><?php echo $errors['first'] ?? ''; ?></p>
        </td>
      </tr>
      <tr>
        <td class="user-data-label">Last Name*: </td>
        <td>
          <input type="text" class="text user-data-input" name="last_name" value="<?php echo $the_last_name ?? $last_name; ?>">
          <p class="error-message"><?php echo $errors['last'] ?? ''; ?></p>
        </td>
      </tr>
      <tr>
        <td class="user-data-label">Email*: </td>
        <td>
          <input type="email" class="text user-data-input" name="email" value="<?php echo $the_email ?? $email; ?>">
          <p class="error-message"><?php echo $errors['email'] ?? ''; ?></p>
        </td>
      </tr>
      <tr>
        <td class="user-data-label">Phone*: </td>
        <td>
          <input type="number" class="text user-data-input" name="phone" value="<?php echo $the_phone ?? $phone; ?>">
          <p class="error-message"><?php echo $errors['phone'] ?? ''; ?></p>
        </td>
      </tr>
      <tr>
        <td class="user-data-label">Phone Code*: </td>
        <td>
          <input type="number" class="text user-data-input" name="phone_code" value="<?php echo $the_phone_code ?? $phone_code; ?>">
          <p class="error-message"><?php echo $errors['code'] ?? ''; ?></p>
        </td>
      </tr>
    </table>
    <div class="update-profile-btn-box">
      <button type="submit" name="update_user" class="btn--cta"><i class="fa fa-check"></i> Submit</button>
    </div>

  </form>
  <?php  
  }
?>