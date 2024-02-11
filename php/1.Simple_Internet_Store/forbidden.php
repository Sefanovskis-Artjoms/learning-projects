<?php include "inc/header.php";?>

<?php
    if(!isset($_GET['r'])){
        header('Location: ../forbidden.php?r=1');
    }
?>

<main class="container">
  <div class="error-msg-box">
    <h2 class="error-small-msg">Looks like you dont have access to this page.</h2>
    <h3 class="error-big-msg">Error 403 Forbidden</h3>
  </div>
</main>

<?php include "inc/footer.php";?>