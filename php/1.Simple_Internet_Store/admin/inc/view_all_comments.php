<?php

  if (!isset($_GET['where'])) {
    $where_statement = " ";
    $where = 'all';
  }
  else{
    $where = $_GET['where'];
    switch ($_GET['where']) {
      case 'draft':
        $where_statement = "where c.comment_status = 'draft' ";
        break;

      case 'approve':
        $where_statement = "where c.comment_status = 'approved' ";
        break;

      case 'deny':
        $where_statement = "where c.comment_status = 'deny' ";
        break;
      
      default:
        $where_statement = " ";
        break;
    }
  }
?>

<div class="page-header-box">
  <div>
    <h2 class="page-heading">View Comments</h2>
    <span class="page-heading-line"></span>
  </div>
</div>

<div class="where-box">
  <a class="where-btn" href="admin_comments.php?where=all">View All</a>
  <a class="where-btn" href="admin_comments.php?where=draft">View Draft</a>
  <a class="where-btn" href="admin_comments.php?where=approve">View Approved</a>
  <a class="where-btn" href="admin_comments.php?where=deny">View Denied</a>
</div>

<?php
  $query = "select comment_id, 
  CASE
      WHEN c.comment_topic_id = 1 THEN 'General'
        ELSE s.service_title
  END as 'the_comment_topic',
    u.user_id,
    u.user_first,
    u.user_last,
    c.comment_rating,
    c.comment_content,
    c.comment_date,
    CASE
      WHEN c.comment_isanonyme = true THEN 'yes'
        ELSE 'no'
    END as 'isanonyme',
    c.comment_status ";
  $query.= "FROM comments as c
  LEFT JOIN services as s on s.service_id = c.comment_topic_id
  JOIN users as u on u.user_id = c.comment_user_id ";
  $query.= $where_statement;
  $query.= "ORDER BY c.comment_date desc";

  $select_comments = mysqli_query($conn,$query);

  if(mysqli_num_rows($select_comments) == 0){
    echo "<div class='empty-msg'>Looks like it is empty here...</div>";
  }
  else{
?>

  <table class="hor-table view-all-comments-table"> 
    <thead class="hor-table-head" >
      <tr>
        <th>ID</th>
        <th>Topic</th>
        <th>User ID</th>
        <th>User</th>
        <th>Rating</th>
        <th>Comment</th>
        <th>Date</th>
        <th>Is Anonyme</th>
        <th>Status</th> 
        <th></th>
        <th></th>
        <th></th>
      </tr>
    </thead>
    <tbody class="hor-table-body">
    
    <?php  
      while ($row = mysqli_fetch_assoc($select_comments)) {
        
        $comment_id = $row['comment_id'];
        $comment_topic = $row['the_comment_topic'];
        $comment_user_id = $row['user_id'];
        $comment_user_id = $row['user_id'];
        $user_first = $row['user_first'];
        $user_last = $row['user_last'];
        $comment_rating = $row['comment_rating'];
        $comment_content = substr($row['comment_content'],0, 200);
        $comment_date = $row['comment_date'];
        $comment_isanonyme = $row['isanonyme'];
        $comment_status = $row['comment_status'];
        
        echo "<tr>";
        echo "<td>{$comment_id}</td>";
        echo "<td>{$comment_topic}</td>";
        echo "<td>{$comment_user_id}</td>";
        echo "<td>$user_first $user_last</td>";
        echo "<td>{$comment_rating}</td>";
        echo "<td>{$comment_content}</td>";
        echo "<td>{$comment_date}</td>";
        echo "<td>{$comment_isanonyme}</td>";
        echo "<td>{$comment_status}</td>";
        echo "<td><a href='admin_comments.php?change_to_approved=$comment_id&where=$where'>Approve</a></td>";
        echo "<td><a href='admin_comments.php?change_to_deny=$comment_id&where=$where'>Deny</a></td>";
        echo "<td><a href='admin_comments.php?source=view_comment&c_id=$comment_id&where=$where'>Full View</a></td>";
        echo "<td><a href='admin_comments.php?delete=$comment_id&where=$where'>Delete</a></td>";
        echo "</tr>";
      }
    ?>
  </tbody>
</table>
<?php } ?>

<?php
  if(isset($_GET['change_to_approved'])){
    $the_comment_id = $_GET['change_to_approved'];
    global $conn;

    $query = "update comments set comment_status = 'approved' ";
    $query.= "where comment_id = $the_comment_id";
    $change_to_approve_query = mysqli_query($conn,$query);
    header("Location: admin_comments.php?where=$where");
  }

  if(isset($_GET['change_to_deny'])){
    $the_comment_id = $_GET['change_to_deny'];
    global $conn;

    $query = "update comments set comment_status = 'deny' ";
    $query.= "where comment_id = $the_comment_id";
    $change_to_deny_query = mysqli_query($conn,$query);
    header("Location: admin_comments.php?where=$where");
  }

  if(isset($_GET['delete'])){
    $the_comment_id = $_GET['delete'];
    global $conn;

    $query = "delete from comments where comment_id = $the_comment_id ";
    $delete_query = mysqli_query($conn,$query);
    header("Location: admin_comments.php?where=$where");
  }
?>