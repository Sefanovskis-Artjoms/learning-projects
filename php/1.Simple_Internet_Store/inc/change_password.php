<?php

  $errors = [];
  $user_id = $_SESSION['user_id'];

  if(isset($_POST['change-password'])){
    $oldPassword = mysqli_real_escape_string($conn,$_POST['oldPassword']);
    $password = mysqli_real_escape_string($conn,$_POST['password']);
    $password_reenter = mysqli_real_escape_string($conn,$_POST['password_reenter']);
    

    if (empty($oldPassword)) {
      $errors['oldPassword'] = 'Please fill the field';
    }
    else{
      $query1 = "select user_password from users where user_id = $user_id;";
      $select_password_query = mysqli_query($conn, $query1);
      while( $row = mysqli_fetch_assoc($select_password_query)){
        $db_password = $row['user_password'];
      }
    }
    if ( $oldPassword === $db_password) {
      if(validatePassword($password)){
        $errors["password"] = validatePassword($password);
      }
      if($password !== $password_reenter){
        $errors["reenter"] = "Password does not match";
      }
    }
    else{
      $errors["oldPassword"] = "Incorect Password";
    }
    
    if(empty($errors)){
      $query2 = "update users set ";
      $query2.= "user_password = '$password' ";
      $query2.= "where user_id = $user_id ";
    
      $update_password_query = mysqli_query($conn, $query2);
    
      if (!$update_password_query) {
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
    <h2 class="second-heading">Change Password</h2>
    <span class="second-header-line"></span>
  </div>
  <a href="profile.php" class="btn--cta user-edit-btn" >
    <i class="fas fa-angle-right"></i>
    <span>Back</span>
  </a>
</div>

<form action="#" method="post">
  <label class="password-change-label" for="password">Enter Current Password:</label>
  <input name="oldPassword" class="change-password-inputfield" type="password">
  <p class="error-message marbo-1-8"><?php echo $errors['oldPassword'] ?? '&nbsp;'; ?></p>

  <label class="password-change-label" for="password">Enter New Password:</label>
  <input name="password" class="change-password-inputfield" type="password">
  <p class="error-message marbo-1-8"><?php echo $errors['password'] ?? '&nbsp;'; ?></p>

  <label class="password-change-label" for="password_reenter">Re-enter New Password:</label>
  <input name="password_reenter" class="change-password-inputfield" type="password">
  <p class="error-message marbo-1-8"><?php echo $errors['reenter'] ?? '&nbsp;'; ?></p>

  <button name="change-password" type="submit" class="btn--cta">
    <i class="fa fa-check"></i>
    Confirm
  </button>
</form>

