<?php 
  $the_order_id = $_GET['o_id'];
  $where = $_GET['where'];

  $query = "select*from order_report where report_order_id = $the_order_id";
  $select_report = mysqli_query($conn,$query);

  while($row = mysqli_fetch_assoc($select_report)){
    $report_date = $row['report_date'];
    $report_text = $row['report_text'];
  }
  
  if(isset($_GET['delete'])){
    global $conn;
    $query = "delete from order_report where report_order_id = $the_order_id";
    $delete_query = mysqli_query($conn,$query);
    header("Location: admin_orders.php?source=view_order&o_id=$the_order_id&where=$where");
  }

?>
<div class="page-header-box">
  <div>
    <h2 class="page-heading">View report for order <?php echo $the_order_id; ?></h2>
    <span class="page-heading-line"></span>
  </div>
  <a href="admin_orders.php?source=view_order&o_id=<?php echo $the_order_id;?>&where=<?php echo $where;?>" class="btn--cta services-create-btn">
    <i class="fas fa-angle-right"></i>
    <span>Back</span>
  </a>
</div>



<table class="ver-table">
  <tr>
    <td><?php echo "<a class='report-link' href='admin_orders.php?source=view_report&o_id=$the_order_id&where=$where&delete=true'>Delete Report</a>";?></td>
  </tr>
  <tr>
    <td class="ver-table-label">Date:</td>
    <td><?php echo $report_date; ?></td>
  </tr>
  <tr>
    <td class="ver-table-label">Report:</td>
    <td><?php echo $report_text; ?></td>
  </tr>
</table>

<div class="btn--submit">
  <a class="btn--cta" href="admin_orders.php?source=edit_report&o_id=<?php echo $the_order_id;?>&where=<?php echo $where;?>">
    <i class="fa fa-pen"></i>
    <span>Edit</span>
  </a>  
</div>
