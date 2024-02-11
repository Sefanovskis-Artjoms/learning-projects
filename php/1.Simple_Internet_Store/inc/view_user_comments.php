<?php
  if(isset($_SESSION['user_id'])){

  $user_id = $_SESSION['user_id'];

  if(isset($_GET['delete'])){
    $the_comment_id = $_GET['delete'];

    global $conn;
    $query = "delete from comments where comment_id = $the_comment_id";
    $delete_query = mysqli_query($conn,$query);
  }

?>

  <div class="second-header-box">
    <div>
      <h2 class="second-heading">My Comments</h2>
      <span class="second-header-line"></span>
    </div>
  </div>

  <?php
    $query = "select c.comment_id, IF(s.service_id = 1,'General',s.service_title) as 'service_title', c.comment_rating, c.comment_content, c.comment_date, IF(c.comment_isanonyme = 0, 'NO', 'YES') as 'comment_isanonyme', c.comment_status ";
    $query.= "FROM comments as c ";
    $query.= "JOIN services as s on s.service_id = c.comment_topic_id ";
    $query.= "WHERE comment_user_id = $user_id ";
    $query.= "order by c.comment_id desc";

    $select_comments = mysqli_query($conn,$query);

    if(mysqli_num_rows($select_comments) == 0){
      echo "<h3 class='empty-message'>Looks like you haven't written any comments.</h3>";
    }
    else{
    ?>
      <table class="users-table comment-table"> 
        <thead class="users-table-head" >
          <tr>
            <th>Number</th>
            <th>Topic Title</th> 
            <th>Rating</th>
            <th>Content</th>
            <th>Date</th>
            <th>Anonyme Comment</th>
            <th>Status</th>
            <th></th>
            <th></th>
          </tr>
        </thead>
        <tbody class="users-table-body" 
          <?php
          $counter = 1;  
          while ($row = mysqli_fetch_assoc($select_comments)) {
            
            $comment_id = $row['comment_id'];
            $title = $row['service_title'];
            $comment_rating = $row['comment_rating'];
            $comment_content = $row['comment_content'];
            $comment_date = $row['comment_date'];
            $comment_isanonyme = $row['comment_isanonyme'];
            $comment_status = $row['comment_status'];
            
            echo "<tr class='users-table-row'>";
            echo "<td>$counter</td>";
            echo "<td>$title</td>";
            echo "<td>$comment_rating</td>";
            echo "<td>$comment_content</td>";
            echo "<td>$comment_date</td>";
            echo "<td>$comment_isanonyme</td>";
            echo "<td>$comment_status</td>";
            echo "<td><a href='profile.php?source=edit_comment&comment_id=$comment_id'>Edit</a></td>";
            echo "<td><a href='profile.php?source=view_user_comments&delete=$comment_id'>Delete</a></td>";
            echo "</tr>";
            $counter++;
          }
          ?>
        </tbody>
      </table>
    <?php
    }
  }
?>