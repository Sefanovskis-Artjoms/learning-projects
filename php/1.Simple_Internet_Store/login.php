<?php include "inc/header.php";


if(isset($_SESSION['user_id'])){
  header("Location: profile.php");
}

$errors = [];
if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $email = mysqli_real_escape_string($conn,$email);
    $password = mysqli_real_escape_string($conn,$password);

    if(!validateEmail($email)){

      $query = "select*from users where user_email = '{$email}' ";
      $select_user_query = mysqli_query($conn,$query);

      if (!$select_user_query) {
        die("Query Failed" . mysqli_error($conn));
      }

      if(mysqli_num_rows($select_user_query) != 0){

        while ($row = mysqli_fetch_assoc($select_user_query)) {
          $db_user_id = $row['user_id'];
          $db_user_first = $row['user_first'];
          $db_user_last = $row['user_last'];
          $db_user_email = $row['user_email'];
          $db_user_phone = $row['user_phone'];
          $db_user_phone_code = $row['user_phone_code'];
          $db_user_role = $row['user_role'];
          $db_user_password = $row['user_password'];
        }
        if($password === $db_user_password){
          session_start();
          $_SESSION['user_id'] = $db_user_id;
          $_SESSION['user_first'] = $db_user_first;
          $_SESSION['user_last'] = $db_user_last;
          $_SESSION['user_email'] = $db_user_email;
          $_SESSION['user_phone'] = $db_user_phone;
          $_SESSION['user_phone_code'] = $db_user_phone_code;
          $_SESSION['user_role'] = $db_user_role;
          header("Location: profile.php");
        }
        else{
          $password_error = "Invalid password";
        }
      }
      else{
        $email_error = "Invalid email";
      }
    }
    else{
      $email_error = validateEmail($email);
    }
  } 
?>

<main class="container">
<link rel="stylesheet" href="css/login.css" />

<div class="second-header-box">
    <div>
      <h2 class="second-heading">Log-In</h2>
      <span class="second-header-line"></span>
    </div>
  </div>
  <div class="login-box">
      <form action="" method="post">
        <label class="text login-label" for="email">Enter Email Address:</label>
        <input name="email" class="inputfield text" type="email" value="<?php echo $email ?? ''; ?>">
        <p class="error-message"><?php echo $email_error ?? "&nbsp;"; ?></p>

        <label class="text login-label" for="password">Enter Password:</label>
        <input name="password" class="inputfield" type="password">
        <p class="error-message"><?php echo $password_error ?? ''; ?></p>
        
        <div class="login-button-box">
          <button name="login" type="submit" class="btn--cta"><i class="fa fa-sign-in"></i> Log-In</button>
          <a class="text link-to-register" href="register.php">Have no account? Register here!</a>
        </div>
      </form>
  </div>
</main>

<?php include "inc/footer.php";?>
