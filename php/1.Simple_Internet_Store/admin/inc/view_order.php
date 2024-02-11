<?php
  if(isset($_GET['o_id'])){

    $order_id = $_GET['o_id'];
    $where = $_GET['where'];

    if(isset($_POST['update_order'])){
      $the_order_status = mysqli_real_escape_string($conn,$_POST['order_status']);
      $the_order_completion_date = mysqli_real_escape_string($conn,$_POST['order_completion_date']);
      $the_order_end_price = mysqli_real_escape_string($conn,$_POST['order_end_price']);
      $the_order_date_of_payment = mysqli_real_escape_string($conn,$_POST['order_date_of_payment']);

      if(empty($the_order_end_price)){
        $the_order_end_price = 0;
      }

      $query = "update orders set ";
      $query.= "order_status = '$the_order_status', ";
      $query.= "order_completion_date = '$the_order_completion_date', ";
      $query.= "order_end_price = $the_order_end_price, ";
      $query.= "order_date_of_payment = '$the_order_date_of_payment' ";
      $query.= "where order_id = $order_id";
  
      $update_order = mysqli_query($conn,$query);
  
      if (!$update_order) {
        die('Query Failed ' . mysqli_error($conn));
      }
      else {
        header("Location: admin_orders.php?source=view_order&o_id=$order_id&where=$where");
      }
    }

    $query = "select 
      u.user_id, 
      CONCAT(u.user_first, ' ', u.user_last) as user_fullname, 
      u.user_email, 
      CONCAT('+', u.user_phone_code, ' ', u.user_phone) as 'user_phone',
      c.car_id,
      c.car_producer,
      c.car_model,
      c.car_number_sign,
      c.car_year,
      c.car_color,
      c.car_interior_material,
      c.car_details,
      s.service_id,
      s.service_title,
      s.service_price,
      o.order_id,
      o.order_date,
      o.order_appointment_date,
      o.order_status,
      ifnull(o.order_completion_date,'') as 'order_completion_date',
      ifnull(o.order_end_price,'') as 'order_end_price',
      ifnull(o.order_date_of_payment,'') as 'order_date_of_payment'
      FROM orders as o
      JOIN users as u on u.user_id = o.order_user_id
      JOIN services as s on s.service_id = o.order_service_id
      JOIN cars as c on c.car_id = o.order_car_id
      WHERE o.order_id = $order_id";

    $select_order = mysqli_query($conn,$query);

    while($row = mysqli_fetch_assoc($select_order)){
      $user_id = $row['user_id'];
      $user_fullname = $row['user_fullname'];
      $user_email = $row['user_email'];
      $user_phone = $row['user_phone'];
      $car_id = $row['car_id'];
      $car_producer = $row['car_producer'];
      $car_model = $row['car_model'];
      $car_number_sign = $row['car_number_sign'];
      $car_year = $row['car_year'];
      $car_color = $row['car_color'];
      $car_interior_material = $row['car_interior_material'];
      $car_details = $row['car_details'];
      $service_id = $row['service_id'];
      $service_title = $row['service_title'];
      $service_price = $row['service_price'];
      $order_id = $row['order_id'];
      $order_date = $row['order_date'];
      $order_appointment_date = $row['order_appointment_date'];
      $order_status = $row['order_status'];
      $order_completion_date = $row['order_completion_date'];
      $order_end_price = $row['order_end_price'];
      $order_date_of_payment = $row['order_date_of_payment'];
    }
  ?>
<div class="page-header-box">
  <div>
    <h2 class="page-heading">Viewing <?php echo "$user_fullname, $service_title"; ?> order</h2>
    <span class="page-heading-line"></span>
  </div>
  <a href="admin_orders.php?where=<?php echo $where; ?>" class="btn--cta user-edit-btn" >
    <i class="fas fa-angle-right"></i>
    <span>Back</span>
  </a>
</div>

  <form action="" method="post">
    <table class="ver-table">
      <tr>
        <td class="ver-table-label">User: </td>
        <td>
          <table class="hor-table inner-table"> 
            <thead class="hor-table-head" >
              <tr>
                <th>ID</th>
                <th>User</th>
                <th>Phone</th>
                <th>Email</th>
              </tr>
            </thead>
            <tbody class="hor-table-body view-orderuser-table">   
              <tr>
                <td><?php echo $user_id; ?></td>
                <td><?php echo $user_fullname; ?></td>
                <td><?php echo $user_phone; ?></td>
                <td><?php echo $user_email; ?></td>
              </tr>
            </tbody>
          </table>
        </td>
      </tr>
      <tr>
        <td class="ver-table-label">Car:</td>
        <td>
          <table class="hor-table inner-table view-ordercar-table"> 
            <thead class="hor-table-head" >
              <tr>
                <th>ID</th>
                <th>Producer</th>
                <th>Model</th>
                <th>Year</th>
                <th>Number Sign</th>
                <th>Color</th>
                <th>Interior</th>
                <th>Details</th>
              </tr>
            </thead>
            <tbody class="hor-table-body">   
              <tr>
                <td><?php echo $car_id; ?></td>
                <td><?php echo $car_producer; ?></td>
                <td><?php echo $car_model; ?></td>
                <td><?php echo $car_year; ?></td>
                <td><?php echo $car_number_sign; ?></td>
                <td><?php echo $car_color; ?></td>
                <td><?php echo $car_interior_material; ?></td>
                <td><?php echo $car_details; ?></td>
              </tr>
            </tbody>
          </table>
        </td>
      </tr>
      <tr>
        <td class="ver-table-label">Order ID: </td>
        <td><?php echo $order_id; ?></td>
      </tr>
      <tr>
        <td class="ver-table-label">Service: </td>
        <td><?php echo "$service_title (ID: $service_id)"; ?></td>
      </tr>
      <tr>
        <td class="ver-table-label">Service Estimated price: </td>
        <td><?php echo "£ $service_price"; ?></td>
      </tr>
      <tr>
        <td class="ver-table-label">Order Date: </td>
        <td><?php echo $order_date; ?></td>
      </tr>
      <tr>
        <td class="ver-table-label">Appointment Date: </td>
        <td><?php echo $order_appointment_date; ?></td>
      </tr>
      <tr>
        <td class="ver-table-label">Status: </td>
        <td>
          <select name="order_status" class="ver-table-input">
            <?php
              echo "<option value='$order_status'>$order_status</option>";
              $options = ['recieved','in progress', 'waiting for payment', 'completed', 'canceled'];
              $value_to_exclude  = array_search($order_status,$options);
              unset($options[$value_to_exclude]);
              foreach ($options as $option) {
                echo "<option value='$option'>$option</option>";
              }
            ?>
          </select>
        </td>
      </tr>
      <tr>
        <td class="ver-table-label">Completion date: </td>
        <td> <input class="ver-table-input" value="<?php echo $order_completion_date;?>" type="date" placeholder="yyyy/mm/dd"  name="order_completion_date" class="user-data-input"></td>
      </tr>
      <tr>
        <td class="ver-table-label">End Price(£): </td>
        <td><input class="ver-table-input" value="<?php if($order_end_price != 0){echo $order_end_price;}?>" name="order_end_price" class="user-data-input"></td>
      </tr>
      <tr>
        <td class="ver-table-label">Payment date: </td>
        <td><input class="ver-table-input" value="<?php echo $order_date_of_payment;?>" type="date" placeholder="yyyy/mm/dd" name="order_date_of_payment" class="user-data-input"></td>
      </tr>
      <tr>
        <td class="ver-table-label">Report: </td>
        <?php
          $query = "select*from order_report where report_order_id = $order_id";
          $select_report = mysqli_query($conn,$query);
          if(mysqli_num_rows($select_report) == 0){
            $report_text = "Create Report";
            $report = "add_report";

          }else{
            $report_text = "View Report";
            $report = "view_report";
          }
        ?>
        <td><?php echo "<a class='report-link' href='admin_orders.php?source=$report&o_id=$order_id&where=$where'>$report_text</a>";?></td>
      </tr>
    </table>

    <div class="btn--submit">
      <button class="btn--cta" type="submit" name="update_order">
        <i class="fa fa-rotate-left"></i>
        <span>Update Order</span>
      </button>  
    </div>
  </form>
  <?php  
  }
?>