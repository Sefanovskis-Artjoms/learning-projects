<?php

  if (!isset($_GET['where'])) {
    $where_statement = " ";
    $where = 'all';
    $header_title = "View all orders";
  }
  else{
    $where = $_GET['where'];
    switch ($where) {
      case 'recieved':
        $where_statement = "where o.order_status = 'recieved' ";
        $header_title = "View recieved orders";
        break;

      case 'progress':
        $where_statement = "where o.order_status = 'in progress' ";
        $header_title = "View orders in progress";
        break;

      case 'waiting':
        $where_statement = "where o.order_status = 'waiting for payment' ";
        $header_title = "View orders waiting for payment";
        break;

      case 'completed':
        $where_statement = "where o.order_status = 'completed' ";
        $header_title = "View Completed orders";
        break;
  
      case 'canceled':
        $where_statement = "where o.order_status = 'canceled' ";
        $header_title = "View canceled orders";
        break;

      case 'report':
        $where_statement = "where o.order_status IN ('waiting for payment','completed') and ifnull(rep.report_id,0) = 0 ";
        $header_title = "View orders waiting for report";
        break;
      
      default:
        $where_statement = " ";
        $header_title = "View all orders";
        break;
    }
  }
?>

<div class="page-header-box">
  <div>
    <h2 class="page-heading"><?php echo $header_title; ?></h2>
    <span class="page-heading-line"></span>
  </div>
</div>

<div class="where-box">
  <a class="where-btn <?php if($where == 'all'){ echo "where-btn-active";}?>" href="admin_orders.php?where=all">View All</a>
  <a class="where-btn <?php if($where == 'recieved'){ echo "where-btn-active";}?>" href="admin_orders.php?where=recieved">View Recieved</a>
  <a class="where-btn <?php if($where == 'progress'){ echo "where-btn-active";}?>" href="admin_orders.php?where=progress">View In Progress</a>
  <a class="where-btn <?php if($where == 'waiting'){ echo "where-btn-active";}?>" href="admin_orders.php?where=waiting">View Waiting for Payment</a>
  <a class="where-btn <?php if($where == 'completed'){ echo "where-btn-active";}?>" href="admin_orders.php?where=completed">View Completed</a>
  <a class="where-btn <?php if($where == 'canceled'){ echo "where-btn-active";}?>" href="admin_orders.php?where=canceled">View Canceled</a>
  <a class="where-btn <?php if($where == 'report'){ echo "where-btn-active";}?>" href="admin_orders.php?where=report">Need Report</a>
</div>

<?php

  $query = "select 
    o.order_id, concat_ws(' ',u.user_first, u.user_last) as 'user', 
      s.service_title, 
      concat_ws(' ',c.car_producer, c.car_model, 
      c.car_number_sign) as 'car', 
      o.order_date,o.order_appointment_date, 
      o.order_status, 
      if(o.order_completion_date<>'0000-00-00',
      o.order_completion_date,'Not completed') as 'order_completion_date', 
      if(o.order_end_price = 0,'Not defined' , 
      o.order_end_price) as 'order_end_price',
      CASE
        WHEN rep.report_id > 0 THEN 'View Report'
          WHEN ifnull(rep.report_id,0) = 0 and o.order_status IN ('waiting for payment','completed') THEN 'Create Report'
          ELSE 'Report not needed'
      END as 'report' ";
  $query.= "FROM orders as o JOIN users as u on u.user_id = o.order_user_id ";
  $query.= "JOIN cars as c on c.car_id = o.order_car_id ";
  $query.= "JOIN services as s on s.service_id = o.order_service_id ";
  $query.= "LEFT JOIN order_report as rep on rep.report_order_id = o.order_id ";
  $query.= $where_statement; 
  $query.= "ORDER BY o.order_date DESC ";
  $select_orders = mysqli_query($conn,$query);

  if(mysqli_num_rows($select_orders) == 0){
    echo "<div class='empty-msg'>Looks like it is empty here...</div>";
  }
  else{
?>
<div class="wrapper">
<table class="hor-table view-all-orders-table"> 
  <thead class="hor-table-head" >
    <tr>
      <th>ID</th>
      <th>User</th>
      <th>Service</th>
      <th>Car</th>
      <th>Order Date</th>
      <th>Appointment Date</th>
      <th>Status</th>
      <th>Date of Completion</th>
      <th>End Price</th>
      <th>Report</th> 
      <th></th>
      <th></th>
      <th></th>
    </tr>
  </thead>
  <tbody class="hor-table-body">
    <?php  
    while ($row = mysqli_fetch_assoc($select_orders)) {
      
      $order_id = $row['order_id'];
      $order_user = $row['user'];
      $order_title = $row['service_title'];
      $order_car = $row['car'];
      $order_date = $row['order_date'];
      $order_appointment_date = $row['order_appointment_date'];
      $order_status = $row['order_status'];
      $order_completion_date = $row['order_completion_date'];
      $order_end_price = $row['order_end_price'];
      $order_report = $row['report'];

      if($order_report == 'View Report' || $order_report == 'Create Report'){
        if($order_report == 'View Report'){
          $report_page = 'view_report';
        }
        else{
          $report_page = 'add_report';
        }

        $report = "<a href='admin_orders.php?source=$report_page&o_id=$order_id&where=$where'>$order_report</a>";
      }
      else{
        $report = $order_report;
      }
      
      echo "<tr>";
      echo "<td>{$order_id}</td>";
      echo "<td>{$order_user}</td>";
      echo "<td>{$order_title}</td>";
      echo "<td>$order_car</td>";
      echo "<td>{$order_date}</td>";
      echo "<td>{$order_appointment_date}</td>";
      echo "<td>{$order_status}</td>";
      echo "<td>{$order_completion_date}</td>";
      echo "<td>{$order_end_price}</td>";
      echo "<td>{$report}</td>";
      echo "<td><a href='admin_orders.php?source=view_order&o_id=$order_id&where=$where'>View</a></td>";
      echo "<td><a href='admin_orders.php?delete=$order_id&where=$where'>Delete</a></td>";
      echo "</tr>";
    }
    ?>
  </tbody>
</table>
</div>
<?php } ?>

<?php

  if(isset($_GET['delete'])){
    $the_order_id = $_GET['delete'];
    global $conn;

    $query = "delete from orders where order_id = $the_order_id ";
    $delete_query = mysqli_query($conn,$query);
    header("Location: admin_orders.php?where=$where");
  }
?>