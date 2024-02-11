<?php

if (isset($_GET['delete'])) {
  $user_id = $_SESSION['user_id'];

  $query = "delete from users where user_id = $user_id ";
  $delete_query = mysqli_query($conn,$query);
  session_destroy();
  header("Location: home.php");
}

?>


<div class="second-header-box">
  <div>
    <h2 class="second-heading">Do you realy want to delete profile ?</h2>
    <span class="second-header-line"></span>
  </div>
  <a href="profile.php" class="btn--cta user-edit-btn" >
    <i class="fas fa-angle-right"></i>
    <span>Back</span>
  </a>
</div>

<div class="check-delete-box">
  <a href="profile.php" class="check-btn check-btn-no">NO</a>
  <a href="profile.php?source=check_password&delete=yes" class="check-btn check-btn-yes">YES</a>
</div>