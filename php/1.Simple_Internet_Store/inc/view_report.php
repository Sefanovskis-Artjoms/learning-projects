<?php
  if(isset($_SESSION['user_id'])){

    $user_id = $_SESSION['user_id'];

    if(isset($_GET['r_id'])){

      $report_id = $_GET['r_id'];

      $query = "select*from order_report where report_id = $report_id";

      $select_report = mysqli_query($conn,$query);

      while($row = mysqli_fetch_assoc($select_report)){
        $report_date = $row['report_date'];
        $report_id = $row['report_id'];
        $report_text = $row['report_text'];
      }
    }

  ?>
  <div class="second-header-box">
    <div>
      <h2 class="second-heading">View Report</h2>
      <span class="second-header-line"></span>
    </div>
  
    <a href="profile.php?source=view_order_history" class="btn--cta user-edit-btn" >
      <i class="fas fa-angle-right"></i>
      <span>Back</span>
    </a>
  </div>

  <table class="user-data-box">
    <tr>
      <td class="user-data-label">Report ID: </td>
      <td><?php echo $report_id; ?></td>
    </tr>
    <tr>
      <td class="user-data-label">Report Date: </td>
      <td><?php echo $report_date; ?></td>
    </tr>
    <tr>
      <td class="user-data-label">Report: </td>
      <td><?php echo $report_text; ?></td>
    </tr>
    <tr>
  </table>

  <?php  
  }
?>