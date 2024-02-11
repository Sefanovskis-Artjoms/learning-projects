<?php
  if(isset($_GET['c_id'])){

    $comment_id = $_GET['c_id'];
    $where = $_GET['where'];

    $query = "select c.comment_id, 
      CASE
          WHEN c.comment_topic_id = 1 THEN 'General'
            ELSE s.service_title
      END as 'the_comment_topic',
        u.user_id,
        u.user_first,
        u.user_last,
        u.user_email,
        u.user_phone,
        u.user_phone_code,
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
    $query.= "WHERE c.comment_id = $comment_id";

    $select_comment = mysqli_query($conn,$query);

    while($row = mysqli_fetch_assoc($select_comment)){
      $comment_id = $row['comment_id'];
      $user_id = $row['user_id'];
      $user_first = $row['user_first'];
      $user_last = $row['user_last'];
      $user_email = $row['user_email'];
      $user_phone = $row['user_phone'];
      $user_phone_code = $row['user_phone_code'];
      $comment_rating = $row['comment_rating'];
      $comment_content = $row['comment_content'];
      $comment_date = $row['comment_date'];
      $comment_isanonyme = $row['isanonyme'];
      $comment_status = $row['comment_status'];
    }
  ?>
  <div class="page-header-box">
    <div>
      <h2 class="page-heading">Comment Information</h2>
      <span class="page-heading-line"></span>
    </div>
    <a href="admin_comments.php?where=<?php echo $where; ?>" class="btn--cta user-edit-btn" >
      <i class="fas fa-angle-right"></i>
      <span>Back</span>
    </a>
  </div>

  <table class="user-data-box">
    <tr>
      <td class="user-data-label">User ID: </td>
      <td><?php echo $user_id; ?></td>
    </tr>
    <tr>
      <td class="user-data-label">User: </td>
      <td><?php echo "$user_first $user_last"; ?></td>
    </tr>
    <tr>
      <td class="user-data-label">Email: </td>
      <td><?php echo $user_email; ?></td>
    </tr>
    <tr>
      <td class="user-data-label">Phone: </td>
      <td><?php echo "+ $user_phone_code $user_phone"; ?></td>
    </tr>
    <tr>
      <td class="user-data-label">Comment ID: </td>
      <td><?php echo $comment_id; ?></td>
    </tr>
    <tr>
      <td class="user-data-label">Is Comment anonyme: </td>
      <td><?php echo $comment_isanonyme; ?></td>
    </tr>
    <tr>
      <td class="user-data-label">Date: </td>
      <td><?php echo $comment_date; ?></td>
    </tr>
    <tr>
      <td class="user-data-label">Status: </td>
      <td><?php echo $comment_status; ?></td>
    </tr>
    <tr>
      <td class="user-data-label">Rating: </td>
      <td><?php echo $comment_rating; ?></td>
    </tr>
    <tr>
      <td class="user-data-label">Content: </td>
      <td><?php echo $comment_content; ?></td>
    </tr>
  </table>
  <div class="options-box">
    <?php
      echo "<a class='where-btn option-approve' href='admin_comments.php?change_to_approved=$comment_id&where=$where'>Approve</a>";
      echo "<a class='where-btn option-deny' href='admin_comments.php?change_to_deny=$comment_id&where=$where'>Deny</a>";
    ?>
  </div>
  <?php  
  }
?>