<?php include 'inc/header.php'; ?>

<link rel="stylesheet" href="style/services.css">
<main class="main">
  <?php 

    if (isset($_GET['source'])) {
      $source = $_GET['source'];
    } else {
      $source = '';
    }
    switch ($source) {
      case 'add_service':
        include "inc/add_service.php";
        break;
        
      case 'edit_service':
        include "inc/edit_service.php";
        break;
          
      default:
      include 'inc/view_all_services.php';
      break;
    }
  ?>
</main>

<?php include 'inc/footer.php'; ?>