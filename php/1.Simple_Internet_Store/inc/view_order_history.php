<?php
  if(isset($_SESSION['user_id'])){

  $user_id = $_SESSION['user_id'];

?>

  <div class="second-header-box">
    <div>
      <h2 class="second-heading">Order History</h2>
      <span class="second-header-line"></span>
    </div>
  </div>

  <?php
    $query = "select o.order_id, s.service_id, s.service_title, c.car_producer, c.car_model, c.car_number_sign, o.order_status, o.order_appointment_date, if(o.order_completion_date<>'0000-00-00',o.order_completion_date,'Not completed') as 'order_completion_date', if(o.order_end_price = 0,'Not defined' , o.order_end_price) as 'order_end_price', ifnull(r.report_id,0) as 'order_report' ";
    $query.= "FROM orders as o ";
    $query.= "JOIN services as s on s.service_id = o.order_service_id ";
    $query.= "JOIN cars as c on c.car_id = o.order_car_id ";
    $query.= "LEFT JOIN order_report as r on r.report_order_id = o.order_id ";
    $query.= "WHERE o.order_user_id = $user_id and o.order_status in ('Completed', 'Canceled') ";
    $query.= "order by o.order_id desc";

    $select_order_history = mysqli_query($conn,$query);

    if(mysqli_num_rows($select_order_history) == 0){
      echo "<h3 class='empty-message'>Looks like you have no completed orders.</h3>";
    }
    else{
    ?>
      <table class="users-table order-history"> 
        <thead class="users-table-head" >
          <tr>
            <th>Order ID</th>
            <th>Service</th> 
            <th>Car</th>
            <th>Status</th>
            <th>Appointment Date</th>
            <th>End Date</th>
            <th>End Price</th>
            <th>Order Report</th>
            <th></th>
          </tr>
        </thead>
        <tbody class="users-table-body" >
          
          <?php  
          
          
          while ($row = mysqli_fetch_assoc($select_order_history)) {
            
            $order_id = $row['order_id'];
            $service = $row['service_title'];
            $service_id = $row['service_id'];
            $car_producer = $row['car_producer'];
            $car_model = $row['car_model'];
            $car_number = $row['car_number_sign'];
            $order_status = $row['order_status'];
            $start_date = $row['order_appointment_date'];
            $end_date = $row['order_completion_date'];
            $order_end_price = $row['order_end_price'];
            $order_report = $row['order_report'];
            if($order_report == 0){
              $report = "Report Not Created";
            }
            else{
              $report = "<a href='profile.php?source=view_report&r_id=$order_report'>View Report</a>";
            }
            
            echo "<tr class='users-table-row'>";
            echo "<td>$order_id</td>";
            echo "<td>$service</td>";
            echo "<td>$car_producer $car_model $car_number</td>";
            echo "<td>$order_status</td>";
            echo "<td>$start_date</td>";
            echo "<td>$end_date</td>";
            echo "<td>$order_end_price</td>";
            echo "<td>$report</td>";
            echo "<td><a href='add_testimonial.php?r_id=$service_id'>Leave Review</a></td>";
            echo "</tr>";
          }
          ?>
        </tbody>
      </table>
    <?php
    }
  }
?>