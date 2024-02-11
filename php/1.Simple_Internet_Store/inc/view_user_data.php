<?php
  if(isset($_SESSION['user_id'])){

    $user_id = $_SESSION['user_id'];

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
  ?>
  <div class="second-header-box">
    <div>
      <h2 class="second-heading">Profile Information</h2>
      <span class="second-header-line"></span>
    </div>
    <a href="profile.php?source=edit_user" class="btn--cta user-edit-btn" >
      <i class="fas fa-pen"></i>
      <span>Edit</span>
    </a>
  </div>

  <table class="user-data-box">
    <tr>
      <td class="user-data-label">First Name: </td>
      <td><?php echo $first_name; ?></td>
    </tr>
    <tr>
      <td class="user-data-label">Last Name: </td>
      <td><?php echo $last_name; ?></td>
    </tr>
    <tr>
      <td class="user-data-label">Email: </td>
      <td><?php echo $email; ?></td>
    </tr>
    <tr>
      <td class="user-data-label">Phone: </td>
      <td><?php echo $phone; ?></td>
    </tr>
    <tr>
      <td class="user-data-label">Phone Code: </td>
      <td><?php echo $phone_code; ?></td>
    </tr>
    <tr>
      <td><a href="profile.php?source=change_password" class="big-red-link">Change Password</a></td>
    </tr>
    <tr>
      <td>
        <a href="profile.php?source=check_password" class="big-red-link">Delete profile</a>
      </td>
    </tr>
  </table>
  <?php  
  }
?>

<script defer src="JS/hide_password.js"></script>