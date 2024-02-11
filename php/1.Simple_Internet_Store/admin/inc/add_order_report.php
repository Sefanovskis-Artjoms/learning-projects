<?php 
  $the_order_id = $_GET['o_id'];
  $where = $_GET['where'];
  $errors = [];

  if(isset($_POST['create_report'])){
    $report_text = mysqli_real_escape_string($conn,$_POST['report_text']);

    if(validateField($report_text)){
      $errors['report'] = validateRating($report_text);
    }

    if(empty($errors)){
      $query = "insert into order_report(report_order_id,report_text,report_date) ";
      $query.= "values($the_order_id,'$report_text',now())";

      $create_report_query = mysqli_query($conn,$query);

      if (!$create_report_query) {
        die('Query Failed ' . mysqli_error($conn));
      }
      else {
        header("Location: admin_orders.php?source=view_report&o_id=$the_order_id&where=$where");
      }
    }
  }
?>

<div class="page-header-box">
  <div>
  <h2 class="page-heading">Write report for order ID:<?php echo $the_order_id; ?></h2>
    <span class="page-heading-line"></span>
  </div>
  <a href="admin_orders.php?source=view_order&o_id=<?php echo $the_order_id;?>&where=<?php echo $where;?>" class="btn--cta services-create-btn">
    <i class="fas fa-angle-right"></i>
    <span>Back</span>
  </a>
</div>

<form action="" method="post">

  <textarea class="text-inputfield report-textarea" name="report_text" rows="10"></textarea>
  <p class="error-message"><?php echo $errors['report'] ?? '' ?></p>  

  <div class="btn--submit">
    <button class="btn--cta" type="submit" name="create_report">
        <i class="fa fa-plus"></i>
        <span>Create Report</span>
      </button>  
    </div>
</form>
