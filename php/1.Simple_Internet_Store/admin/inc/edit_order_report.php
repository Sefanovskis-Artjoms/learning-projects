<?php 
  $the_order_id = $_GET['o_id'];
  $where = $_GET['where'];
  $errors = [];

  $query = "select*from order_report where report_order_id = $the_order_id";
  $select_report = mysqli_query($conn,$query);

  while($row = mysqli_fetch_assoc($select_report)){
    $report_date = $row['report_date'];
    $report_text = $row['report_text'];
  }
  
  if(isset($_POST['update_report'])){
    $the_report_text = mysqli_real_escape_string($conn,$_POST['report_text']);

    if(validateField($the_report_text)){
      $errors['report'] = validateRating($the_report_text);
    }

    if(empty($errors)){
      $query = "update order_report set ";
      $query.= "report_date = now(), ";
      $query.= "report_text = '$the_report_text' ";
      $query.= "where report_order_id = $the_order_id";

      $update_report = mysqli_query($conn,$query);

      if (!$update_report) {
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
    <h2 class="page-heading">Edit report for order <?php echo $the_order_id; ?></h2>
    <span class="page-heading-line"></span>
  </div>
  <a href="admin_orders.php?source=view_report&o_id=<?php echo $the_order_id;?>&where=<?php echo $where;?>" class="btn--cta services-create-btn">
    <i class="fas fa-angle-right"></i>
    <span>Back</span>
  </a>
</div>

<form action="" method="post">
  
  <table class="ver-table">
    <tr>
      <td class="ver-table-label">Date:</td>
      <td><?php echo $report_date; ?></td>
    </tr>
    <tr>
      <td class="ver-table-label">Report:</td>
      <td>
        <textarea class="text-inputfield" class="text service-description" name="report_text" rows="10"><?php echo $the_report_text ?? $report_text; ?></textarea>
        <p class="error-message"><?php echo $errors['report'] ?? '' ?></p>
      </td>
    </tr>
  </table>

  <div class="btn--submit">
    <button class="btn--cta" type="submit" name="update_report">
      <i class="fa fa-rotate-left"></i>
      <span>Update</span>
    </button>  
  </div>
</form>