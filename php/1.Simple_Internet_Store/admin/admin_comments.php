<?php include 'inc/header.php'; ?>

<link rel="stylesheet" href="style/comments.css">
<main class="main">
  <?php 

    if (isset($_GET['source'])) {
      $source = $_GET['source'];
    } else {
      $source = '';
    }
    switch ($source) {
      case 'view_comment':
        include "inc/view_comment.php";
        break;
          
      default:
      include 'inc/view_all_comments.php';
      break;
    }
  ?>
</main>

<?php include 'inc/footer.php'; ?>