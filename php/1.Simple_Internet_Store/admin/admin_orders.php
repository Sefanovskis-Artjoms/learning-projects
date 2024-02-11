<?php include 'inc/header.php'; ?>

<link rel="stylesheet" href="style/orders.css">
<main class="main">
  <?php 

    if (isset($_GET['source'])) {
      $source = $_GET['source'];
    } else {
      $source = '';
    }
    switch ($source) {
      case 'view_order':
        include "inc/view_order.php";
        break;

      case 'view_report':
        include "inc/view_order_report.php";
        break;

      case 'edit_report':
        include "inc/edit_order_report.php";
        break;

      case 'add_report':
        include "inc/add_order_report.php";
        break;
          
      default:
      include 'inc/view_all_orders.php';
      break;
    }
  ?>
</main>

<?php include 'inc/footer.php'; ?>