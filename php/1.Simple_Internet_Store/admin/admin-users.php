<?php include 'inc/header.php'; ?>

<link rel="stylesheet" href="style/users.css">
<main class="main">
  <?php 

    if (isset($_GET['source'])) {
      $source = $_GET['source'];
    } else {
      $source = '';
    }
    switch ($source) {
      case 'add_user':
        include "inc/add_user.php";
        break;
        
      case 'edit_user':
        include "inc/edit_user.php";
        break;
          
      default:
      include 'inc/view_all_users.php';
      break;
    }
  ?>
</main>

<?php include 'inc/footer.php'; ?>