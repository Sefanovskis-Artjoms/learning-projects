<?php include "inc/header.php";?>

<?php
    if(!isset($_GET['r'])){
        header('Location: ../error.php?r=1');
    }
?>

<main class="container">
  <div class="error-msg-box">
    <h2 class="error-small-msg">Sorry we could not find your page.</h2>
    <h3 class="error-big-msg">Error 404 Page not found...</h3>
  </div>
</main>

<?php include "inc/footer.php";?>