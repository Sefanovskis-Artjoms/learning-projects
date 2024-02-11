<?php include "inc/header.php";?>

<?php
  if(isset($_SESSION['user_id'])){
    header("Location: profile.php");
  }
?>

<?php

  $errors = [];

  if(isset($_POST['register'])){
    
    $first = mysqli_real_escape_string($conn,$_POST['firstname']);
    $last = mysqli_real_escape_string($conn,$_POST['lastname']);
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
        $query = "select user_id from users where user_email = '{$email}' ";
        $select_user_query = mysqli_query($conn,$query);

        while ($row = mysqli_fetch_assoc($select_user_query)) {
          $db_user_id = $row['user_id'];
        }
        session_start();
        $_SESSION['user_id'] = $db_user_id;
        $_SESSION['user_first'] = $first;
        $_SESSION['user_last'] = $last;
        $_SESSION['user_email'] = $email;
        $_SESSION['user_phone'] = $phone;
        $_SESSION['user_phone_code'] = $phone_code;
        $_SESSION['user_role'] = 'user';

        header('Location: profile.php');
      }
    }
  }
?>
<link rel="stylesheet" href="css/login.css" />

<main class="container register-container">

  <div class="second-header-box"> 
    <div>
      <h2 class="second-heading">Register</h2>
      <span class="second-header-line"></span>
    </div>
    
    <a href="login.php" class="btn--cta user-edit-btn" >
      <i class="fas fa-angle-right"></i>
      <span>Back</span>
    </a>
  </div>

  <div class="login-box">
      <form action="#" method="post">

        <p class="text mandatory-msg">Mandatory fields(*)</p>


        <label class="text login-label" for="firstname">First name*:</label>
        <input name="firstname" class="inputfield text" type="text" value="<?php echo $first ?? ''; ?>">
        <p class="error-message"><?php echo $errors['first'] ?? ''; ?></p>

        <label class="text login-label" for="lastname">Last Name*:</label>
        <input name="lastname" class="inputfield" type="text" value="<?php echo $last ?? ''; ?>">
        <p class="error-message"><?php echo $errors['last'] ?? ''; ?></p>

        <label class="text login-label" for="email">Email*:</label>
        <input name="email" class="inputfield" type="email" value="<?php echo $email ?? ''; ?>">
        <p class="error-message"><?php echo $errors['email'] ?? ''; ?></p>

        <label class="text login-label" for="phone">Phone number*:</label>
        <input name="phone" class="inputfield" type="number" value="<?php echo $phone ?? ''; ?>">
        <p class="error-message"><?php echo $errors['phone'] ?? ''; ?></p>

        <label class="text login-label" for="phone_code">Country code of the number*:</label>
        <input name="phone_code" class="inputfield" type="number" value="<?php echo $phone_code ?? ''; ?>">
        <p class="error-message"><?php echo $errors['code'] ?? ''; ?></p>

        <label class="text login-label" for="password">Enter Password*:</label>
        <input name="password" class="inputfield" type="password">
        <p class="error-message"><?php echo $errors['password'] ?? ''; ?></p>
        

        <label class="text login-label" for="password_reenter">Re-enter Password*:</label>
        <input name="password_reenter" class="inputfield" type="password">
        <p class="error-message"><?php echo $errors['reenter'] ?? ''; ?></p>

        <button name="register" type="submit" class="btn--cta"><i class="fa fa-user-plus"></i> Register</button>
      </form>
  </div>
</main>

<?php include "inc/footer.php";?>