<?php
  $errors = [];

  if (isset($_POST['create_user'])) {
    $first = mysqli_real_escape_string($conn,$_POST['first']);
    $last = mysqli_real_escape_string($conn,$_POST['last']);
    $email = mysqli_real_escape_string($conn,$_POST['email']);
    $phone = mysqli_real_escape_string($conn,$_POST['phone']);
    $phone_code = mysqli_real_escape_string($conn,$_POST['phone_code']);
    $password = mysqli_real_escape_string($conn,$_POST['password']);
    $password_reenter = mysqli_real_escape_string($conn,$_POST['password_reenter']);

    if(validateNameField($first)){
      $errors["first"] = validateNameField($first);
    }
    if(validateNameField($last)){
      $errors["last"] = validateNameField($last);
    }
    if(validateEmail($email)){
      $errors["email"] = validateEmail($email);
    }
    if(empty($errors["email"])){
      $check_email = "select * from users where user_email = '$email' ";
      $check_email_query = mysqli_query($conn,$check_email);
      if(mysqli_num_rows($check_email_query) != 0){
        $errors["email"] = "Email already in use";
      }
    }
    if(validatenumberField($phone)){
      $errors["phone"] = validatenumberField($phone);
    }
    if(validatenumberField($phone_code)){
      $errors["code"] = validatenumberField($phone_code);
    }
    if(validatePassword($password)){
      $errors["password"] = validatePassword($password);
    }
    if($password !== $password_reenter){
      $errors["reenter"] = "Password does not match";
    }

    if(empty($errors)){
      $query = "insert into users(user_first, user_last, user_email, user_phone, user_phone_code, user_password) ";
      $query.= "values('$first','$last','$email','$phone','$phone_code', '$password')";
      
      $create_user_query = mysqli_query($conn,$query);

      if (!$create_user_query) {
        die('Query Failed ' . mysqli_error($conn));
      }
      else {
        header('Location: admin-users.php');
      }
    }
  } 
  ?> 
  <div class="page-header-box">
    <div>
      <h2 class="page-heading">Create user</h2>
      <span class="page-heading-line"></span>
    </div>
    <a href="admin-users.php" class="btn--cta services-create-btn">
      <i class="fas fa-angle-right"></i>
      <span>Back</span>
    </a>
  </div>

<form action="" method="post">

  <label class="input-label" for="first">First Name</label>
  <input type="text" name="first" class="text input-field">
  <p class="error-message"><?php echo $errors['first'] ?? ''; ?></p>

  <label class="input-label" for="last">Last Name</label>
  <input type="text" name="last" class="text input-field">
  <p class="error-message"><?php echo $errors['last'] ?? ''; ?></p>

  <label class="input-label" for="email">Email</label>
  <input type="email" name="email" class="text input-field">
  <p class="error-message"><?php echo $errors['email'] ?? ''; ?></p>

  <label class="input-label" for="phone">Phone number</label>
  <input type="number" name="phone" class="text input-field">
  <p class="error-message"><?php echo $errors['phone'] ?? ''; ?></p>

  <label class="input-label" for="phone_code">Phone number country code</label>
  <input type="number" name="phone_code" class="text input-field">
  <p class="error-message"><?php echo $errors['code'] ?? ''; ?></p>

  <label class="input-label" for="password">Password</label>
  <input type="password" name="password" class="text input-field">
  <p class="error-message"><?php echo $errors['password'] ?? ''; ?></p>

  <label class="input-label" for="password_reenter">Re-enter Password*:</label>
  <input name="password_reenter" class="text input-field" type="password">
  <p class="error-message"><?php echo $errors['reenter'] ?? ''; ?></p>

  <div class="btn--submit">
    <button class="btn--cta" type="submit" name="create_user">
      <i class="fa fa-user-plus"></i>
      <span>Create User</span>
    </button>  
  </div>
  
</form>