<?php 

if(isset($_GET['u_id'])){
  $the_user_id = $_GET['u_id'];
}
$errors = [];

$query = "select*from users where user_id = $the_user_id";
$select_user = mysqli_query($conn,$query);

while($row = mysqli_fetch_assoc($select_user)){

  $user_id = $row['user_id'];
  $user_first = $row['user_first'];
  $user_last = $row['user_last'];
  $user_email = $row['user_email'];
  $user_phone = $row['user_phone'];
  $user_phone_code = $row['user_phone_code'];
  $user_password = $row['user_password'];
}

if(isset($_POST['update_user'])){

  $the_user_first = mysqli_real_escape_string($conn,$_POST['user_first']);
  $the_user_last = mysqli_real_escape_string($conn,$_POST['user_last']);
  $the_user_phone = mysqli_real_escape_string($conn,$_POST['user_phone']);
  $the_user_phone_code = mysqli_real_escape_string($conn,$_POST['user_phone_code']);

  if(validateNameField($the_user_first)){
    $errors['first'] = validateNameField($the_user_first);
  }
  if(validateNameField($the_user_last)){
    $errors['last'] = validateNameField($the_user_last);
  }
  if(validateNumberField($the_user_phone)){
    $errors['number'] = validateNumberField($the_user_phone);
  }
  if(validateNumberField($the_user_phone_code)){
    $errors['code'] = validateNumberField($the_user_phone_code);
  }

  if(empty($errors)){

    $query = "update users set ";
    $query.= "user_first = '$the_user_first', ";
    $query.= "user_last = '$the_user_last', ";
    $query.= "user_phone = $the_user_phone, ";
    $query.= "user_phone_code = $the_user_phone_code ";
    $query.= "where user_id = $the_user_id";

    $update_user = mysqli_query($conn,$query);

    if (!$update_user) {
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
    <h2 class="page-heading">Edit user data</h2>
    <span class="page-heading-line"></span>
  </div>
  <a href="admin-users.php" class="btn--cta services-create-btn">
    <i class="fas fa-angle-right"></i>
    <span>Back</span>
  </a>
</div>

<form action="" method="post">
  
  <label class="input-label" for="user_first">First Name*</label>
  <input value="<?php echo $the_user_first ?? $user_first; ?>" type="text" name="user_first" class="text input-field">
  <p class="error-message"><?php echo $errors['first'] ?? ''; ?></p>

  <label class="input-label" for="user_last">Last Name*</label>
  <input value="<?php echo $the_user_last ?? $user_last; ?>" type="text" name="user_last" class="text input-field">
  <p class="error-message"><?php echo $errors['last'] ?? ''; ?></p>

  <label class="input-label" for="user_phone">Phone number*</label>
  <input value="<?php echo $the_user_phone ?? $user_phone; ?>" type="number" name="user_phone" class="text input-field">
  <p class="error-message"><?php echo $errors['number'] ?? ''; ?></p>

  <label class="input-label" for="user_phone_code">Phone number country code*</label>
  <input value="<?php echo $the_user_phone_code ?? $user_phone_code; ?>" type="number" name="user_phone_code" class="text input-field">
  <p class="error-message"><?php echo $errors['code'] ?? ''; ?></p>

  <div class="btn--submit">
    <button class="btn--cta" type="submit" name="update_user">
      <i class="fa fa-rotate-left"></i>
      <span>Update User</span>
    </button>  
  </div>
  
</form>