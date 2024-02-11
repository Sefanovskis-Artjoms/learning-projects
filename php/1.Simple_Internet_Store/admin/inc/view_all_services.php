<div class="page-header-box">
  <div>
    <h2 class="page-heading">View Services</h2>
    <span class="page-heading-line"></span>
  </div>
  <a href="admin-services.php?source=add_service" class="btn--cta services-create-btn">
    <i class="fas fa-plus"></i>
    <span>Create Service</span>
  </a>
</div>

<?php
  $querry = "select 
  s.service_id,
  s.service_title,
  s.service_price,
  s.service_hours,
  ifnull(COUNT(c.comment_id),0) as 'service_review_count',
  ifnull(ROUND(AVG(c.comment_rating),2),0) as 'service_rating',
  s.service_description,
  s.service_image
  from services as s 
  LEFT JOIN (select*from comments where comment_status = 'approved') as c on c.comment_topic_id = s.service_id
  where service_id <> 1 
  GROUP BY s.service_id";
  $select_services = mysqli_query($conn,$querry);

  if(mysqli_num_rows($select_services) == 0){
    echo "<div class='empty-msg'>Looks like it is empty here...</div>";
  }
  else{
?>

<table class="hor-table view-all-services-table"> 
  <thead class="hor-table-head">
    <tr>
      <th>ID</th>
      <th>Title</th>
      <th>Price</th>
      <th>Hours</th>
      <th>Review count</th>
      <th>Rating</th>
      <th>Description</th>
      <th>Image</th>
      <th></th>
      <th></th>
    </tr>
  </thead>
  <tbody>  
    <?php  
  
    while ($row = mysqli_fetch_assoc($select_services)) {
      
      $service_id = $row['service_id'];
      $service_title = $row['service_title'];
      $service_price = $row['service_price'];
      $service_hours = $row['service_hours'];
      $service_review_count = $row['service_review_count'];
      $service_rating = $row['service_rating'];
      $service_description = substr($row['service_description'],0, 200);
      $service_image = $row['service_image'];
      
      echo "<tr>";
      echo "<td>{$service_id}</td>";
      echo "<td>{$service_title}</td>";
      echo "<td>£{$service_price}</td>";
      echo "<td>{$service_hours}</td>";
      echo "<td>{$service_review_count}</td>";
      echo "<td>{$service_rating}</td>";
      echo "<td>{$service_description}</td>";
      echo "<td><img width='100px' src='../img/services-images/$service_image'></td>";
      echo "<td><a href='admin-services.php?source=edit_service&s_id={$service_id}'>Edit</a></td>";
      echo "<td><a href='admin-services.php?delete=$service_id'>Delete</a></td>";
      echo "</tr>";
    }
    ?>
  </tbody>
</table>
<?php } ?>

<?php 
  if (isset($_GET['delete'])) {
      $the_service_id = $_GET['delete'];
    
      global $conn;
      $query = "delete from services where service_id = $the_service_id";
      $delete_query = mysqli_query($conn,$query);
      header("Location: admin-services.php");
    
    }
?>