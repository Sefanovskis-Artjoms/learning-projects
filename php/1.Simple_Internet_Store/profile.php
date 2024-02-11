<?php include "inc/header.php";?>
<link rel="stylesheet" href="css/profile.css">
<?php
  if(!isset($_SESSION['user_id'])){
    header("Location: need_to_login.php");
  }
?>
<main class="container profile-main">
  <menu class="profile-menu">
    <ul class="profile-menu-list">
      <li class="profile-menu-item"><a class="profile-menu-link" href="profile.php">Profile Information</a></li>
      <li class="profile-menu-item"><a class="profile-menu-link" href="profile.php?source=view_cars">My Cars</a></li>
      <li class="profile-menu-item"><a class="profile-menu-link" href="profile.php?source=view_active_orders">Active Orders</a></li>
      <li class="profile-menu-item"><a class="profile-menu-link" href="profile.php?source=view_order_history">Order History</a></li>
      <li class="profile-menu-item"><a class="profile-menu-link" href="profile.php?source=view_user_comments">My Comments</a></li>
      <li class="profile-menu-item"><a class="profile-menu-link" href="inc/logout.php">Log-Out</a></li>
    </ul>
  </menu>
  <div class="profile-box"> 
    <?php 

    if (isset($_GET['source'])) {
      $source = $_GET['source'];
    } else {
      $source = '';
    }
    switch ($source) {

      case 'change_password':
        include "inc/change_password.php";
        break;
      
      case 'add_car':
        include "inc/add_car.php";
        break;

      case 'view_cars':
        include "inc/view_cars.php";
        break;
        
      case 'view_user_comments':
        include "inc/view_user_comments.php";
        break;
        
      case 'view_report':
        include "inc/view_report.php";
        break;
        
      case 'view_active_orders':
        include "inc/view_active_orders.php";
        break;

      case 'view_order_history':
        include "inc/view_order_history.php";
        break;

      case 'edit_user':
        include "inc/edit_user.php";
        break;
              
      case 'edit_car':
        include "inc/edit_car.php";
        break;

      case 'edit_comment':
        include "inc/edit_comment.php";
        break;

      case 'check_password':
        include "inc/check_delete.php";
        break;
          
      default:
        include "inc/view_user_data.php";
        break;
    }
    ?>
  </div>
</main>

<?php include "inc/footer.php";?>